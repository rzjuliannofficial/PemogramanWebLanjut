# Jobsheet 3 - Filament Validation

## Analisis & Diskusi

### Pertanyaan

**1. Mengapa validasi penting pada admin panel?**

Mencegah garbage in, garbage out. Validasi adalah lapis pertahanan utama untuk memastikan integritas database tidak rusak karena format data yang salah, kosong, atau duplikat. Tanpa ini, sistemmu rentan error saat merender data.

**2. Apa perbedaan validasi client-side dan server-side?**

**Client-side:**
- Berjalan di browser pengguna (menggunakan HTML/JS)
- Cepat memberi respons
- Sangat mudah diakali atau dibypass oleh user (misal dengan mematikan JS)

**Server-side:**
- Berjalan di backend (Laravel/Filament)
- Mutlak dan tidak bisa dibypass
- Ini adalah validasi sebenarnya

**3. Mengapa `unique` otomatis bekerja saat edit data?**

Filament sangat mengerti konteks Eloquent Laravel. Saat kamu menyimpan data edit, rule `unique` Filament di belakang layar otomatis menyuntikkan pengecualian (ignore) untuk ID dari record yang sedang kamu perbarui, sehingga tidak dianggap sebagai duplikat oleh dirinya sendiri.

**4. Kapan kita perlu menggunakan rules array dibanding string?**

- **String** (misal: `'required|min:3'`) — gunakan untuk validasi yang pendek dan sederhana
- **Array** (misal: `['required', 'min:3']`) — gunakan jika rule-nya panjang, rumit, atau saat kamu perlu menyisipkan custom rule object bawaan Laravel (seperti `Rule::unique(...)` atau closure)

Array jauh lebih rapi dan aman dari kesalahan pemotongan (parsing).

## Tampilan
**Tampilan CRUD Update**
<br>![Tampilan Create](img/Create_Update.png)
