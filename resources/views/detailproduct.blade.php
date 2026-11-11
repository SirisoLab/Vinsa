<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="apple-touch-icon" href="{{ asset('image/vinsalg_square.png') }}">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-55S5JHNQLG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-55S5JHNQLG');
    </script>
    <script src="https://analytics.ahrefs.com/analytics.js" data-key="+dmea0Inq5AGGqalX2/X/w" async></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('image/vinsalg.png') }}">
    @php
        use Illuminate\Support\Str;

        $metaTitle = $product->meta_title ?: $product->name . ' | Vinsa Electric';
        $metaDesc = $product->meta_description ?: Str::limit(strip_tags($product->description ?? ''), 155);

        if (!function_exists('formatToTitleCase')) {
            function formatToTitleCase($text) {
                return preg_replace_callback('/[a-zA-Z0-9]+/', function($matches) {
                    $word = $matches[0];
                    
                    // If it contains numbers (e.g., 9A, 65.5, IP65), keep as is
                    if (preg_match('/[0-9]/', $word)) {
                        return $word;
                    }
                    
                    // Handle abbreviations/units (singkatan)
                    $len = strlen($word);
                    $isAllUpper = ($word === strtoupper($word));
                    $noVowels = !preg_match('/[aeiouAEIOU]/', $word);
                    
                    // Units/abbreviations are usually short (1-2 chars), or 3-4 chars with no vowels or already all caps
                    if ($len <= 2 || ($isAllUpper && $len <= 4) || ($len <= 3 && $noVowels)) {
                        return strtoupper($word);
                    }
                    
                    // Otherwise, Title Case for regular words (kata-kata)
                    return ucfirst(strtolower($word));
                }, $text);
            }
        }
    @endphp

    @php
        $detailCanonical = 'https://vinsa.fr/detail/' . ($product->slug ?? '');
        $productImg = !empty($product->image) ? asset($product->image) : asset('image/vinsalg.png');
        $fullTitle = $metaTitle . ' | Vinsa Electric (vinsa.fr)';
    @endphp

    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $metaDesc }} - Komponen kelistrikan industri resmi Vinsa Electric berstandar IEC 60947 & CE standar global.">
    <meta name="keywords" content="{{ $product->name }}, {{ $product->kode ?? '' }}, alat listrik vinsa, switchgear, komponen panel listrik, iec 60947, vinsa.fr">
    <meta name="author" content="Vinsa Electric">

    <!-- Canonical & Alternates -->
    <link rel="canonical" href="{{ $detailCanonical }}">
    <link rel="alternate" hreflang="id" href="{{ $detailCanonical }}">
    <link rel="alternate" hreflang="en" href="{{ $detailCanonical }}">
    <link rel="alternate" hreflang="fr" href="{{ $detailCanonical }}">
    <link rel="alternate" hreflang="x-default" href="{{ $detailCanonical }}">

    <!-- Crawlers -->
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <!-- Open Graph (Product) -->
    <meta property="og:type" content="product">
    <meta property="og:site_name" content="Vinsa Electric">
    <meta property="og:url" content="{{ $detailCanonical }}">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:image" content="{{ $productImg }}">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $fullTitle }}">
    <meta name="twitter:description" content="{{ $metaDesc }}">
    <meta name="twitter:image" content="{{ $productImg }}">

    <!-- GEO / AEO Schema Markup (JSON-LD) -->
    <x-schema.product :product="$product" />
    <x-schema.breadcrumb :items="[
        ['name' => 'Home', 'url' => 'https://vinsa.fr/'],
        ['name' => 'Products', 'url' => 'https://vinsa.fr/product'],
        ['name' => $product->name ?? 'Detail Produk', 'url' => $detailCanonical]
    ]" />

    <style>
        .outfit {
            font-family: "Outfit", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 7px;
        }

        ::-webkit-scrollbar-thumb {
            background: #066c5f;
            border-radius: 100px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #0dd8bd;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        @keyframes pulse-bg {
            0%, 100% {
                background-color: #0dd8bd;
            }
            50% {
                background-color: #066c5f;
            }
        }

        .pulse-bg {
            animation: pulse-bg 1.5s infinite;
        }

        .tab-button.active {
            background: white;
            color: #066c5f;
        }

        @keyframes gradient-shift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        .gradient-animated {
            background-size: 200% 200%;
            animation: gradient-shift 8s ease infinite;
        }

        .tab-button {
            position: relative;
            transition: all 0.3s ease;
        }

        .tab-button:hover {
            transform: translateY(-2px);
        }

        .card-glow {
            box-shadow: 0 0 40px rgba(255, 255, 255, 0.3), 
                        0 20px 60px rgba(6, 108, 95, 0.15);
        }

          .wa-text-curv {
            width: 100%;
            position: absolute;
            top: 0%;
            -webkit-animation: spin 6s linear infinite;
            -moz-animation: spin 6s linear infinite;
            animation: spin 6s linear infinite;
        }

        @-moz-keyframes spin {
            100% {
                -moz-transform: rotate(360deg);
            }
        }

        @-webkit-keyframes spin {
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="outfit bg-[#FDFBEE]">
    <x-app-loader />
    <div class="max-w-[93%] mx-auto">
        <div class="flex justify-between items-center py-3">
            <x-navUser></x-navUser>
        </div>

        <!-- Product Detail Container -->
        <div class="bg-[#0dd8bd] rounded-[40px] shadow-2xl overflow-hidden mb-10">
            <!-- Header with Back Button -->
            <div class="p-6 lg:p-10">
                <a href="javascript:window.history.back()" class="inline-flex items-center gap-2 text-white hover:text-white/80 transition-all group mb-6">
                    <svg viewBox="0 0 24 24" width="24px" height="24px" fill="none" xmlns="http://www.w3.org/2000/svg" class="stroke-current transition-transform group-hover:-translate-x-1">
                        <path d="M6 12H18M6 12L11 7M6 12L11 17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <span class="font-semibold">{{ __('Back to Products') }}</span>
                </a>
            </div>

            <!-- Product Overview Section -->
            <div class="backdrop-blur-sm rounded-3xl mx-6 lg:mx-10 mb-8">
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 p-6 lg:p-12">
                <div class="flex items-center justify-center rounded-3xl p-8 lg:p-12 bg-white/50">
                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($product->image, 800) }}" 
                         alt="{{ $product->name }}" 
                         {!! \App\Helpers\ProductHelper::imgAttrs($product->image) !!} 
                         fetchpriority="high"
                         decoding="async"
                         class="max-w-full h-auto max-h-[400px] object-contain drop-shadow-2xl">
                </div>

                <!-- Product Info -->
                <div class="flex flex-col justify-center space-y-6">
                    @php
                        $categoryName = strtolower((string) ($product->category?->name ?? ''));
                        $resolvedTypeName = $product->resolvedTypeName();
                        $resolvedSubtitle = $product->resolvedSubtitle();
                        $customInput = json_decode($product->custom_input, true);
                        $filteredCustomInput = [];
                        if (is_array($customInput)) {
                            foreach ($customInput as $key => $value) {
                                if (blank($value)) {
                                    continue;
                                }
                                $isLegacyTypeKey = $resolvedTypeName && (
                                    in_array(strtolower($key), ['tipe', 'type'], true)
                                    || (strtolower($key) === 'value' && $categoryName !== 'cable tray')
                                );
                                if (!$isLegacyTypeKey) {
                                    $filteredCustomInput[$key] = $value;
                                }
                            }
                        }
                    @endphp
                    
                    <!-- Product Category & Type Badge -->
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('products.view.user', Str::slug($product->category?->name ?? '')) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 text-white text-sm font-bold tracking-wider uppercase w-fit hover:bg-white/30 transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                            {{ $product->category?->name ?? 'Product' }}
                        </a>
                        @if ($resolvedTypeName && $product->category)
                            <a href="{{ route('products.view.user', ['category' => Str::slug($product->category->name), 'type' => Str::slug($resolvedTypeName)]) }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-[#066c5f] text-white text-sm font-bold tracking-wider uppercase w-fit hover:bg-[#F77F1E] transition-all">
                                {{ $resolvedTypeName }}
                            </a>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-4xl lg:text-5xl font-black text-gray-900 leading-tight">
                        {{ $product->name }}
                        @if (in_array($categoryName, ['cable tray', 'pilot lamp', 'accessories']) && $resolvedSubtitle)
                            <span class="text-[#0dd8bd]">- {{ $resolvedSubtitle }}</span>
                        @endif
                    </h1>

                    <!-- Product Code -->
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold text-gray-100 uppercase tracking-wider">{{ __('Product Code:') }}</span>
                        <span class="text-xl font-bold text-white">{{ $product->kode }}</span>
                    </div>

                    <!-- Type & Custom Input Fields -->
                    @if ($resolvedTypeName || !empty($filteredCustomInput))
                        <div class="grid grid-cols-2 gap-4 p-6 bg-white/20 rounded-2xl">
                            @if ($resolvedTypeName)
                                <div>
                                    <p class="text-xs font-semibold text-gray-200 uppercase tracking-wider mb-1">{{ __('Type') }}</p>
                                    <p class="text-lg font-bold text-white">{{ __($resolvedTypeName) }}</p>
                                </div>
                            @endif
                            @foreach ($filteredCustomInput as $key => $value)
                                <div>
                                    <p class="text-xs font-semibold text-gray-200 uppercase tracking-wider mb-1">{{ __(ucfirst($key)) }}</p>
                                    <p class="text-lg font-bold text-white">{{ __($value) }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="https://wa.me/6281335715398" class="inline-flex items-center justify-center gap-3 bg-white text-[#066c5f] px-8 py-4 rounded-full text-lg font-bold hover:shadow-2xl hover:scale-105 transition-all shadow-lg">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            {{ __('Contact Us') }}
                        </a>

                        @if($product->datasheet)
                        <a href="{{ filter_var($product->datasheet, FILTER_VALIDATE_URL) ? $product->datasheet : asset('storage/' . $product->datasheet) }}" target="_blank" class="inline-flex items-center justify-center gap-3 bg-white/20 backdrop-blur-md text-white border border-white/30 px-8 py-4 rounded-full text-lg font-bold hover:bg-white/30 hover:shadow-2xl hover:scale-105 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            {{ __('Datasheet') }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            </div>

            <!-- Tabs Section -->
            <div class="rounded-3xl mx-6 lg:mx-10 mb-8">
            <div class="px-6 lg:px-12 pb-12">
                <div class="border-b border-gray-200 mb-8">
                    <div class="flex gap-4 overflow-x-auto">
                        <button onclick="switchTab('specifications')" class="tab-button active px-6 py-3 font-bold text-gray-100 hover:text-[#066c5f] border-b-2 border-transparent hover:border-[#066c5f] transition-all whitespace-nowrap">
                            {{ __('Specifications') }}
                        </button>
                        <button onclick="switchTab('description')" class="tab-button px-6 py-3 font-bold text-gray-100 hover:text-[#066c5f] border-b-2 border-transparent hover:border-[#066c5f] transition-all whitespace-nowrap">
                            {{ __('Description') }}
                        </button>
                        @if (Str::contains(strtoupper($product->kode), 'VHB') || Str::contains(strtoupper($product->name), 'WAREHOUSE') || $product->optional_image)
                            <button onclick="switchTab('comparison')" class="tab-button px-6 py-3 font-bold text-gray-100 hover:text-[#066c5f] border-b-2 border-transparent hover:border-[#066c5f] transition-all whitespace-nowrap">
                                {{ __('Product Details') }}
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Tab Content -->
                <div id="specifications" class="tab-content">
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">{{ __('Technical Specifications') }}</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach ($product->attributes as $attribute)
                            <div class="flex items-center text-sm justify-between space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <span class="font-semibold text-gray-700">{{ formatToTitleCase(__($attribute->field_name)) }} :</span>
                                <span class="font-bold text-right text-[#066c5f]">{{ formatToTitleCase(__($attribute->field_value)) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div id="description" class="tab-content hidden">
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">{{ __('Product Description') }}</h2>
                    <div class="prose prose-lg max-w-none">
                        <ul class="space-y-3">
                            @foreach (explode("\n", $product->description) as $line)
                                @if(trim($line))
                                    <li class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-[#0dd8bd] mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-gray-100">{{ $line }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

                @if (Str::contains(strtoupper($product->kode), 'VHB200'))
                    <div id="comparison" class="tab-content hidden">
                        <h2 class="text-4xl font-bold text-gray-900 mb-6">{{ __('Why Choose Vinsa Box Panel?') }}</h2>
                        <div class="mb-8 flex justify-center">
                            <img src="/image/fs.png" alt="Vinsa Features" class="max-w-full h-auto">
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse bg-white rounded-xl overflow-hidden">
                                <thead class="bg-gradient-to-r from-[#066c5f] to-[#0dd8bd] text-white">
                                    <tr>
                                        <th rowspan="3" class="border border-gray-300 p-4 text-lg font-bold">{{ __('Type') }}</th>
                                        <th colspan="3" class="border border-gray-300 p-4 text-lg font-bold">{{ __('Dimensions (mm)') }}</th>
                                        <th rowspan="3" class="border border-gray-300 p-4 text-lg font-bold">{{ __('Weight (Kg)') }}</th>
                                        <th colspan="2" rowspan="2" class="border border-gray-300 p-4 text-lg font-bold">{{ __('Thickness (mm)') }}</th>
                                        <th rowspan="3" class="border border-gray-300 p-4 text-lg font-bold">{{ __('Base Plate') }}</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="border border-gray-300 p-3">{{ __('Height') }}</th>
                                        <th rowspan="2" class="border border-gray-300 p-3">{{ __('Width') }}</th>
                                        <th rowspan="2" class="border border-gray-300 p-3">{{ __('Depth') }}</th>
                                    </tr>
                                    <tr>
                                        <th class="border border-gray-300 p-3">{{ __('Door') }}</th>
                                        <th class="border border-gray-300 p-3">{{ __('Body') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangs as $barang)
                                        @php
                                            $isActive = isset($kodeAktif) && strtoupper($barang->kode) === $kodeAktif;
                                        @endphp

                                        @if (Str::contains(strtolower($barang->name), 'box'))
                                            <tr class="{{ $isActive ? 'pulse-bg text-white' : 'bg-white hover:bg-gray-50' }} transition-colors">
                                                <td class="border border-gray-300 p-3 font-bold">{{ $barang->kode }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Height')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Width')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Depth')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Net Weight')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Door Thickness')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Body Thickness')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Base Plate Thickness')->field_value ?? '-' }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif (Str::contains(strtoupper($product->kode), 'VHB'))
                    <div id="comparison" class="tab-content hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('Why Choose Vinsa Box Panel?') }}</h2>
                        <div class="mb-8 flex justify-center">
                            <img src="/image/bvin.png" alt="Vinsa Features" class="max-w-full h-auto">
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse bg-white rounded-xl overflow-hidden shadow-lg">
                                <thead class="bg-gradient-to-r from-[#066c5f] to-[#0dd8bd] text-white">
                                    <tr>
                                        <th rowspan="3" class="border border-gray-300 p-4 text-lg font-bold">{{ __('Type') }}</th>
                                        <th colspan="3" class="border border-gray-300 p-4 text-lg font-bold">{{ __('Dimensions (mm)') }}</th>
                                        <th rowspan="3" class="border border-gray-300 p-4 text-lg font-bold">{{ __('Weight (Kg)') }}</th>
                                        <th colspan="2" rowspan="2" class="border border-gray-300 p-4 text-lg font-bold">{{ __('Thickness (mm)') }}</th>
                                        <th rowspan="3" class="border border-gray-300 p-4 text-lg font-bold">{{ __('Base Plate') }}</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="border border-gray-300 p-3">{{ __('Height') }}</th>
                                        <th rowspan="2" class="border border-gray-300 p-3">{{ __('Width') }}</th>
                                        <th rowspan="2" class="border border-gray-300 p-3">{{ __('Depth') }}</th>
                                    </tr>
                                    <tr>
                                        <th class="border border-gray-300 p-3">{{ __('Door') }}</th>
                                        <th class="border border-gray-300 p-3">{{ __('Body') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangs as $barang)
                                        @php
                                            $isActive = isset($kodeAktif) && strtoupper($barang->kode) === $kodeAktif;
                                        @endphp

                                        @if (Str::contains(strtolower($barang->name), 'box'))
                                            <tr class="{{ $isActive ? 'pulse-bg text-white' : 'bg-white hover:bg-gray-50' }} transition-colors">
                                                <td class="border border-gray-300 p-3 font-bold">{{ $barang->kode }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Height')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Width')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Depth')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Net Weight')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Door Thickness')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Body Thickness')->field_value ?? '-' }}</td>
                                                <td class="border border-gray-300 p-3">{{ $barang->attributes->firstWhere('field_name', 'Base Plate Thickness')->field_value ?? '-' }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif (Str::contains(strtoupper($product->name), 'WAREHOUSE'))
                    <div id="comparison" class="tab-content hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('Why Choose Vinsa Warehouse Rack?') }}</h2>
                        <div class="space-y-6">
                            <img src="/image/9.png" alt="Warehouse Rack Features" class="w-full h-auto rounded-2xl">
                            <img src="/image/10.png" alt="Warehouse Rack Specifications" class="w-full h-auto rounded-2xl">
                        </div>
                    </div>
                @elseif ($product->optional_image)
                    <div id="comparison" class="tab-content hidden">
                        <div class="flex flex-col items-center">
                            <h2 class="text-4xl font-bold text-gray-900 mb-8 self-start">{{ __('Product Details') }}</h2>
                            <div class="w-full max-w-4xl">
                                <img src="{{ \App\Helpers\ProductHelper::imageUrl($product->optional_image) }}" alt="{{ $product->name }}" {!! \App\Helpers\ProductHelper::imgAttrs($product->optional_image) !!} class="w-full h-auto rounded-[2rem]">

                            </div>
                        </div>
                    </div>
                @endif
            </div>
            </div>

            <!-- CTA Section -->
            <div class="p-12 lg:p-12">
                <div class="max-w-[93%] mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="text-center md:text-left">
                        <h3 class="text-3xl lg:text-4xl font-black text-white mb-2">{{ __('Interested in This Product?') }}</h3>
                        <p class="text-xl text-white/90">{{ __('Contact us for pricing and availability') }}</p>
                    </div>
                    <a href="https://wa.me/6281335715398" class="inline-flex items-center gap-3 bg-white text-[#066c5f] px-8 py-4 rounded-full text-lg font-bold hover:bg-gray-100 hover:scale-105 transition-all shadow-xl">
                        {{ __('Contact Us') }}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <x-footer></x-footer>

    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-[#066c5f]');
            });

            // Show selected tab content
            document.getElementById(tabName).classList.remove('hidden');

            // Add active class to clicked button
            event.target.classList.add('active', 'border-[#066c5f]');
        }

        document.getElementById('menu-toggle')?.addEventListener('click', function() {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });
    </script>
</body>

</html>


