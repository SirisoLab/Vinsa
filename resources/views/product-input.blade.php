<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="p-6 md:p-10">
        <div class="max-w-5xl mx-auto">
            
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Create Product</h1>
                    <p class="text-slate-500 font-medium">Add a new item to the Vinsa catalog.</p>
                </div>
                <a href="{{ route('products.edit') }}" class="group inline-flex items-center gap-2 text-slate-500 hover:text-[#066c5f] font-bold transition-all">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Back to Catalog
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 font-semibold text-sm">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl">
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

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                
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
                                        <input type="text" name="name" required value="{{ old('name') }}"
                                            class="w-full px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-semibold"
                                            placeholder="e.g. MCB Schneider iC60H">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Product Code</label>
                                        <input type="text" name="kode" required value="{{ old('kode') }}"
                                            class="w-full px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-semibold uppercase"
                                            placeholder="e.g. VHB-200">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Description</label>
                                    <textarea name="description" rows="5"
                                        class="w-full px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-semibold"
                                        placeholder="Detailed description of the product...">{{ old('description') }}</textarea>
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
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Add as many as needed</p>
                            </div>

                            <div id="specifications" class="space-y-3">
                                <div class="flex gap-3 spec-row animate-in fade-in slide-in-from-top-2 duration-300">
                                    <input type="text" name="specifications[0][field_name]" placeholder="Property (e.g. Voltage)"
                                        value="{{ old('specifications.0.field_name') }}"
                                        class="w-1/2 px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-emerald-500 font-semibold spec-field">
                                    <input type="text" name="specifications[0][field_value]" placeholder="Value (e.g. 230V)"
                                        value="{{ old('specifications.0.field_value') }}"
                                        class="w-1/2 px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-emerald-500 font-semibold spec-value">
                                </div>
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
                                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
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
                                        maxlength="500" placeholder="Meta description for search engine results...">{{ old('meta_description') }}</textarea>
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
                        @endphp
                        <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm space-y-6">
                            <h2 class="text-xl font-black text-slate-900">Classification</h2>
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label for="categorySelect" class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Category</label>
                                    <select name="category_id" id="categorySelect" required 
                                            class="w-full px-5 py-3 bg-slate-100 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-bold appearance-none">
                                        <option value="">Choose a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" data-name="{{ strtolower($category->name) }}" {{ (string) old('category_id') === (string) $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex items-center justify-between pl-1">
                                        <label for="typeSelect" class="block text-xs font-black text-slate-500 uppercase tracking-widest">Type</label>
                                        <a id="manageCategoryTypesLink" href="{{ route('categories.index') }}" target="_blank"
                                           class="hidden text-[10px] font-black text-[#066c5f] hover:text-[#F77F1E] uppercase tracking-wider transition-colors">
                                            Kelola Type &rarr;
                                        </a>
                                    </div>
                                    <select name="type_id" id="typeSelect" disabled
                                            class="w-full px-5 py-3 bg-slate-100 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-bold appearance-none disabled:opacity-60">
                                        <option value="">Pilih category terlebih dahulu</option>
                                    </select>
                                    <p id="typeHelperText" class="text-[11px] font-medium text-slate-400 pl-1">
                                        Pilihan type otomatis mengikuti category yang dipilih.
                                    </p>
                                </div>

                                <div id="category-extra" class="space-y-4 animate-in fade-in duration-300"></div>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm space-y-6">
                            <h2 class="text-xl font-black text-slate-900">Media Assets</h2>
                            
                            <div class="space-y-6">
                                <div class="space-y-4">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest pl-1">Product Image</label>
                                    
                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Option A: Upload File</p>
                                            <div class="relative group">
                                                <div class="absolute inset-0 bg-[#066c5f] rounded-2xl opacity-0 group-hover:opacity-10 transition-opacity pointer-events-none"></div>
                                                <input type="file" name="image" id="image_file"
                                                    class="block w-full text-xs text-slate-500 
                                                    file:mr-4 file:py-3 file:px-6 
                                                    file:rounded-xl file:border-0 
                                                    file:text-xs file:font-black file:uppercase file:tracking-widest
                                                    file:bg-[#066c5f] file:text-white 
                                                    hover:file:bg-[#088a7a]
                                                    transition-all cursor-pointer">
                                            </div>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ratio 8:11 recommended</p>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Option B: Image URL (Google Drive, etc.)</p>
                                            <input type="url" name="image_link" id="image_link" value="{{ old('image_link') }}"
                                                placeholder="https://drive.google.com/file/d/.../view"
                                                class="w-full px-4 py-2.5 bg-slate-50 border-0 rounded-xl focus:ring-2 focus:ring-[#066c5f] text-xs font-bold">
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest">* One of the two options is required</p>
                                </div>

                                <div class="space-y-4">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest pl-1">Optional Detail Image (Tab Detail)</label>
                                    
                                    <div class="space-y-3">
                                        <div class="space-y-1">
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Option A: Upload File</label>
                                            <div class="relative group">
                                                <div class="absolute inset-0 bg-[#066c5f] rounded-2xl opacity-0 group-hover:opacity-10 transition-opacity pointer-events-none"></div>
                                                <input type="file" name="optional_image"
                                                    class="block w-full text-xs text-slate-500 
                                                    file:mr-4 file:py-3 file:px-6 
                                                    file:rounded-xl file:border-0 
                                                    file:text-xs file:font-black file:uppercase file:tracking-widest
                                                    file:bg-slate-900 file:text-white 
                                                    hover:file:bg-slate-800
                                                    transition-all cursor-pointer">
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
                                                class="w-full px-5 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-medium text-slate-800 placeholder:text-slate-300 focus:ring-2 focus:ring-[#066c5f] focus:border-[#066c5f] transition-all">
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Optional: This image will show in the "Product Detail" tab.</p>
                                </div>

                                <div class="border-t border-slate-100 pt-6 space-y-4">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest pl-1">Technical Datasheet</label>
                                    
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
                                            <input type="url" name="datasheet_link" value="{{ old('datasheet_link') }}"
                                                placeholder="https://example.com/spec.pdf"
                                                class="w-full px-4 py-2.5 bg-slate-50 border-0 rounded-xl focus:ring-2 focus:ring-slate-900 text-xs font-bold">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Section -->
                        <div class="bg-slate-900 rounded-[2rem] p-8 shadow-2xl shadow-slate-200">
                             <button type="submit"
                                class="w-full py-4 bg-[#066c5f] text-white rounded-2xl font-black uppercase tracking-[0.2em] shadow-lg shadow-[#066c5f]/30 hover:bg-[#F77F1E] hover:text-white transition-all duration-300 flex items-center justify-center gap-3">
                                Create Product
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts remain same but updated identifiers -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let specContainer = document.getElementById('specifications');

            function addNewSpecificationRow() {
                let specCount = document.querySelectorAll('.spec-row').length;
                let div = document.createElement('div');
                div.classList.add('flex', 'gap-3', 'spec-row', 'animate-in', 'fade-in', 'slide-in-from-top-2', 'duration-300');
                div.innerHTML = `
                    <input type="text" name="specifications[${specCount}][field_name]" placeholder="Property"
                        class="w-1/2 px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-emerald-500 font-semibold spec-field">
                    <input type="text" name="specifications[${specCount}][field_value]" placeholder="Value"
                        class="w-1/2 px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-emerald-500 font-semibold spec-value">
                `;
                specContainer.appendChild(div);
                addListenerToLastInput();
            }

            function addListenerToLastInput() {
                let lastField = document.querySelectorAll('.spec-field');
                let lastValue = document.querySelectorAll('.spec-value');
                let field = lastField[lastField.length - 1];
                let value = lastValue[lastValue.length - 1];

                function trigger(e) {
                    if (e.target.value.length > 0) {
                        field.removeEventListener("input", trigger);
                        value.removeEventListener("input", trigger);
                        addNewSpecificationRow();
                    }
                }

                field.addEventListener("input", trigger);
                value.addEventListener("input", trigger);
            }

            addListenerToLastInput();

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
            const categoryTypesMap = @json($categoryTypesMap);
            const oldCategoryId = @json((string) old('category_id', ''));
            const oldTypeId = @json((string) old('type_id', ''));

            function populateTypeOptions(categoryId, preserveOldSelection = false) {
                if (!categoryId || !categoryTypesMap[categoryId]) {
                    typeSelect.innerHTML = '<option value="">Pilih category terlebih dahulu</option>';
                    typeSelect.disabled = true;
                    typeHelperText.textContent = 'Pilihan type otomatis mengikuti category yang dipilih.';
                    manageTypesLink.classList.add('hidden');
                    return;
                }

                const catData = categoryTypesMap[categoryId];
                const types = catData.types || [];
                manageTypesLink.href = catData.manageUrl;
                manageTypesLink.classList.remove('hidden');

                if (types.length === 0) {
                    typeSelect.innerHTML = '<option value="">Belum ada type di category ini (opsional)</option>';
                    typeSelect.disabled = false;
                    typeHelperText.textContent = 'Category ini belum memiliki Master Type. Klik "Kelola Type" untuk menambahkan.';
                    return;
                }

                typeSelect.disabled = false;
                typeHelperText.textContent = `${types.length} type tersedia di dalam category ${catData.name}.`;

                const placeholderOpt = document.createElement('option');
                placeholderOpt.value = '';
                placeholderOpt.textContent = 'Pilih Type (Opsional)';
                typeSelect.innerHTML = '';
                typeSelect.appendChild(placeholderOpt);

                types.forEach(typeItem => {
                    const opt = document.createElement('option');
                    opt.value = String(typeItem.id);
                    opt.textContent = typeItem.name;
                    if (preserveOldSelection && String(typeItem.id) === oldTypeId) {
                        opt.selected = true;
                    }
                    typeSelect.appendChild(opt);
                });
            }

            function renderCategorySeriesFields(selectedCategory) {
                extraContainer.innerHTML = '';

                if (!selectedCategory) {
                    return;
                }

                const fieldWrap = (label, input) => `
                    <div class="space-y-2 animate-in fade-in slide-in-from-top-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">${label}</label>
                        ${input}
                    </div>
                `;

                const selectStyled = (name, options) => `
                    <select name="${name}" class="w-full px-5 py-3 bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-bold">
                        <option value="">Pilih Series (Opsional)</option>
                        ${options.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                `;

                if (selectedCategory === 'cable tray') {
                    extraContainer.innerHTML = fieldWrap('U & C Series', selectStyled('uc_series', ['U Series', 'C Series']));
                } else if (selectedCategory.includes('push button')) {
                    extraContainer.innerHTML = fieldWrap('Series', selectStyled('push_button_series', ['KB 2 Series', 'KB 5 Series']));
                } else if (selectedCategory.includes('selector switch')) {
                    extraContainer.innerHTML = fieldWrap('Series', selectStyled('selector_switch_series', ['KB 2 Series', 'KB 5 Series']));
                } else if (selectedCategory === 'terminal block') {
                    extraContainer.innerHTML = fieldWrap('Series', selectStyled('terminal_block_series', ['Terminal Strip', 'Terminal Block TB', 'Terminal Block TBC', 'Terminal Block TBR', 'Terminal Block TUK', 'Terminal Block TUSLKG', 'Terminal Block KLUS']));
                } else if (selectedCategory === 'cable lug') {
                    extraContainer.innerHTML = fieldWrap('Series', selectStyled('cable_lug_series', ['SC Cable Lug', 'SV Cable Lug', 'RV Cable Lug', 'PTV Cable Lug', 'DBV Cable Lug']));
                } else if (selectedCategory === 'mccb') {
                    extraContainer.innerHTML = fieldWrap('Series', selectStyled('mccb_series', ['M12B 25kA', 'M16F 35kA', 'M25F 35kA', 'M40F 35kA', 'M63F 35kA', 'M80F 35kA']));
                } else if (selectedCategory === 'mccb accessories') {
                    extraContainer.innerHTML = fieldWrap('Series', selectStyled('mccb_accessories_series', ['MAA Alarm Contact', 'MAS Shunt Release', 'MAAUX Auxiliary Contact', 'MAUVT Under Voltage', 'MARH Extended Rotary Handle']));
                } else if (selectedCategory === 'contactor accessories') {
                    extraContainer.innerHTML = fieldWrap('Series', selectStyled('contactor_accessories_series', ['Coil Contactor', 'Auxiliary Contact', 'Time Delay', 'Thermal Overload relay']));
                }
            }

            const handleCategoryChange = (preserveOld = false) => {
                const selectedOpt = categorySelect.options[categorySelect.selectedIndex];
                const categoryId = categorySelect.value;
                const selectedCategoryName = (selectedOpt?.dataset?.name || '').toLowerCase().trim();

                populateTypeOptions(categoryId, preserveOld && categoryId === oldCategoryId);
                renderCategorySeriesFields(selectedCategoryName);
            };

            if (categorySelect.value) {
                handleCategoryChange(true);
            }

            categorySelect.addEventListener('change', function () {
                handleCategoryChange(false);
            });
        });
    </script>
</x-app-layout>
