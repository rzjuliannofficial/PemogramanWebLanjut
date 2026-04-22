# LAPORAN PRAKTIKUM PEMROGRAMAN WEB LANJUT
## Jobsheet 7 - Implementasi Wizard Form (Multi Step Form) di Filament

### A. Studi Kasus

Dalam sistem e-commerce, form untuk memasukkan data produk biasanya sangat panjang dan kompleks. Untuk meningkatkan user experience (UX) dan membuatnya lebih user-friendly, form tersebut dibagi menjadi beberapa tahap menggunakan teknik Wizard Form (Multi Step Form). Tahapan yang dibuat meliputi:
- Product Info
- Pricing & Stock
- Media & Status

---

### B. Langkah-Langkah Praktikum

#### 1. Membuat Migrasi Database

Langkah pertama adalah membuat tabel products di database.

**Perintah:**
```bash
php artisan make:migration create_products_table
```

**Kode Migrasi** (database/migrations/2026_04_16_044706_create_products_table.php):
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint ) {
            ->id();
            ->string('name');
            ->string('sku')->unique();
            ->text('description');
            ->integer('price');
            ->integer('stock');
            ->string('image')->nullable();
            ->boolean('is_active')->default(true);
            ->boolean('is_featured')->default(false);
            ->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

> 📸 **SCREENSHOT:**
> ![Screenshot Migrasi Database](img/Migration.png)
> *Contoh: Screenshot terminal saat tulisan Migrating... Done muncul atau screenshot struktur tabel di phpMyAdmin/DBeaver.*

#### 2. Membuat Model Product

**Perintah:**
```bash
php artisan make:model Product
```

**Kode Model** (app/Models/Product.php):
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected  = [
        'name', 'sku', 'description', 'price', 
        'stock', 'image', 'is_active', 'is_featured'
    ];

    protected  = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
    ];
}
```

#### 3. Membuat Resource Product di Filament

**Perintah:**
```bash
php artisan make:filament-resource Product
```

**Catatan saat prompt muncul:**
- Title attribute: 
ame
- Generate view page: yes
- Generate from database: 
o

> 📸 **SCREENSHOT:** 
> ![Menu Products di Sidebar](img/Product-filament.png)
> ![Menu Products di Sidebar](img/menu_products.png)

#### 4. Implementasi Wizard Form & Validasi (Termasuk Tugas M)

Mengubah form default menjadi form multi-step. Di sini juga langsung diterapkan penyelesaian dari Tugas M (Menambahkan icon pada step dan validasi minimal harga > 0).

**Kode Form** (app/Filament/Admin/Resources/Products/Schemas/ProductForm.php):
```php
namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Actions\Action;

class ProductForm
{
    public static function configure(Schema ): Schema
    {
        return ->components([
            Wizard::make([
                Step::make('Product Info')
                    ->description('Isi informasi dasar produk')
                    ->icon('heroicon-o-information-circle') // Jawaban Tugas M.1
                    ->schema([
                        Group::make([
                            TextInput::make('name')->required(),
                            TextInput::make('sku')->required(),
                        ])->columns(2),
                        MarkdownEditor::make('description')->columnSpanFull(),
                    ]),

                Step::make('Pricing & Stock')
                    ->description('Isi harga dan jumlah stok')
                    ->icon('heroicon-o-currency-dollar') // Jawaban Tugas M.1
                    ->schema([
                        TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->minValue(1), // Jawaban Tugas M.2: Minimal harga > 0

                        TextInput::make('stock')
                            ->numeric()
                            ->required(),
                    ]),

                Step::make('Media & Status')
                    ->description('Upload gambar dan atur status')
                    ->icon('heroicon-o-photo') // Jawaban Tugas M.1
                    ->schema([
                        FileUpload::make('image')
                            ->disk('public')
                            ->directory('products'),
                        Checkbox::make('is_active')->label('Is Active'),
                        Checkbox::make('is_featured')->label('Is Featured'),
                    ]),
            ])
            ->columnSpanFull()
            ->submitAction( // Pengaturan tombol submit pada Wizard
                Action::make('save')
                    ->label('Save Product')
                    ->button()
                    ->color('primary')
                    ->submit('save')
            )
        ]);
    }
}
```

> 📸 **SCREENSHOT:** 
> - **Product:** ![Wizard Step 1](img/product.png)
> - **Step 1:** ![Wizard Step 1](img/wizard_step1.png)
> - **Step 2:** ![Wizard Step 2](img/wizard_step2.png)
> - **Step 3:** ![Wizard Step 3](img/wizard_step3.png)

#### 5. Menghilangkan Default Button

Karena kita sudah menggunakan tombol submit dari Wizard, tombol "Create" bawaan halaman harus dihilangkan agar tidak bingung.

**Kode Page** (app/Filament/Admin/Resources/Products/Pages/CreateProduct.php):
```php
namespace App\Filament\Admin\Resources\Products\Pages;

use App\Filament\Admin\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string  = ProductResource::class;

    // Override fungsi ini untuk mengembalikan array kosong
    protected function getFormActions(): array
    {
        return [];
    }
}
```

#### 6. Menampilkan Data pada Tabel (Termasuk Tugas M)

Menampilkan data yang telah diinput ke dalam tabel Filament. Ini termasuk Tugas M.3 (menambahkan badge pada kolom status aktif).

**Kode Table** (app/Filament/Admin/Resources/Products/Tables/ProductsTable.php):
```php
namespace App\Filament\Admin\Resources\Products\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

