<x-app-layout>
    <div class="p-6 md:p-10">
        <div class="max-w-3xl mx-auto">
            
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Mass Upload & Update</h1>
                    <p class="text-slate-500 font-medium">Batch process products using Excel/CSV files.</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('products.edit') }}" class="group inline-flex items-center gap-2 text-slate-500 hover:text-[#066c5f] font-bold transition-all">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Back to Catalog
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8">
                
                <!-- Import Card -->
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200 shadow-sm space-y-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-[#066c5f]/10 text-[#066c5f] rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900">Upload Data</h2>
                    </div>

                    <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="bg-rose-50 border border-rose-200 rounded-2xl p-6 space-y-2">
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
                                    <h3 class="text-sm font-black text-rose-700 uppercase tracking-widest">Upload Error</h3>
                                </div>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-sm font-semibold text-rose-600">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Session Error --}}
                        @if (session('error'))
                            <div class="bg-rose-50 border border-rose-200 rounded-2xl p-6">
                                <p class="text-sm font-semibold text-rose-600">{{ session('error') }}</p>
                            </div>
                        @endif

                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Choose Excel/CSV File</label>
                            
                            <div class="relative">
                                <label for="file-upload" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-slate-200 rounded-[2rem] cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all group overflow-hidden">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-slate-300 group-hover:text-[#066c5f] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                        <p class="mb-2 text-sm text-slate-500"><span class="font-black text-[#066c5f]">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">XLSX, XLS, or CSV (MAX. 10MB)</p>
                                    </div>
                                    <input id="file-upload" name="file" type="file" class="hidden" required onchange="updateFileName(this)" />
                                    
                                    <!-- Selected File Preview -->
                                    <div id="file-name-container" class="absolute inset-0 bg-white items-center justify-center p-6 hidden">

                                        <div class="text-center">
                                            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </div>
                                            <p id="selected-file-name" class="text-slate-900 font-black truncate max-w-xs"></p>
                                            <button type="button" onclick="resetFileSelection()" class="mt-2 text-xs font-black text-rose-500 uppercase tracking-widest hover:underline">Remove File</button>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-[0.2em] shadow-2xl hover:bg-[#066c5f] transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            Start Import Process
                        </button>
                    </form>
                </div>

                <!-- Template & Help -->
                <div class="bg-[#066c5f] rounded-[2.5rem] p-10 text-white shadow-xl shadow-[#066c5f]/20">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                        <div class="space-y-4 max-w-md">
                            <h2 class="text-2xl font-black flex items-center gap-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                Need a template?
                            </h2>
                            <p class="text-emerald-50/70 font-medium">Use our pre-formatted template to ensure your data is processed correctly. It includes all current products to help you with mass updates.</p>
                        </div>
                        <a href="{{ route('products.export.template') }}" 
                            class="inline-flex items-center gap-4 px-10 py-5 bg-white text-slate-900 rounded-2xl font-black uppercase tracking-widest text-sm hover:bg-[#F77F1E] hover:text-white transition-all shadow-lg whitespace-nowrap">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            Download Template
                        </a>
                    </div>

                    <div class="mt-10 pt-10 border-t border-white/10 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <h4 class="font-black uppercase tracking-widest text-[10px] text-emerald-200">System Logic</h4>
                            <p class="text-sm font-bold">Existing <span class="bg-white/10 px-2 py-1 rounded">KODE</span> will trigger an <u>Update</u>. New codes will trigger a <u>Creation</u>.</p>
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-black uppercase tracking-widest text-[10px] text-emerald-200">Categories &amp; Types</h4>
                            <p class="text-sm font-bold">If a category or <span class="bg-white/10 px-2 py-1 rounded">type</span> in Excel doesn't exist yet, the system will <u>create that type inside the row's category</u> automatically.</p>
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-black uppercase tracking-widest text-[10px] text-emerald-200">Images (image & optional_image)</h4>
                            <p class="text-sm font-bold">Both <span class="bg-white/10 px-2 py-1 rounded">image</span> and <span class="bg-white/10 px-2 py-1 rounded">optional_image</span> support <span class="bg-white/10 px-2 py-1 rounded">Google Drive</span> share links. Paste the share URL and it will be auto-converted.</p>
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-black uppercase tracking-widest text-[10px] text-emerald-200">Specifications (Attributes)</h4>
                            <p class="text-sm font-bold">Use format: <span class="bg-white/10 px-2 py-1 rounded font-mono text-xs">name:value|name:value</span></p>
                            <p class="text-xs text-emerald-100/60 font-medium">Example: <span class="font-mono">Voltage:220V|Power:500W|Weight:2.5kg</span></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            if (input.files && input.files[0]) {
                const container = document.getElementById('file-name-container');
                const nameDisplay = document.getElementById('selected-file-name');
                nameDisplay.textContent = input.files[0].name;
                container.classList.remove('hidden');
                container.classList.add('flex');
            }
        }

        function resetFileSelection() {
            const input = document.getElementById('file-upload');
            const container = document.getElementById('file-name-container');
            input.value = '';
            container.classList.add('hidden');
            container.classList.remove('flex');
        }

    </script>
</x-app-layout>
