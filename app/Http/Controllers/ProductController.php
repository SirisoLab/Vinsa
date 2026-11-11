<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAtribute;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request, $category = null)
    {
        $query = Product::select('id', 'name', 'slug', 'kode', 'image', 'category_id', 'type_id', 'custom_input')
            ->with(['category:id,name', 'type:id,category_id,name']);

        $activeCategoryId = null;
        $activeCategory = null;
        $activeTypeId = null;
        $activeType = null;

        $categories = \Illuminate\Support\Facades\Cache::remember('all_categories_nav', 3600, function () {
            return Category::with(['types' => fn ($q) => $q->select('id', 'category_id', 'name')->orderBy('name')])
                ->select('id', 'name')
                ->get();
        });

        if ($category) {
            $categoryModel = $categories->first(function ($c) use ($category) {
                return Str::slug($c->name) === $category || strtolower($c->name) === strtolower($category);
            });

            if ($categoryModel) {
                $query->where('category_id', $categoryModel->id);
                $activeCategoryId = $categoryModel->id;
                $activeCategory = $categoryModel;
            }
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
            $activeCategoryId = $request->category;
            if (!$activeCategory) {
                $activeCategory = $categories->firstWhere('id', $request->category);
            }
        }

        if ($activeCategory && !$activeCategory->relationLoaded('types')) {
            $activeCategory->load(['types' => fn ($q) => $q->select('id', 'category_id', 'name')->orderBy('name')]);
        }

        $availableTypes = $activeCategory ? $activeCategory->types : collect();

        if ($request->filled('type')) {
            $typeParam = trim((string) $request->query('type'));
            if ($activeCategory) {
                $matchedType = $availableTypes->first(function ($t) use ($typeParam) {
                    return (string) $t->id === $typeParam
                        || Str::slug($t->name) === Str::slug($typeParam)
                        || strtolower($t->name) === strtolower($typeParam);
                });

                if ($matchedType) {
                    $query->where('type_id', $matchedType->id);
                    $activeType = $matchedType;
                    $activeTypeId = $matchedType->id;
                } else {
                    // Explicit type filter that does not belong to this category should yield 0 matches
                    $query->whereRaw('1 = 0');
                }
            } elseif (ctype_digit($typeParam)) {
                $matchedType = Type::select('id', 'category_id', 'name')->find((int) $typeParam);
                if ($matchedType) {
                    $query->where('type_id', $matchedType->id);
                    $activeType = $matchedType;
                    $activeTypeId = $matchedType->id;
                }
            }
        }

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('kode', 'like', "%{$searchTerm}%")
                    ->orWhere('custom_input', 'like', "%{$searchTerm}%")
                    ->orWhereHas('type', fn ($tq) => $tq->where('name', 'like', "%{$searchTerm}%"));
            });
        }

        $products = $query->latest('id')->paginate(24)->withQueryString();

        return view('product', compact(
            'products',
            'categories',
            'activeCategoryId',
            'activeCategory',
            'availableTypes',
            'activeType',
            'activeTypeId'
        ));
    }

    public function show($param)
    {
        $product = Product::with(['attributes', 'category', 'type'])
            ->where(function ($q) use ($param) {
                $q->where('slug', $param)
                    ->orWhere('id', $param);
            })
            ->firstOrFail();

        // Kalau akses pakai ID, redirect ke slug
        if ((string)$product->id === (string)$param) {
            return redirect()
                ->route('product.show', $product->slug)
                ->setStatusCode(301);
        }

        // Hanya load perbandingan produk jika kategori atau kode adalah Box Panel / VHB
        $barangs = collect();
        $isBoxPanel = Str::contains(strtoupper($product->kode), 'VHB') || Str::contains(strtoupper($product->name), 'BOX');
        if ($isBoxPanel) {
            $barangs = Product::select('id', 'name', 'kode')
                ->where(function ($q) {
                    $q->where('kode', 'like', '%VHB%')
                        ->orWhere('name', 'like', '%box%');
                })
                ->with('attributes')
                ->get();
        }

        return view('detailproduct', [
            'product' => $product,
            'barangs' => $barangs,
            'kodeAktif' => strtoupper($product->kode),
        ]);
    }



    public function view()
    {
        $categories = Category::with(['types' => fn ($q) => $q->select('id', 'category_id', 'name')->orderBy('name')])
            ->orderBy('name')
            ->get();

        return view('product-input', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'kode' => 'required|string|unique:products,kode',
            'category_id' => 'required|exists:categories,id',
            'type_id' => [
                'nullable',
                'integer',
                Rule::exists('types', 'id')->where(fn ($query) => $query->where('category_id', $request->input('category_id'))),
            ],
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',

            'image' => [
                'required_without:image_link',
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                function ($attribute, $value, $fail) {
                    if ($value && $value->isValid()) {
                        $dimensions = getimagesize($value);
                        $ratio = $dimensions[0] / $dimensions[1];
                        if (abs($ratio - (8 / 11)) > 0.01) {
                            $fail('Gambar harus memiliki rasio 8:11.');
                        }
                    }
                }
            ],
            'image_link' => 'nullable|url',
            'specifications' => 'nullable|array',
            'specifications.*.field_name' => 'nullable|string',
            'specifications.*.field_value' => 'nullable|string',
            'datasheet' => 'nullable|file|mimes:pdf|max:10240', // max 10MB PDF
            'datasheet_link' => 'nullable|url',
            'optional_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB

        ]);

        foreach ($request->specifications ?? [] as $index => $spec) {
            if (!empty($spec['field_name']) && empty($spec['field_value'])) {
                return back()->withErrors([
                    "specifications.$index.field_value" => "Field value dibutuhkan jika field name diisi.",
                ])->withInput();
            }

            if (empty($spec['field_name']) && !empty($spec['field_value'])) {
                return back()->withErrors([
                    "specifications.$index.field_name" => "Field name dibutuhkan jika field value diisi.",
                ])->withInput();
            }
        }

        $customInput = null;
        $hasMasterType = $request->filled('type_id');
        $category = Category::find($request->category_id);

        if ($category) {
            $categoryName = strtolower($category->name);

            $seriesMap = [
                'push button' => ['type' => 'push_button_type', 'series' => 'push_button_series', 'contains' => true],
                'selector switch' => ['type' => 'selector_switch_type', 'series' => 'selector_switch_series', 'contains' => true],
                'cable lug' => ['type' => 'cable_lug_type', 'series' => 'cable_lug_series', 'contains' => false],
                'mccb' => ['type' => 'mccb_type', 'series' => 'mccb_series', 'contains' => false],
                'mccb accessories' => ['type' => 'mccb_accessories_type', 'series' => 'mccb_accessories_series', 'contains' => false],
                'contactor accessories' => ['type' => 'contactor_accessories_type', 'series' => 'contactor_accessories_series', 'contains' => false],
                'terminal block' => ['type' => 'terminal_block_type', 'series' => 'terminal_block_series', 'contains' => false],
            ];

            $matched = false;
            foreach ($seriesMap as $key => $fields) {
                $isMatch = $fields['contains']
                    ? str_contains($categoryName, $key)
                    : $categoryName === $key;

                if ($isMatch) {
                    $matched = true;
                    $series = $request->input($fields['series']);
                    $legacyType = !$hasMasterType ? $request->input($fields['type']) : null;

                    $payload = [];
                    if (!blank($legacyType)) {
                        $payload['tipe'] = $legacyType;
                    }
                    if (!blank($series)) {
                        $payload['series'] = $series;
                    }
                    if (!empty($payload)) {
                        $customInput = json_encode($payload);
                    }
                    break;
                }
            }

            if (!$matched) {
                if ($request->filled('uc_series')) {
                    $customInput = json_encode([
                        'value' => $request->input('uc_series'),
                    ]);
                } elseif (!$hasMasterType) {
                    foreach (['pilot_lamp_type', 'accessories_type'] as $field) {
                        if ($request->filled($field)) {
                            $customInput = json_encode([
                                'value' => $request->input($field),
                            ]);
                            break;
                        }
                    }
                }
            }
        }

        // Handle image: file upload takes priority, then URL
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } elseif ($request->image_link) {
            $imagePath = $this->processImageUrl($request->image_link);
        }

        $datasheetPath = null;
        if ($request->hasFile('datasheet')) {
            $datasheetPath = $request->file('datasheet')->store('datasheets', 'public');
        } elseif ($request->datasheet_link) {
            $datasheetPath = $request->datasheet_link;
        }

        $optionalImagePath = null;
        if ($request->hasFile('optional_image')) {
            $optionalImagePath = $request->file('optional_image')->store('products', 'public');
        } elseif ($request->optional_image_link) {
            $optionalImagePath = $this->processImageUrl($request->optional_image_link);
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'stock' => $request->stock,
            'kode' => $request->kode,
            'category_id' => $request->category_id,
            'type_id' => $request->filled('type_id') ? (int) $request->input('type_id') : null,
            'custom_input' => $customInput,
            'image' => $imagePath,
            'optional_image' => $optionalImagePath,
            'datasheet' => $datasheetPath,

            // ✅ META (langsung simpan, nullable)
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        if ($request->has('specifications')) {
            foreach ($request->specifications as $spec) {
                if (!empty($spec['field_name']) && !empty($spec['field_value'])) {
                    ProductAtribute::create([
                        'product_id' => $product->id,
                        'field_name' => $spec['field_name'],
                        'field_value' => $spec['field_value'],
                    ]);
                }
            }
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->histories()->create([
            'action' => 'create',
            'entity_type' => 'product',
            'entity_id' => $product->id,
            'description' => $user->name . ' menambahkan produk baru: ' . $product->name,
        ]);

        return redirect()->route('products.view', $product->id)->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Request $request)
    {
        $query = Product::select('id', 'name', 'description', 'kode', 'image', 'category_id', 'type_id', 'custom_input')
            ->with(['category:id,name', 'type:id,category_id,name']);

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('kode', 'like', "%{$searchTerm}%")
                    ->orWhere('custom_input', 'like', "%{$searchTerm}%")
                    ->orWhereHas('category', fn ($cq) => $cq->where('name', 'like', "%{$searchTerm}%"))
                    ->orWhereHas('type', fn ($tq) => $tq->where('name', 'like', "%{$searchTerm}%"));
            });
        }

        $products = $query->latest('id')->paginate(30)->withQueryString();
        return view('editProductView', compact('products'));
    }

    public function editView($id)
    {
        $product = Product::with(['attributes', 'category', 'type'])->findOrFail($id);
        $categories = Category::with(['types' => fn ($q) => $q->select('id', 'category_id', 'name')->orderBy('name')])
            ->orderBy('name')
            ->get();

        return view('update-product', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'kode' => 'required|string|unique:products,kode,' . $id,
            'category_id' => 'required|exists:categories,id',
            'type_id' => [
                'nullable',
                'integer',
                Rule::exists('types', 'id')->where(fn ($query) => $query->where('category_id', $request->input('category_id'))),
            ],

            // ✅ META (AMAN: nullable)
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                function ($attribute, $value, $fail) {
                    if ($value && $value->isValid()) {
                        $dimensions = getimagesize($value);
                        $ratio = $dimensions[0] / $dimensions[1];
                        if (abs($ratio - (8 / 11)) > 0.01) {
                            $fail('Gambar harus memiliki rasio 8:11.');
                        }
                    }
                }
            ],
            'image_link' => 'nullable|url',
            'specifications' => 'nullable|array',
            'specifications.*.field_name' => 'required_with:specifications.*.field_value',
            'specifications.*.field_value' => 'required_with:specifications.*.field_name',
            'datasheet' => 'nullable|file|mimes:pdf|max:10240', // max 10MB PDF
            'datasheet_link' => 'nullable|url',
            'optional_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
        ]);

        $product = Product::findOrFail($id);
        $historyChanges = [];

        if ($product->name !== $request->name) {
            $historyChanges[] = 'nama dari "' . $product->name . '" menjadi "' . $request->name . '"';
            $product->name = $request->name;
        }

        if ($product->description !== $request->description) {
            $old = $product->description ?? '(kosong)';
            $new = $request->description ?? '(kosong)';
            $historyChanges[] = 'deskripsi dari "' . $old . '" menjadi "' . $new . '"';
            $product->description = $request->description;
        }

        if ($product->stock != $request->stock) {
            $historyChanges[] = 'stok dari "' . $product->stock . '" menjadi "' . $request->stock . '"';
            $product->stock = $request->stock;
        }

        if ($product->kode !== $request->kode) {
            $historyChanges[] = 'kode dari "' . $product->kode . '" menjadi "' . $request->kode . '"';
            $product->kode = $request->kode;
        }

        if ((int) $product->category_id !== (int) $request->category_id) {
            $oldCategoryName = $product->category ? $product->category->name : '(kategori dihapus)';
            $newCategoryName = Category::find($request->category_id)?->name ?? '(kategori tidak ditemukan)';
            $historyChanges[] = 'kategori dari "' . $oldCategoryName . '" menjadi "' . $newCategoryName . '"';
            $product->category_id = (int) $request->category_id;
        }

        $oldTypeId = $product->type_id ? (int) $product->type_id : null;
        $newTypeId = $request->filled('type_id') ? (int) $request->input('type_id') : null;
        if ($oldTypeId !== $newTypeId) {
            $oldTypeName = $product->type ? $product->type->name : '(kosong)';
            $newTypeName = $newTypeId ? (Type::find($newTypeId)?->name ?? '(kosong)') : '(kosong)';
            $historyChanges[] = 'type dari "' . $oldTypeName . '" menjadi "' . $newTypeName . '"';
            $product->type_id = $newTypeId;
        }

        if ($request->has('custom_input')) {
            $customInput = $request->input('custom_input');

            if ($product->custom_input !== $customInput) {
                $oldCustom = $product->custom_input ?? '(kosong)';
                $newCustom = $customInput ?? '(kosong)';
                $historyChanges[] = 'custom input dari "' . $oldCustom . '" menjadi "' . $newCustom . '"';
                $product->custom_input = $customInput;
            }
        }

        // ✅ META CHANGES
        if ($product->meta_title !== $request->meta_title) {
            $old = $product->meta_title ?? '(kosong)';
            $new = $request->meta_title ?? '(kosong)';
            $historyChanges[] = 'meta title dari "' . $old . '" menjadi "' . $new . '"';
            $product->meta_title = $request->meta_title;
        }

        if ($product->meta_description !== $request->meta_description) {
            $old = $product->meta_description ?? '(kosong)';
            $new = $request->meta_description ?? '(kosong)';
            $historyChanges[] = 'meta description dari "' . $old . '" menjadi "' . $new . '"';
            $product->meta_description = $request->meta_description;
        }

        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('products', 'public');
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $newImagePath;
            $historyChanges[] = 'gambar produk telah diperbarui';
        } elseif ($request->filled('image_link')) {
            $newImageUrl = $this->processImageUrl($request->image_link);
            if ($newImageUrl !== $product->image) {
                if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $product->image = $newImageUrl;
                $historyChanges[] = 'gambar produk diperbarui ke URL eksternal';
            }
        }

        if ($request->hasFile('optional_image')) {
            $newOptionalImagePath = $request->file('optional_image')->store('products', 'public');
            if ($product->optional_image && !filter_var($product->optional_image, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($product->optional_image)) {
                Storage::disk('public')->delete($product->optional_image);
            }
            $product->optional_image = $newOptionalImagePath;
            $historyChanges[] = 'gambar opsional produk telah diperbarui';
        } elseif ($request->filled('optional_image_link')) {
            $newOptionalImageUrl = $this->processImageUrl($request->optional_image_link);
            if ($newOptionalImageUrl !== $product->optional_image) {
                if ($product->optional_image && !filter_var($product->optional_image, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($product->optional_image)) {
                    Storage::disk('public')->delete($product->optional_image);
                }
                $product->optional_image = $newOptionalImageUrl;
                $historyChanges[] = 'gambar opsional produk diperbarui ke URL eksternal';
            }
        }

        if ($request->hasFile('datasheet')) {
            $newDatasheetPath = $request->file('datasheet')->store('datasheets', 'public');
            if ($product->datasheet && !filter_var($product->datasheet, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($product->datasheet)) {
                Storage::disk('public')->delete($product->datasheet);
            }
            $product->datasheet = $newDatasheetPath;
            $historyChanges[] = 'datasheet produk telah diperbarui (file)';
        } elseif ($request->has('datasheet_link')) {
            if ($product->datasheet !== $request->datasheet_link) {
                if ($product->datasheet && !filter_var($product->datasheet, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($product->datasheet)) {
                    Storage::disk('public')->delete($product->datasheet);
                }
                $product->datasheet = $request->datasheet_link;
                $historyChanges[] = 'datasheet produk telah diperbarui (link)';
            }
        }

        $product->save();

        // Update spesifikasi
        $product->attributes()->delete();
        $hasSpec = false;
        if ($request->has('specifications')) {
            foreach ($request->specifications as $spec) {
                if (!empty($spec['field_name']) || !empty($spec['field_value'])) {
                    ProductAtribute::create([
                        'product_id' => $product->id,
                        'field_name' => $spec['field_name'],
                        'field_value' => $spec['field_value'],
                    ]);
                    $hasSpec = true;
                }
            }
        }

        if ($hasSpec) {
            $historyChanges[] = 'spesifikasi telah diperbarui';
        }

        if (!empty($historyChanges)) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->histories()->create([
                'action' => 'update',
                'entity_type' => 'product',
                'entity_id' => $product->id,
                'description' => $user->name . ' memperbarui produk "' . $product->name . '" dengan perubahan: ' . implode(', ', $historyChanges),
            ]);
        }

        return redirect()->route('products.edit')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $productName = $product->name;

        if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->attributes()->delete();
        $product->delete();

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->histories()->create([
            'action' => 'delete',
            'entity_type' => 'product',
            'entity_id' => $id,
            'description' => $user->name . ' menghapus produk: ' . $productName,
        ]);

        return redirect()->route('products.edit')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Process image URL - convert Google Drive share links to direct embeddable URLs
     * Uses lh3.googleusercontent.com format which is most reliable for img embedding
     */
    private function processImageUrl(string $url): string
    {
        $url = trim($url);

        // Google Drive: /file/d/FILE_ID/view
        if (preg_match('#drive\.google\.com/file/d/([a-zA-Z0-9_-]+)#', $url, $matches)) {
            return 'https://lh3.googleusercontent.com/d/' . $matches[1];
        }

        // Google Drive: /open?id=FILE_ID
        if (preg_match('#drive\.google\.com/open\?id=([a-zA-Z0-9_-]+)#', $url, $matches)) {
            return 'https://lh3.googleusercontent.com/d/' . $matches[1];
        }

        // Google Drive: /uc?id=FILE_ID or /uc?export=view&id=FILE_ID
        if (preg_match('#drive\.google\.com/uc\?.*id=([a-zA-Z0-9_-]+)#', $url, $matches)) {
            return 'https://lh3.googleusercontent.com/d/' . $matches[1];
        }

        // Return as-is for other URLs
        return $url;
    }
}
