# Laporan Tugas Jobsheet 03 - Filament - PWL 2025/2026

## Analisis & Diskusi

### Pertanyaan

**1. Mengapa kita perlu $fillable?**

$fillable adalah properti pada Model Laravel yang mendefinisikan atribut-atribut mana saja yang dapat diisi secara massal (mass assignment) melalui method seperti `create()` atau `update()`. Kita membutuhkannya untuk alasan keamanan, mencegah pengisian atribut yang tidak diinginkan. Tanpa $fillable, jika kita tidak menggunakan $guarded, semua atribut bisa diisi yang berisiko terhadap mass assignment vulnerability. Contoh: `protected $fillable = ['name', 'slug', 'description'];`

**2. Apa fungsi $casts pada Laravel?**

$casts adalah properti Model yang mengubah tipe data atribut secara otomatis. Ia berfungsi untuk mengkonversi data dari database ke tipe PHP yang diinginkan saat mengakses atribut, dan sebaliknya saat menyimpan. Contohnya: `protected $casts = ['is_active' => 'boolean', 'price' => 'decimal:2', 'created_at' => 'datetime'];` sehingga data boolean disimpan sebagai 0/1 di database tetapi diakses sebagai true/false di aplikasi.

**3. Apa perbedaan integer biasa dengan foreign key?**

Integer biasa adalah kolom angka biasa tanpa hubungan dengan tabel lain. Foreign key adalah kolom integer yang mereferensi primary key dari tabel lain, menciptakan hubungan antar tabel. Foreign key memastikan integritas referensial: tidak bisa menyimpan nilai yang tidak ada di tabel yang direferensi, dan ada aturan saat data di tabel parent dihapus. Contoh: `$table->foreignId('category_id')->constrained();` membuat foreign key ke tabel categories.

**4. Bagaimana jika category dihapus tetapi masih ada post?**

Bergantung pada constraint yang didefinisikan pada foreign key:
- **CASCADE**: Post akan otomatis dihapus jika category dihapusnya. `$table->foreignId('category_id')->constrained()->onDelete('cascade');`
- **SET NULL**: category_id pada post akan menjadi NULL jika category dihapus. `$table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');`
- **RESTRICT**: Database akan menolak penghapusan category jika masih ada post. `$table->foreignId('category_id')->constrained()->onDelete('restrict');`
