<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }" :class="{ 'overflow-hidden': sidebarOpen }">

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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('image/sa.png') }}">
    @php
        $catTitle = isset($activeCategory) ? ($activeCategory->name . ' - ') : '';
        $metaTitle = $catTitle . 'Katalog Komponen Kelistrikan & Panel Industri | Vinsa Electric (vinsa.fr)';
        $metaDesc = isset($activeCategory)
            ? 'Koleksi ' . $activeCategory->name . ' resmi Vinsa Electric (vinsa.fr). Komponen switchgear industri berkualitas tinggi berstandar IEC 60947 & CE untuk panel maker dan proyek MEP.'
            : 'Katalog lengkap komponen kelistrikan industri Vinsa Electric (vinsa.fr): Push Button 22mm, Magnetic Contactor CJX2, MCB, MCCB, Box Panel IP65/IP66, Pilot Lamp, dan Terminal Block berstandar IEC 60947 & CE standar global.';
        $canonicalProdUrl = isset($activeCategory) 
            ? ('https://vinsa.fr/product/' . \Illuminate\Support\Str::slug($activeCategory->name))
            : 'https://vinsa.fr/product';
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <meta name="keywords" content="produk vinsa, katalog alat listrik, vinsa electric, kontaktor cjx2, push button 22mm, box panel ip65, mccb, mcb, switchgear indonesia, vinsa.fr">
    <meta name="author" content="Vinsa Electric">

    <!-- Canonical & Alternates -->
    <link rel="canonical" href="{{ $canonicalProdUrl }}">
    <link rel="alternate" hreflang="id" href="{{ $canonicalProdUrl }}">
    <link rel="alternate" hreflang="en" href="{{ $canonicalProdUrl }}">
    <link rel="alternate" hreflang="fr" href="{{ $canonicalProdUrl }}">
    <link rel="alternate" hreflang="x-default" href="{{ $canonicalProdUrl }}">

    <!-- Crawlers -->
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vinsa Electric">
    <meta property="og:url" content="{{ $canonicalProdUrl }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:image" content="{{ asset('image/vinsalg.png') }}">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDesc }}">
    <meta name="twitter:image" content="{{ asset('image/vinsalg.png') }}">

    <link rel="icon" type="image/png" href="{{ asset('image/vinsalg.png') }}">

    <!-- GEO / AEO Schema Markup (JSON-LD) -->
    <x-schema.organization />
    @php
        $breadcrumbItems = [
            ['name' => 'Home', 'url' => 'https://vinsa.fr/'],
            ['name' => 'Products', 'url' => 'https://vinsa.fr/product']
        ];
        if (isset($activeCategory) && $activeCategory) {
            $breadcrumbItems[] = ['name' => $activeCategory->name, 'url' => $canonicalProdUrl];
        }
    @endphp
    <x-schema.breadcrumb :items="$breadcrumbItems" />

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }

        .outfit {
            font-family: "Outfit", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }

        @keyframes shine {
            0% { background-position: -200%; }
            100% { background-position: 200%; }
        }

        .shining-text {
            background-image: linear-gradient(90deg, #9e9e9e 25%, #ffffff 50%, #9e9e9e 75%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shine 6s linear infinite;
        }

        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #79B0A9;
            border-radius: 20px;
            border: 3px solid transparent;
            background-clip: content-box;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #8CBBB5;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        .category-pill.active {
            background-color: #F77F1E !important;
            color: white !important;
            border-color: #F77F1E !important;
            box-shadow: 0 10px 20px rgba(247, 127, 30, 0.4) !important;
        }
    </style>
</head>

