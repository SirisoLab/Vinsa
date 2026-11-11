<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Type;
use App\Models\ProductAtribute;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductsImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public int $created = 0;
    public int $updated = 0;
    public int $skipped = 0;
    public array $errors = [];

    /**
     * In-memory cache for category name => id to avoid repetitive queries
     * @var array<string, int>
     */
    protected array $categoryCache = [];

    /**
     * In-memory cache for "categoryId|lowercase_type" => id
     * @var array<string, int>
     */
    protected array $typeCache = [];

    public function __construct()
    {
        // Preload existing categories & types into memory cache
        try {
            $this->categoryCache = Category::pluck('id', 'name')
                ->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])
                ->all();
        } catch (\Throwable $e) {
            $this->categoryCache = [];
        }

        try {
            $this->typeCache = Type::all(['id', 'category_id', 'name'])
                ->mapWithKeys(fn($type) => [
                    $type->category_id . '|' . strtolower(trim($type->name)) => $type->id,
                ])
                ->all();
        } catch (\Throwable $e) {
            $this->typeCache = [];
        }
    }

    /**
     * Process collection of rows in chunks
     *
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $validRows = [];
        $kodes = [];

        foreach ($rows as $row) {
            $kode = isset($row['kode']) ? trim((string)$row['kode']) : '';
            $name = isset($row['name']) ? trim((string)$row['name']) : '';

            if (empty($kode) || empty($name)) {
                $this->skipped++;
                continue;
            }

            $validRows[] = $row;
            $kodes[] = $kode;
        }

        if (empty($validRows)) {
            return;
        }

        // Process this chunk within a DB transaction for maximum speed & atomicity
        DB::transaction(function () use ($validRows, $kodes) {
            // Pre-fetch existing products in this chunk with 1 single query
            $existingProducts = Product::with('category:id,name')
                ->whereIn('kode', $kodes)
                ->get()
                ->keyBy('kode');

            $allAttributesToInsert = [];
            $productsToCleanAttributes = [];

            foreach ($validRows as $row) {
                $kode = trim((string)$row['kode']);
                $name = trim((string)$row['name']);

                try {
                    $existingProduct = $existingProducts->get($kode);

                    // Resolve Category ID using cache
                    $categoryId = null;
                    if (!empty($row['category'])) {
                        $catName = trim((string)$row['category']);
                        $catKey = strtolower($catName);

                        if (isset($this->categoryCache[$catKey])) {
                            $categoryId = $this->categoryCache[$catKey];
                        } else {
                            $category = Category::whereRaw('LOWER(name) = ?', [$catKey])->first()
                                ?? Category::create(['name' => $catName]);
                            $this->categoryCache[$catKey] = $category->id;
                            $categoryId = $category->id;
                        }
                    }

                    $effectiveCategoryId = $categoryId ?? $existingProduct?->category_id;
                    $rawTypeName = isset($row['type']) ? trim((string)$row['type']) : '';
                    $typeId = null;

                    if ($effectiveCategoryId && $rawTypeName !== '') {
                        $typeKey = $effectiveCategoryId . '|' . strtolower($rawTypeName);
                        if (isset($this->typeCache[$typeKey])) {
                            $typeId = $this->typeCache[$typeKey];
                        } else {
                            $typeModel = Type::where('category_id', $effectiveCategoryId)
                                ->whereRaw('LOWER(name) = ?', [strtolower($rawTypeName)])
                                ->first()
                                ?? Type::create([
                                    'category_id' => $effectiveCategoryId,
                                    'name' => $rawTypeName,
                                ]);
                            $this->typeCache[$typeKey] = $typeModel->id;
                            $typeId = $typeModel->id;
                        }
                    }

                    // Process images & datasheet
                    $imageValue = $this->processImage($row['image'] ?? null);
                    $optionalImageValue = $this->processImage($row['optional_image'] ?? null);
                    $datasheetValue = !empty($row['datasheet']) ? trim((string)$row['datasheet']) : null;

                    // Parse specifications
                    $specifications = $this->parseSpecifications($row['specifications'] ?? null);

                    $effectiveCategoryName = !empty($row['category'])
                        ? (string)$row['category']
                        : ($existingProduct?->category?->name ?? null);

                    // Build custom input JSON (series kept in custom_input; type fallback only if no master type_id resolved)
                    $customInput = $this->buildCustomInput(
                        $effectiveCategoryName,
                        $typeId === null ? ($row['type'] ?? null) : null,
                        $row['series'] ?? null
                    );

                    if ($existingProduct) {
                        $categoryChanged = $categoryId !== null && (int)$categoryId !== (int)$existingProduct->category_id;

                        // Update existing product
                        $updateData = [
                            'name' => $name,
                            'description' => $row['description'] ?? $existingProduct->description,
                            'stock' => $row['stock'] ?? $existingProduct->stock,
                            'category_id' => $categoryId ?? $existingProduct->category_id,
                            'meta_title' => $row['meta_title'] ?? $existingProduct->meta_title,
                            'meta_description' => $row['meta_description'] ?? $existingProduct->meta_description,
                        ];

                        if ($typeId !== null) {
                            $updateData['type_id'] = $typeId;
                        } elseif ($categoryChanged) {
                            $updateData['type_id'] = null;
                        }

                        if ($customInput !== null) {
                            $updateData['custom_input'] = $customInput;
                        }
                        if (!empty($imageValue)) {
                            $updateData['image'] = $imageValue;
                        }
                        if (!empty($optionalImageValue)) {
                            $updateData['optional_image'] = $optionalImageValue;
                        }
                        if (!empty($datasheetValue)) {
                            $updateData['datasheet'] = $datasheetValue;
                        }

                        $existingProduct->update($updateData);

                        if (!empty($specifications)) {
                            $productsToCleanAttributes[] = $existingProduct->id;
                            $now = now();
                            foreach ($specifications as $spec) {
                                $allAttributesToInsert[] = [
                                    'product_id' => $existingProduct->id,
                                    'field_name' => $spec['field_name'],
                                    'field_value' => $spec['field_value'],
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                ];
                            }
                        }

                        $this->updated++;
                    } else {
                        // Create new product
                        $newProduct = Product::create([
                            'name'             => $name,
                            'kode'             => $kode,
                            'description'      => $row['description'] ?? null,
                            'stock'            => $row['stock'] ?? 0,
                            'category_id'      => $categoryId,
                            'type_id'          => $typeId,
                            'custom_input'     => $customInput,
                            'meta_title'       => $row['meta_title'] ?? null,
                            'meta_description' => $row['meta_description'] ?? null,
                            'image'            => $imageValue ?: 'default.png',
                            'optional_image'   => $optionalImageValue,
                            'datasheet'        => $datasheetValue,
                        ]);

                        if (!empty($specifications)) {
                            $now = now();
                            foreach ($specifications as $spec) {
                                $allAttributesToInsert[] = [
                                    'product_id' => $newProduct->id,
                                    'field_name' => $spec['field_name'],
                                    'field_value' => $spec['field_value'],
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                ];
                            }
                        }

                        $this->created++;
                    }
                } catch (\Throwable $e) {
                    $this->errors[] = "Row kode={$kode}: {$e->getMessage()}";
                }
            }

            // Clean up attributes in 1 query for updated products
            if (!empty($productsToCleanAttributes)) {
                ProductAtribute::whereIn('product_id', $productsToCleanAttributes)->delete();
            }

            // Batch insert all attributes in 1 single SQL query for this chunk
            if (!empty($allAttributesToInsert)) {
                // Chunk attribute inserts in slices of 500 to stay well below MySQL placeholders limit
                foreach (array_chunk($allAttributesToInsert, 500) as $attrChunk) {
                    ProductAtribute::insert($attrChunk);
                }
            }
        });
    }

    /**
     * Chunk size for Excel reading
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Build custom_input JSON from type and series columns based on category.
     *
     * @param string|null $categoryName
     * @param string|null $type
     * @param string|null $series
     * @return string|null JSON string or null
     */
    private function buildCustomInput(?string $categoryName, ?string $type, ?string $series): ?string
    {
        $type = $type !== null ? trim($type) : '';
        $series = $series !== null ? trim($series) : '';

        if ($type === '' && $series === '') {
            return null;
        }

        $categoryName = strtolower(trim($categoryName ?? ''));

        // Cable tray stores series as 'value'
        if ($categoryName === 'cable tray') {
            $val = $series !== '' ? $series : $type;
            return $val !== '' ? json_encode(['value' => $val]) : null;
        }

        // Pilot lamp and accessories store legacy type as 'value' when no master type_id exists
        if (in_array($categoryName, ['pilot lamp', 'accessories']) && $series === '') {
            return $type !== '' ? json_encode(['value' => $type]) : null;
        }

        $payload = [];
        if ($type !== '') {
            $payload['tipe'] = $type;
        }
        if ($series !== '') {
            $payload['series'] = $series;
        }

        return !empty($payload) ? json_encode($payload) : null;
    }

    /**
     * Parse specifications string into array
     * Format: "field_name:field_value|field_name:field_value"
     *
     * @param string|null $specString
     * @return array
     */
    private function parseSpecifications(?string $specString): array
    {
        if (empty($specString)) {
            return [];
        }

        $specString = trim((string)$specString);
        $specs = [];

        // Split by pipe
        $pairs = explode('|', $specString);

        foreach ($pairs as $pair) {
            $pair = trim($pair);
            if (empty($pair)) continue;

            $colonPos = strpos($pair, ':');
            if ($colonPos !== false) {
                $fieldName = trim(substr($pair, 0, $colonPos));
                $fieldValue = trim(substr($pair, $colonPos + 1));

                if (!empty($fieldName) && !empty($fieldValue)) {
                    $specs[] = [
                        'field_name' => $fieldName,
                        'field_value' => $fieldValue,
                    ];
                }
            }
        }

        return $specs;
    }

    /**
     * Process image value - convert Google Drive share links to direct URLs
     */
    private function processImage(?string $image): ?string
    {
        if (empty($image)) {
            return null;
        }

        $image = trim((string)$image);

        // Google Drive: /file/d/FILE_ID/view
        if (preg_match('#drive\.google\.com/file/d/([a-zA-Z0-9_-]+)#', $image, $matches)) {
            return 'https://lh3.googleusercontent.com/d/' . $matches[1];
        }

        // Google Drive: /open?id=FILE_ID
        if (preg_match('#drive\.google\.com/open\?id=([a-zA-Z0-9_-]+)#', $image, $matches)) {
            return 'https://lh3.googleusercontent.com/d/' . $matches[1];
        }

        // Google Drive: /uc?id=FILE_ID
        if (preg_match('#drive\.google\.com/uc\?.*id=([a-zA-Z0-9_-]+)#', $image, $matches)) {
            return 'https://lh3.googleusercontent.com/d/' . $matches[1];
        }

        // Already lh3 format
        if (preg_match('#lh3\.googleusercontent\.com/d/([a-zA-Z0-9_-]+)#', $image, $matches)) {
            return 'https://lh3.googleusercontent.com/d/' . $matches[1];
        }

        return $image;
    }
}
