# Laporan Tugas Jobsheet 04 - Eloquent ORM

## Praktikum 1 - $fillable

### Langkah-Langkah

**1. Menambahkan atribut $fillable pada UserModel**

Mendaftarkan kolom yang diizinkan untuk diisi melalui mass assignment.

```php
class UserModel extends Model
{
    use HasFactory;
    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    
    protected $fillable = ['level_id', 'username', 'nama', 'password'];
}
```

**2. Insert Data di UserController**

Menambahkan data baru menggunakan method create().

```php
public function index()
{
    $data = [
        'level_id' => 2,
        'username' => 'manager_dua',
        'nama' => 'Manager 2',
        'password' => Hash::make('12345')
    ];
    UserModel::create($data);

    $user = UserModel::all();
    return view('user', ['data' => $user]);
}
```

![Insert dengan $fillable](img/addFillable1.png)

**3. Modifikasi atribut $fillable**

Menghapus 'password' dari $fillable dan mengubah $data untuk melihat efek pembatasan Eloquent.

```php
protected $fillable = ['level_id', 'username', 'nama'];
```
![Modifikasi  $fillable](img/addFillableError.png)

**Hasil & Pengamatan:**
✅ Atribut $fillable bertindak sebagai pengaman (whitelist). Kolom yang tidak terdaftar di dalamnya akan otomatis diabaikan oleh Eloquent saat operasi insert/update massal dilakukan.

---

## Praktikum 2.1 - Retrieving Single Models

### Langkah-Langkah

**1. Menggunakan find()**

Mengambil data berdasarkan Primary Key.

```php
$user = UserModel::find(1);
```

![Find by ID](img/find_method.png)

**2. Menggunakan where()->first()**

Mengambil data pertama yang cocok dengan kondisi.

```php
$user = UserModel::where('level_id', 1)->first();
```

![Where First](img/where_first.png)

**3. Menggunakan firstWhere()**

Penulisan lebih singkat untuk where()->first().

```php
$user = UserModel::firstWhere('level_id', 1);
```
![Where First](img/firstWhere.png)

**4. Menggunakan findOr()**

Mengambil data tunggal atau menjalankan callback fungsi (misal: abort(404)) jika data tidak ditemukan.

```php
$user = UserModel::findOr(20, ['username', 'nama'], function () {
    abort(404);
});
```

![FindOr Result](img/findor_method.png)

**Hasil & Pengamatan:**
✅ Method find() cocok untuk pencarian berdasarkan primary key
✅ where()->first() dan firstWhere() memberikan fleksibilitas pencarian dengan kondisi custom
✅ findOr() memungkinkan error handling tanpa exception otomatis

---

## Praktikum 2.2 - Not Found Exceptions

### Langkah-Langkah

**1. Menggunakan findOrFail()**

```php
$user = UserModel::findOrFail(1);
```

![FindOrFail Success](img/findorfail_success.png)

**2. Menggunakan firstOrFail()**

```php
$user = UserModel::where('username', 'manager9')->firstOrFail();
```

![FirstOrFail Exception](img/firstorfail_exception.png)

**Hasil & Pengamatan:**
✅ Jika rekaman data tidak ditemukan, method ini otomatis melemparkan ModelNotFoundException
✅ Exception otomatis merender halaman error 404 tanpa perlu callback manual
✅ Berguna untuk early validation pada operasi update dan delete

---

## Praktikum 2.3 - Retrieving Aggregates

### Langkah-Langkah

**1. Menghitung jumlah data dengan count()**

```php
$user = UserModel::where('level_id', 2)->count();
dd($user);
```

![Count Result](img/count_aggregate.png)

**2. Menampilkan agregat di View**

```blade
<table border="1" cellpadding="2" cellspacing="0">
    <tr>
        <th>Jumlah Pengguna</th>
    </tr>
    <tr>
        <td>{{ $data }}</td>
    </tr>
</table>
```

![View Agregat](img/view_aggregate.png)

**Hasil & Pengamatan:**
✅ Fungsi agregat (count, max, sum) mengembalikan nilai skalar berupa angka secara langsung
✅ Tidak mengembalikan instance model Eloquent
✅ Efisien untuk operasi statistik dan reporting

---

## Praktikum 2.4 - Retrieving or Creating Models

### Langkah-Langkah

**1. Menggunakan firstOrCreate()**

Mengambil data yang cocok. Jika tidak ada, langsung dibuat dan disimpan ke database.

```php
$user = UserModel::firstOrCreate(
    ['username' => 'manager22'],
    ['nama' => 'Manager Dua Dua', 'password' => Hash::make('12345'), 'level_id' => 2]
);
```

![FirstOrCreate Result](img/firstorcreate.png)

**2. Menggunakan firstOrNew()**

Membuat instance model baru di memori jika tidak ditemukan, namun belum tersimpan ke database. Membutuhkan pemanggilan save().

```php
$user = UserModel::firstOrNew(
    'username' => 'manager33',
    'nama' => 'Manager Tiga Tiga', 
    'password' => Hash::make('12345'), 
    'level_id' => 2
);
$user->save();
```

![FirstOrNew Result](img/firstornew.png)

**Hasil & Pengamatan:**
✅ firstOrCreate() langsung menyimpan ke database jika data tidak ditemukan
✅ firstOrNew() memberikan kontrol lebih dengan membuat instance terlebih dahulu sebelum save()
✅ Keduanya berguna untuk menghindari duplikasi data

---