<body class="outfit bg-[#FDFBEE] min-h-screen">
    <x-app-loader />
    <main class="max-w-[95%] mx-auto">
        <!-- Navigation -->
        <div class="flex justify-between items-center py-4">
            <x-navUser class="relative z-50"></x-navUser>
        </div>

        <!-- Hero Section -->
        <div class="relative overflow-hidden bg-gradient-to-br from-[#066C5F] via-[#098d7c] to-[#0dd8bd] rounded-[40px] px-6 py-20 md:py-32 mb-12 shadow-[0_20px_50px_rgba(6,108,95,0.3)]" data-aos="zoom-in-up">
            <!-- Decorative Elements -->
            <div class="absolute top-[-20%] right-[-10%] w-[500px] h-[500px] bg-white opacity-10 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute bottom-[-20%] left-[-10%] w-[600px] h-[600px] bg-[#F77F1E] opacity-10 rounded-full blur-[150px]"></div>
            
            <div class="absolute bottom-1/4 right-20 w-6 h-6 bg-white/10 rounded-full animate-ping" style="animation-duration: 3s;"></div>

            <div class="relative z-10 text-center max-w-4xl mx-auto">
                <div class="inline-block px-4 py-1.5 mb-6 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-bold tracking-widest uppercase" data-aos="fade-down">
                    {{ __('Premium Electrical Solutions') }}
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white mb-8 uppercase tracking-tighter leading-none" data-aos="fade-up" data-aos-delay="100">
                    {{ __('Our') }} <span class="shining-text">{{ __('Collection') }}</span>
                </h1>
                <p class="text-lg md:text-2xl text-white/80 mb-12 font-medium max-w-2xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                    {{ __('Elevating industry standards with precision-engineered products designed for reliability and safety.') }}
                </p>

                <!-- Search Container -->
                <form method="GET" action="{{ route('products.view.user', $activeCategory ? \Illuminate\Support\Str::slug($activeCategory->name) : null) }}" class="relative max-w-2xl mx-auto group shadow-2xl rounded-3xl" data-aos="fade-up" data-aos-delay="300">
                    @if(isset($activeType) && $activeType)
                        <input type="hidden" name="type" value="{{ \Illuminate\Support\Str::slug($activeType->name) }}">
                    @endif
                    <div class="absolute inset-y-0 left-0 pl-7 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-gray-400 group-focus-within:text-[#066C5F] transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="searchInput" 
                        value="{{ request('search') }}"
                        placeholder="{{ __('Search by name or product code...') }}"
                        class="w-full pl-16 pr-28 py-6 rounded-3xl text-xl text-gray-800 bg-white/95 backdrop-blur-sm focus:outline-none focus:ring-4 focus:ring-[#F77F1E]/40 transition-all border-none placeholder-gray-400">
                    @if(request('search'))
                        <a href="{{ route('products.view.user', array_filter(['category' => $activeCategory ? \Illuminate\Support\Str::slug($activeCategory->name) : null, 'type' => isset($activeType) && $activeType ? \Illuminate\Support\Str::slug($activeType->name) : null])) }}" class="absolute right-14 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400 hover:text-red-500 bg-gray-100 px-3 py-1.5 rounded-full transition-colors">
                            ✕ Clear
                        </a>
                    @endif
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-[#066C5F] hover:bg-[#F77F1E] text-white rounded-2xl flex items-center justify-center transition-colors shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>
            <div class="px-4">
            <!-- Filters Section -->
            <div class="mb-16" data-aos="fade-up">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-8 mb-10 border-b border-gray-100 pb-10">
                    <div class="flex flex-col items-center lg:items-start">
                        <div class="flex items-center gap-3 mb-2 md:mt-10 lg:mt-0">
                             <div class="w-2 h-8 bg-[#F77F1E] rounded-full"></div>
                             <h2 class="text-3xl font-black text-white tracking-tight">{{ __('Product Categories') }}</h2>
                        </div>
                        <p class="text-gray-200 font-medium">{{ __('Browse by series and technical classification') }}</p>
                    </div>
                    
                    <div class="flex items-center gap-3 overflow-x-auto pb-4 lg:pb-0 no-scrollbar w-full lg:w-auto scroll-smooth">
                        <a href="{{ route('products.view.user', request('search') ? ['search' => request('search')] : []) }}" 
                            class="category-pill {{ !$activeCategoryId ? 'active' : '' }} whitespace-nowrap px-8 py-3 rounded-2xl border-2 border-transparent font-bold bg-white text-gray-600 shadow-sm hover:shadow-md transition-all duration-300 flex items-center gap-2" id="cat-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            {{ __('All Products') }}
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('products.view.user', array_merge(['category' => \Illuminate\Support\Str::slug($category->name)], request('search') ? ['search' => request('search')] : [])) }}" 
                                class="category-pill {{ $activeCategoryId == $category->id ? 'active' : '' }} whitespace-nowrap px-8 py-3 rounded-2xl border-2 border-transparent font-bold bg-white text-gray-600 shadow-sm hover:shadow-md transition-all duration-300" id="cat-{{ $category->id }}">
                                {{ __($category->name) }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @if ($activeCategory && isset($availableTypes) && $availableTypes->isNotEmpty())
                    <div class="mb-10 flex flex-wrap items-center gap-2.5 bg-slate-900/15 backdrop-blur-sm border border-white/15 rounded-2xl p-4">
                        <span class="text-xs font-black text-white uppercase tracking-widest mr-2">
                            {{ __('Type') }} ({{ __($activeCategory->name) }}):
                        </span>
                        <a href="{{ route('products.view.user', array_filter(['category' => \Illuminate\Support\Str::slug($activeCategory->name), 'search' => request('search')])) }}"
                           class="whitespace-nowrap px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm {{ !$activeTypeId ? 'bg-[#F77F1E] text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                            {{ __('All Types') }}
                        </a>
                        @foreach ($availableTypes as $typeOption)
                            <a href="{{ route('products.view.user', array_filter(['category' => \Illuminate\Support\Str::slug($activeCategory->name), 'type' => \Illuminate\Support\Str::slug($typeOption->name), 'search' => request('search')])) }}"
                               class="whitespace-nowrap px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm {{ $activeTypeId == $typeOption->id ? 'bg-[#F77F1E] text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                                {{ __($typeOption->name) }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Product Grid -->
                <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                    @forelse ($products as $product)
                        @php
                            $customInput = null;
                            if (!empty($product->custom_input)) {
                                $customInput = json_decode($product->custom_input, true);
                            }
                            $resolvedTypeName = $product->resolvedTypeName();
                        @endphp
                        <div class="product-card group relative bg-white rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] hover:shadow-[0_20px_60px_rgba(6,108,95,0.12)] transition-all duration-500 overflow-hidden border border-gray-50 flex flex-col h-full" 
                             data-category-id="{{ $product->category_id }}" 
                             data-aos="fade-up"
                             data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                            
                            <!-- Category Badge Float -->
                            <div class="absolute top-6 left-6 z-20">
                                <span class="bg-white/80 backdrop-blur-md px-4 py-1.5 rounded-full text-[10px] font-black text-[#066C5F] uppercase tracking-widest border border-gray-100 shadow-sm">
                                    {{ __($product->category->name ?? '') }}
                                </span>
                            </div>

                            <!-- Product Image Container -->
                            <div class="relative h-72 overflow-hidden bg-gray-50/50 group-hover:bg-white transition-colors duration-500 flex items-center justify-center p-12">
                                <img src="{{ \App\Helpers\ProductHelper::imageUrl($product->image, 400) }}" 
                                     alt="{{ $product->name }}" 
                                     @if(\App\Helpers\ProductHelper::srcset($product->image))
                                     srcset="{{ \App\Helpers\ProductHelper::srcset($product->image) }}"
                                     sizes="(max-width: 640px) 280px, (max-width: 1024px) 380px, 450px"
                                     @endif
                                     {!! \App\Helpers\ProductHelper::imgAttrs($product->image) !!}
                                     loading="lazy"
                                     decoding="async"
                                     class="max-w-full max-h-full object-contain transform group-hover:scale-110 group-hover:rotate-2 transition-all duration-700 ease-out">
                                
                                <!-- Decorative background circle -->
                                <div class="absolute inset-0 bg-radial-gradient from-[#066C5F]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-8 flex flex-col flex-grow">
                                <div class="mb-6 flex-grow">
                                    <div class="text-[11px] font-bold text-[#F77F1E] mb-2 tracking-widest uppercase flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 bg-[#F77F1E] rounded-full"></span>
                                        {{ $product->kode ?? 'SKU-VINSA' }}
                                    </div>
                                    <h3 class="text-2xl font-black text-gray-900 group-hover:text-[#066C5F] transition-colors duration-300 leading-tight mb-4 line-clamp-2 h-16" title="{{ $product->name }}">
                                        {{ \Illuminate\Support\Str::limit($product->name, 50) }}
                                    </h3>

                                    <!-- Technical Details Pills -->
                                    <div class="flex flex-wrap gap-2">
                                        @php $pillCount = 0; @endphp
                                        @if ($resolvedTypeName)
                                            <span class="px-3 py-1 bg-[#066C5F]/10 rounded-lg text-[10px] font-bold text-[#066C5F] border border-[#066C5F]/20">
                                                {{ __('Type') }}: {{ \Illuminate\Support\Str::limit(__($resolvedTypeName), 18) }}
                                            </span>
                                            @php $pillCount++; @endphp
                                        @endif
                                        @if ($customInput && is_array($customInput))
                                            @foreach ($customInput as $key => $value)
                                                @php
                                                    $isDuplicateTypeKey = $resolvedTypeName && in_array(strtolower($key), ['tipe', 'type', 'value'], true)
                                                        && strtolower((string) ($product->category?->name ?? '')) !== 'cable tray';
                                                @endphp
                                                @if($pillCount < 3 && !empty($value) && !$isDuplicateTypeKey)
                                                    <span class="px-3 py-1 bg-gray-50 rounded-lg text-[10px] font-bold text-gray-500 border border-gray-100">
                                                        {{ __(ucfirst($key)) }}: {{ \Illuminate\Support\Str::limit(__((string)$value), 15) }}
                                                    </span>
                                                    @php $pillCount++; @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <a href="{{ route('product.show', $product->slug ?: $product->id) }}" 
                                   class="group/btn relative overflow-hidden flex items-center justify-center gap-3 w-full py-4 bg-[#066C5F] text-white rounded-2xl font-black text-sm tracking-wide shadow-lg shadow-[#066C5F]/20 hover:shadow-[#F77F1E]/30 transition-all duration-500">
                                    <span class="relative z-10">{{ __('VIEW SPECIFICATIONS') }}</span>
                                    <svg class="w-5 h-5 relative z-10 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                    <div class="absolute inset-0 bg-[#F77F1E] translate-y-full group-hover/btn:translate-y-0 transition-transform duration-500"></div>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-32 text-center" data-aos="fade-up">
                            <div class="w-32 h-32 bg-gray-50 rounded-[40px] flex items-center justify-center mb-8 border border-gray-100 shadow-inner">
                               <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 00-2 2H6a2 2 0 00-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <h3 class="text-3xl font-black text-gray-300 mb-4">{{ __('No Products Found') }}</h3>
                            <p class="text-gray-400 max-w-sm mx-auto font-medium">{{ __('Our engineering team is currently updating this collection. Please check back soon.') }}</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination Section -->
                @if ($products->hasPages())
                    <div class="mt-16 flex justify-center" data-aos="fade-up">
                        <div class="bg-white/95 backdrop-blur-md rounded-3xl px-6 py-4 shadow-xl border border-white/20">
                            {{ $products->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <x-footer />

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            easing: 'ease-out-expo'
        });
    </script>
    <script src="https://unpkg.com/alpinejs" defer></script>
</body>

</html>
