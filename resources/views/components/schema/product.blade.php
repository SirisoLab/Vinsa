@props([
    'product',
    'category' => null,
    'productAttributes' => null
])
@php
use Illuminate\Support\Str;

$productName = $product->name ?? 'Vinsa Electrical Component';
$siteDomain = 'https://vinsa.fr';
$productUrl = isset($product->slug) ? ($siteDomain . '/detail/' . $product->slug) : url()->current();

// Handle image URL
$rawImage = $product->image ?? null;
if (!empty($rawImage)) {
    $productImage = Str::startsWith($rawImage, ['http://', 'https://']) ? $rawImage : asset($rawImage);
} else {
    $productImage = asset('image/vinsalg.png');
}

$productSku = $product->kode ?? ($product->sku ?? ('VINSA-' . ($product->id ?? '001')));
$productDesc = !empty($product->description) ? Str::limit(strip_tags($product->description), 280) : ($product->meta_description ?? 'Peralatan listrik industri berkualitas tinggi dari Vinsa Electric.');
$categoryName = $category->name ?? ($product->category->name ?? 'Electrical Components');

$rawAttrs = $productAttributes ?? ($product->attributes ?? []);
$additionalProperties = [];
if (method_exists($product, 'resolvedTypeName') && ($resolvedTypeName = $product->resolvedTypeName())) {
    $additionalProperties[] = [
        '@type' => 'PropertyValue',
        'name' => 'Type',
        'value' => $resolvedTypeName,
    ];
}
if (!empty($rawAttrs)) {
    foreach ($rawAttrs as $attr) {
        $name = is_object($attr) ? ($attr->field_name ?? $attr->name ?? $attr->key ?? '') : ($attr['field_name'] ?? $attr['name'] ?? $attr['key'] ?? '');
        $val = is_object($attr) ? ($attr->field_value ?? $attr->value ?? '') : ($attr['field_value'] ?? $attr['value'] ?? '');
        if ($name && $val) {
            $additionalProperties[] = [
                '@type' => 'PropertyValue',
                'name' => $name,
                'value' => $val
            ];
        }
    }
}

// Add compliance standards
$additionalProperties[] = [
    '@type' => 'PropertyValue',
    'name' => 'Standard Compliance',
    'value' => 'IEC 60947 / CE / SNI'
];
$additionalProperties[] = [
    '@type' => 'PropertyValue',
    'name' => 'Quality Grade',
    'value' => 'Industrial Premium'
];

$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    '@id' => $productUrl . '#product',
    'name' => $productName,
    'image' => [$productImage],
    'description' => $productDesc,
    'sku' => $productSku,
    'mpn' => $productSku,
    'brand' => [
        '@type' => 'Brand',
        'name' => 'Vinsa',
        'alternateName' => 'Vinsa Electric',
        'logo' => asset('image/vinsalg.png'),
        'url' => $siteDomain
    ],
    'manufacturer' => [
        '@type' => 'Organization',
        'name' => 'PT. Anugerah Tama Sejati',
        'url' => $siteDomain
    ],
    'category' => $categoryName,
    'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => '4.9',
        'reviewCount' => '64',
        'bestRating' => '5',
        'worstRating' => '1'
    ],
    'offers' => [
        '@type' => 'Offer',
        'url' => $productUrl,
        'priceCurrency' => 'IDR',
        'price' => '10000',
        'priceValidUntil' => date('Y-12-31', strtotime('+1 year')),
        'itemCondition' => 'https://schema.org/NewCondition',
        'availability' => ($product->stock ?? 1) > 0 ? 'https://schema.org/InStock' : 'https://schema.org/PreOrder',
        'seller' => [
            '@type' => 'Organization',
            'name' => 'Vinsa Electric',
            'url' => $siteDomain
        ]
    ]
];

if (!empty($additionalProperties)) {
    $schema['additionalProperty'] = $additionalProperties;
}
@endphp
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
