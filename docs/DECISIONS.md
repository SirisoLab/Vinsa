# Catatan Keputusan Arsitektur (Master Category & Type)

## D-01: Tabel `types` terpisah dengan FK `category_id` (bukan enum/JSON)
- **Keputusan**: Membuat tabel `types` dengan kolom `category_id` (`foreignId -> categories.id`, `cascadeOnDelete`) dan indeks unik komposit `['category_id', 'name']`, serta kolom nullable `products.type_id` (`nullOnDelete`).
- **Alasan**: Permintaan pengguna menetapkan *"type ada di dalam category"*. Relasi ternormalisasi `Category 1 -> N Type -> N Product` menjamin integritas referensial, memungkinkan nama Type yang sama di kategori yang berbeda (mis. "Standard" di Push Button dan Selector Switch), dan memungkinkan filter katalog yang cepat terindeks.
- **Konsekuensi**: Validasi unik pada `Type` harus selalu di-scope ke `category_id` dan Product Create/Update harus memvalidasi kesesuaian `type_id` terhadap `category_id`.

## D-02: Dua titik akses UI yang saling terhubung (`/admin/categories/{category}` & `/admin/types`)
- **Keputusan**: Pengguna dapat mengelola Type langsung di dalam halaman detail Category (`/admin/categories/{category}`) DAN melalui menu overview Master Types (`/admin/types`) yang mewajibkan pemilihan Category serta menyediakan filter per Category.
- **Alasan**: Pengelolaan di dalam detail Category mencerminkan struktur hierarkis secara natural, sementara overview terfilter memudahkan pencarian Type lintas kategori tanpa mengizinkan Type yatim tanpa Category.

## D-03: Kompatibilitas mundur `custom_input` & layout `new.blade.php`
- **Keputusan**: Kolom `products.custom_input` tidak dihapus atau dimigrasi destruktif. Input `series` tetap disimpan di `custom_input` agar 12 section khusus di `resources/views/new.blade.php` terus berjalan normal. Untuk Type, UI Product Create/Edit mengganti input teks bebas dengan dropdown Master `type_id`, sambil tetap menampilkan nilai `custom_input['tipe']`/`['value']` lama secara read-only sebagai fallback jika `type_id` masih `NULL`.
- **Alasan**: Menghindari regresi tampilan homepage dan data historis produk yang sudah ada di produksi.

## D-04: Carousel Sub-Panel Master Type Dinamis di Beranda (`new.blade.php` + `<x-category-types-slider>`)
- **Keputusan**: Pada `NewController@show`, relasi `types` untuk cache beranda `homepage_categories_tree` diurutkan `reorder('id', 'asc')` (urutan pembuatan), sementara dropdown/daftar Master Type di admin tetap memakai `orderBy('name')`. Di `resources/views/new.blade.php`, jika `$category->types->isNotEmpty()`, beranda merender komponen `<x-category-types-slider>` dengan outer carousel `.group/outer-slider` (tombol kiri/kanan langsung via selektor direct-child JS/CSS) dan inner `.group/slider` per Type, beserta fallback `Other Types` untuk produk legacy `type_id = NULL` yang tidak cocok nama tipe-nya; jika `types` kosong, section tetap merender cabang legacy (`Box Panel` grid 2 kolom, `Push Button`, `MCCB`, dkk).
- **Alasan**: Menjawab kebutuhan penambahan Type baru langsung muncul di beranda dalam kategori yang sama (mis. `Box Panel Wall Mounting IP65`, `Box Panel Free Standing IP55`, dan Type baru berikutnya) serta dapat digeser kiri/kanan tanpa memecah kategori legacy yang belum menggunakan Master Type.

