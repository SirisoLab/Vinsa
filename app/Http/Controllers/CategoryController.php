<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $categories = Category::query()
            ->withCount(['types', 'products'])
            ->with(['types' => fn ($q) => $q->select('id', 'category_id', 'name')->orderBy('name')])
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $totalCategories = Category::count();
        $totalTypes = Type::count();

        return view('categories.index', compact('categories', 'search', 'totalCategories', 'totalTypes'));
    }

    public function show(Category $category, Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $category->loadCount(['types', 'products']);

        $types = $category->types()
            ->withCount('products')
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('categories.show', compact('category', 'types', 'categories', 'search'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $exists = Category::whereRaw('LOWER(name) = ?', [Str::lower($value)])->exists();
                    if ($exists) {
                        $fail('Nama category sudah terdaftar.');
                    }
                },
            ],
        ]);

        $category = DB::transaction(function () use ($validated) {
            $category = Category::create([
                'name' => $validated['name'],
            ]);

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->histories()->create([
                'action' => 'create',
                'entity_type' => 'category',
                'entity_id' => $category->id,
                'description' => $user->name . ' menambahkan kategori baru: ' . $category->name,
            ]);

            return $category;
        });

        return redirect()
            ->route('categories.index')
            ->with('success', "Category \"{$category->name}\" berhasil ditambahkan.");
    }

    public function update(Request $request, Category $category)
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
                    $exists = Category::where('id', '!=', $category->id)
                        ->whereRaw('LOWER(name) = ?', [Str::lower($value)])
                        ->exists();
                    if ($exists) {
                        $fail('Nama category sudah digunakan kategori lain.');
                    }
                },
            ],
        ]);

        DB::transaction(function () use ($category, $validated) {
            $oldName = $category->name;
            $category->name = $validated['name'];
            $category->save();

            if ($oldName !== $category->name) {
                /** @var \App\Models\User $user */
                $user = Auth::user();
                $user->histories()->create([
                    'action' => 'update',
                    'entity_type' => 'category',
                    'entity_id' => $category->id,
                    'description' => $user->name . ' memperbarui kategori "' . $oldName . '" menjadi "' . $category->name . '"',
                ]);
            }
        });

        $redirectTarget = $request->input('_origin') === 'category_show'
            ? redirect()->route('categories.show', $category)
            : redirect()->route('categories.index');

        return $redirectTarget->with('success', "Category \"{$category->name}\" berhasil diperbarui.");
    }

    public function destroy(Category $category)
    {
        $productCount = $category->products()->count();
        if ($productCount > 0) {
            return redirect()
                ->route('categories.index')
                ->with('error', "Category \"{$category->name}\" tidak dapat dihapus karena masih digunakan oleh {$productCount} produk.");
        }

        $categoryName = $category->name;

        DB::transaction(function () use ($category) {
            $categoryId = $category->id;
            $name = $category->name;

            $category->types()->delete();
            $category->delete();

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->histories()->create([
                'action' => 'delete',
                'entity_type' => 'category',
                'entity_id' => $categoryId,
                'description' => $user->name . ' menghapus kategori: ' . $name,
            ]);
        });

        return redirect()
            ->route('categories.index')
            ->with('success', "Category \"{$categoryName}\" berhasil dihapus.");
    }
}

