@props(['category'])

@php
    $categorySlug = \Illuminate\Support\Str::slug($category->name);

    $productsByTypeId = $category->products->whereNotNull('type_id')->groupBy('type_id');
    $unassignedProducts = $category->products->whereNull('type_id');

    // Match legacy untyped rows only if their custom_input type explicitly equals a master Type name
    $typeNameMap = $category->types->mapWithKeys(fn ($t) => [strtolower(trim($t->name)) => $t->id]);
    $legacyMatchedByTypeId = collect();
    $remainingUnassigned = collect();

    foreach ($unassignedProducts as $item) {
        $legacyName = strtolower(trim((string) ($item->legacyTypeName() ?? '')));
        if ($legacyName !== '' && $typeNameMap->has($legacyName)) {
            $matchedId = $typeNameMap->get($legacyName);
            $legacyMatchedByTypeId[$matchedId] = ($legacyMatchedByTypeId[$matchedId] ?? collect())->push($item);
        } else {
            $remainingUnassigned->push($item);
        }
    }

    $typePanels = $category->types->map(function ($type) use ($productsByTypeId, $legacyMatchedByTypeId, $categorySlug) {
        $items = ($productsByTypeId->get($type->id) ?? collect())
            ->concat($legacyMatchedByTypeId->get($type->id) ?? collect())
            ->sortBy(fn ($item) => $item->kode, SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        return [
            'id' => $type->id,
            'name' => $type->name,
            'url' => route('products.view.user', [
                'category' => $categorySlug,
                'type' => \Illuminate\Support\Str::slug($type->name),
            ]),
            'products' => $items,
        ];
    })->values();

    if ($remainingUnassigned->isNotEmpty()) {
        $typePanels->push([
            'id' => null,
            'name' => 'Other Types',
            'url' => route('products.view.user', ['category' => $categorySlug]),
            'products' => $remainingUnassigned->sortBy(fn ($item) => $item->kode, SORT_NATURAL | SORT_FLAG_CASE)->values(),
        ]);
    }

    $panelWidthClass = $typePanels->count() === 1
        ? 'w-full'
        : 'w-[88%] sm:w-[78%] lg:w-[calc(50%-0.5rem)]';
@endphp

<div class="relative group/outer-slider mt-4 {{ $typePanels->count() < 2 ? 'hide-slider-mobile' : '' }}">
    <button type="button"
        aria-label="Geser type ke kiri"
        class="slider-nav-btn outer-slider-btn absolute left-1 lg:-left-4 top-1/2 -translate-y-1/2 z-40 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110"
        onclick="scrollSlider(this, -1)">
        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <div class="slider-container flex gap-4 overflow-x-auto pb-2 snap-x snap-mandatory scroll-smooth no-scrollbar">
        @foreach ($typePanels as $typePanel)
            @php
                $panelProducts = $typePanel['products'];
            @endphp
            <div class="snap-start flex-shrink-0 {{ $panelWidthClass }} text-white bg-white/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/10">
                <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-[#0cbca5] rounded-full flex-shrink-0"></span>
                    <a href="{{ $typePanel['url'] }}" class="hover:text-[#0cbca5] transition-colors truncate">
                        {{ __($typePanel['name']) }}
                    </a>
                </h4>

                @if ($panelProducts->isNotEmpty())
                    <div class="relative group/slider {{ $panelProducts->count() < 3 ? 'hide-slider-mobile' : '' }}">
                        <button type="button"
                            aria-label="Geser produk ke kiri"
                            class="slider-nav-btn absolute -left-2 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110"
                            onclick="scrollSlider(this, -1)">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <div class="category-slider slider-container flex gap-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                            @foreach ($panelProducts as $productItem)
                                @php
                                    $customInput = json_decode($productItem->custom_input, true);
                                    $cardMeta = [];
                                    if (is_array($customInput)) {
                                        foreach ($customInput as $metaKey => $metaVal) {
                                            if (is_scalar($metaVal) && !blank($metaVal) && !in_array(strtolower((string) $metaKey), ['tipe', 'type'], true)) {
                                                $cardMeta[$metaKey] = (string) $metaVal;
                                            }
                                        }
                                    }
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

                                            @if(!empty($cardMeta))
                                                <div class="mt-2 space-y-0.5">
                                                    @foreach (array_slice($cardMeta, 0, 2) as $key => $value)
                                                        <div class="text-[9px] text-white/50 capitalize">{{ $key }}: {{ Str::limit((string) $value, 14) }}</div>
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

                        <button type="button"
                            aria-label="Geser produk ke kanan"
                            class="slider-nav-btn absolute -right-2 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hover:bg-white hover:scale-110"
                            onclick="scrollSlider(this, 1)">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                @else
                    <div class="py-10 text-center rounded-2xl bg-white/5 border border-white/10">
                        <p class="text-sm text-white/70">{{ __('No products available.') }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <button type="button"
        aria-label="Geser type ke kanan"
        class="slider-nav-btn outer-slider-btn absolute right-1 lg:-right-4 top-1/2 -translate-y-1/2 z-40 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white/95 backdrop-blur shadow-2xl flex items-center justify-center text-[#066c5f] transition-all duration-300 hover:bg-white hover:scale-110"
        onclick="scrollSlider(this, 1)">
        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>
</div>
