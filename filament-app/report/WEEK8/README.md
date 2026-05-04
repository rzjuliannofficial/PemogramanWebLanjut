# Laporan Praktikum Pertemuan 10: Implementasi Sorting pada Table Filament

**Mata Kuliah:** Pemrograman Web Lanjut  
**Nama Mahasiswa:** [Nama Anda]  
**NIM:** [NIM Anda]  

---

## 1. Implementasi Sorting pada Kolom Title dan Slug
Menambahkan method `sortable()` pada kolom `title` dan `slug` untuk memungkinkan pengguna mengurutkan data berdasarkan alfabet.

**Langkah Kerja:**
Buka file `app/Filament/Resources/Posts/Tables/PostsTable.php` dan tambahkan `->sortable()` pada kolom title dan slug.

```php
TextColumn::make('title')
    ->sortable(),
TextColumn::make('slug')
    ->sortable(),
```

**Tampilan:**
![Sorting Title Ascending](img/Sorting%20Title%20Ascending.png)
*Keterangan: Menampilkan data dari A ke Z saat header Title diklik.*

![Sorting Title Descending](img/Sorting%20Title%20Descending.png)
*Keterangan: Menampilkan data dari Z ke A saat header Title diklik kembali.*

---

## 2. Sorting pada Relasi (Category)
Filament memudahkan sorting kolom yang berasal dari relasi database. Kita cukup menggunakan dot notation `category.name`.

**Langkah Kerja:**
```php
TextColumn::make('category.name')
    ->sortable(),
```

**Tampilan:**
![Sorting Category](img/Sorting%20Category.png)
*Keterangan: Tabel otomatis melakukan join dan mengurutkan berdasarkan nama kategori.*

---

## 3. Sorting pada Kolom Tanggal (Created At)
Mengaktifkan sorting pada kolom waktu untuk melihat data terbaru atau terlama.

**Langkah Kerja:**
```php
TextColumn::make('created_at')
    ->label('Created At')
    ->dateTime()
    ->sortable(),
```

**Tampilan:**
![Sorting Date Descending](img/Sorting%20Date%20Descending.png)
*Keterangan: Mengurutkan post dari yang paling baru dibuat.*

---

## 4. Mengatur Default Sorting
Untuk memberikan user experience yang lebih baik, kita mengatur agar tabel secara default menampilkan data terbaru.

**Langkah Kerja:**
Menambahkan `->defaultSort('created_at', 'desc')` pada konfigurasi tabel.

```php
public static function configure(Table $table): Table
{
    return $table
        ->defaultSort('created_at', 'desc')
        ->columns([
            // ...
        ]);
}
```

---

## Analisis & Diskusi

1. **Mengapa sorting penting pada admin panel?**
   Sorting sangat krusial untuk manajemen data skala besar agar admin dapat dengan cepat menemukan data terbaru, data berdasarkan kategori tertentu, atau mencari data secara alfabetis tanpa harus melakukan scrolling manual yang melelahkan.

2. **Apa perbedaan sortable() biasa dengan defaultSort()?**
   `sortable()` adalah fungsi untuk **mengaktifkan** tombol/fitur sorting pada header kolom agar bisa diklik oleh user. Sedangkan `defaultSort()` digunakan untuk menentukan **keadaan awal** (initial state) urutan data saat halaman pertama kali dimuat.

3. **Mengapa relasi tetap bisa di-sort?**
   Filament secara cerdas menangani query di balik layar. Saat kita memanggil `category.name` dengan `sortable()`, Filament melakukan *Eager Loading* dan menerapkan join query SQL yang diperlukan sehingga pengurutan data antar tabel tetap efisien.

4. **Kapan kita menggunakan desc sebagai default?**
   Biasanya digunakan pada kolom tanggal (`created_at`) atau ID untuk aplikasi seperti blog, log aktivitas, atau transaksi, di mana informasi paling relevan bagi pengguna biasanya adalah data yang paling baru dimasukkan.

---

## Kesimpulan
Melalui praktikum ini, fitur sorting pada Filament terbukti sangat mudah diimplementasikan hanya dengan menambahkan satu method `sortable()`. Kita juga telah berhasil mengatur urutan default tabel sehingga mempermudah pengelolaan data Post.
