<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div
        x-data="{
            editTypeModalOpen: false,
            editTypeName: '',
            editTypeCategoryId: '',
            editTypeProductsCount: 0,
            editTypeActionUrl: '',
            openEditTypeModal(name, categoryId, productsCount, actionUrl) {
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
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <span class="inline-flex px-3 py-1 bg-[#066c5f]/10 text-[#066c5f] rounded-full text-xs font-black uppercase tracking-widest mb-2">
                    {{ $totalTypes }} Total Types
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Master Types</h1>
                <p class="text-slate-500 font-medium">Setiap type berada di dalam satu category. Pilih category saat membuat atau memfilter type.</p>
            </div>

            <a href="{{ route('categories.index') }}"
                class="inline-flex items-center gap-2 bg-slate-900 text-white px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#066c5f] transition-colors shadow-sm w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                Kelola Master Categories
            </a>
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

        <!-- Create Type Card -->
        <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-200 shadow-sm">
            <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-3">
                <span class="w-8 h-8 bg-[#066c5f]/10 text-[#066c5f] rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                </span>
                Tambah Type Baru di dalam Category
            </h2>

            @if ($categories->isEmpty())
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-sm font-semibold text-amber-800 flex flex-wrap items-center justify-between gap-3">
                    <span>Belum ada category terdaftar. Buat category terlebih dahulu sebelum menambahkan type.</span>
                    <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-amber-600 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-amber-700">
                        Buat Category
                    </a>
                </div>
            @else
                <form method="POST" action="{{ route('types.store') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    @csrf
                    <div class="md:col-span-5 space-y-1.5">
                        <label for="create_type_category_id" class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Category (Wajib)</label>
                        <select id="create_type_category_id" name="category_id" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-bold outline-none">
                            <option value="">Pilih Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $categoryId) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->types_count }} type)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-5 space-y-1.5">
                        <label for="create_type_name" class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Type Name</label>
                        <input id="create_type_name" type="text" name="name" value="{{ old('name') }}" required
                            placeholder="e.g. Flush Green, Mushroom Head"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-semibold outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <button type="submit"
                            class="w-full px-6 py-3.5 bg-[#066c5f] text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#088a7a] transition-all shadow-lg shadow-[#066c5f]/20">
                            Simpan
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <!-- Filter & Table -->
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 md:p-8 border-b border-slate-100">
                <form method="GET" action="{{ route('types.index') }}" class="flex flex-col md:flex-row gap-4 items-stretch md:items-end justify-between">
                    <div class="flex flex-col sm:flex-row gap-4 flex-1">
                        <div class="sm:w-64 space-y-1.5">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Filter Category</label>
                            <select name="category_id" onchange="this.form.submit()"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#066c5f] text-sm font-bold outline-none">
                                <option value="">Semua Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (string) $categoryId === (string) $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1 space-y-1.5">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Cari Type / Category</label>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama type atau category..."
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#066c5f] text-sm font-semibold outline-none">
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-[#066c5f] transition-colors">
                            Terapkan
                        </button>
                        @if(!empty($categoryId) || $search !== '')
                            <a href="{{ route('types.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-slate-200 transition-colors">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            @if ($types->isEmpty())
                <div class="py-20 px-6 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900">Belum ada type yang sesuai</h3>
                    <p class="text-sm text-slate-500 mt-1">Tambahkan type baru atau ubah filter pencarian.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 text-[11px] font-black uppercase tracking-widest border-b border-slate-100">
                                <th class="px-6 py-4">Type Name</th>
                                <th class="px-6 py-4">Category Induk</th>
                                <th class="px-6 py-4">Produk Terhubung</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($types as $type)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $type->name }}</td>
                                    <td class="px-6 py-4">
                                        @if($type->category)
                                            <a href="{{ route('categories.show', $type->category_id) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#066c5f]/10 text-[#066c5f] rounded-full text-xs font-bold hover:bg-[#066c5f] hover:text-white transition-colors">
                                                {{ $type->category->name }}
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-bold">
                                            {{ $type->products_count }} Produk
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button"
                                                data-name="{{ $type->name }}"
                                                data-category-id="{{ $type->category_id }}"
                                                data-products-count="{{ $type->products_count }}"
                                                data-url="{{ route('types.update', $type) }}"
                                                @click="openEditTypeModal($el.dataset.name, $el.dataset.categoryId, $el.dataset.productsCount, $el.dataset.url)"
                                                class="px-3.5 py-1.5 bg-slate-100 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-900 hover:text-white transition-colors">
                                                Edit
                                            </button>

                                            <form id="delete-type-form-{{ $type->id }}" method="POST" action="{{ route('types.destroy', $type) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="_origin" value="types_index">
                                                <input type="hidden" name="_filter_category_id" value="{{ $categoryId }}">
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
                    <input type="hidden" name="_origin" value="types_index">
                    <input type="hidden" name="_filter_category_id" value="{{ $categoryId }}">

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Category Induk</label>
                        <select name="category_id" x-model="editTypeCategoryId" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#066c5f] font-bold outline-none">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
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
                        text: `Type "${name}" akan dihapus permanen.`,
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

