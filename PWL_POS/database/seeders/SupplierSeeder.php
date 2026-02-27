<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['supplier_kode' => 'SUP01', 'supplier_nama' => 'PT Jaya Abadi', 'supplier_alamat' => 'Jakarta', 'created_at' => now()],
            ['supplier_kode' => 'SUP02', 'supplier_nama' => 'CV Makmur', 'supplier_alamat' => 'Surabaya', 'created_at' => now()],
            ['supplier_kode' => 'SUP03', 'supplier_nama' => 'UD Sejahtera', 'supplier_alamat' => 'Malang', 'created_at' => now()],
        ];
        DB::table('m_supplier')->insert($data);
    }
}
