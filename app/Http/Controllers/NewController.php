<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Carousel;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class NewController extends Controller
{
    public function show()
    {
        // Cache carousel data (1 hour)
        $carousels = Cache::remember('homepage_carousels', 3600, function () {
            return Carousel::all();
        });

        // Cache blogs data (1 hour)
        $blogs = Cache::remember('homepage_blogs', 3600, function () {
            return Blog::with([
                'sections' => fn($q) => $q->select('id', 'blog_id', 'subtitle', 'content', 'image')
            ])
            ->where('is_published', true)
            ->latest()
            ->limit(12)
            ->get(['id', 'title', 'slug', 'image', 'content', 'is_published', 'created_at']);
        });

        // Cache categories & homepage products tree (1 hour) to eliminate DB load
        $categories = Cache::remember('homepage_categories_tree', 3600, function () {
            $allCategories = Category::with([
                'types' => function ($q) {
                    $q->select('id', 'category_id', 'name')->reorder('id', 'asc');
                },
                'products' => function ($q) {
                    $q->select('id', 'name', 'slug', 'kode', 'image', 'category_id', 'type_id', 'custom_input')
                        ->with('type:id,category_id,name');
                }
            ])->get(['id', 'name']);

            $customOrder = [
                'Contactor',
                'Contactor Accessories',
                'MCCB',
                'MCCB Accessories',
                'Box Panel',
                'Cable Lug',
                'Push Button',
                'Illuminated Push Button',
                'Emergency Push Button',
                'Pilot Lamp',
                'Illuminated Selector Switch',
                'Selector Switch',
                'Flashing Buzzer',
                'Terminal Block',
                'Empty Control Panel',
                'Cable Ties',
                'Cable Tray',
                'Accessories',
                'Rak',
            ];

            $orderedCategories = collect($customOrder)
                ->map(function ($name) use ($allCategories) {
                    return $allCategories->firstWhere('name', $name);
                })
                ->filter();

            $remainingCategories = $allCategories->filter(function ($category) use ($customOrder) {
                return !in_array($category->name, $customOrder);
            });

            return $orderedCategories->concat($remainingCategories)->values();
        });

        return view('new', compact('carousels', 'categories', 'blogs'));
    }
}