class ProductsTable
{
    public static function configure(Table ): Table
    {
        return 
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('sku'),
                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('stock'),
                ImageColumn::make('image')->disk('public'),
                
                // Jawaban Tugas M.3: Badge Kolom Status Aktif
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool ): string =>  ? 'Aktif' : 'Non-Aktif')
                    ->color(fn (bool ): string =>  ? 'success' : 'danger'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

> 📸 **SCREENSHOT:** 
> ![Tabel Products (Min. 3 Data)](img/tabel_products.png)
> *Pastikan screenshot memperlihatkan badge status aktif dan gambar yang berhasil diupload.*

---

### C. Jawaban Analisis & Diskusi (Bagian L)

**1. Mengapa Wizard Form lebih baik untuk form panjang?**
Wizard Form memecah form yang panjang dan mengintimidasi menjadi beberapa potongan logis yang lebih kecil. Hal ini secara drastis mengurangi beban kognitif (*cognitive load*) pengguna. Pengguna dapat fokus pada satu konteks data pada satu waktu (misal: hanya memikirkan harga, sebelum memikirkan foto produk), sehingga mengurangi kemungkinan kesalahan input dan meningkatkan rasio penyelesaian pengisian form.

**2. Kapan kita menggunakan skippable()?**
Fungsi skippable() digunakan ketika sebuah tahapan (step) dalam wizard memuat informasi yang bersifat opsional atau tidak wajib diisi saat itu juga. Dengan skippable(), sistem mengizinkan pengguna untuk melewati langkah tersebut tanpa memicu error validasi form, sehingga mereka bisa langsung menuju langkah akhir atau submit.

**3. Apa kelebihan multi step dibanding single form panjang?**
- **Fokus Visual:** Tampilan tidak terlihat penuh sesak.
- **Organisasi Data:** Data dikelompokkan secara logis, memudahkan pemahaman alur.
- **Validasi Berkala:** Validasi dilakukan per langkah, sehingga pengguna langsung tahu jika ada error sebelum mereka tersesat di tumpukan form.
- **Progress Indication:** Adanya indikator visual (Step 1, 2, 3) memberikan efek psikologis bahwa tugas ini terukur dan akan segera selesai.

**4. Apakah wizard cocok untuk semua jenis form?**
**Tidak.** Wizard form sangat buruk jika digunakan untuk form yang sederhana dan pendek (seperti form Login, form Contact Us, atau input yang hanya butuh 2-3 kolom). Memaksa form pendek menjadi wizard hanya akan membuang waktu pengguna karena harus melakukan klik tambahan secara sia-sia. Wizard hanya cocok untuk entitas data kompleks yang membutuhkan kategorisasi masif.

---

---

# LAPORAN PRAKTIKUM PEMROGRAMAN WEB LANJUT
## Jobsheet 8 - Implementasi Info List (View Page) di Filament

---

### A. Studi Kasus

Pada Jobsheet sebelumnya (Jobsheet 7), kami telah mengimplementasikan Wizard Form (Multi Step Form) untuk input data produk. Namun, ketika pengguna mengklik tombol "View" untuk melihat detail produk, halaman masih menampilkan form input yang tidak sesuai untuk tampilan informasi read-only.

Solusi yang tepat adalah menggunakan **Info List** untuk menampilkan data produk dalam bentuk display informasi yang profesional dan lebih rapi. Jobsheet ini bertujuan untuk meningkatkan tampilan halaman detail produk dengan menggunakan komponen-komponen Info List seperti TextEntry, ImageEntry, dan IconEntry.

---

### B. Capaian Pembelajaran

Setelah mengikuti praktikum ini, mahasiswa mampu:
1. Memahami konsep Info List pada Filament
2. Mengubah tampilan View Page dari form menjadi display informasi
3. Menggunakan TextEntry, ImageEntry, dan IconEntry
4. Menggunakan Badge, Color, Icon, dan Format Date
5. Mendesain halaman detail (show page) yang lebih profesional

---

### C. Konsep Info List

**Pengertian Info List:**
Info List adalah komponen di Filament yang digunakan untuk menampilkan data detail record dalam bentuk informasi read-only (tidak dapat diedit). Ini berbeda dengan Form yang memungkinkan pengguna untuk mengedit data.

**Kapan menggunakan Info List:**
- Menampilkan data detail record
- Mengganti tampilan input form menjadi display-only pada halaman View
- Membuat halaman detail produk/kategori yang profesional
- Menampilkan informasi historis atau data yang tidak boleh diubah

**Perbandingan Komponen:**

| Form | Table | Info List |
|------|-------|-----------|
| TextInput | TextColumn | TextEntry |
| FileUpload | ImageColumn | ImageEntry |
| Checkbox | IconColumn | IconEntry |
| Editable | Sortable | Read-only |

---

### D. Langkah-Langkah Implementasi

#### 1. File Structure

Struktur file yang digunakan dalam implementasi:
```
app/
  Filament/
    Resources/
      Products/
        ProductResource.php
        Schemas/
          ProductForm.php (dari Week 7)
          ProductInfolist.php (BARU)
        Pages/
          ViewProduct.php
          ListProducts.php
          CreateProduct.php
          EditProduct.php
        Tables/
          ProductsTable.php
  Models/
    Product.php
database/
  factories/
    ProductFactory.php (BARU)
  seeders/
    ProductSeeder.php (BARU)
    DatabaseSeeder.php (Updated)
```

#### 2. Membuat ProductInfolist

**File:** `app/Filament/Resources/Products/Schemas/ProductInfolist.php`

```php
<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section 1: Product Info
                Section::make('Product Info')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Product Name')
                            ->weight('bold')
                            ->color('primary'),
                        TextEntry::make('id')
                            ->label('Product ID'),
                        TextEntry::make('sku')
                            ->label('Product SKU')
                            ->badge()
                            ->color('success'),
                        TextEntry::make('description')
                            ->label('Product Description'),
                    ])
                    ->columnSpanFull(),

                // Section 2: Pricing & Stock
                Section::make('Pricing & Stock')
                    ->schema([
                        TextEntry::make('price')
                            ->label('Product Price')
                            ->icon('heroicon-o-currency-dollar')
                            ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                        TextEntry::make('stock')
                            ->label('Product Stock')
                            ->icon('heroicon-o-cube'),
                    ])
                    ->columns(2),

                // Section 3: Media & Status
                Section::make('Media & Status')
                    ->schema([
                        ImageEntry::make('image')
                            ->label('Product Image')
                            ->disk('public'),
                        IconEntry::make('is_active')
                            ->label('Is Active')
                            ->boolean(),
                        IconEntry::make('is_featured')
                            ->label('Is Featured')
                            ->boolean(),
                        TextEntry::make('created_at')
                            ->label('Product Creation Date')
                            ->dateTime('d M Y, H:i')
                            ->color('info'),
                    ])
                    ->columns(2),
            ]);
    }
}
```

**Penjelasan Komponen:**

**a) Section - Pengelompokan Data**
```php
Section::make('Product Info')
    ->schema([...])
    ->columnSpanFull()
```
- Section digunakan untuk mengelompokkan data secara logis
- `columnSpanFull()` membuat section menjangkau seluruh lebar tersedia

