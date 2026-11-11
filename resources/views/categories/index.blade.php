<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div
        x-data="{
            editModalOpen: false,
            editCategoryId: null,
            editCategoryName: '',
            editActionUrl: '',
            quickTypeModalOpen: false,
            quickTypeCategoryName: '',
            quickTypeActionUrl: '',
            openEditModal(id, name, actionUrl) {
                this.editCategoryId = id;
                this.editCategoryName = name;
                this.editActionUrl = actionUrl;
                this.editModalOpen = true;
            },
            openQuickTypeModal(catName, actionUrl) {
                this.quickTypeCategoryName = catName;
                this.quickTypeActionUrl = actionUrl;
                this.quickTypeModalOpen = true;
            }
        }"
        @keydown.escape.window="editModalOpen = false; quickTypeModalOpen = false"
        class="p-6 md:p-10 space-y-8"
    >
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <span class="px-3 py-1 bg-[#066c5f]/10 text-[#066c5f] rounded-full text-xs font-black uppercase tracking-widest">
                        {{ $totalCategories }} Categories
                    </span>
                    <span class="px-3 py-1 bg-slate-200/70 text-slate-700 rounded-full text-xs font-black uppercase tracking-widest">
                        {{ $totalTypes }} Types
                    </span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Master Categories</h1>
                <p class="text-slate-500 font-medium">Kelola category produk beserta daftar type di dalam masing-masing category.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('categories.index') }}" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400 group-focus-within:text-[#066c5f] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari category..."
                        class="w-full sm:w-64 pl-11 pr-10 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#066c5f] focus:border-transparent font-semibold shadow-sm outline-none" />
                    @if($search !== '')
                        <a href="{{ route('categories.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 hover:text-rose-600" title="Reset">&times;</a>
                    @endif
                </form>

                <a href="{{ route('types.index') }}"
                    class="inline-flex items-center gap-2 bg-slate-900 text-white px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#F77F1E] transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    All Types
                </a>
            </div>
        </div>

        <!-- Flash & Validation Alerts -->
        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 font-semibold text-sm">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl flex items-center gap-3 font-semibold text-sm">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl">
                <div class="flex items-center gap-2 text-rose-700 font-bold text-sm mb-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Terdapat kesalahan input:
                </div>
                <ul class="list-disc list-inside text-sm text-rose-600 font-medium space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add New Category Form -->
        <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-200 shadow-sm">
            <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-3">
                <span class="w-8 h-8 bg-[#066c5f]/10 text-[#066c5f] rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                </span>
                Tambah Category Baru
            </h2>
            <form method="POST" action="{{ route('categories.store') }}" class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-end">
                @csrf
                <div class="flex-1 space-y-1.5">
                    <label for="new_category_name" class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Category Name</label>
                    <input id="new_category_name" type="text" name="name" value="{{ old('name') }}" required
                        placeholder="e.g. Circuit Breaker, Push Button, Cable Lug"
                        class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#066c5f] focus:bg-white font-semibold outline-none">
                </div>
                <button type="submit"
                    class="px-8 py-3.5 bg-[#066c5f] text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#088a7a] transition-all shadow-lg shadow-[#066c5f]/20 whitespace-nowrap">
                    Simpan Category
                </button>
            </form>
        </div>

        <!-- Categories List -->
        @if ($categories->isEmpty())
            <div class="bg-white rounded-[2rem] border border-slate-200 py-24 px-6 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 text-slate-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-xl font-black text-slate-900">Belum ada category ditemukan</h3>
                <p class="text-slate-500 font-medium mt-1">
                    {{ $search !== '' ? 'Coba kata kunci pencarian lain atau reset filter.' : 'Tambahkan category pertama Anda menggunakan formulir di atas.' }}
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($categories as $category)
                    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-lg hover:border-[#066c5f]/30 transition-all duration-200 p-6 md:p-8 flex flex-col justify-between gap-6">
                        <div class="space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <a href="{{ route('categories.show', $category) }}" class="text-xl font-black text-slate-900 hover:text-[#066c5f] transition-colors block truncate">
                                        {{ $category->name }}
                                    </a>
                                    <div class="flex flex-wrap items-center gap-2 mt-2">
                                        <span class="px-3 py-1 bg-[#066c5f]/10 text-[#066c5f] rounded-full text-[11px] font-black uppercase tracking-wider">
                                            {{ $category->types_count }} Type
                                        </span>
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[11px] font-black uppercase tracking-wider">
                                            {{ $category->products_count }} Produk
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <button type="button"
                                        data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}"
                                        data-url="{{ route('categories.update', $category) }}"
                                        @click="openEditModal($el.dataset.id, $el.dataset.name, $el.dataset.url)"
                                        class="p-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-900 hover:text-white transition-colors"
                                        title="Edit Category">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <form id="delete-category-form-{{ $category->id }}" method="POST" action="{{ route('categories.destroy', $category) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="delete-category-btn p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-colors"
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}"
                                            title="Delete Category">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Preview Types Inside Category -->
                            <div class="pt-3 border-t border-slate-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5">Type di dalam Category ini</p>
                                @if ($category->types->isNotEmpty())
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ($category->types->take(6) as $type)
                                            <a href="{{ route('categories.show', $category) }}"
                                                class="px-2.5 py-1 bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold text-slate-700 hover:border-[#066c5f] hover:text-[#066c5f] transition-colors">
                                                {{ $type->name }}
                                            </a>
                                        @endforeach
                                        @if ($category->types->count() > 6)
                                            <a href="{{ route('categories.show', $category) }}"
                                                class="px-2.5 py-1 bg-amber-50 border border-amber-200 rounded-lg text-xs font-bold text-amber-700">
                                                +{{ $category->types->count() - 6 }} lainnya
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-xs font-medium text-slate-400 italic">Belum ada type di dalam category ini.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Bottom Actions -->
                        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                            <button type="button"
                                data-cat-name="{{ $category->name }}"
                                data-url="{{ route('categories.types.store', $category) }}"
                                @click="openQuickTypeModal($el.dataset.catName, $el.dataset.url)"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 text-slate-800 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-[#F77F1E] hover:text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                                Tambah Type
                            </button>

                            <a href="{{ route('categories.show', $category) }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#066c5f] text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-[#088a7a] transition-colors">
                                Kelola Type
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($categories->hasPages())
                <div class="flex justify-center pt-4">
                    <div class="bg-white rounded-2xl p-3 border border-slate-200 shadow-sm">
                        {{ $categories->links() }}
                    </div>
                </div>
            @endif
        @endif

        <!-- Edit Category Modal -->
        <div x-show="editModalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
            <div @click.away="editModalOpen = false" class="bg-white rounded-[2rem] border border-slate-200 shadow-2xl max-w-md w-full p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-slate-900">Edit Category</h3>
                    <button type="button" @click="editModalOpen = false" class="p-2 text-slate-400 hover:text-slate-700 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form method="POST" :action="editActionUrl" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Category Name</label>
                        <input type="text" name="name" x-model="editCategoryName" required
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-semibold outline-none">
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="editModalOpen = false"
                            class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-[#066c5f] text-white rounded-xl font-black text-sm hover:bg-[#088a7a] transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Add Type inside Category Modal -->
        <div x-show="quickTypeModalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
            <div @click.away="quickTypeModalOpen = false" class="bg-white rounded-[2rem] border border-slate-200 shadow-2xl max-w-md w-full p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-[#066c5f] uppercase tracking-widest">Category</p>
                        <h3 class="text-xl font-black text-slate-900" x-text="'Tambah Type ke ' + quickTypeCategoryName"></h3>
                    </div>
                    <button type="button" @click="quickTypeModalOpen = false" class="p-2 text-slate-400 hover:text-slate-700 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form method="POST" :action="quickTypeActionUrl" class="space-y-5">
                    @csrf
                    <input type="hidden" name="_origin" value="categories_index">
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Type Name</label>
                        <input type="text" name="name" required placeholder="e.g. Flush Green, Mushroom Head"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-semibold outline-none">
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="quickTypeModalOpen = false"
                            class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-[#066c5f] text-white rounded-xl font-black text-sm hover:bg-[#088a7a] transition-colors">
                            Simpan Type
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-category-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    Swal.fire({
                        title: 'Hapus Category?',
                        text: `Category "${name}" beserta type kosong di dalamnya akan dihapus.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        customClass: {
                            popup: 'rounded-[2rem]',
                            confirmButton: 'rounded-xl font-bold px-6 py-2.5',
                            cancelButton: 'rounded-xl font-bold px-6 py-2.5'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-category-form-${id}`).submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>

