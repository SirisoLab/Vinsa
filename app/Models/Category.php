<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('homepage_categories_tree');
            Cache::forget('all_categories_nav');
        });

        static::deleted(function () {
            Cache::forget('homepage_categories_tree');
            Cache::forget('all_categories_nav');
        });
    }

    public function types()
    {
        return $this->hasMany(Type::class)->orderBy('name');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