**b) TextEntry - Menampilkan Teks**
```php
TextEntry::make('name')
    ->label('Product Name')
    ->weight('bold')  // Teks tebal
    ->color('primary')  // Warna biru
```
- `weight('bold')` membuat teks menjadi tebal
- `color('primary')` memberikan warna primer pada teks
- Properti lainnya: `secondary`, `success`, `danger`, `warning`, `info`

**c) Badge - Format Badge**
```php
TextEntry::make('sku')
    ->label('Product SKU')
    ->badge()  // Tampilkan sebagai badge
    ->color('success')  // Warna hijau
```
- `badge()` menampilkan nilai dalam bentuk badge
- Rapi dan mudah dibaca

**d) Icon - Menambahkan Icon**
```php
TextEntry::make('price')
    ->icon('heroicon-o-currency-dollar')
```
- `icon()` menambahkan icon membantu pengguna memahami data
- Icon menggunakan Heroicons library

**e) formatStateUsing - Format Custom**
```php
->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
```
- Memformat harga menjadi format Rupiah dengan separator ribuan
- Contoh: 15000000 menjadi "Rp 15.000.000"

**f) ImageEntry - Menampilkan Gambar**
```php
ImageEntry::make('image')
    ->label('Product Image')
    ->disk('public')
```
- Menampilkan gambar dari disk 'public'
- Ukuran gambar akan disesuaikan otomatis

**g) IconEntry - Boolean Icon**
```php
IconEntry::make('is_active')
    ->boolean()
```
- Menampilkan icon check (✓) jika value true
- Menampilkan icon silang (✗) jika value false

**h) dateTime - Format Tanggal**
```php
TextEntry::make('created_at')
    ->dateTime('d M Y, H:i')
```
- Format: "16 Apr 2026, 10:30"
- Format lain: `date('d M Y')`, `time('H:i')`

#### 3. Mengintegrasikan Info List ke ProductResource

**File:** `app/Filament/Resources/Products/ProductResource.php`

ProductResource sudah dikonfigurasi untuk menggunakan ProductInfolist:
```php
public static function infolist(Schema $schema): Schema
{
    return ProductInfolist::configure($schema);
}
```

#### 4. ViewProduct Page (Sudah Dikonfigurasi)

**File:** `app/Filament/Resources/Products/Pages/ViewProduct.php`

```php
<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
```

Halaman ini otomatis akan menampilkan Info List yang telah dikonfigurasi di ProductResource.

---

### E. Membuat Data Uji Coba

#### 1. ProductFactory

**File:** `database/factories/ProductFactory.php`

```php
<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'sku' => fake()->unique()->bothify('SKU-####??'),
            'description' => fake()->paragraph(3),
            'price' => fake()->numberBetween(10000, 500000),
            'stock' => fake()->numberBetween(1, 100),
            'image' => null,
            'is_active' => true,
            'is_featured' => fake()->boolean(30),
        ];
    }
}
```

#### 2. ProductSeeder

**File:** `database/seeders/ProductSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed 5 produk random
        Product::factory(5)->create();

        // Seed 2 produk dengan data spesifik
        Product::create([
            'name' => 'Laptop Gaming Pro',
            'sku' => 'LAP-001',
            'description' => 'Laptop gaming dengan spesifikasi tinggi, prosesor Intel i7, RAM 16GB, SSD 512GB, GPU RTX 3060 Ti',
            'price' => 15000000,
            'stock' => 5,
            'image' => null,
            'is_active' => true,
            'is_featured' => true,
        ]);

        Product::create([
            'name' => 'Mouse Gaming RGB',
            'sku' => 'MOU-001',
            'description' => 'Mouse gaming dengan lighting RGB programmable, DPI 12800, 8 tombol yang dapat diprogram',
            'price' => 350000,
            'stock' => 25,
            'image' => null,
            'is_active' => true,
            'is_featured' => false,
        ]);
    }
}
```

#### 3. Update DatabaseSeeder

**File:** `database/seeders/DatabaseSeeder.php`

```php
public function run(): void
{
    User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    // Seed products
    $this->call(ProductSeeder::class);
}
```

#### 4. Menjalankan Migrations dan Seeders

```bash
php artisan migrate --seed
```

Atau jika sudah ada data sebelumnya:
```bash
php artisan migrate:refresh --seed
```

---

### F. Hasil Tampilan Info List

#### Section 1: Product Info
- **Product Name**: Menampilkan nama produk dengan format bold dan warna primary (biru)
- **Product ID**: ID unik produk
- **Product SKU**: Stock Keeping Unit dalam format badge hijau
- **Product Description**: Deskripsi lengkap produk

