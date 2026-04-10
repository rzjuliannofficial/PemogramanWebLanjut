# Jobsheet 2 - Filament Layout Form

## Mengapa layout form penting dalam aplikasi admin?

Layout yang terstruktur meningkatkan User Experience (UX) dan efisiensi. Dengan mengelompokkan data yang relevan (seperti memisahkan detail konten dari meta-data), pengguna dapat melakukan entri data lebih cepat, mengurangi kebingungan, dan meminimalisir kesalahan input.

## Apa perbedaan `Section` dan `Group`?

**Section:**
- Memiliki wujud visual berupa kotak (box) dengan border
- Bisa diberi judul, deskripsi, dan ikon
- Digunakan untuk memisahkan UI secara visual

**Group:**
- Komponen invisible (tidak terlihat di layar)
- Digunakan murni secara struktural di belakang layar
- Mengelompokkan beberapa field agar bisa diatur properti layout/grid-nya secara bersamaan (misalnya mengatur `columnSpan`)
- Tidak menambah kotak visual baru di antarmuka

## Kapan kita menggunakan `columnSpanFull()`?

Digunakan ketika ada sebuah field yang membutuhkan ruang maksimal secara horizontal dari ujung kiri ke kanan di dalam container-nya. Biasanya ini wajib diterapkan pada text editor (`MarkdownEditor` / `RichEditor`) agar area pengetikan cukup luas dan nyaman digunakan.

## Apa keuntungan sistem grid 12 kolom?

Sistem grid 12 kolom (seperti yang digunakan Tailwind CSS dan Filament) sangat fleksibel secara matematis. Angka 12 bisa dibagi rata menjadi banyak proporsi:
- **1/2** = 6 kolom
- **1/3** = 4 kolom
- **1/4** = 3 kolom
- **2/3** = 8 kolom

Ini memudahkan pembuatan desain form asimetris yang tetap responsif dan proporsional di berbagai ukuran layar ponsel maupun desktop.