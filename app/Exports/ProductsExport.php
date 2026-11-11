<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with(['category', 'type', 'attributes'])->get();
    }

    public function headings(): array
    {
        return [
            'kode',
            'name',
            'description',
            'stock',
            'category',
            'type',
            'series',
            'meta_title',
            'meta_description',
            'image',
            'optional_image',
            'datasheet',
            'specifications',
        ];
    }

    /**
    * @var Product $product
    */
    public function map($product): array
    {
        // Format specifications as "field_name:field_value|field_name:field_value"
        $specs = '';
        if ($product->attributes && $product->attributes->count() > 0) {
            $specs = $product->attributes->map(function ($attr) {
                return $attr->field_name . ':' . $attr->field_value;
            })->implode('|');
        }

        // Resolve type (master type preferred, fallback to legacy custom_input) and series
        $type = $product->resolvedTypeName() ?? '';
        $series = $product->resolvedSeriesName() ?? '';

        return [
            $product->kode,
            $product->name,
            $product->description,
            $product->stock,
            $product->category ? $product->category->name : '',
            $type,
            $series,
            $product->meta_title,
            $product->meta_description,
            $product->image,
            $product->optional_image,
            $product->datasheet,
            $specs,
        ];
    }
}