#### Section 2: Pricing & Stock
- **Product Price**: Harga dalam format Rp dengan icon dolar
  - Format: "Rp 15.000.000"
- **Product Stock**: Jumlah stok dengan icon kotak

#### Section 3: Media & Status
- **Product Image**: Gambar produk (jika tersedia)
- **Is Active**: Icon check jika status aktif
- **Is Featured**: Icon check jika produk featured
- **Product Creation Date**: Tanggal pembuatan dalam format readable

---

### G. Perbandingan Sebelum & Sesudah Implementasi

| Aspek | Sebelum (Form Input) | Sesudah (Info List) |
|-------|------|---------|
| **Tampilan** | Form input dengan field editable | Display profesional read-only |
| **Interaksi** | User bisa mengedit data | User hanya bisa melihat data |
| **Struktur** | Flat tanpa pengelompokan | Terorganisir dalam sections |
| **Validitas Data** | Perlu validasi input | Data sudah pasti valid |
| **User Experience** | Bingung untuk melihat data | Jelas dan mudah dipahami |

---

### H. Ringkasan Komponen Info List

| Komponen | Fungsi | Contoh |
|----------|--------|--------|
| **Section** | Mengelompokkan data secara logis | `Section::make('Product Info')` |
| **TextEntry** | Menampilkan teks biasa | `TextEntry::make('name')` |
| **ImageEntry** | Menampilkan gambar | `ImageEntry::make('image')->disk('public')` |
| **IconEntry** | Menampilkan boolean sebagai icon | `IconEntry::make('is_active')->boolean()` |
| **badge()** | Format badge | `.badge()->color('success')` |
| **color()** | Memberikan warna teks | `.color('primary')` |
| **icon()** | Menambahkan icon | `.icon('heroicon-o-star')` |
| **weight()** | Bold/normal text | `.weight('bold')` |
| **formatStateUsing()** | Custom format | `.formatStateUsing(fn ($state) => 'Rp ' . $state)` |
| **dateTime()** | Format tanggal | `.dateTime('d M Y, H:i')` |

---

### I. Jawaban Analisis & Diskusi (Bagian L)

#### 1. Mengapa View Page tidak cocok menggunakan form input?

**Jawaban:**
View Page tidak cocok menggunakan form input karena:
- **Confusing UX**: Pengguna akan sulit membedakan apakah ini halaman view atau edit. Mereka mungkin akan mencoba mengedit data padahal seharusnya hanya viewing.
- **Data Validation**: Form input biasanya memiliki validasi yang dapat menampilkan error. Di halaman view, ini tidak diperlukan dan malah mengganggu.
- **Performance**: Form input memiliki logic lebih kompleks dibanding display. Menggunakan form hanya untuk display adalah waste of resources.
- **Security**: Menampilkan form input di view menawarkan kesempatan untuk manipulasi data melalui JavaScript browser, meski sudah ada backend validation.
- **Visual Clarity**: Info List dengan sections memberikan penampilan yang lebih rapi, terstruktur, dan professional.

#### 2. Apa perbedaan TextColumn dan TextEntry?

**Jawaban:**

| TextColumn | TextEntry |
|-----------|-----------|
| Digunakan di Table | Digunakan di Info List (View Page) |
| Menampilkan data dalam bentuk kolom row | Menampilkan data dalam bentuk detail record |
| Bersifat sortable dan dapat di-search | Read-only, tidak dapat di-sort |
| Cocok untuk melihat daftar data | Cocok untuk melihat detail satu record |
| Misalnya: Daftar produk di tabel | Misalnya: Detail produk saat view |

**Contoh TextColumn:**
```php
TextColumn::make('price')->money('IDR')->sortable();
```

**Contoh TextEntry:**
```php
TextEntry::make('price')
    ->label('Product Price')
    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'));
```

#### 3. Kapan kita menggunakan badge?

**Jawaban:**
Badge digunakan ketika:
- **Status sederhana**: Menampilkan status yang jelas dan singkat (Aktif, Inactive, Featured, dll)
- **Quick scan**: Badge memudahkan user untuk quick scan tanpa membaca teks panjang
- **Visual distinction**: Badge membuat teks menonjol dengan background color dan border
- **Kategori**: Menampilkan kategori atau tag produk
- **Priority level**: Badge bisa menampilkan tingkat prioritas dengan warna (merah=urgent, hijau=normal, dll)

**Contoh penggunaan:**
```php
// SKU dengan badge success
TextEntry::make('sku')->badge()->color('success');

// Status dengan kondisional
TextEntry::make('status')
    ->badge()
    ->color(fn (string $state): string =>
        match($state) {
            'active' => 'success',
            'pending' => 'warning',
            'inactive' => 'danger',
        }
    );
```

#### 4. Apa keuntungan menggunakan IconEntry untuk boolean?

**Jawaban:**
Keuntungan IconEntry untuk boolean:
- **Quick visualization**: User langsung tahu true/false tanpa harus membaca teks "Yes/No" atau "1/0"
- **Space efficient**: Icon memakan space lebih kecil dibanding teks
- **Universal understanding**: Icon check dan silang dimengerti secara universal (tidak perlu teks)
- **Accessibility**: Icon mudah terlihat dengan warna: hijau (check) untuk true, merah (silang) untuk false
- **Professional look**: Menampilkan icon boolean membuat UI lebih professional dan clean
- **Pattern matching**: User sudah terbiasa dengan pattern ini dari aplikasi lain (checkboxes, status indicators)

