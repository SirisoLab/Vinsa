<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'stock',
        'kode',
        'category_id',
        'type_id',
        'image',
        'optional_image',
        'datasheet',
        'custom_input',
        'meta_title',
        'meta_description',
    ];

    protected static function booted()
    {
        // Saat create: slug otomatis jika kosong
        static::creating(function ($product) {
            if (blank($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            } else {
                // kalau user input slug manual, tetap rapikan biar aman (tanpa "/")
                $product->slug = static::generateUniqueSlug($product->slug);
            }
        });

        // Auto-clear cache saat ada produk yang dibuat / diupdate / dihapus
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_categories_tree');
            \Illuminate\Support\Facades\Cache::forget('all_categories_nav');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_categories_tree');
            \Illuminate\Support\Facades\Cache::forget('all_categories_nav');
        });
    }

    /**
     * Generate slug unik
     */
    public static function generateUniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value);

        // fallback kalau hasil slug kosong
        if (blank($base)) {
            $base = 'product';
        }

        $slug = $base;
        $i = 2;

        while (static::slugExists($slug, $ignoreId)) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    protected static function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();
    }

    public function attributes()
    {
        return $this->hasMany(ProductAtribute::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function legacyTypeName(): ?string
    {
        if (blank($this->custom_input)) {
            return null;
        }

        $decoded = json_decode((string) $this->custom_input, true);
        if (is_array($decoded)) {
            foreach (['tipe', 'type'] as $key) {
                if (!empty($decoded[$key]) && is_string($decoded[$key])) {
                    $trimmed = trim($decoded[$key]);
                    if ($trimmed !== '') {
                        return $trimmed;
                    }
                }
            }

            $categoryName = strtolower(trim((string) ($this->category?->name ?? '')));
            if (!empty($decoded['value']) && is_string($decoded['value']) && $categoryName !== 'cable tray') {
                $trimmed = trim($decoded['value']);
                if ($trimmed !== '') {
                    return $trimmed;
                }
            }

            return null;
        }

        $categoryName = strtolower(trim((string) ($this->category?->name ?? '')));
        if (in_array($categoryName, ['pilot lamp', 'accessories'], true)) {
            $trimmed = trim((string) $this->custom_input);
            return $trimmed !== '' ? $trimmed : null;
        }

        return null;
    }

    public function resolvedTypeName(): ?string
    {
        if ($this->type_id && $this->type) {
            $trimmed = trim((string) $this->type->name);
            if ($trimmed !== '') {
                return $trimmed;
            }
        }

        return $this->legacyTypeName();
    }

    public function resolvedSeriesName(): ?string
    {
        if (blank($this->custom_input)) {
            return null;
        }

        $categoryName = strtolower(trim((string) ($this->category?->name ?? '')));
        $decoded = json_decode((string) $this->custom_input, true);

        if (is_array($decoded)) {
            if (!empty($decoded['series']) && is_string($decoded['series'])) {
                $trimmed = trim($decoded['series']);
                if ($trimmed !== '') {
                    return $trimmed;
                }
            }

            if ($categoryName === 'cable tray' && !empty($decoded['value']) && is_string($decoded['value'])) {
                $trimmed = trim($decoded['value']);
                if ($trimmed !== '') {
                    return $trimmed;
                }
            }

            return null;
        }

        if ($categoryName === 'cable tray') {
            $trimmed = trim((string) $this->custom_input);
            return $trimmed !== '' ? $trimmed : null;
        }

        return null;
    }

    public function resolvedSubtitle(): ?string
    {
        $categoryName = strtolower(trim((string) ($this->category?->name ?? '')));
        if ($categoryName === 'cable tray') {
            return $this->resolvedSeriesName() ?: $this->resolvedTypeName();
        }

        return $this->resolvedTypeName();
    }
}
