<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="p-6 md:p-10">
        <div class="max-w-5xl mx-auto">
            
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl animate-in fade-in duration-300">
                    <div class="flex items-center gap-3 text-rose-600 font-bold mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Please correct the following errors:
                    </div>
                    <ul class="list-disc list-inside text-sm text-rose-500 font-medium space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Product</h1>
                    <p class="text-slate-500 font-medium">Updating details for <span class="text-[#066c5f]">#{{ $product->kode }}</span></p>
                </div>
                <div class="flex items-center gap-4">
                    <form id="delete-product-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="delete-product-btn px-6 py-2.5 bg-rose-50 text-rose-600 rounded-xl font-bold text-sm hover:bg-rose-600 hover:text-white transition-all border border-rose-100" data-id="{{ $product->id }}">
                            Delete Product
                        </button>
                    </form>
                    <a href="{{ route('products.edit') }}" class="group inline-flex items-center gap-2 text-slate-500 hover:text-[#066c5f] font-bold transition-all">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Back
                    </a>
                </div>
            </div>

            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                @method('PUT')
                
                <!-- Main Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    
                    <!-- Left Column: Primary Info -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm space-y-6">
                            <h2 class="text-xl font-black text-slate-900 flex items-center gap-3">
                                <span class="w-8 h-8 bg-[#066c5f]/10 text-[#066c5f] rounded-lg flex items-center justify-center text-sm font-bold">01</span>
                                General Information
                            </h2>

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Product Name</label>
                                        <input type="text" name="name" required value="{{ old('name', $product->name) }}"
                                            class="w-full px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-semibold"
                                            placeholder="e.g. MCB Schneider iC60H">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Product Code</label>
                                        <input type="text" name="kode" required value="{{ old('kode', $product->kode) }}"
                                            class="w-full px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-semibold uppercase"
                                            placeholder="e.g. VHB-200">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Description</label>
                                    <textarea name="description" rows="5"
                                        class="w-full px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-semibold"
                                        placeholder="Detailed description of the product...">{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Specifications Section -->
                        <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm space-y-6">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-black text-slate-900 flex items-center gap-3">
                                    <span class="w-8 h-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center text-sm font-bold">02</span>
                                    Specifications
                                </h2>
                                <button type="button" onclick="addSpecification()" class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all">Add Field</button>
                            </div>

                            <div id="specifications" class="space-y-3">
                                @foreach ($product->attributes as $index => $attribute)
                                    <div class="flex gap-3 spec-row animate-in fade-in slide-in-from-top-2 duration-300">
                                        <input type="text" name="specifications[{{ $index }}][field_name]" placeholder="Property"
                                            value="{{ old("specifications.$index.field_name", $attribute->field_name) }}"
                                            class="w-1/2 px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-emerald-500 font-semibold">
                                        <input type="text" name="specifications[{{ $index }}][field_value]" placeholder="Value"
                                            value="{{ old("specifications.$index.field_value", $attribute->field_value) }}"
                                            class="w-1/2 px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-emerald-500 font-semibold">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- SEO Metadata -->
                        <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm space-y-6">
                            <h2 class="text-xl font-black text-slate-900 flex items-center gap-3">
                                <span class="w-8 h-8 bg-[#F77F1E]/10 text-[#F77F1E] rounded-lg flex items-center justify-center text-sm font-bold">03</span>
                                SEO Optimization
                            </h2>

                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <div class="flex justify-between items-end pl-1">
                                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Meta Title</label>
                                        <span class="text-[10px] font-black text-slate-400 tracking-widest uppercase"><span id="meta_title_count">0</span> / 255</span>
                                    </div>
                                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $product->meta_title ?? '') }}"
                                        class="w-full px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-[#F77F1E] font-semibold"
                                        maxlength="255" placeholder="MCB Schneider iC60H | Buy at Vinsa Electric">
                                </div>

                                <div class="space-y-2">
                                    <div class="flex justify-between items-end pl-1">
                                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Meta Description</label>
                                        <span class="text-[10px] font-black text-slate-400 tracking-widest uppercase"><span id="meta_desc_count">0</span> / 500</span>
                                    </div>
                                    <textarea name="meta_description" id="meta_description" rows="4"
                                        class="w-full px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-[#F77F1E] font-semibold"
                                        maxlength="500" placeholder="Meta description for search engine results...">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Media & Category -->
                    <div class="space-y-6">
                        <!-- Category Section -->
                        @php
                            $categoryTypesMap = $categories->mapWithKeys(fn ($c) => [
                                (string) $c->id => [
                                    'name' => $c->name,
                                    'manageUrl' => route('categories.show', $c),
                                    'types' => $c->types->map(fn ($t) => [
                                        'id' => $t->id,
                                        'name' => $t->name,
                                    ])->values(),
                                ],
                            ])->all();
                            $legacyTypeHint = $product->type_id === null ? $product->legacyTypeName() : null;
                        @endphp
                        <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm space-y-6">
                            <h2 class="text-xl font-black text-slate-900">Classification</h2>
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label for="categorySelect" class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Category</label>
                                    <select name="category_id" id="categorySelect" required 
                                            class="w-full px-5 py-3 bg-slate-100 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-bold appearance-none">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ (string) old('category_id', $product->category_id) === (string) $category->id ? 'selected' : '' }} data-name="{{ strtolower($category->name) }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex items-center justify-between pl-1">
                                        <label for="typeSelect" class="block text-xs font-black text-slate-500 uppercase tracking-widest">Type</label>
                                        <a id="manageCategoryTypesLink" href="{{ $product->category_id ? route('categories.show', $product->category_id) : route('categories.index') }}" target="_blank"
                                           class="text-[10px] font-black text-[#066c5f] hover:text-[#F77F1E] uppercase tracking-wider transition-colors">
                                            Kelola Type &rarr;
                                        </a>
                                    </div>
                                    <select name="type_id" id="typeSelect"
                                            class="w-full px-5 py-3 bg-slate-100 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-bold appearance-none">
                                        <option value="">Pilih Type (Opsional)</option>
                                    </select>
                                    <p id="typeHelperText" class="text-[11px] font-medium text-slate-400 pl-1">
                                        Pilihan type mengikuti category yang dipilih.
                                    </p>
                                    @if ($legacyTypeHint)
                                        <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs font-semibold text-amber-800">
                                            Legacy Type tercatat: <span class="font-black">{{ $legacyTypeHint }}</span> &mdash; pilih Master Type di atas untuk memetakan.
                                        </div>
                                    @endif
                                </div>

                                <input type="hidden" name="custom_input" id="custom_input" value="{{ old('custom_input', $product->custom_input ?? '') }}">
                                <div id="category-extra" class="space-y-4 animate-in fade-in duration-300"></div>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm space-y-6">
                            <h2 class="text-xl font-black text-slate-900">Media Assets</h2>
                            
                            <div class="space-y-6">
                                <div class="space-y-4">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest pl-1">Update Image</label>
                                    
                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Option A: Upload File</p>
                                            <div class="relative group aspect-[8/11] bg-slate-100 rounded-[2rem] overflow-hidden border-2 border-dashed border-slate-200 flex flex-col items-center justify-center p-4">
                                                <img src="{{ \App\Helpers\ProductHelper::imageUrl($product->image) }}" alt="Current" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-110 transition-transform duration-500">

                                                <div class="relative z-10 bg-white/80 backdrop-blur-md p-4 rounded-2xl shadow-xl flex flex-col items-center gap-2">
                                                    <svg class="w-8 h-8 text-[#066c5f]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                    <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Change Photo</span>
                                                </div>
                                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer">
                                            </div>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ratio 8:11 recommended</p>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Option B: Image URL (Google Drive, etc.)</p>
                                            <input type="url" name="image_link" id="image_link" value="{{ old('image_link', (filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : '')) }}"
                                                placeholder="https://drive.google.com/file/d/.../view"
                                                class="w-full px-4 py-2.5 bg-slate-50 border-0 rounded-xl focus:ring-2 focus:ring-[#066c5f] text-xs font-bold">
                                            @if(filter_var($product->image, FILTER_VALIDATE_URL))
                                                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">✓ Currently using external URL</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="space-y-4">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest pl-1">Optional Detail Image (Tab Detail)</label>
                                    
                                    <div class="space-y-3">
                                        <div class="space-y-1">
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Option A: Upload File</label>
                                            <div class="relative group aspect-video bg-slate-100 rounded-[2rem] overflow-hidden border-2 border-dashed border-slate-200 flex flex-col items-center justify-center p-4">
                                                @if($product->optional_image)
                                                    <img src="{{ \App\Helpers\ProductHelper::imageUrl($product->optional_image) }}" alt="Optional" {!! \App\Helpers\ProductHelper::imgAttrs($product->optional_image) !!} class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-110 transition-transform duration-500">
                                                @endif
                                                <div class="relative z-10 bg-white/80 backdrop-blur-md p-4 rounded-2xl shadow-xl flex flex-col items-center gap-2">
                                                    <svg class="w-8 h-8 text-[#066c5f]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                    <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest">{{ $product->optional_image ? 'Change Detail Photo' : 'Upload Detail Photo' }}</span>
                                                </div>
                                                <input type="file" name="optional_image" class="absolute inset-0 opacity-0 cursor-pointer">
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <div class="flex-1 h-px bg-slate-200"></div>
                                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">or</span>
                                            <div class="flex-1 h-px bg-slate-200"></div>
                                        </div>

                                        <div class="space-y-1">
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Option B: Image URL (Google Drive supported)</label>
                                            <input type="url" name="optional_image_link" placeholder="https://drive.google.com/file/d/.../view"
                                                value="{{ filter_var($product->optional_image, FILTER_VALIDATE_URL) ? $product->optional_image : '' }}"
                                                class="w-full px-5 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-medium text-slate-800 placeholder:text-slate-300 focus:ring-2 focus:ring-[#066c5f] focus:border-[#066c5f] transition-all">
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Optional: This image will show in the "Product Detail" tab.</p>
                                </div>

                                <div class="border-t border-slate-100 pt-6 space-y-4">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest pl-1">Update Datasheet</label>
                                    
                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Option A: Upload PDF</p>
                                            <input type="file" name="datasheet" accept="application/pdf"
                                                class="block w-full text-xs text-slate-500 
                                                file:mr-4 file:py-2 file:px-4 
                                                file:rounded-xl file:border-0 
                                                file:text-[10px] file:font-bold file:uppercase file:tracking-widest
                                                file:bg-slate-900 file:text-white 
                                                hover:file:bg-slate-800
                                                cursor-pointer">
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Option B: External Link</p>
                                            <input type="url" name="datasheet_link" value="{{ old('datasheet_link', (filter_var($product->datasheet, FILTER_VALIDATE_URL) ? $product->datasheet : '')) }}"
                                                placeholder="https://example.com/spec.pdf"
                                                class="w-full px-4 py-2.5 bg-slate-50 border-0 rounded-xl focus:ring-2 focus:ring-slate-900 text-xs font-bold">
                                        </div>
                                    </div>

                                    @if($product->datasheet)
                                        <a href="{{ filter_var($product->datasheet, FILTER_VALIDATE_URL) ? $product->datasheet : asset('storage/' . $product->datasheet) }}" target="_blank"
                                           class="mt-4 flex items-center gap-3 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 group hover:bg-emerald-600 transition-all duration-300">
                                            <svg class="w-8 h-8 text-emerald-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            <div>
                                                <p class="text-[10px] font-black text-emerald-600 group-hover:text-emerald-100 uppercase tracking-widest mb-1">Current File</p>
                                                <p class="text-xs font-bold text-slate-900 group-hover:text-white truncate max-w-[150px]">{{ basename($product->datasheet) }}</p>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Action Section -->
                        <div class="bg-slate-900 rounded-[2rem] p-8 shadow-2xl shadow-slate-200">
                             <button type="submit"
                                class="w-full py-4 bg-[#066c5f] text-white rounded-2xl font-black uppercase tracking-[0.2em] shadow-lg shadow-[#066c5f]/30 hover:bg-[#F77F1E] hover:text-white transition-all duration-300 flex items-center justify-center gap-3">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let specCount = {{ count($product->attributes) }};

        function addSpecification() {
            let div = document.createElement('div');
            div.classList.add('flex', 'gap-3', 'spec-row', 'animate-in', 'fade-in', 'slide-in-from-top-2', 'duration-300');
            div.innerHTML = `
                <input type="text" name="specifications[${specCount}][field_name]" placeholder="Property" class="w-1/2 px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-emerald-500 font-semibold">
                <input type="text" name="specifications[${specCount}][field_value]" placeholder="Value" class="w-1/2 px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-emerald-500 font-semibold">
            `;
            document.getElementById('specifications').appendChild(div);
            specCount++;
        }

        function parseLegacyJsonObject(raw) {
            const trimmed = (raw || '').trim();
            if (!trimmed.startsWith('{')) {
                return {};
            }
            try {
                const parsed = JSON.parse(trimmed);
                return parsed && typeof parsed === 'object' && !Array.isArray(parsed) ? parsed : {};
            } catch (err) {
                return {};
            }
        }

        function updateSeriesCustomInput(series = null, valueKeyOnly = false) {
            const hidden = document.getElementById('custom_input');
            const current = parseLegacyJsonObject(hidden.value);

            if (valueKeyOnly) {
                if (series) {
                    hidden.value = JSON.stringify({ value: series });
                } else {
                    hidden.value = '';
                }
                return;
            }

            if (series !== null) {
                if (series === '') {
                    delete current.series;
                } else {
                    current.series = series;
                }
            }
            hidden.value = Object.keys(current).length > 0 ? JSON.stringify(current) : '';
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Meta character counter logic
            const metaTitle = document.getElementById('meta_title');
            const metaTitleCount = document.getElementById('meta_title_count');
            const metaDesc = document.getElementById('meta_description');
            const metaDescCount = document.getElementById('meta_desc_count');

            if (metaTitle && metaTitleCount) {
                const updateMetaTitle = () => {
                    metaTitleCount.textContent = metaTitle.value.length;
                    metaTitleCount.classList.toggle('text-[#066c5f]', metaTitle.value.length >= 50 && metaTitle.value.length <= 60);
                };
                metaTitle.addEventListener('input', updateMetaTitle);
                updateMetaTitle();
            }

            if (metaDesc && metaDescCount) {
                const updateMetaDesc = () => {
                    metaDescCount.textContent = metaDesc.value.length;
                    metaDescCount.classList.toggle('text-[#066c5f]', metaDesc.value.length >= 140 && metaDesc.value.length <= 155);
                };
                metaDesc.addEventListener('input', updateMetaDesc);
                updateMetaDesc();
            }

            const categorySelect = document.getElementById('categorySelect');
            const typeSelect = document.getElementById('typeSelect');
            const typeHelperText = document.getElementById('typeHelperText');
            const manageTypesLink = document.getElementById('manageCategoryTypesLink');
            const extraContainer = document.getElementById('category-extra');
            const customInputHidden = document.getElementById('custom_input');
            const categoryTypesMap = @json($categoryTypesMap);
            const initialCategoryId = @json((string) old('category_id', $product->category_id));
            const initialTypeId = @json((string) old('type_id', $product->type_id ?? ''));

            const originalCustomValue = customInputHidden.value;
            let oldValue = originalCustomValue;
            let parsedOld = parseLegacyJsonObject(oldValue);

            function populateTypeOptions(categoryId, selectedTypeId = '') {
                const catData = categoryTypesMap[categoryId];
                if (!catData) {
                    typeSelect.innerHTML = '<option value="">Pilih category terlebih dahulu</option>';
                    typeSelect.disabled = true;
                    manageTypesLink.href = @json(route('categories.index'));
                    return;
                }

                const types = catData.types || [];
                manageTypesLink.href = catData.manageUrl;

                if (types.length === 0) {
                    typeSelect.innerHTML = '<option value="">Belum ada type di category ini (opsional)</option>';
                    typeSelect.disabled = false;
                    typeHelperText.textContent = 'Category ini belum memiliki Master Type. Klik "Kelola Type" untuk menambahkan.';
                    return;
                }

                typeSelect.disabled = false;
                typeHelperText.textContent = `${types.length} type tersedia di dalam category ${catData.name}.`;

                typeSelect.innerHTML = '';
                const emptyOpt = document.createElement('option');
                emptyOpt.value = '';
                emptyOpt.textContent = 'Pilih Type (Opsional)';
                typeSelect.appendChild(emptyOpt);

                types.forEach(typeItem => {
                    const opt = document.createElement('option');
                    opt.value = String(typeItem.id);
                    opt.textContent = typeItem.name;
                    if (selectedTypeId && String(typeItem.id) === String(selectedTypeId)) {
                        opt.selected = true;
                    }
                    typeSelect.appendChild(opt);
                });
            }

            function renderExtraFields(category) {
                extraContainer.innerHTML = '';
                if (!category) return;

                const fieldWrap = (label, input) => `
                    <div class="space-y-2 animate-in fade-in slide-in-from-top-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">${label}</label>
                        ${input}
                    </div>
                `;

                const renderSeriesSelect = (label, options, selectedValue, valueKeyOnly = false) => {
                    return fieldWrap(label, `
                        <select class="w-full px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-bold"
                            onchange="updateSeriesCustomInput(this.value, ${valueKeyOnly ? 'true' : 'false'})">
                            <option value="">Pilih Series (Opsional)</option>
                            ${options.map(opt => `<option value="${opt}" ${selectedValue === opt ? 'selected' : ''}>${opt}</option>`).join('')}
                        </select>
                    `);
                };

                if (category === 'cable tray') {
                    const selected = parsedOld.value || (!oldValue.startsWith('{') ? oldValue : '');
                    extraContainer.innerHTML = renderSeriesSelect('U & C Series', ['U Series', 'C Series'], selected, true);
                } else if (category.includes('push button') || category.includes('selector switch')) {
                    const series = parsedOld.series || '';
                    extraContainer.innerHTML = renderSeriesSelect('Series', ['KB 2 Series', 'KB 5 Series'], series);
                } else if (category === 'mccb') {
                    const series = parsedOld.series || '';
                    extraContainer.innerHTML = renderSeriesSelect('Series', ['M12B 25kA', 'M16F 35kA', 'M25F 35kA', 'M40F 35kA', 'M63F 35kA', 'M80F 35kA'], series);
                } else if (category === 'terminal block') {
                    const series = parsedOld.series || '';
                    extraContainer.innerHTML = renderSeriesSelect('Series', ['Terminal Strip', 'Terminal Block TB', 'Terminal Block TBC', 'Terminal Block TBR', 'Terminal Block TUK', 'Terminal Block TUSLKG', 'Terminal Block KLUS'], series);
                } else if (category === 'cable lug') {
                    const series = parsedOld.series || '';
                    extraContainer.innerHTML = renderSeriesSelect('Series', ['SC Cable Lug', 'SV Cable Lug', 'RV Cable Lug', 'PTV Cable Lug', 'DBV Cable Lug'], series);
                } else if (category === 'mccb accessories') {
                    const series = parsedOld.series || '';
                    extraContainer.innerHTML = renderSeriesSelect('Series', ['MAA Alarm Contact', 'MAS Shunt Release', 'MAAUX Auxiliary Contact', 'MAUVT Under Voltage', 'MARH Extended Rotary Handle'], series);
                } else if (category === 'contactor accessories') {
                    const series = parsedOld.series || '';
                    extraContainer.innerHTML = renderSeriesSelect('Series', ['Coil Contactor', 'Auxiliary Contact', 'Time Delay', 'Thermal Overload relay'], series);
                }
            }

            const initialCategoryName = categorySelect.options[categorySelect.selectedIndex]?.dataset?.name || '';
            populateTypeOptions(categorySelect.value, categorySelect.value === initialCategoryId ? initialTypeId : '');
            if (initialCategoryName) {
                renderExtraFields(initialCategoryName);
            }

            categorySelect.addEventListener('change', function () {
                const selectedOpt = this.options[this.selectedIndex];
                const selectedCategoryId = this.value;
                const selectedName = selectedOpt?.dataset?.name || '';
                if (selectedCategoryId === initialCategoryId) {
                    oldValue = originalCustomValue;
                    parsedOld = parseLegacyJsonObject(originalCustomValue);
                    customInputHidden.value = originalCustomValue;
                } else {
                    oldValue = '';
                    parsedOld = {};
                    customInputHidden.value = '';
                }
                populateTypeOptions(selectedCategoryId, selectedCategoryId === initialCategoryId ? initialTypeId : '');
                renderExtraFields(selectedName);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-product-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const form = document.getElementById(`delete-product-form-${id}`);
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This removal is permanent!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, delete it!',
                        customClass: {
                            popup: 'rounded-[2.5rem]',
                            confirmButton: 'rounded-xl font-bold px-8 py-3',
                            cancelButton: 'rounded-xl font-bold px-8 py-3'
                        }
                    }).then((result) => { if (result.isConfirmed) form.submit(); });
                });
            });
        });
    </script>
</x-app-layout>
