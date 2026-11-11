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
    @php
        $isProduction = app()->environment('production');
        $manifestPath = $isProduction ? '../public_html/build/manifest.json' : public_path('build/manifest.json');
    @endphp

    @if ($isProduction && file_exists($manifestPath))
        @php
            $manifest = json_decode(file_get_contents($manifestPath), true);
        @endphp
        <link rel="stylesheet" href="{{ config('app.url') }}/build/{{ $manifest['resources/css/app.css']['file'] }}">
        <script type="module" src="{{ config('app.url') }}/build/{{ $manifest['resources/js/app.js']['file'] }}"></script>
    @else
        @viteReactRefresh
        @vite(['resources/js/app.js', 'resources/css/app.css'])
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <title>Vinsa Electric | Solusi Perlengkapan Kelistrikan Industri & Komponen Panel Terpercaya (vinsa.fr)</title>
    <meta name="description" content="Vinsa Electric (vinsa.fr) - Merek perlengkapan kelistrikan industri dan otomasi terpercaya berstandar IEC 60947, CE, dan SNI standar global. Menyediakan Magnetic Contactor, Push Button 22mm, MCCB, MCB, Box Panel IP65/IP66, Pilot Lamp, dan switchgear berkualitas tinggi untuk kontraktor, panel maker, dan pabrik.">
    <meta name="keywords" content="vinsa, vinsa electric, vinsa.fr, alat listrik vinsa, kontaktor cjx2, push button 22mm, box panel ip65, mccb, mcb, pilot lamp, switchgear industri, alternatif merk global, panel listrik surabaya, pt anugerah tama sejati">
    <meta name="author" content="Vinsa Electric (PT. Anugerah Tama Sejati)">
    
    <!-- Canonical & Alternate Locales -->
    <link rel="canonical" href="https://vinsa.fr/">
    <link rel="alternate" hreflang="id" href="https://vinsa.fr/">
    <link rel="alternate" hreflang="en" href="https://vinsa.fr/">
    <link rel="alternate" hreflang="fr" href="https://vinsa.fr/">
    <link rel="alternate" hreflang="x-default" href="https://vinsa.fr/">

    <link rel="icon" type="image/png" href="{{ asset('image/vinsalg.png') }}">

    <!-- Bot & Search Crawler Optimization -->
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <!-- Open Graph / Facebook / LinkedIn / WhatsApp Preview -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vinsa Electric">
    <meta property="og:url" content="https://vinsa.fr/">
    <meta property="og:title" content="Vinsa Electric | Solusi Perlengkapan Kelistrikan Industri Terpercaya (vinsa.fr)">
    <meta property="og:description" content="Produsen & distributor komponen kelistrikan industri: Magnetic Contactor, Push Button, MCCB, MCB, Box Panel IP65/IP66 berstandar IEC 60947 & CE.">
    <meta property="og:image" content="{{ asset('image/vinsalg.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Vinsa Electric - Solusi Perlengkapan Kelistrikan Industri">
    <meta property="og:locale" content="id_ID">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:locale:alternate" content="fr_FR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@vinsa_fr">
    <meta name="twitter:title" content="Vinsa Electric | Solusi Perlengkapan Kelistrikan Industri (vinsa.fr)">
    <meta name="twitter:description" content="Brand alat listrik terpercaya berstandar IEC 60947 & CE. Solusi andal untuk panel maker, kontraktor MEP, dan industri standar global.">
    <meta name="twitter:image" content="{{ asset('image/vinsalg.png') }}">

    <!-- GEO / AEO Knowledge Graph Schema Markup (JSON-LD) -->
    <x-schema.website />
    <x-schema.organization />
    <x-schema.local-business />
    <style>
        .outfit {
            font-family: "Outfit", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
        }

        @keyframes shine {
            0% {
                background-position: -200%;
            }

            100% {
                background-position: 200%;
            }
        }

        .shining-text {
            background-image: linear-gradient(90deg, #9e9e9e 25%, #ffffff 50%, #9e9e9e 75%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shine 6s linear infinite;
        }

        /* Untuk Chrome, Safari, Edge */
        ::-webkit-scrollbar {
            width: 6px;
            /* Lebar scrollbar */
            height: 7px;
            /* Tinggi scrollbar */
        }

        ::-webkit-scrollbar-button {
            display: block;
            background-color: #cccccc00;
            /* Warna tombol */
            border-radius: 10px;
            width: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #ffffff84;
            /* Warna thumb */
            border-radius: 100px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #ffffffd6;
            /* Warna saat hover */
        }

        ::-webkit-scrollbar-track {
            background: transparent;
            /* Menghilangkan background */
        }

        /* Untuk Firefox */
        .scroll-container {
            scrollbar-width: thin;
            /* Lebar scrollbar */
            scrollbar-color: #888 transparent;
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

        @keyframes jump {

            0%,
            85% {
                transform: translateY(0);
            }

            /* Stays normal */
            90% {
                transform: translateY(-10px);
            }

            /* Moves up */
            100% {
                transform: translateY(0);
            }

            /* Smooth return */
        }

        .jump-text span {
            display: inline-block;
            white-space: pre;
            animation: jump 2.3s ease-in-out infinite;
            animation-delay: calc(45ms * var(--i));
        }
        /* Tablet-only (768px to 1024px) no-slide behavior */
        @media (min-width: 768px) and (max-width: 1024px) {
            .category-slider {
                flex-wrap: wrap !important;
                overflow-x: hidden !important;
                gap: 1rem !important;
            }
            .category-slider > div:nth-child(n+5) {
                display: none !important;
            }
            .see-more-tablet {
                display: flex !important;
            }
        }
        @media (max-width: 767px), (min-width: 1025px) {
            .see-more-tablet {
                display: none !important;
            }
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }

        /* Ensure slider buttons are visible on mobile */
        @media (max-width: 767px) {
            .group\/slider > button,
            .group\/outer-slider > button.outer-slider-btn {
                opacity: 1 !important;
                display: flex !important;
            }
            .group\/outer-slider > button.outer-slider-btn:disabled {
                opacity: 0.4 !important;
            }
            .hide-slider-mobile > button {
                display: none !important;
            }
        }

        /* Landscape Mobile Optimization */
        @media (max-height: 500px) and (orientation: landscape) {
            .landscape-banner {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
                max-height: 400px !important;
            }
            .landscape-title {
                font-size: 2.5rem !important;
                line-height: 1.1 !important;
            }
            .landscape-subtitle {
                font-size: 1rem !important;
                padding-bottom: 1rem !important;
            }
            .landscape-buttons {
                margin-top: 1rem !important;
            }
        }

        /* Safari & iOS Compatibility */
        .slider-container, #blogCarousel, .category-slider {
            -webkit-overflow-scrolling: touch !important; /* Smooth momentum scrolling on iOS */
            scroll-behavior: smooth;
        }

        [class*="backdrop-blur"] {
            -webkit-backdrop-filter: blur(12px); /* Safari support for backdrop-filter */
            backdrop-filter: blur(12px);
        }

        /* Fix for Safari flex gap issues in older versions if necessary */
        .slider-container {
            display: -webkit-flex;
            display: flex;
            overscroll-behavior-x: contain;
            will-change: scroll-position;
        }

        /* 60fps GPU-Accelerated Dropdown (No scrollHeight / layout thrashing) */
        .vinsa-dropdown-wrapper {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.28s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.22s ease;
            opacity: 0;
        }

        .vinsa-dropdown-wrapper.is-open {
            grid-template-rows: 1fr;
            opacity: 1;
        }

        .vinsa-dropdown-inner {
            overflow: hidden;
            min-height: 0;
        }
    </style>
</head>

<body class="outfit bg-[#FDFBEE]">
    <x-app-loader />
    <div class="max-w-[93%] mx-auto">
        <header role="banner" class="flex justify-between items-center py-3">
            <x-navUser class="relative z-[11]"></x-navUser>
        </header>

        <main id="main-content" role="main">
            {{-- Hero Banner Section --}}
            <section aria-label="Pengenalan Vinsa Electric" class="landscape-banner overflow-hidden lg:p-[5rem] lg:justify-center py-[80px] h-full lg:max-h-[720px] flex justify-center relative bg-no-repeat bg-cover after:content-[''] after:bg-[rgba(40,40,40,0.65)] after:w-full after:h-full after:absolute after:top-0 after:left-0 rounded-[40px]"
                style="background-image:url('/image/pabrik.jpg')">
                <div class="lg:w-[65%] w-full relative z-[10] px-4 text-center">
                    <p class="shining-text text-lg md:text-xl font-semibold tracking-wide uppercase mb-3">
                        {{ __('Standar Kualitas Internasional IEC 60947 & CE') }}
                    </p>
                    <h1 class="landscape-title text-3xl sm:text-5xl lg:text-6xl font-extrabold text-[#fff] tracking-tight leading-tight">
                        {!! __('Vinsa Electric<br>Solusi Kelistrikan & Panel Industri Terpercaya') !!}
                    </h1>
                    <p class="landscape-subtitle text-base sm:text-lg lg:text-xl text-center mx-auto text-white/95 pt-4 pb-8 max-w-2xl leading-relaxed">
                        "{{ __('Dedikasi dalam menghadirkan perlengkapan kelistrikan industri dan switchgear berkualitas premium standar global untuk panel maker, kontraktor MEP, manufaktur, dan perumahan.') }}"
                    </p>
                    <div class="landscape-buttons flex flex-wrap gap-4 my-4 justify-center">
                        <a href="/product"
                            class="bg-[#066c5f] hover:bg-[#0dd8bd] text-white font-bold px-8 py-3.5 transition-all duration-200 ease-in-out rounded-full shadow-lg shadow-teal-900/30">
                            {{ __('Jelajahi Produk') }}
                        </a>
                        <a href="https://wa.me/6281335715398"
                            class="border-2 border-[#F77F1E] text-white font-bold px-8 py-3.5 rounded-full transition-all duration-300 ease-in-out shadow hover:bg-[#F77F1E]">
                            {{ __('Konsultasi Teknis & Penawaran') }}
                        </a>
                    </div>
                </div>
            </section>

            {{-- Slider Carousel Unggulan --}}
            <section aria-label="Produk dan Inovasi Unggulan" class="swiper mySwiper w-full mt-10">
                <div class="swiper-wrapper">
                    @foreach ($carousels as $carousel)
                        <div class="swiper-slide flex justify-center">
                            <img class="rounded-3xl w-full object-cover max-h-[460px]" 
                                 src="{{ \App\Helpers\ProductHelper::imageUrl($carousel->image) }}" 
                                 alt="Vinsa Electric - Komponen Panel Listrik dan Switchgear Industri Berstandar IEC 60947"
                                 loading="lazy">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </section>


        {{-- category produk --}}
        <div class="grid gap-4">
            @foreach ($categories as $category)
                @php
                    $firstProduct = $category->products->first();
                    $categorySlug = \Illuminate\Support\Str::slug($category->name);
                @endphp

                <div class="grid grid-cols-12 gap-4 row-span-1  ">
                    <!-- {{-- KIRI: Gambar dan nama kategori --}}
                    @if (strtolower($category->name) === 'accessories')
                        <div
                            class="bg-[#5f5f5f60] border-white border-[1.5px] col-span-2 hidden p-4 text-center rounded-xl overflow-hidden shadow-md md:flex md:flex-col items-center justify-start md:hidden lg:block">
                            <h3 class="text-lg font-bold mb-2">{{ $category->name }}</h3>

                            @if ($firstProduct)
                                <div
                                    class="w-[120px] h-[150px] flex items-center justify-center text-gray-400 bg-white rounded-md">
                                    Gambar tidak tersedia
                                </div>
                            @else
                                <div
                                    class="w-[120px] h-[150px] flex items-center justify-center text-gray-400 bg-white rounded-md">
                                    Gambar tidak tersedia
                                </div>
                            @endif
                        </div>
                    @else
                        <div
                            class="bg-[#5f5f5f60] border-white border-[1.5px] col-span-2 hidden p-4 text-center rounded-xl overflow-hidden shadow-md items-center justify-start md:hidden lg:block">
                            <h3 class="text-lg font-bold mb-2">
                                <a href="{{ route('products.view.user', \Illuminate\Support\Str::slug($category->name)) }}" class="hover:text-[#066C5F] transition-colors uppercase">
                                    {{ $category->name }}
                                </a>
                            </h3>

                            @if ($firstProduct && $firstProduct->image)
                                <img src="{{ \App\Helpers\ProductHelper::imageUrl($firstProduct->image) }}"
                                    alt="{{ $firstProduct->name }}" class="w-[120px] h-[150px] object-cover rounded-md">
                            @else
                                <div
                                    class="w-[120px] h-[150px] flex items-center justify-center text-gray-400 bg-white rounded-md">
                                    {{ __('Image not available') }}
                                </div>
                            @endif
                        </div>
                    @endif -->

                    {{-- KANAN: Produk dalam slider horizontal --}}
                    <div class="col-span-12 bg-[#5f5f5f60]/30 backdrop-blur-sm w-full rounded-3xl p-6 md:hidden lg:block shadow-xl border border-white/10">
                        <h3 class="text-xl font-bold mb-4 border-b-[1.5px] pb-3 border-white/20 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-[#066c5f] rounded-full"></span>
                            <a href="{{ route('products.view.user', \Illuminate\Support\Str::slug($category->name)) }}" class="hover:text-[#066C5F] transition-colors uppercase">
                                {{ __($category->name) }}
                            </a>
                        </h3>

                        @if ($category->products->count() || $category->types->isNotEmpty())
                            @if ($category->types->isNotEmpty())
                                <x-category-types-slider :category="$category" />
                            @elseif (strtolower($category->name) === 'push button')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                                    {{-- KB 5 Series --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            KB 5 Series
                                        </h4>
                                        @php
                                            $kb5Products = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'kb5');
                                            })->sortBy(function ($item) {
                                                return $item->kode;
                                            }, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $kb5Products->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($kb5Products as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- KB 2 Series --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            KB 2 Series
                                        </h4>
                                        @php
                                            $kb2Products = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'kb2');
                                            })->sortBy(fn($i) => $i->kode, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $kb2Products->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($kb2Products as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @elseif (strtolower($category->name) === 'illuminated push button')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                                    {{-- KB 5 Series --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            KB 5 Series
                                        </h4>
                                        @php
                                            $kb5Products = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'kb5');
                                            })->sortBy(function ($item) {
                                                return $item->kode;
                                            }, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $kb5Products->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($kb5Products as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- KB 2 Series --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            KB 2 Series
                                        </h4>
                                        @php
                                            $kb2Products = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'kb2');
                                            })->sortBy(fn($i) => $i->kode, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $kb2Products->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($kb2Products as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @elseif (strtolower($category->name) === 'emergency push button')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                                    {{-- KB 5 Series --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            KB 5 Series
                                        </h4>
                                        @php
                                            $kb5Products = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'kb5');
                                            })->sortBy(function ($item) {
                                                return $item->kode;
                                            }, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $kb5Products->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($kb5Products as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- KB 2 Series --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            KB 2 Series
                                        </h4>
                                        @php
                                            $kb2Products = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'kb2');
                                            })->sortBy(fn($i) => $i->kode, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $kb2Products->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($kb2Products as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @elseif (strtolower($category->name) === 'illuminated selector switch')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                                    {{-- KB 5 Series --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            KB 5 Series
                                        </h4>
                                        @php
                                            $kb5Products = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'kb5');
                                            })->sortBy(function ($item) {
                                                return $item->kode;
                                            }, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $kb5Products->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($kb5Products as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- KB 2 Series --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            KB 2 Series
                                        </h4>
                                        @php
                                            $kb2Products = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'kb2');
                                            })->sortBy(fn($i) => $i->kode, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $kb2Products->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($kb2Products as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @elseif (strtolower($category->name) === 'cable ties')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                                    {{-- Nylon --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            Nylon Cable Ties
                                        </h4>
                                        @php
                                            $nctProducts = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'nct');
                                            })->sortBy(function ($item) {
                                                return $item->kode;
                                            }, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $nctProducts->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($nctProducts as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Stainless Steel --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            Stainless Steel Cable Ties
                                        </h4>
                                        @php
                                            $ssctProducts = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'ssct');
                                            })->sortBy(fn($i) => $i->kode, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $ssctProducts->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($ssctProducts as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @elseif (strtolower($category->name) === 'selector switch')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                                    {{-- KB 5 Series --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            KB 5 Series
                                        </h4>
                                        @php
                                            $kb5Products = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'kb5');
                                            })->sortBy(function ($item) {
                                                return $item->kode;
                                            }, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $kb5Products->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($kb5Products as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- KB 2 Series --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            KB 2 Series
                                        </h4>
                                        @php
                                            $kb2Products = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'kb2');
                                            })->sortBy(fn($i) => $i->kode, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $kb2Products->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($kb2Products as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @elseif (strtolower($category->name) === 'cable lug')
                                @php
                                    // 5 panel series Cable Lug (samakan dengan value yang tersimpan di custom_input['series'])
                                    $lugSeries = [
                                        'SC Cable Lug',
                                        'SV Cable Lug',
                                        'RV Cable Lug',
                                        'PTV Cable Lug',
                                        'DBV Cable Lug',
                                    ];

                                    $getCI = function ($item) {
                                        $ci = json_decode($item->custom_input, true);
                                        return is_array($ci) ? $ci : [];
                                    };
                                @endphp

                                {{-- CAROUSEL panel: tampil 2 panel, geser untuk lihat 5 panel --}}
                                @php
                                    $cntSeries = count($lugSeries);
                                @endphp
                                <div class="relative group/outer-slider {{ $cntSeries < 3 ? 'hide-slider-mobile' : '' }}">
                                    <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <div class="slider-container flex gap-4 overflow-x-auto pb-6 snap-x snap-mandatory no-scrollbar">
                                    @foreach ($lugSeries as $seriesName)
                                        @php
                                            $items = $category->products
                                                ->filter(function ($item) use ($getCI, $seriesName) {
                                                    $ci = $getCI($item);
                                                    $series = strtolower(trim((string) ($ci['series'] ?? '')));
                                                    return $series === strtolower(trim($seriesName));
                                                })
                                                ->sortBy(fn($i) => $i->kode, SORT_NATURAL | SORT_FLAG_CASE);

                                            // judul panel biar tampil "SC Series" dst
                                            $panelTitle =
                                                strtoupper(trim(str_ireplace('Cable Lug', '', $seriesName))) .
                                                ' ' . __('Series');
                                        @endphp

                                        <x-product-series :seriesName="$panelTitle" :items="$items" />
                                    @endforeach
                                    </div>
                                    <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                            @elseif (strtolower($category->name) === 'terminal block')
                                @php
                                    $tbSeries = [
                                        'Terminal Strip',
                                        'Terminal Block TB',
                                        'Terminal Block TBC',
                                        'Terminal Block TBR',
                                        'Terminal Block TUK',
                                        'Terminal Block TUSLKG',
                                        'Terminal Block KLUS',
                                    ];

                                    $getCI = function ($item) {
                                        $ci = json_decode($item->custom_input, true);
                                        return is_array($ci) ? $ci : [];
                                    };
                                @endphp

                                {{-- CAROUSEL panel: tampil 2 panel, geser untuk lihat 6 panel --}}
                                <div class="relative group/outer-slider {{ count($tbSeries) < 3 ? 'hide-slider-mobile' : '' }}">
                                    <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <div class="slider-container flex gap-4 overflow-x-auto pb-6 snap-x snap-mandatory no-scrollbar">
                                    @foreach ($tbSeries as $seriesName)
                                        @php
                                            $items = $category->products
                                                ->filter(function ($item) use ($getCI, $seriesName) {
                                                    $ci = $getCI($item);
                                                    $series = strtolower(trim((string) ($ci['series'] ?? '')));
                                                    return $series === strtolower(trim($seriesName));
                                                })
                                                ->sortBy(fn($i) => $i->kode, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp

                                        <x-product-series :seriesName="$seriesName" :items="$items" />
                                    @endforeach
                                    </div>
                                    <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                            @elseif (strtolower($category->name) === 'mccb')
                                @php
                                    $mccbSeries = [
                                        'M12B 25kA',
                                        'M16F 35kA',
                                        'M25F 35kA',
                                        'M40F 35kA',
                                        'M63F 35kA',
                                        'M80F 35kA',
                                    ];

                                    $getCI = function ($item) {
                                        $ci = json_decode($item->custom_input, true);
                                        return is_array($ci) ? $ci : [];
                                    };
                                @endphp

                                {{-- CAROUSEL panel: tampil 2 panel, geser untuk lihat 6 panel --}}
                                <div class="relative group/outer-slider {{ count($mccbSeries) < 3 ? 'hide-slider-mobile' : '' }}">
                                    <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <div class="slider-container flex gap-4 overflow-x-auto pb-6 snap-x snap-mandatory no-scrollbar">
                                    @foreach ($mccbSeries as $seriesName)
                                        @php
                                            $items = $category->products
                                                ->filter(function ($item) use ($getCI, $seriesName) {
                                                    $ci = $getCI($item);
                                                    $series = strtolower(trim((string) ($ci['series'] ?? '')));
                                                    return $series === strtolower(trim($seriesName));
                                                })
                                                ->sortBy(fn($i) => $i->kode, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp

                                        <x-product-series :seriesName="$seriesName" :items="$items" />
                                    @endforeach
                                    </div>
                                    <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                            @elseif (strtolower($category->name) === 'mccb accessories')
                                @php
                                    $mccbacSeries = [
                                        'MAA Alarm Contact',
                                        'MAS Shunt Release',
                                        'MAAUX Auxiliary Contact',
                                        'MAUVT Under Voltage',
                                        'MARH Extended Rotary Handle',
                                    ];

                                    $getCI = function ($item) {
                                        $ci = json_decode($item->custom_input, true);
                                        return is_array($ci) ? $ci : [];
                                    };
                                @endphp

                                {{-- CAROUSEL panel: tampil 2 panel, geser untuk lihat 6 panel --}}
                                <div class="relative group/outer-slider {{ count($mccbacSeries) < 3 ? 'hide-slider-mobile' : '' }}">
                                    <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <div class="slider-container flex gap-4 overflow-x-auto pb-6 snap-x snap-mandatory no-scrollbar">
                                    @foreach ($mccbacSeries as $seriesName)
                                        @php
                                            $items = $category->products
                                                ->filter(function ($item) use ($getCI, $seriesName) {
                                                    $ci = $getCI($item);
                                                    $series = strtolower(trim((string) ($ci['series'] ?? '')));
                                                    return $series === strtolower(trim($seriesName));
                                                })
                                                ->sortBy(fn($i) => $i->kode, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp

                                        <x-product-series :seriesName="$seriesName" :items="$items" />
                                    @endforeach
                                    </div>
                                    <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                            @elseif (strtolower($category->name) === 'contactor accessories')
                                @php
                                    $caSeries = [
                                        'Coil Contactor',
                                        'Auxiliary Contact',
                                        'Time Delay',
                                        'Thermal Overload Relay',
                                    ];

                                    $getCI = function ($item) {
                                        $ci = json_decode($item->custom_input, true);
                                        return is_array($ci) ? $ci : [];
                                    };
                                @endphp

                                {{-- CAROUSEL panel: tampil 2 panel, geser untuk lihat 6 panel --}}
                                <div class="relative group/outer-slider {{ count($caSeries) < 3 ? 'hide-slider-mobile' : '' }}">
                                    <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <div class="slider-container flex gap-4 overflow-x-auto pb-6 snap-x snap-mandatory no-scrollbar">
                                    @foreach ($caSeries as $seriesName)
                                        @php
                                            $items = $category->products
                                                ->filter(function ($item) use ($getCI, $seriesName) {
                                                    $ci = $getCI($item);
                                                    $series = strtolower(trim((string) ($ci['series'] ?? '')));
                                                    return $series === strtolower(trim($seriesName));
                                                })
                                                ->sortBy(fn($i) => $i->kode, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp

                                        <x-product-series :seriesName="$seriesName" :items="$items" />
                                    @endforeach
                                    </div>
                                    <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                            @elseif (strtolower($category->name) === 'box panel')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    {{-- Wall Mounting IP65 --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            Box Panel Wall Mounting IP65
                                        </h4>
                                        @php
                                            $wallMountingProducts = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'vhb') && !str_contains(strtolower($item->kode), 'vhb200');
                                            })->sortBy(function ($item) {
                                                return $item->kode;
                                            }, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $wallMountingProducts->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($wallMountingProducts as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Free Standing IP55 --}}
                                    <div class="w-full text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full"></span>
                                            Box Panel Free Standing IP55
                                        </h4>
                                        @php
                                            $freeStandingProducts = $category->products->filter(function ($item) {
                                                return str_contains(strtolower($item->kode), 'vhb200');
                                            })->sortBy(function ($item) {
                                                return $item->kode;
                                            }, SORT_NATURAL | SORT_FLAG_CASE);
                                        @endphp
                                        <div class="relative group/slider {{ $freeStandingProducts->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                            <button type="button" class="absolute -left-2 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                                                @foreach ($freeStandingProducts as $productItem)
                                                    @php
                                                        $customInput = json_decode($productItem->custom_input, true);
                                                    @endphp
                                                    <div class="flex-shrink-0 w-48 group">
                                                        <a href="/detail/{{ $productItem->slug }}"
                                                            class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4">
                                                            <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                                @if (!empty($productItem->image))
                                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                         @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                         srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                         sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                         @endif
                                                                         {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                         loading="lazy"
                                                                         alt="{{ $productItem->name }}"
                                                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                                @else
                                                                    <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="mt-4 flex flex-col flex-1">
                                                                <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                                    {{ Str::limit($productItem->kode, 20) }}
                                                                </p>
                                                                <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                
                                                                @if(isset($customInput) && $customInput)
                                                                    <div class="mt-2 space-y-0.5">
                                                                        @foreach (array_slice($customInput, 0, 2) as $key => $value)
                                                                            <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit($value, 12) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="mt-auto pt-3 flex justify-between items-center">
                                                                    <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="absolute -right-2 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Layout default jika bukan kategori khusus di atas --}}
                                <div class="relative group/slider {{ $category->products->count() < 3 ? 'hide-slider-mobile' : '' }}">
                                    <button type="button" class="absolute -left-2 lg:-left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, -1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar mt-4">
                                        @foreach ($category->products->sortBy(function ($item) {
                                            return $item->kode;
                                        }, SORT_NATURAL | SORT_FLAG_CASE) as $productItem)
                                            @php
                                                $customInput = json_decode($productItem->custom_input, true);
                                            @endphp
                                            <div class="flex-shrink-0 w-48 group">
                                                <a href="/detail/{{ $productItem->slug }}"
                                                    class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4 shadow-lg">
                                                    <div class="w-full h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
                                                        @if (!empty($productItem->image))
                                                            <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                                 @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                                 srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                                 sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                                 @endif
                                                                 {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                                 loading="lazy"
                                                                 alt="{{ $productItem->name }}"
                                                                 class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                        @else
                                                            <div class="text-xs text-white/50">{{ __('No image') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="mt-4 flex flex-col flex-1">
                                                        <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                                                            {{ Str::limit($productItem->kode, 20) }}
                                                        </p>
                                                        <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                                                            {{ $productItem->name }}
                                                        </p>
                                                        @if ($resolvedCardType = $productItem->resolvedTypeName())
                                                            <div class="mt-1.5 text-[9px] text-white/60 uppercase">
                                                                {{ __('Type') }}: {{ Str::limit($resolvedCardType, 16) }}
                                                            </div>
                                                        @endif
                                                        <div class="mt-auto pt-3 flex justify-between items-center">
                                                            <span class="text-[10px] text-white/40 font-semibold italic">{{ __('VIEW') }}</span>
                                                            <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-[#066c5f] transition-colors">
                                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="absolute -right-2 lg:-right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110" onclick="scrollSlider(this, 1)">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                            @endif
                        @else
                            <p class="text-sm text-gray-500">{{ __('No products in this category.') }}</p>
                        @endif
                    </div>

                    @php
                        $previewItems = $category->products->take(3);
                    @endphp

                    {{-- TABLET ONLY (md): NO MORE carousel inside carousel --}}
                    <div class="hidden md:block bg-[#5f5f5f60]/40 backdrop-blur-md lg:hidden p-8 mt-2 col-span-12 rounded-[2rem] border border-white/20 shadow-2xl">
                        <h3 class="text-2xl font-bold mb-4 border-b-[1.5px] pb-4 border-white/20 text-white flex items-center gap-3">
                            <div class="w-3 h-3 bg-[#066c5f] rounded-full animate-pulse shadow-[0_0_10px_#066c5f]"></div>
                            {{ __($category->name) }}
                        </h3>

                        @if ($category->types->isNotEmpty())
                            <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-2 no-scrollbar">
                                @foreach ($category->types as $tabletType)
                                    <a href="{{ route('products.view.user', ['category' => $categorySlug, 'type' => \Illuminate\Support\Str::slug($tabletType->name)]) }}"
                                        class="whitespace-nowrap px-4 py-1.5 rounded-full bg-white/15 hover:bg-[#066c5f] text-white text-xs font-bold border border-white/20 transition-colors">
                                        {{ __($tabletType->name) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="grid grid-cols-3 gap-6">
                            @foreach ($previewItems as $productItem)
                                <a href="/detail/{{ $productItem->slug }}"
                                    class="group bg-white/5 hover:bg-white/15 backdrop-blur-xl border border-white/10 hover:border-white/30 transition-all duration-500 rounded-[1.5rem] p-5 flex flex-col shadow-2xl hover:-translate-y-2">

                                    <div class="w-full h-44 rounded-xl overflow-hidden bg-white/10 flex items-center justify-center p-4">
                                        @if (!empty($productItem->image))
                                            <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}"
                                                 @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                                                 srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                                                 sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                                                 @endif
                                                 {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                                                 loading="lazy"
                                                 alt="{{ $productItem->name }}"
                                                 class="w-full h-full object-contain group-hover:scale-125 transition-transform duration-700">
                                        @else
                                            <div class="text-xs text-white/30">{{ __('No image') }}</div>
                                        @endif
                                    </div>

                                    <div class="mt-5 flex flex-col flex-1">
                                        <p class="text-[10px] uppercase tracking-[0.2em] font-black mb-2 opacity-80">
                                            {{ Str::limit($productItem->kode, 24) }}
                                        </p>
                                        <p class="text-base font-bold text-white leading-snug line-clamp-2 group-hover:text-[#066c5f] transition-colors">
                                            {{ $productItem->name }}
                                        </p>
                                        @if ($tabletCardType = $productItem->resolvedTypeName())
                                            <p class="text-[11px] font-semibold text-white/75 mt-1.5 truncate">
                                                {{ __($tabletCardType) }}
                                            </p>
                                        @endif
                                        
                                        <div class="mt-auto pt-5 flex justify-between items-center border-t border-white/5">
                                            <span class="text-[11px] text-white/50 font-medium tracking-wide">{{ __('DETAILS') }}</span>
                                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-[#066c5f] transition-all duration-300 group-hover:rotate-45">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="flex justify-center md:justify-end mt-6">
                            <a href="{{ url('/product/' . $categorySlug) }}"
                                class="group flex items-center gap-2 px-6 py-2.5 bg-white/10 hover:bg-white text-white hover:text-[#066c5f] border border-white/20 rounded-full font-bold transition-all duration-300 shadow-lg backdrop-blur-sm">
                                <span>{{ __('See All Products') }}</span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mx-auto mt-10">
            <!-- Grid Section -->
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-[#ffffff60] backdrop-blur-sm border-[1.5px] border-[#066c5f] p-6 rounded-3xl shadow-lg">
                    <h2 class="text-xl font-bold mb-2">{{ __('🌟 Best Quality') }}</h2>
                    <p>{{ __('Quality you can trust, performance you can rely on.') }}</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-[#ffffff60] backdrop-blur-sm border-[1.5px] border-[#066c5f] p-6 rounded-3xl shadow-lg">
                    <h2 class="text-xl font-bold mb-2">{{ __('🔧 Best Product') }}</h2>
                    <p>{{ __('Reliable, safe, and efficient electrical products for home and business.') }}</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-[#ffffff60] backdrop-blur-sm border-[1.5px] border-[#066c5f] p-6 rounded-3xl shadow-lg">
                    <h2 class="text-xl font-bold mb-2">{{ __('⚙ Best Service') }}</h2>
                    <p>{{ __('Smart, durable, and energy-efficient electrical solutions for homes and businesses.') }}</p>
                </div>
            </div>
            <!-- Call to Action -->
            <div
                class="mt-10 p-6 bg-[#066c5f] mb border-[1.5px] border-[#0cbca5] text-white rounded-3xl text-center shadow-lg">
                <h2 class="text-2xl font-bold mb-4">{{ __('Contact Us') }}</h2>
                <p class="mb-[1.5rem]">{{ __('Get the best products and the best quality at affordable prices and you will be able to feel the advantages yourself.') }}</p>
                <a href="{{ route('contact-us') }}"
                    class="border-2 bg-white underline hover:text-blue-500 text-[#000] px-6 py-2 rounded-full transition-all duration-300 ease-in-out shadow border-[#fff]">{{ __('Contact Us') }} →</a>
            </div>
            <div
                class="mt-10 mx-auto p-6 lg:w-[50%] bg-[#ffffff60] backdrop-blur-sm mb border-[1.5px] border-[#066c5f] rounded-3xl text-center shadow-lg">
                <h2 class="text-2xl font-bold mb-4 jump-text">
                    @php
                        $checkOurProduct = __('Check Our Product');
                        $letters = str_split($checkOurProduct);
                    @endphp
                    @foreach($letters as $index => $letter)
                        <span style="--i:{{ $index }}">{{ $letter }}</span>
                    @endforeach
                </h2>
                <p class="mb-[1.5rem]">{{ __('Built for durability and safety') }}</p>
                <a href="/product"
                    class="border-2 bg-[#066c5f] text-white underline hover:text-blue-500  px-6 pt-2 pb-3 rounded-full transition-all duration-300 ease-in-out shadow border-[#fff]">{{ __('Our Product More') }} →</a>
            </div>
        </div>
        <p class="font-bold text-[28px] border-b-[1.5px] mb-5 pb-4 border-[#0000006a]">{{ __('From Our Blog') }}</p>

        @php
            // Ambil hanya yang published
            $publishedBlogs = $blogs->filter(fn($b) => !empty($b->is_published))->values();
            $count = $publishedBlogs->count();

            // Max 3 jika tidak carousel
            $displayBlogs = $count <= 3 ? $publishedBlogs : $publishedBlogs; // carousel: tampil semua
        @endphp

        @if ($count === 0)
            <p class="text-sm text-gray-500">{{ __('No blogs available.') }}</p>
        @elseif($count <= 3)
            {{-- GRID MAX 3 --}}
            <div class="grid md:grid-cols-3 gap-6 items-stretch">
                @foreach ($displayBlogs as $blog)
                    <a href="{{ route('blog.public', ['slug' => $blog->slug]) }}" class="group block w-full h-full">
                        <div
                            class="mx-auto w-full max-w-[420px]
                           min-h-[420px] max-h-[420px]
                           bg-[#ffffff60] backdrop-blur-sm
                           border-[1.5px] border-[#066c5f]
                           p-6 rounded-3xl shadow-lg
                           flex flex-col overflow-hidden
                           transition-all duration-300
                           group-hover:shadow-xl group-hover:shadow-[#00000046]
                           group-hover:ring-2 group-hover:ring-[#066c5f]/30
                           group-hover:scale-[1.01]">

                            <div
                                class="w-full h-[190px] rounded-2xl overflow-hidden bg-white/60 flex items-center justify-center">
                                @if (!empty($blog->image))
                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($blog->image) }}" alt="{{ $blog->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="text-xs text-gray-500">{{ __('No Image') }}</div>
                                @endif
                            </div>

                            <div class="mt-4 flex-1 flex flex-col">
                                <p class="font-bold text-base leading-snug line-clamp-2">{{ $blog->title }}</p>

                                @php
                                    $firstSection = $blog->sections->first();
                                    $previewHtml = $blog->content ?? (optional($firstSection)->content ?? '');
                                    $previewText = trim(preg_replace('/\s+/', ' ', strip_tags($previewHtml)));
                                @endphp

                                @if (!empty($previewText))
                                    <p class="text-[11px] text-gray-700 mt-2 line-clamp-5">
                                        @if (!empty(optional($firstSection)->subtitle))
                                            <span class="font-semibold">{{ $firstSection->subtitle }}:</span>
                                        @endif
                                        {{ $previewText }}
                                    </p>
                                @else
                                    <p class="text-[11px] text-gray-500 italic mt-2">{{ __('No content') }}</p>
                                @endif

                                <div class="mt-auto pt-3">
                                    <span
                                        class="text-[11px] text-[#066c5f] font-semibold opacity-80 group-hover:opacity-100">
                                        {{ __('Read more') }} →
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            {{-- CAROUSEL (jika lebih dari 3) --}}
            <div class="relative">
                {{-- tombol kiri --}}
                <button type="button"
                    class="hidden md:flex items-center justify-center absolute -left-3 top-1/2 -translate-y-1/2 z-10
                   w-10 h-10 rounded-full bg-white/80 backdrop-blur border border-black/10 shadow
                   hover:bg-white transition"
                    onclick="blogCarouselScroll(-1)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="stroke-black">
                        <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>

                {{-- tombol kanan --}}
                <button type="button"
                    class="hidden md:flex items-center justify-center absolute -right-3 top-1/2 -translate-y-1/2 z-10
                   w-10 h-10 rounded-full bg-white/80 backdrop-blur border border-black/10 shadow
                   hover:bg-white transition"
                    onclick="blogCarouselScroll(1)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="stroke-black">
                        <path d="M9 6l6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>

                {{-- track --}}
                <div id="blogCarousel"
                    class="flex gap-6 overflow-x-auto scroll-smooth snap-x snap-mandatory
                    py-10 -mx-1 px-1
                    [scrollbar-width:none] [-ms-overflow-style:none]
                    [&::-webkit-scrollbar]:hidden">
                    @foreach ($displayBlogs as $blog)
                        <a href="{{ route('blog.public', ['slug' => $blog->slug]) }}"
                            class="group block snap-start shrink-0 w-[88%] sm:w-[60%] md:w-[420px]">
                            <div
                                class="w-full
                               min-h-[420px] max-h-[420px]
                               bg-[#ffffff60] backdrop-blur-sm
                               border-[1.5px] border-[#066c5f]
                               p-6 rounded-3xl shadow-lg
                               flex flex-col overflow-hidden
                               transition-all duration-300
                               group-hover:shadow-xl group-hover:shadow-[#00000046]
                               group-hover:ring-2 group-hover:ring-[#066c5f]/30
                               group-hover:scale-[1.01]">

                                <div
                                    class="w-full h-[190px] rounded-2xl overflow-hidden bg-white/60 flex items-center justify-center">
                                    @if (!empty($blog->image))
                                        <img src="{{ \App\Helpers\ProductHelper::imageUrl($blog->image) }}"
                                            alt="{{ $blog->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-xs text-gray-500">No Image</div>
                                    @endif
                                </div>

                                <div class="mt-4 flex-1 flex flex-col">
                                    <p class="font-bold text-base leading-snug line-clamp-2">{{ $blog->title }}</p>

                                    @php
                                        $firstSection = $blog->sections->first();
                                        $previewHtml = $blog->content ?? (optional($firstSection)->content ?? '');
                                        $previewText = trim(preg_replace('/\s+/', ' ', strip_tags($previewHtml)));
                                    @endphp

                                    @if (!empty($previewText))
                                        <p class="text-[11px] text-gray-700 mt-2 line-clamp-5">
                                            @if (!empty(optional($firstSection)->subtitle))
                                                <span class="font-semibold">{{ $firstSection->subtitle }}:</span>
                                            @endif
                                            {{ $previewText }}
                                        </p>
                                    @else
                                        <p class="text-[11px] text-gray-500 italic mt-2">Tidak ada konten</p>
                                    @endif

                                    <div class="mt-auto pt-3">
                                        <span
                                            class="text-[11px] text-[#066c5f] font-semibold opacity-80 group-hover:opacity-100">
                                            Baca selengkapnya →
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- dots (optional simple) --}}
                <div class="flex justify-center mt-4 gap-2 md:hidden">
                    <span class="w-2 h-2 rounded-full bg-[#066c5f]/40"></span>
                    <span class="w-2 h-2 rounded-full bg-[#066c5f]/20"></span>
                    <span class="w-2 h-2 rounded-full bg-[#066c5f]/20"></span>
                </div>
            </div>

            <script>
                function blogCarouselScroll(direction) {
                    const el = document.getElementById('blogCarousel');
                    if (!el) return;

                    const firstCard = el.firstElementChild;
                    if (firstCard) {
                        const cardWidth = firstCard.offsetWidth;
                        const gap = parseInt(window.getComputedStyle(el).gap) || 0;
                        const amount = (cardWidth + gap) * direction;

                        el.scrollBy({
                            left: amount,
                            behavior: 'smooth'
                        });
                    } else {
                        // Fallback
                        const cardWidth = 420;
                        const gap = 24; 
                        const amount = (cardWidth + gap) * direction;
                        el.scrollBy({
                            left: amount,
                            behavior: 'smooth'
                        });
                    }
                }
            </script>
        @endif

        {{-- Benchmark / Technical Comparison Matrix --}}
        <section aria-labelledby="comparison-heading" class="my-16 bg-white/90 backdrop-blur-md rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-xl">
            <div class="max-w-4xl mb-8">
                <span class="text-xs font-black tracking-widest text-[#066c5f] uppercase bg-[#066c5f]/10 px-3.5 py-1.5 rounded-full inline-block mb-3">
                    Benchmark Teknis
                </span>
                <h2 id="comparison-heading" class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Perbandingan Vinsa Electric vs Standar Internasional
                </h2>
                <p class="mt-2 text-slate-600 text-sm sm:text-base leading-relaxed">
                    Evaluasi parameter teknis komponen kelistrikan industri Vinsa (<a href="https://vinsa.fr" class="text-[#066c5f] underline font-semibold">vinsa.fr</a>) terhadap standar global dan produk pasaran umum.
                </p>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm bg-white">
                <table class="w-full text-left text-xs sm:text-sm text-slate-700 border-collapse">
                    <thead class="bg-slate-100 text-slate-800 uppercase text-[11px] sm:text-xs tracking-wider border-b border-slate-200">
                        <tr>
                            <th scope="col" class="py-4 px-4 sm:px-6 font-extrabold">Parameter Spesifikasi</th>
                            <th scope="col" class="py-4 px-4 sm:px-6 font-extrabold text-slate-700">Standar Global</th>
                            <th scope="col" class="py-4 px-4 sm:px-6 font-extrabold bg-emerald-50 text-[#066c5f] border-x border-emerald-200">Vinsa Electric (vinsa.fr)</th>
                            <th scope="col" class="py-4 px-4 sm:px-6 font-extrabold text-slate-500">Komponen Non-Sertifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <th scope="row" class="py-3.5 px-4 sm:px-6 font-bold text-slate-900 bg-slate-50/40">Standar Uji Keselamatan</th>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-700">IEC 60947, IEC 60898, CE</td>
                            <td class="py-3.5 px-4 sm:px-6 bg-emerald-50/50 text-[#066c5f] font-bold border-x border-emerald-200">IEC 60947, CE, SNI Teruji</td>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-400">Tidak ada uji lab</td>
                        </tr>
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <th scope="row" class="py-3.5 px-4 sm:px-6 font-bold text-slate-900 bg-slate-50/40">Ketahanan Mekanis & Elektrikal</th>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-700">&gt; 1.000.000 Siklus Operasi</td>
                            <td class="py-3.5 px-4 sm:px-6 bg-emerald-50/50 text-[#066c5f] font-bold border-x border-emerald-200">&gt; 1.000.000 Siklus Operasi</td>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-400">&lt; 100.000 Siklus</td>
                        </tr>
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <th scope="row" class="py-3.5 px-4 sm:px-6 font-bold text-slate-900 bg-slate-50/40">Bahan Kontak Utama</th>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-700">Silver Alloy / Pure Copper</td>
                            <td class="py-3.5 px-4 sm:px-6 bg-emerald-50/50 text-[#066c5f] font-bold border-x border-emerald-200">99.9% Tembaga Murni + Perak</td>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-400">Besi lapis tembaga tipis</td>
                        </tr>
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <th scope="row" class="py-3.5 px-4 sm:px-6 font-bold text-slate-900 bg-slate-50/40">Isolasi & Tahan Api</th>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-700">UL94 V-0 Flame Retardant</td>
                            <td class="py-3.5 px-4 sm:px-6 bg-emerald-50/50 text-[#066c5f] font-bold border-x border-emerald-200">UL94 V-0 Tahan Suhu Tinggi</td>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-400">Plastik daur ulang mudah terbakar</td>
                        </tr>
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <th scope="row" class="py-3.5 px-4 sm:px-6 font-bold text-slate-900 bg-slate-50/40">Ketersediaan Stok Indonesia</th>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-700">Sering indent 4-12 minggu</td>
                            <td class="py-3.5 px-4 sm:px-6 bg-emerald-50/50 text-[#066c5f] font-bold border-x border-emerald-200">Ready Stock Nasional (Surabaya &amp; Pandaan)</td>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-400">Tidak menentu</td>
                        </tr>
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <th scope="row" class="py-3.5 px-4 sm:px-6 font-bold text-slate-900 bg-slate-50/40">Dukungan Tender & Engineering</th>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-700">Distributor bertingkat</td>
                            <td class="py-3.5 px-4 sm:px-6 bg-emerald-50/50 text-[#066c5f] font-bold border-x border-emerald-200">Surat Dukungan Tender + CAD Datasheet Langsung</td>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-400">Tidak tersedia</td>
                        </tr>
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <th scope="row" class="py-3.5 px-4 sm:px-6 font-bold text-slate-900 bg-slate-50/40">Garansi & Unit Pengganti</th>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-700">Garansi resmi</td>
                            <td class="py-3.5 px-4 sm:px-6 bg-emerald-50/50 text-[#066c5f] font-bold border-x border-emerald-200">1 Tahun Garansi Resmi + Penggantian Cepat</td>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-400">Tanpa garansi</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        {{-- FAQ Section with FAQPage Schema --}}
        @php
        $homepageFaqs = [
            [
                'question' => 'Apa itu Vinsa Electric dan produk apa saja yang disediakan?',
                'answer' => 'Vinsa Electric (vinsa.fr) adalah merek terpercaya penyedia perlengkapan kelistrikan industri, sistem distribusi tegangan rendah (low-voltage switchgear), dan kontrol otomasi. Produk utama kami meliputi Magnetic AC Contactor (seri CJX2), Thermal Overload Relay, Molded Case Circuit Breaker (MCCB), Miniature Circuit Breaker (MCB), Industrial Push Button 22mm & 30mm, Pilot Lamp LED, Terminal Block, Cable Lug, serta Box Panel tahan cuaca (IP65/IP66).'
            ],
            [
                'question' => 'Bagaimana standar mutu Vinsa Electric jika dibandingkan dengan merk global?',
                'answer' => 'Seluruh produk Vinsa Electric dirancang dan diuji mengacu pada standar internasional IEC 60947 dan standar keselamatan CE serta SNI, menggunakan kontak perak tembaga murni 99.9% dan material tahan panas (flame retardant). Produk Vinsa memiliki ketahanan mekanis lebih dari 1.000.000 siklus operasi, menjadikannya pilihan andal setara merk global, dengan keuntungan harga yang jauh lebih efisien untuk proyek, ketersediaan stok lokal di Indonesia, dan dukungan teknis pabrikan langsung.'
            ],
            [
                'question' => 'Apakah produk Vinsa kompatibel untuk perakitan panel maker dan standar proyek industri?',
                'answer' => 'Ya, komponen Vinsa Electric dirancang dengan dimensi modular standar DIN-Rail dan mounting universal yang 100% kompatibel dengan tata letak box panel industri standar (termasuk panel yang biasa menggunakan komponen merk global). Hal ini memudahkan kontraktor panel maker dalam instalasi, retrofit, maupun penggantian suku cadang tanpa perlu modifikasi mekanikal.'
            ],
            [
                'question' => 'Apakah Vinsa Electric melayani pengadaan proyek B2B, kontraktor MEP, dan tender?',
                'answer' => 'Tentu. Vinsa Electric melayani pengadaan skala proyek untuk panel maker, pabrik manufaktur, kontraktor MEP (Mechanical, Electrical, Plumbing), serta distributor di seluruh Indonesia. Kami menyediakan surat dukungan tender resmi, sertifikat uji kelayakan, datasheet teknis CAD, dan harga khusus volume proyek melalui tim sales teknis kami di +62 813-3571-5398 atau sales@ATstekno.com.'
            ],
            [
                'question' => 'Di mana lokasi kantor, showroom, dan gudang resmi Vinsa?',
                'answer' => 'Vinsa Electric memiliki 3 fasilitas utama di Indonesia: (1) Head Office di Galaxy Bumi Permai J1-23 Sukolilo, Surabaya; (2) Showroom Komersial di Jl. Jagalan No.38 Pabean Cantian, Surabaya; dan (3) Showroom & Engineering Hub di The Taman Dayu, Cluster Palazio Boulevard J-1 No.06, Pandaan, Pasuruan. Pelanggan dapat berkunjung langsung untuk inspeksi fisik produk dan pengujian sampel.'
            ],
            [
                'question' => 'Berapa lama masa garansi produk kelistrikan Vinsa?',
                'answer' => 'Setiap produk resmi Vinsa Electric dilindungi oleh garansi resmi pabrikan hingga 1 tahun terhadap cacat manufaktur. Kami juga menjamin ketersediaan suku cadang, unit pengganti cepat (one-to-one replacement untuk klaim valid), serta konsultasi teknis purnajual langsung dari tim engineering kami.'
            ]
        ];
        @endphp

        <section aria-labelledby="faq-section-heading" class="my-16 bg-white/90 backdrop-blur-md rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-xl">
            <div class="max-w-4xl mb-8">
                <span class="text-xs font-black tracking-widest text-[#066c5f] uppercase bg-[#066c5f]/10 px-3.5 py-1.5 rounded-full inline-block mb-3">
                    FAQ
                </span>
                <h2 id="faq-section-heading" class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Pertanyaan yang Sering Diajukan (FAQ Vinsa Electric)
                </h2>
                <p class="mt-2 text-slate-600 text-sm sm:text-base leading-relaxed">
                    Jawaban komprehensif seputar spesifikasi teknis, legalitas standar IEC, kesesuaian proyek, dan garansi resmi Vinsa.
                </p>
            </div>

            <div class="space-y-4">
                @foreach($homepageFaqs as $idx => $faq)
                    <details class="group bg-slate-50/70 rounded-2xl border border-slate-200 overflow-hidden shadow-sm transition-all duration-200 hover:border-emerald-300">
                        <summary class="flex items-center justify-between p-5 sm:p-6 cursor-pointer font-bold text-slate-900 list-none select-none group-open:bg-white group-open:text-[#066c5f] transition-colors">
                            <span class="flex items-center gap-3 pr-4 text-sm sm:text-base md:text-lg">
                                <span class="w-7 h-7 rounded-lg bg-emerald-100 text-[#066c5f] flex items-center justify-center text-xs font-bold shrink-0 group-open:bg-[#066c5f] group-open:text-white transition-colors">
                                    Q{{ $idx + 1 }}
                                </span>
                                {{ $faq['question'] }}
                            </span>
                            <span class="w-8 h-8 rounded-full bg-slate-200/60 flex items-center justify-center shrink-0 group-open:rotate-180 transition-transform duration-200 text-slate-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="p-5 sm:p-6 pt-3 sm:pt-4 text-slate-700 text-xs sm:text-sm md:text-base leading-relaxed border-t border-slate-200/60 bg-white">
                            {!! $faq['answer'] !!}
                        </div>
                    </details>
                @endforeach
            </div>

            <x-schema.faq :items="$homepageFaqs" />
        </section>

        </main>
    </div>

    <x-footer></x-footer>
    @stack('scripts')

    <script>
        function toggleProductDropdown(id, btn) {
            const dropdown = document.getElementById(id);
            if (!dropdown) return;
            
            const isOpen = dropdown.classList.toggle('is-open');
            const textSpan = btn.querySelector('.btn-text');
            const iconBtn = btn.querySelector('.btn-icon');
            
            if (textSpan) {
                textSpan.textContent = isOpen ? '{{ __("Show Less") }}' : '{{ __("Show More") }}';
            }
            if (iconBtn) {
                iconBtn.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        }
    </script>
</body>

</html>
<script>
    document.getElementById('menu-toggle')?.addEventListener('click', function() {
        document.getElementById('mobile-menu')?.classList.toggle('hidden');
    });
</script>

<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function getDirectSliderContainer(sliderGroup) {
            return Array.from(sliderGroup.children).find(el => el.classList.contains('slider-container'))
                || sliderGroup.querySelector('.slider-container');
        }

        function getDirectScrollButtons(sliderGroup) {
            const direct = Array.from(sliderGroup.children).filter(
                el => el.tagName === 'BUTTON' && (el.getAttribute('onclick') || '').includes('scrollSlider')
            );
            return direct.length ? direct : Array.from(sliderGroup.querySelectorAll('button[onclick*="scrollSlider"]'));
        }

        function updateSliderGroup(sliderGroup) {
            const container = getDirectSliderContainer(sliderGroup);
            if (!container) return;

            const maxScrollLeft = container.scrollWidth - container.clientWidth;
            const hasScroll = maxScrollLeft > 2;
            const buttons = getDirectScrollButtons(sliderGroup);

            buttons.forEach(button => {
                button.style.display = hasScroll ? 'flex' : 'none';
                if (!hasScroll) {
                    button.disabled = true;
                    return;
                }

                const dir = (button.getAttribute('onclick') || '').includes('-1') ? -1 : 1;
                const atEdge = dir === -1
                    ? container.scrollLeft <= 2
                    : container.scrollLeft >= maxScrollLeft - 2;
                button.disabled = atEdge;
                if (button.classList.contains('outer-slider-btn')) {
                    button.classList.toggle('opacity-40', atEdge);
                    button.classList.toggle('pointer-events-none', atEdge);
                }
            });
        }

        function updateNavigationButtons() {
            document.querySelectorAll('.group\\/slider, .group\\/outer-slider').forEach(updateSliderGroup);
        }

        updateNavigationButtons();

        document.querySelectorAll('.group\\/slider, .group\\/outer-slider').forEach(sliderGroup => {
            const container = getDirectSliderContainer(sliderGroup);
            if (container) {
                container.addEventListener('scroll', () => updateSliderGroup(sliderGroup), { passive: true });
            }
        });

        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(updateNavigationButtons, 150);
        }, { passive: true });
    });

    function scrollSlider(button, direction) {
        const sliderGroup = button.parentElement;
        const container = Array.from(sliderGroup.children).find(el => el.classList.contains('slider-container'))
            || sliderGroup.querySelector('.slider-container');
        if (container) {
            const firstCard = container.firstElementChild;
            const cardWidth = firstCard ? firstCard.offsetWidth : 200;
            const gap = parseInt(window.getComputedStyle(container).gap) || 16;
            const scrollAmount = (cardWidth + gap) * direction;
            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
    }
</script>