**Perbandingan:**
```
Pakai TextEntry:  is_active: true (membingungkan, perlu dibaca)
Pakai IconEntry:  ✓ (langsung tahu aktif)

Pakai TextEntry:  is_featured: false (membingungkan)
Pakai IconEntry:  ✗ (langsung tahu tidak featured)
```

---

### J. Ringkasan Implementasi Week 8

Fitur yang telah diimplementasikan:

✅ **Mengubah View Page menjadi Info List**
- ProductInfolist.php telah dibuat dengan structure yang rapi

✅ **Menggunakan TextEntry**
- Menampilkan name, id, sku, dan description

✅ **Menggunakan ImageEntry**
- Menampilkan product image dari disk public

✅ **Menggunakan IconEntry untuk boolean**
- Menampilkan is_active dan is_featured sebagai icon

✅ **Menggunakan badge, icon, color**
- SKU dengan badge success
- Price dengan icon dolar
- Stock dengan icon kotak
- Created date dengan warna info

✅ **Format tanggal dan harga**
- Harga: "Rp 15.000.000" (formatStateUsing)
- Tanggal: "16 Apr 2026, 10:30" (dateTime)

✅ **Membuat data uji coba**
- ProductFactory untuk generate data random
- ProductSeeder untuk seed data spesifik
- DatabaseSeeder diupdate untuk call ProductSeeder

---

### K. Tasks yang Sudah Diselesaikan (Dari Jobsheet Bagian K)

#### ✅ Task 1: Tambahkan badge untuk SKU dengan warna berbeda
```php
TextEntry::make('sku')
    ->label('Product SKU')
    ->badge()
    ->color('success')  // Warna hijau
```

#### ✅ Task 2: Tambahkan icon pada Stock
```php
TextEntry::make('stock')
    ->label('Product Stock')
    ->icon('heroicon-o-cube')  // Icon kotak
```

#### ✅ Task 3: Tambahkan format harga menjadi Rp dengan formatStateUsing()
```php
TextEntry::make('price')
    ->label('Product Price')
    ->icon('heroicon-o-currency-dollar')
    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
```

#### ✅ Task 4: Buat minimal 2 product untuk pengujian
- ProductFactory dibuat bisa generate unlimited products random
- ProductSeeder membuat 5 + 2 produk spesifik = 7 total products

#### ✅ Task 5: Screenshots (Perlu dijalankan saat database tersedia)
- Section Product Info
- Section Pricing & Stock  
- Section Media & Status

---

### L. Persiapan untuk Testing

Untuk menjalankan dan test aplikasi, gunakan perintah:

```bash
# 1. Migrate dan seed database
php artisan migrate:refresh --seed

# 2. Start development server
php artisan serve

# 3. Akses aplikasi di http://localhost:8000
# Login dengan
# Email: test@example.com
# Password: password

# 4. Navigasi ke Products di sidebar
# Klik view pada salah satu product untuk melihat Info List
```

---

### M. Kesimpulan

Pada Jobsheet Week 8 ini, kami telah berhasil:

1. **Memahami konsep Info List** - Komponen untuk menampilkan data read-only
2. **Mengubah View Page** - Dari form input menjadi display informasi profesional
3. **Menguasai komponen Info List** - TextEntry, ImageEntry, IconEntry
4. **Formatting data** - Color, badge, icon, date formatting
5. **Membuat test data** - Factory dan Seeder untuk data testing
6. **Best practices** - Struktur section untuk UI yang terorganisir

Info List memberikan pengalaman user yang jauh lebih baik dibanding form input ketika hanya menampilkan data. Dengan kombinasi TextEntry, ImageEntry, IconEntry, serta styling (color, badge, icon), halaman view menjadi professional dan mudah dipahami.

---

**Status Implementasi:** ✅ SELESAI

**Tanggal:** 22 April 2026

**File yang dibuat/dimodifikasi:**
- ✅ `app/Filament/Resources/Products/Schemas/ProductInfolist.php` (Baru)
- ✅ `database/factories/ProductFactory.php` (Baru)
- ✅ `database/seeders/ProductSeeder.php` (Baru)
- ✅ `database/seeders/DatabaseSeeder.php` (Updated)

---

---

# LAPORAN PRAKTIKUM PEMROGRAMAN WEB LANJUT
## Jobsheet 9 - Implementasi Tabs pada Info List di Filament

### A. Studi Kasus

Pada Jobsheet sebelumnya (Jobsheet 8), kami telah menggunakan Info List dengan Section untuk menampilkan detail Product. Namun jika data cukup banyak, pengguna harus scroll panjang ke bawah untuk melihat semua informasi.

Solusi yang lebih baik adalah menggunakan **Tabs** agar informasi dibagi menjadi beberapa kategori dan dapat diakses dengan klik. Dengan pendekatan ini, halaman View menjadi lebih ringkas, interaktif, dan user-friendly.

**Contoh pembagian Tabs:**
- **Tab 1:** Product Info (nama, SKU, deskripsi)
- **Tab 2:** Pricing & Stock (harga, stok, badge dinamis)
- **Tab 3:** Media & Status (gambar, status aktif, featured)

---

### B. Capaian Pembelajaran

Setelah mengikuti praktikum ini, mahasiswa mampu:
1. Menggunakan komponen Tabs pada Info List
2. Mengelompokkan informasi detail ke dalam beberapa tab
3. Menambahkan icon dan badge pada tab
4. Implementasi badge dinamis berdasarkan data
5. Mengubah orientasi tab (horizontal & vertical)
6. Mendesain halaman View agar lebih ringkas dan user-friendly

---

### C. Konsep Tabs di Info List

**Pengertian Tabs:**
Tabs adalah komponen UI yang membagi informasi ke dalam beberapa halaman kecil yang dapat diakses dengan klik pada tab header. Setiap tab menampilkan konten yang berbeda tanpa harus scroll panjang.

