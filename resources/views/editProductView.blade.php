<x-app-layout>
    <div x-data="{ search: '' }" class="p-6 md:p-10 space-y-10">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Product Catalog</h1>
                <p class="text-slate-500 font-medium tracking-tight">Manage and update your products</p>
            </div>
            <div class="flex items-center gap-4">
                <form method="GET" action="{{ route('products.edit') }}" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400 group-focus-within:text-[#066c5f] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product name or code..."
                        class="w-full md:w-80 pl-11 pr-10 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#066c5f] focus:border-transparent font-semibold shadow-sm transition-all outline-none" />
                    @if(request('search'))
                        <a href="{{ route('products.edit') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 hover:text-red-500">✕</a>
                    @endif
                </form>
                <a href="{{ route('products.view') }}" class="inline-flex items-center gap-2 bg-[#066c5f] text-white px-6 py-3 rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-[#066c5f]/30 hover:bg-[#088a7a] transition-all active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    New Product
                </a>
            </div>
        </div>

        <!-- Flash Alerts -->
        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 font-semibold text-sm">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl flex items-center gap-3 font-semibold text-sm">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Horizontal List Container -->
        <div class="space-y-4">
            <!-- List Header (Desktop Only) -->
            <div class="hidden lg:grid grid-cols-12 gap-4 px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                <div class="col-span-1">Preview</div>
                <div class="col-span-4">Product Details</div>
                <div class="col-span-2">Category &amp; Type</div>
                <div class="col-span-2">Ref Code</div>
                <div class="col-span-2">Attributes</div>
                <div class="col-span-1 text-right">Action</div>
            </div>

            @foreach ($products as $product)
                @php
                    $details = json_decode($product->custom_input, true);
                    $isJson = (json_last_error() == JSON_ERROR_NONE && is_array($details));
                    $resolvedTypeName = $product->resolvedTypeName();

                    $detailString = '';
                    if ($isJson) {
                        $detailString = implode(' ', array_keys($details)) . ' ' . implode(' ', array_values($details));
                    } else {
                        $detailString = $product->custom_input ?? '';
                    }
                    $searchContext = Str::lower($product->name . ' ' . $product->kode . ' ' . $detailString . ' ' . ($product->category->name ?? '') . ' ' . ($resolvedTypeName ?? ''));
                @endphp
                <div x-show="{{ json_encode($searchContext) }}.includes(search.toLowerCase())"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="group relative bg-white rounded-[1.5rem] border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#066c5f]/20 transition-all duration-300 overflow-hidden">
                    
                    <div class="lg:grid grid-cols-12 items-center gap-4 p-4 lg:px-8">
                        
                        <!-- Thumbnail (Mobile + Desktop) -->
                        <div class="col-span-1 mb-4 lg:mb-0">
                            <div class="w-16 h-16 rounded-xl bg-slate-100 overflow-hidden border border-slate-100 group-hover:scale-105 transition-transform">
                                <img src="{{ \App\Helpers\ProductHelper::imageUrl($product->image) }}" alt="{{ $product->name }}" 

                                     class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Info (Mobile + Desktop) -->
                        <div class="col-span-4 mb-4 lg:mb-0">
                            <h2 class="text-sm font-black text-slate-900 leading-tight group-hover:text-[#066c5f] transition-colors truncate">
                                {{ $product->name }}
                            </h2>
                            <p class="text-[10px] font-bold text-slate-400 mt-0.5 truncate">{{ Str::limit($product->description, 60) }}</p>
                        </div>

                        <!-- Category & Type -->
                        <div class="col-span-2 mb-4 lg:mb-0 relative space-y-1">
                            <span class="lg:hidden text-[8px] font-black text-slate-400 uppercase block mb-1">Category &amp; Type</span>
                            <span class="inline-flex px-3 py-1 bg-slate-50 text-[#F77F1E] rounded-full text-[9px] font-black uppercase tracking-widest border border-slate-100">
                                {{ $product->category->name ?? 'Product' }}
                            </span>
                            @if ($resolvedTypeName)
                                <div class="block">
                                    <span class="inline-flex px-2.5 py-0.5 bg-[#066c5f]/10 text-[#066c5f] rounded-full text-[9px] font-bold tracking-wide">
                                        Type: {{ $resolvedTypeName }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Ref Code -->
                        <div class="col-span-2 mb-4 lg:mb-0">
                            <span class="lg:hidden text-[8px] font-black text-slate-400 uppercase block mb-1">Ref Code</span>
                            <p class="text-xs font-black text-slate-900 font-mono tracking-tight">#{{ $product->kode }}</p>
                        </div>

                        <!-- Dynamic Attributes / Decoded JSON -->
                        <div class="col-span-2 mb-6 lg:mb-0">
                            <span class="lg:hidden text-[8px] font-black text-slate-400 uppercase block mb-2">Attributes</span>
                            <div class="flex flex-wrap gap-1.5">
                                @if($product->custom_input)
                                    @if($isJson)
                                        @php $hasRenderedAttr = false; @endphp
                                        @foreach($details as $key => $value)
                                            @if(!empty($value) && !($product->type_id && in_array(strtolower($key), ['tipe', 'type'], true)))
                                                @php
                                                    $hasRenderedAttr = true;
                                                    $label = match(strtolower($key)) {
                                                        'tipe' => 'Type',
                                                        'series' => 'Series',
                                                        default => str_replace('_', ' ', $key)
                                                    };
                                                @endphp
                                                <div class="flex items-center gap-1.5 bg-slate-50 px-2 py-0.5 rounded-md border border-slate-100">
                                                    <span class="text-[7px] font-black text-slate-400 uppercase">{{ $label }}:</span>
                                                    <span class="text-[9px] font-bold text-slate-700 truncate max-w-[80px] capitalize">{{ $value }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if(!$hasRenderedAttr && !$resolvedTypeName)
                                            <span class="text-[10px] text-slate-300 italic">No extra data</span>
                                        @endif
                                    @else
                                        <p class="text-[10px] font-bold text-slate-500 italic">{{ Str::limit($product->custom_input, 30) }}</p>
                                    @endif
                                @elseif(!$resolvedTypeName)
                                    <span class="text-[10px] text-slate-300 italic">No extra data</span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="col-span-1 text-right">
                            <a href="/products/{{ $product->id }}/edit" 
                               class="inline-flex items-center justify-center w-full lg:w-auto px-6 py-2 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#066c5f] transition-all shadow-sm">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($products->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-2xl p-3 border border-slate-200 shadow-sm">
                    {{ $products->links() }}
                </div>
            </div>
        @endif

        @if(count($products) == 0)
            <div class="py-40 text-center">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4" /></svg>
                </div>
                <h3 class="text-xl font-black text-slate-900 tracking-tight">No products found</h3>
                <p class="text-slate-500 font-medium">Get started by creating your first product.</p>
            </div>
        @endif

    </div>
</x-app-layout>
