<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $kategori_id = 1;
        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
                'kategori_id' => $kategori_id,
                'barang_kode' => 'BRG' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'barang_nama' => 'Barang Dummy ' . $i,
                'harga_beli' => rand(5000, 10000),
                'harga_jual' => rand(15000, 20000),
                'created_at' => now(),
            ];
            // Ganti kategori setiap 3 barang (agar 15 barang tersebar ke 5 kategori)
            if ($i % 3 == 0) $kategori_id++; 
        }
        DB::table('m_barang')->insert($data);
    }
}
