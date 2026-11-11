<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div
        x-data="{
            editTypeModalOpen: false,
            editTypeId: null,
            editTypeName: '',
            editTypeCategoryId: '{{ $category->id }}',
            editTypeProductsCount: 0,
            editTypeActionUrl: '',
            renameCategoryOpen: false,
            openEditTypeModal(id, name, categoryId, productsCount, actionUrl) {
                this.editTypeId = id;
                this.editTypeName = name;
                this.editTypeCategoryId = String(categoryId);
                this.editTypeProductsCount = Number(productsCount);
                this.editTypeActionUrl = actionUrl;
                this.editTypeModalOpen = true;
            }
        }"
        @keydown.escape.window="editTypeModalOpen = false"
        class="p-6 md:p-10 space-y-8"
    >
        <!-- Breadcrumb & Back -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <nav class="flex items-center gap-2 text-sm font-bold text-slate-500">
                <a href="{{ route('categories.index') }}" class="hover:text-[#066c5f] transition-colors">Master Categories</a>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-slate-900">{{ $category->name }}</span>
            </nav>

            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-[#066c5f] font-bold text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Master Categories
            </a>
        </div>

        <!-- Category Summary Header -->
        <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-200 shadow-sm space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="inline-flex px-3 py-1 bg-[#066c5f]/10 text-[#066c5f] rounded-full text-[11px] font-black uppercase tracking-widest mb-2">
                        Category &amp; Types di Dalamnya
                    </span>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $category->name }}</h1>
                    <div class="flex flex-wrap items-center gap-3 mt-3">
                        <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-bold">
                            {{ $category->types_count }} Type
                        </span>
                        <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-bold">
                            {{ $category->products_count }} Produk
                        </span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" @click="renameCategoryOpen = !renameCategoryOpen"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-800 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-slate-900 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        Ubah Nama Category
                    </button>

                    <a href="{{ route('products.view.user', \Illuminate\Support\Str::slug($category->name)) }}" target="_blank"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold text-xs uppercase tracking-wider hover:border-[#066c5f] hover:text-[#066c5f] transition-colors">
                        Lihat Katalog
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </a>
                </div>
            </div>

            <!-- Inline Rename Category -->
            <div x-show="renameCategoryOpen" x-cloak class="pt-5 border-t border-slate-100">
                <form method="POST" action="{{ route('categories.update', $category) }}" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-end">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_origin" value="category_show">
                    <div class="flex-1 space-y-1.5">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Nama Category Baru</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#066c5f] font-semibold outline-none">
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-[#066c5f] transition-colors">
                        Simpan Nama
                    </button>
                </form>
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

        <!-- Add Type Inside Category -->
        <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-200 shadow-sm">
            <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-3">
                <span class="w-8 h-8 bg-[#066c5f]/10 text-[#066c5f] rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                </span>
                Tambah Type di dalam "{{ $category->name }}"
            </h2>
            <form method="POST" action="{{ route('categories.types.store', $category) }}" class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-end">
                @csrf
                <div class="flex-1 space-y-1.5">
                    <label for="new_type_name" class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Type Name</label>
                    <input id="new_type_name" type="text" name="name" value="{{ old('name') }}" required
                        placeholder="e.g. Flush Green, Illuminated Red, Twin Pole"
                        class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#066c5f] focus:bg-white font-semibold outline-none">
                </div>
                <button type="submit"
                    class="px-8 py-3.5 bg-[#066c5f] text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#088a7a] transition-all shadow-lg shadow-[#066c5f]/20 whitespace-nowrap">
                    Tambah Type
                </button>
            </form>
        </div>

        <!-- Types Inside This Category -->
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-black text-slate-900">Daftar Type ({{ $types->total() }})</h2>
                    <p class="text-xs font-medium text-slate-500 mt-0.5">Type berikut tersedia saat menambah atau mengedit produk pada kategori {{ $category->name }}.</p>
                </div>

                <form method="GET" action="{{ route('categories.show', $category) }}" class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari type..."
                        class="w-full sm:w-64 pl-4 pr-9 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#066c5f] text-sm font-semibold outline-none">
                    @if($search !== '')
                        <a href="{{ route('categories.show', $category) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 hover:text-rose-600">&times;</a>
                    @endif
                </form>
            </div>

            @if ($types->isEmpty())
                <div class="py-20 px-6 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900">Belum ada type di category ini</h3>
                    <p class="text-sm text-slate-500 mt-1">Gunakan formulir di atas untuk menambahkan type baru.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 text-[11px] font-black uppercase tracking-widest border-b border-slate-100">
                                <th class="px-6 py-4">Type Name</th>
                                <th class="px-6 py-4">Produk Terhubung</th>
                                <th class="px-6 py-4">Terakhir Diperbarui</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($types as $type)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $type->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-bold">
                                            {{ $type->products_count }} Produk
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-medium text-slate-500">
                                        {{ $type->updated_at?->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button"
                                                data-id="{{ $type->id }}"
                                                data-name="{{ $type->name }}"
                                                data-category-id="{{ $type->category_id }}"
                                                data-products-count="{{ $type->products_count }}"
                                                data-url="{{ route('types.update', $type) }}"
                                                @click="openEditTypeModal($el.dataset.id, $el.dataset.name, $el.dataset.categoryId, $el.dataset.productsCount, $el.dataset.url)"
                                                class="px-3.5 py-1.5 bg-slate-100 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-900 hover:text-white transition-colors">
                                                Edit
                                            </button>

                                            <form id="delete-type-form-{{ $type->id }}" method="POST" action="{{ route('types.destroy', $type) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="_origin" value="category_show">
                                                <button type="button"
                                                    class="delete-type-btn px-3.5 py-1.5 bg-rose-50 text-rose-600 rounded-xl text-xs font-bold hover:bg-rose-600 hover:text-white transition-colors"
                                                    data-id="{{ $type->id }}"
                                                    data-name="{{ $type->name }}">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($types->hasPages())
                    <div class="p-6 border-t border-slate-100">
                        {{ $types->links() }}
                    </div>
                @endif
            @endif
        </div>

        <!-- Edit Type Modal -->
        <div x-show="editTypeModalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
            <div @click.away="editTypeModalOpen = false" class="bg-white rounded-[2rem] border border-slate-200 shadow-2xl max-w-md w-full p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-slate-900">Edit Type</h3>
                    <button type="button" @click="editTypeModalOpen = false" class="p-2 text-slate-400 hover:text-slate-700 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form method="POST" :action="editTypeActionUrl" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_origin" value="category_show">

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Category</label>
                        <select name="category_id" x-model="editTypeCategoryId"
                            :class="editTypeProductsCount > 0 ? 'opacity-70' : ''"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-bold outline-none">
                            @foreach ($categories as $catOption)
                                <option value="{{ $catOption->id }}">{{ $catOption->name }}</option>
                            @endforeach
                        </select>
                        <p x-show="editTypeProductsCount > 0" class="text-[11px] font-semibold text-amber-600 pl-1">
                            Category tidak dapat dipindahkan selama type masih dipakai oleh produk.
                        </p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Type Name</label>
                        <input type="text" name="name" x-model="editTypeName" required
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-semibold outline-none">
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="editTypeModalOpen = false"
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-type-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    Swal.fire({
                        title: 'Hapus Type?',
                        text: `Type "${name}" akan dihapus dari category ini.`,
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
                            document.getElementById(`delete-type-form-${id}`).submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>