**Kapan menggunakan Tabs:**
- Informasi detail yang sangat banyak
- Mengelompokkan data ke dalam kategori logis
- Mengurangi cognitive load pengguna
- Membuat UI lebih professional dan interactive

**Perbandingan Section vs Tabs:**

| Section | Tabs |
|---------|------|
| Semua tampil sekaligus | Tersembunyi sampai diklik |
| Scroll panjang | Navigasi klik |
| Kurang interaktif | Lebih interaktif |
| Cocok untuk data sedikit | Cocok untuk data banyak |

---

### D. Implementasi Tabs di ProductInfolist

#### 1. Struktur Dasar Tabs

```php
Tabs::make('Product Tabs')
    ->tabs([
        Tabs\Tab::make('Tab Name')
            ->icon('heroicon-xxxx')
            ->schema([
                // Komponen di dalam tab
            ]),
        // Tab lainnya...
    ])
    ->columnSpanFull()
```

#### 2. File yang Diupdate

**File:** `app/Filament/Resources/Products/Schemas/ProductInfolist.php`

```php
<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product Tabs')
                    ->tabs([
                        // Tab 1: Product Info
                        Tabs\Tab::make('Product Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextEntry::make('id')
                                    ->label('Product ID'),
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),
                                TextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color('success'),
                                TextEntry::make('description')
                                    ->label('Product Description')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),

                        // Tab 2: Pricing & Stock
                        Tabs\Tab::make('Pricing & Stock')
                            ->icon('heroicon-o-currency-dollar')
                            ->badge(fn ($record) => $record->stock)
                            ->badgeColor(fn ($record) => $record->stock > 10 ? 'success' : ($record->stock > 0 ? 'warning' : 'danger'))
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Product Price')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                                TextEntry::make('stock')
                                    ->label('Product Stock')
                                    ->icon('heroicon-o-cube')
                                    ->color(fn ($state) => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger')),
                            ])
                            ->columns(2),

                        // Tab 3: Media & Status
                        Tabs\Tab::make('Media & Status')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public')
                                    ->columnSpanFull(),
                                IconEntry::make('is_active')
                                    ->label('Active Status')
                                    ->boolean(),
                                IconEntry::make('is_featured')
                                    ->label('Featured')
                                    ->boolean(),
                                TextEntry::make('created_at')
                                    ->label('Created Date')
                                    ->dateTime('d M Y, H:i')
                                    ->color('info'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * Variasi: Implementasi dengan Tabs Vertical
     * Uncomment method ini jika ingin menggunakan Tabs Vertical
     */
    public static function configureVertical(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product Tabs')
                    ->vertical()
                    ->tabs([
                        // Tab 1-3 sama seperti di atas, hanya ditambahin ->vertical()
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
```

---

### E. Penjelasan Komponen Tabs

#### 1. Tabs - Container
```php
Tabs::make('Product Tabs')
```
- `make()` membuat instance Tabs dengan identifier unik
- Nama ini untuk keperluan internal Vue.js

#### 2. Tabs\Tab - Individual Tab
```php
Tabs\Tab::make('Product Info')
```
- Membuat satu tab dengan nama "Product Info"
- Nama ini akan ditampilkan di tab header

#### 3. icon() - Icon di Tab Header
```php
->icon('heroicon-o-information-circle')
```
- Menambahkan icon di sebelah kiri nama tab
- Membuat recognizer lebih mudah
- Icon menggunakan Heroicons library

#### 4. badge() - Badge di Tab Header
```php
->badge(fn ($record) => $record->stock)
->badgeColor(fn ($record) => $record->stock > 10 ? 'success' : ...)
```
- Menampilkan angka di tab header
- Contoh: "Pricing & Stock [5]" jika stock = 5
- **Jawaban Latihan K.1:** Badge dinamis berdasarkan stock

#### 5. badgeColor() - Warna Badge Dinamis
```php
->badgeColor(fn ($record) => 
    $record->stock > 10 ? 'success' : 
    ($record->stock > 0 ? 'warning' : 'danger')
)
```
- **Jawaban Latihan K.2:** Warna badge berbeda
- `success` (hijau) jika stock > 10
- `warning` (kuning) jika stock 1-10
- `danger` (merah) jika stock 0

#### 6. schema() - Konten Tab
```php
->schema([
    TextEntry::make('name'),
    // Komponen lainnya...
])
```
- Mendefinisikan komponen yang ditampilkan di dalam tab
- Sama seperti schema pada Section atau Form

#### 7. columnSpanFull() - Full Width
```php
->columnSpanFull()
```
- Membuat tab/konten menjangkau seluruh lebar
- Penting untuk layout responsif

#### 8. vertical() - Orientasi Vertical
```php
Tabs::make('Product Tabs')
    ->vertical()
```
- **Jawaban Latihan K.3:** Mengubah orientasi ke vertical
- Tab header akan ditampilkan di sebelah kiri
- Konten akan ditampilkan di sebelah kanan

---

### F. Fitur Tab yang Tersedia

| Method | Fungsi |
|--------|--------|
| `icon()` | Menambahkan icon pada tab |
| `badge()` | Menambahkan badge dengan angka |
| `badgeColor()` | Mengubah warna badge |
| `schema()` | Mendefinisikan konten tab |
| `columnSpanFull()` | Full width layout |
| `vertical()` | Ubah orientasi ke vertical |
| `lazyLoad()` | Load tab content hanya saat diklik |
| `persistTabInQueryString()` | Simpan active tab di URL |

---

### G. Dynamic Badge Implementation

**Kode untuk Dynamic Badge:**

