# Spesifikasi: Master Category & Master Type (Type di dalam Category)

## 1. Tujuan & Ringkasan
Menambahkan manajemen **Master Category** dan **Master Type** di backoffice Vinsa Electric, dengan aturan hierarki ketat bahwa **setiap Type berada di dalam satu Category (`Category 1 -> N Type`)**. Relasi ini dihubungkan ke **Product (`type_id`)**, **Mass Import/Export**, **Catalog Admin**, dan **Katalog Publik**, tanpa merusak data produk lama (`custom_input` JSON) maupun tampilan khusus di halaman beranda.

## 2. Pengguna & Akses
- Hanya user terautentikasi (`auth` middleware) yang dapat mengakses rute backoffice `/admin/categories*`, `/admin/types*`, dan endpoint JSON `/admin/categories/{category}/types-json`.
- Sesuai konfigurasi aplikasi (`bootstrap/app.php`), guest yang mengakses rute admin dikembalikan `404 Not Found`.

## 3. Entitas & Aturan Bisnis
1. **Category (`categories`)**
   - `name`: wajib, unik case-insensitive, maks 255 karakter, di-trim.
   - Memiliki banyak `Type` (`hasMany`, cascade delete di DB) dan banyak `Product` (`hasMany`).
   - **Proteksi hapus**: Category yang masih digunakan oleh minimal 1 Product (`products()->exists()`) tidak boleh dihapus dan mengembalikan pesan error yang jelas.
2. **Type (`types`)**
   - `category_id`: wajib, merujuk ke `categories.id`. Type **tidak boleh** dibuat tanpa Category.
   - `name`: wajib, unik case-insensitive **di dalam Category yang sama** (`unique(category_id, name)`), maks 255 karakter, di-trim. Nama Type yang sama **boleh** digunakan di Category yang berbeda.
   - **Proteksi ubah kategori**: Mengubah `category_id` milik suatu Type ditolak apabila masih ada Product yang memakai Type tersebut.
   - **Proteksi hapus**: Type yang masih digunakan oleh minimal 1 Product (`products()->exists()`) tidak boleh dihapus.
3. **Product (`products`)**
   - Kolom baru `type_id` (nullable FK -> `types.id`, `nullOnDelete`).
   - Saat Create/Update Product, jika `type_id` diisi, sistem memvalidasi secara server-side bahwa `type_id` tersebut **benar-benar berada di dalam `category_id` yang dipilih** (`Rule::exists('types', 'id')->where('category_id', ...)`).
   - Data lama di `custom_input` (`series`, `tipe`, `value`) tidak dimigrasikan secara destruktif: `series` tetap dipertahankan di `custom_input` untuk kebutuhan layout beranda (`new.blade.php`), sedangkan `type_id` menjadi sumber utama Type (fallback ke `custom_input` jika `type_id` null).
4. **Cache & Audit Log (`histories`)**
   - Menyimpan/menghapus `Category` atau `Type` otomatis menghapus cache `homepage_categories_tree` dan `all_categories_nav`.
   - Setiap create, update, dan delete pada Category/Type mencatat entri ke tabel `histories` (`entity_type`: `'category'` / `'type'`).

## 4. Alur Utama
1. **Kelola Category (`/admin/categories`)**: lihat daftar kategori beserta jumlah Type & Product serta pratinjau Type di dalamnya, tambah, ubah nama, hapus (jika kosong produk), atau masuk ke halaman detail kategori untuk mengelola Type-nya.
2. **Kelola Type di dalam Category (`/admin/categories/{category}`)**: melihat seluruh Type milik Category tersebut, tambah Type langsung ke dalam Category tanpa pilih ulang, ubah nama/pindah Category (jika 0 produk), dan hapus Type (jika 0 produk).
3. **Master Type Overview (`/admin/types`)**: melihat dan memfilter seluruh Type lintas kategori berdasarkan Category + kata kunci, serta membuat Type baru dengan memilih Category secara eksplisit.
4. **Form Tambah & Edit Product (`/input-product`, `/products/{id}/edit`)**: dropdown `Type` otomatis mengisi daftar Type milik `Category` yang sedang dipilih (beserta tautan cepat ke manajemen Type kategori terkait), tetap menjaga input `Series` yang sudah ada.
5. **Mass Import/Export (`/products/import`, `/products/export-template`)**: kolom `type` Excel mencari/membuat `Type` di dalam `Category` baris bersangkutan dan mengisi `products.type_id`; export mengutamakan `$product->type->name` dengan fallback `custom_input`.
6. **Katalog Publik & Detail (`/product/{category?}`, `/detail/{slug}`)**: ketika kategori aktif memiliki Type, muncul chip filter `?type=...`; kartu dan halaman detail menampilkan nama Type secara konsisten.
7. **Beranda Dinamis per Type (`/`, `new.blade.php` + `<x-category-types-slider>`)**:
   - Jika suatu Category memiliki minimal 1 data pada Master `types`, section Category tersebut di beranda merender sub-panel per Type secara dinamis sesuai urutan pembuatan (`types.id asc`), masing-masing berisi tautan ke `/product/{category}?type={typeSlug}` dan slider produk horizontal di dalamnya.
   - Panel-panel Type dibungkus carousel horizontal (`.group/outer-slider`, 2 panel berdampingan di desktop `>= 1024px`, swipeable di mobile) dengan tombol navigasi kiri (`<`) dan kanan (`>`). Penambahan Type baru di backoffice otomatis membersihkan cache `homepage_categories_tree` dan langsung tampil di kanan pada beranda.
   - Produk lama yang belum memiliki `type_id` di kategori tersebut (dan tidak cocok nama `custom_input`-nya dengan Master Type) ditampung dalam panel `Other Types` (`Tipe Lainnya`) di paling kanan agar tidak hilang. Category yang belum memiliki Master `types` tetap memakai layout legacy masing-masing.

