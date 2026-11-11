<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        $search = trim((string) $request->query('search', ''));

        $categories = Category::withCount('types')
            ->orderBy('name')
            ->get(['id', 'name']);

        $types = Type::query()
            ->with('category:id,name')
            ->withCount('products')
            ->when(!empty($categoryId), fn ($q) => $q->where('category_id', $categoryId))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhereHas('category', fn ($cq) => $cq->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('category_id')
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        $totalTypes = Type::count();

        return view('types.index', compact('types', 'categories', 'categoryId', 'search', 'totalTypes'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
        ]);

        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail) use ($request) {
                    $catId = $request->input('category_id');
                    if (!$catId) {
                        return;
                    }
                    $exists = Type::where('category_id', $catId)
                        ->whereRaw('LOWER(name) = ?', [Str::lower($value)])
                        ->exists();
                    if ($exists) {
                        $fail('Nama type tersebut sudah ada di dalam category yang dipilih.');
                    }
                },
            ],
        ]);

        $type = DB::transaction(function () use ($validated) {
            $type = Type::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
            ]);
            $type->load('category');

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->histories()->create([
                'action' => 'create',
                'entity_type' => 'type',
                'entity_id' => $type->id,
                'description' => $user->name . ' menambahkan type baru "' . $type->name . '" pada kategori "' . ($type->category->name ?? '-') . '"',
            ]);

            return $type;
        });

        return redirect()
            ->route('types.index', ['category_id' => $type->category_id])
            ->with('success', "Type \"{$type->name}\" berhasil ditambahkan ke category \"{$type->category->name}\".");
    }

    public function storeForCategory(Request $request, Category $category)
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail) use ($category) {
                    $exists = Type::where('category_id', $category->id)
                        ->whereRaw('LOWER(name) = ?', [Str::lower($value)])
                        ->exists();
                    if ($exists) {
                        $fail('Nama type tersebut sudah ada di dalam category ini.');
                    }
                },
            ],
        ]);

        $type = DB::transaction(function () use ($category, $validated) {
            $type = $category->types()->create([
                'name' => $validated['name'],
            ]);

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->histories()->create([
                'action' => 'create',
                'entity_type' => 'type',
                'entity_id' => $type->id,
                'description' => $user->name . ' menambahkan type baru "' . $type->name . '" pada kategori "' . $category->name . '"',
            ]);

            return $type;
        });

        $redirectTo = $request->input('_origin') === 'categories_index'
            ? redirect()->route('categories.index')
            : redirect()->route('categories.show', $category);

        return $redirectTo->with('success', "Type \"{$type->name}\" berhasil ditambahkan di dalam category \"{$category->name}\".");
    }

    public function update(Request $request, Type $type)
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
        ]);

        $targetCategoryId = $request->filled('category_id')
            ? (int) $request->input('category_id')
            : (int) $type->category_id;

        $validated = $request->validate([
            'category_id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail) use ($type, $targetCategoryId) {
                    $exists = Type::where('category_id', $targetCategoryId)
                        ->where('id', '!=', $type->id)
                        ->whereRaw('LOWER(name) = ?', [Str::lower($value)])
                        ->exists();
                    if ($exists) {
                        $fail('Nama type tersebut sudah ada di dalam category tujuan.');
                    }
                },
            ],
        ]);

        $finalCategoryId = isset($validated['category_id'])
            ? (int) $validated['category_id']
            : (int) $type->category_id;

        if ($finalCategoryId !== (int) $type->category_id && $type->products()->exists()) {
            $productCount = $type->products()->count();
            return back()
                ->withErrors(['category_id' => "Category milik type ini tidak dapat dipindahkan karena masih digunakan oleh {$productCount} produk."])
                ->with('error', "Type \"{$type->name}\" tidak dapat dipindahkan ke category lain karena masih digunakan oleh {$productCount} produk.")
                ->withInput();
        }

        $oldCategoryId = (int) $type->category_id;

        DB::transaction(function () use ($type, $validated, $finalCategoryId) {
            $oldName = $type->name;
            $oldCategoryName = $type->category?->name ?? '-';

            $type->category_id = $finalCategoryId;
            $type->name = $validated['name'];
            $type->save();
            $type->load('category');

            if ($oldName !== $type->name || $oldCategoryName !== ($type->category?->name ?? '-')) {
                /** @var \App\Models\User $user */
                $user = Auth::user();
                $user->histories()->create([
                    'action' => 'update',
                    'entity_type' => 'type',
                    'entity_id' => $type->id,
                    'description' => $user->name . ' memperbarui type "' . $oldName . '" (' . $oldCategoryName . ') menjadi "' . $type->name . '" (' . ($type->category?->name ?? '-') . ')',
                ]);
            }
        });

        $redirect = $request->input('_origin') === 'types_index'
            ? redirect()->route('types.index', array_filter(['category_id' => $request->input('_filter_category_id')]))
            : redirect()->route('categories.show', $oldCategoryId);

        return $redirect->with('success', "Type \"{$type->name}\" berhasil diperbarui.");
    }

    public function destroy(Request $request, Type $type)
    {
        $productCount = $type->products()->count();
        if ($productCount > 0) {
            $redirect = $request->input('_origin') === 'types_index'
                ? redirect()->route('types.index', array_filter(['category_id' => $request->input('_filter_category_id')]))
                : redirect()->route('categories.show', $type->category_id);

            return $redirect->with('error', "Type \"{$type->name}\" tidak dapat dihapus karena masih digunakan oleh {$productCount} produk.");
        }

        $categoryId = $type->category_id;
        $typeName = $type->name;

        DB::transaction(function () use ($type) {
            $type->load('category');
            $typeId = $type->id;
            $name = $type->name;
            $catName = $type->category?->name ?? '-';

            $type->delete();

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->histories()->create([
                'action' => 'delete',
                'entity_type' => 'type',
                'entity_id' => $typeId,
                'description' => $user->name . ' menghapus type "' . $name . '" dari kategori "' . $catName . '"',
            ]);
        });

        $redirect = $request->input('_origin') === 'types_index'
            ? redirect()->route('types.index', array_filter(['category_id' => $request->input('_filter_category_id')]))
            : redirect()->route('categories.show', $categoryId);

        return $redirect->with('success', "Type \"{$typeName}\" berhasil dihapus.");
    }

    public function byCategory(Category $category)
    {
        $types = $category->types()
            ->orderBy('name')
            ->get(['id', 'category_id', 'name']);

        return response()->json([
            'category_id' => $category->id,
            'category_name' => $category->name,
            'types' => $types,
        ]);
    }
}