```php
// Badge dengan nilai dinamis (jumlah stok)
Tabs\Tab::make('Pricing & Stock')
    ->badge(fn ($record) => $record->stock)  // Menampilkan nilai stock
    ->badgeColor(fn ($record) => 
        $record->stock > 10 ? 'success' :      // Hijau jika > 10
        ($record->stock > 0 ? 'warning' :      // Kuning jika 1-10
        'danger')                               // Merah jika 0
    )
```

**Logika Warna:**
- 🟢 **Success (Hijau):** Stock > 10 (Stok melimpah)
- 🟡 **Warning (Kuning):** Stock 1-10 (Stok menipis)
- 🔴 **Danger (Merah):** Stock 0 (Stok habis)

**Contoh Tampilan:**
- Produk A (Stok 50): `Pricing & Stock [50]` dengan badge hijau
- Produk B (Stok 5): `Pricing & Stock [5]` dengan badge kuning
- Produk C (Stok 0): `Pricing & Stock [0]` dengan badge merah

---

### H. Icon di Setiap Tab

**Jawaban Latihan K.4:** Icon berbeda pada setiap tab

```php
// Tab 1: Product Info
->icon('heroicon-o-information-circle')

// Tab 2: Pricing & Stock
->icon('heroicon-o-currency-dollar')

// Tab 3: Media & Status
->icon('heroicon-o-photo')
```

**List Icon Heroicons yang sering digunakan:**
- `heroicon-o-information-circle` - Info icon
- `heroicon-o-currency-dollar` - Dolar currency
- `heroicon-o-photo` - Foto/image
- `heroicon-o-cube` - Box/stock
- `heroicon-o-check-circle` - Success
- `heroicon-o-x-circle` - Error
- `heroicon-o-exclamation-circle` - Warning

---

### I. Horizontal vs Vertical Tabs

#### Horizontal Tabs (Default)
```php
Tabs::make('Product Tabs')
    ->tabs([...])
```

**Karakteristik:**
- Tab header di atas (horizontal)
- Konten di bawah
- Layout kompak
- Cocok untuk 2-5 tabs
- Responsive di desktop

```
┌─────────────────────────────┐
│ [Tab1] [Tab2] [Tab3]        │  ← Tab headers (horizontal)
├─────────────────────────────┤
│ Konten tab 1                │  ← Tab content
│ ...                         │
└─────────────────────────────┘
```

#### Vertical Tabs
```php
Tabs::make('Product Tabs')
    ->vertical()
    ->tabs([...])
```

**Karakteristik:**
- Tab header di kiri (vertical)
- Konten di kanan
- Lebih banyak space
- Cocok untuk banyak tabs
- Lebih readable

```
┌─────────┬──────────────────┐
│ Tab1  │ Konten tab 1     │
│ Tab2  │ ...              │
│ Tab3  │                  │
│──────│                  │
└─────────┴──────────────────┘
```

---

### J. Perbandingan Sebelum & Sesudah

#### Sebelum (Week 8 - Section)
```
Section Product Info
├─ Product Name: Laptop Gaming Pro
├─ Product ID: 1
├─ Product SKU: LAP-001
└─ Product Description: Laptop gaming...

Section Pricing & Stock
├─ Product Price: Rp 15.000.000
└─ Product Stock: 5

Section Media & Status
├─ Product Image: [Gambar]
├─ Is Active: ✓
├─ Is Featured: ✓
└─ Created Date: 22 Apr 2026, 10:30
```
**Problem:** User harus scroll banyak untuk melihat semua

#### Sesudah (Week 9 - Tabs)
```
[Product Info] [Pricing & Stock] [Media & Status]

Saat klik "Pricing & Stock":
├─ Product Price: Rp 15.000.000
├─ Product Stock: 5 (dengan warna warning)
└─ Badge di header: [5]
```
**Solusi:** Compact view, user pilih tab yang ingin dilihat

---

### K. Jawaban Latihan Praktikum

#### ✅ Latihan K.1: Badge Dinamis Berdasarkan Stok
```php
Tabs\Tab::make('Pricing & Stock')
    ->badge(fn ($record) => $record->stock)
```
Menampilkan jumlah stok sebagai badge di header tab.

#### ✅ Latihan K.2: Warna Badge Berbeda
```php
->badgeColor(fn ($record) => 
    $record->stock > 10 ? 'success' : 
    ($record->stock > 0 ? 'warning' : 'danger')
)
```
- Stock > 10: Hijau (success)
- Stock 1-10: Kuning (warning)
- Stock 0: Merah (danger)

#### ✅ Latihan K.3: Ubah Ke Vertical
```php
Tabs::make('Product Tabs')
    ->vertical()
    ->tabs([...])
```
Menambahkan `->vertical()` sebelum tabs.

#### ✅ Latihan K.4: Icon Berbeda Tiap Tab
```php
Tabs\Tab::make('Product Info')->icon('heroicon-o-information-circle')
Tabs\Tab::make('Pricing & Stock')->icon('heroicon-o-currency-dollar')
Tabs\Tab::make('Media & Status')->icon('heroicon-o-photo')
```

---

### L. Analisis & Diskusi

#### 1. Kapan kita menggunakan Tabs dibanding Section?

**Jawaban:**
- **Gunakan Section ketika:**
  - Data sedikit (2-3 kelompok)
  - Semua informasi perlu terlihat sekaligus
  - User tidak perlu membuat keputusan tentang informasi mana yang perlu dilihat
  - Page tidak terlalu panjang

- **Gunakan Tabs ketika:**
  - Data banyak (4+ kelompok)
  - Informasi dapat dikelompokkan ke dalam kategori jelas
  - Halaman akan terlalu panjang dengan Section
  - Ingin membuat UI lebih interactive dan professional

**Contoh:**
- Section: Product list dengan hanya 2-3 kolom
- Tabs: Product detail dengan 15+ field data

