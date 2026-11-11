<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

