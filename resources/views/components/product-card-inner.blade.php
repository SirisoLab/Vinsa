<div class="flex-shrink-0 w-full group">
    <a href="/detail/{{ $productItem->slug ?? '' }}"
        class="flex flex-col h-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300 rounded-2xl p-4 shadow-lg">
        <div class="w-full h-32 sm:h-40 rounded-xl overflow-hidden bg-white/20 flex items-center justify-center p-2">
            @if (!empty($productItem->image))
                <img src="{{ \App\Helpers\ProductHelper::imageUrl($productItem->image) }}" 
                    @if(\App\Helpers\ProductHelper::srcset($productItem->image))
                    srcset="{{ \App\Helpers\ProductHelper::srcset($productItem->image) }}"
                    sizes="(max-width: 640px) 300px, (max-width: 1024px) 600px, 1000px"
                    @endif
                    {!! \App\Helpers\ProductHelper::imgAttrs($productItem->image) !!}
                    loading="{{ isset($isLazy) && !$isLazy ? 'eager' : 'lazy' }}"
                    alt="{{ $productItem->name ?? '' }}"
                    class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">

            @else
                <div class="text-xs text-white/50">{{ __('No image') }}</div>
            @endif
        </div>
        <div class="mt-4 flex flex-col flex-1">
            <p class="text-[10px] uppercase tracking-wider text-[#FF7600] font-bold mb-1">
                {{ Str::limit($productItem->kode ?? '', 20) }}
            </p>
            <p class="text-xs font-bold text-white leading-tight line-clamp-2">
                {{ $productItem->name ?? '' }}
            </p>
            
            @php
                $cardType = $productItem->resolvedTypeName() ?? ($ci['tipe'] ?? ($ci['type'] ?? null));
            @endphp
            <div class="mt-2 space-y-0.5">
                @if (!empty($cardType))
                    <div class="text-[9px] text-white/60 uppercase">{{ __('Type') }}: {{ Str::limit($cardType, 14) }}</div>
                @endif
                {{-- If it's another field (e.g., custom sizes for cable ties) --}}
                @if (!empty($ci['size']))
                    <div class="text-[9px] text-white/50 uppercase">{{ __('Size') }}: {{ Str::limit($ci['size'], 12) }}</div>
                @endif
            </div>

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