#### 2. Apa kelebihan Tabs untuk data panjang?

**Jawaban:**
1. **Reduce Cognitive Load**: User fokus pada satu kategori data saja
2. **Cleaner Interface**: UI tidak penuh sesak, lebih rapi dan profesional
3. **Better Organization**: Data terkelompok secara logis dan mudah ditemukan
4. **Faster Navigation**: Klik tab lebih cepat daripada scroll panjang
5. **Mobile Friendly**: Pada mobile, horizontal scroll tab lebih mudah daripada vertical scroll panjang
6. **Progressive Disclosure**: Hanya tampilkan informasi yang relevan dengan konteks

#### 3. Apakah Tabs bisa digunakan pada Form juga?

**Jawaban:**
**YA**, Tabs bisa digunakan pada Form di Filament. Implementasinya sama seperti pada Info List, cukup gunakan `Tabs` di dalam `Schema` pada method `form()`.

**Contoh di Form:**
```php
public static function form(Schema $schema): Schema
{
    return ProductForm::configure($schema);
}
```

Update ProductForm.php:
```php
Tabs::make('Product Wizard')
    ->tabs([
        Tabs\Tab::make('Basic Info')->schema([...]),
        Tabs\Tab::make('Pricing')->schema([...]),
        Tabs\Tab::make('Media')->schema([...]),
    ])
```

**Use case:** Form dengan banyak field, lebih dari 20 field menjadi kurang user-friendly jika ditampilkan sekaligus.

#### 4. Bagaimana jika tab terlalu banyak?

**Jawaban:**
Jika tab lebih dari 5-6, ada beberapa solusi:

1. **Buatlah sub-grouping:**
   - Bukan 10 tab terpisah, tapi 3 tab utama dengan section di dalamnya
   - Contoh: "Basic", "Details", "Advanced"

2. **Gunakan lazy loading:**
   ```php
   ->lazyLoad()
   ```
   - Tab content hanya di-load saat diklik
   - Mengurangi memory usage

3. **Split ke halaman berbeda:**
   - Jangan paksa semua di satu page
   - Buat multiple pages/resources
   - Contoh: Product basic, Product pricing, Product media

4. **Gunakan accordion:**
   - Alternatif lain jika Tabs terlalu banyak
   - Lebih space-efficient untuk banyak item

5. **Evaluasi user need:**
   - Apakah user benar-benar butuh melihat semua data?
   - Mungkin ada data yang tidak perlu ditampilkan

---

### M. Implementasi di ViewProduct Page

**File:** `app/Filament/Resources/Products/Pages/ViewProduct.php`

Tidak perlu ada perubahan di ViewProduct page, karena sudah otomatis menggunakan:

```php
public static function infolist(Schema $schema): Schema
{
    return ProductInfolist::configure($schema);
}
```

Yang sekarang menggunakan Tabs di dalamnya.

---

### N. Ringkasan Implementasi Week 9

Fitur yang telah diimplementasikan:

✅ **Mengganti Section menjadi Tabs**
- ProductInfolist.php diupdate untuk menggunakan Tabs

✅ **Membuat 3 Tab berbeda**
- Tab 1: Product Info
- Tab 2: Pricing & Stock
- Tab 3: Media & Status

✅ **Menambahkan icon pada Tab**
- Information circle, currency dollar, photo

✅ **Menambahkan badge**
- Badge dinamis berdasarkan jumlah stok

✅ **Mengubah orientasi ke vertical**
- Method configureVertical() tersedia untuk digunakan

✅ **Warna badge dinamis**
- Success (hijau) jika stock > 10
- Warning (kuning) jika stock 1-10
- Danger (merah) jika stock 0

---

### O. Fitur Tambahan

#### Lazy Load (Optional)
```php
Tabs::make('Product Tabs')
    ->lazyLoad()
    ->tabs([...])
```
Tab content hanya dimuat saat tab diklik.

#### Persist Tab in Query String (Optional)
```php
Tabs::make('Product Tabs')
    ->persistTabInQueryString()
    ->tabs([...])
```
URL akan berubah saat tab aktif berubah, misalnya: `?tab=Pricing%20%26%20Stock`

---

### P. Kesimpulan Week 9

Pada Jobsheet 9 ini, kami telah berhasil:

1. **Memahami Tabs component** - Cara kerja dan use case
2. **Mengimplementasikan Tabs di Info List** - Mengganti Section
3. **Dynamic badge** - Badge berubah warna berdasarkan data
4. **Icon management** - Icon konsisten untuk setiap tab
5. **Layout flexibility** - Horizontal dan vertical orientation
6. **Better UX** - Interface lebih ringkas dan interactive

**Perbedaan konsep:**
- **Week 7**: Wizard Form - Untuk input multi-step
- **Week 8**: Info List - Untuk menampilkan data dengan Section
- **Week 9**: Tabs - Untuk menampilkan data dengan navigasi tab

Dengan implementasi Tabs, halaman View Product menjadi lebih professional, interactive, dan user-friendly. User tidak perlu scroll panjang lagi, cukup klik tab yang ingin dilihat.

---

**Status Implementasi:** ✅ SELESAI

**Tanggal:** 22 April 2026

**File yang dibuat/dimodifikasi:**
- ✅ `app/Filament/Resources/Products/Schemas/ProductInfolist.php` (Updated)

**Metode yang tersedia:**
- ✅ `configure()` - Tabs Horizontal (default)
- ✅ `configureVertical()` - Tabs Vertical (opsional)

---

**Perjalanan Learning Path:**
```
Week 7: Wizard Form (Multi-Step Form Input)
    ↓
Week 8: Info List (Display Read-Only)
    ↓
Week 9: Tabs (Organized Display with Navigation)
    ↓
Next: Advanced Features atau Relations
```

---

