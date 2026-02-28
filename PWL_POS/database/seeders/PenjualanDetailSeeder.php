<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($penjualan_id = 1; $penjualan_id <= 10; $penjualan_id++) { // 10 Transaksi
            for ($i = 1; $i <= 3; $i++) {                               // 3 Barang per Transaksi
                $data[] = [
                    'penjualan_id' => $penjualan_id,
                    'barang_id' => rand(1, 15), // Ambil barang acak dari ID 1-15
                    'harga' => 15000,
                    'jumlah' => rand(1, 5),
                    'created_at' => now(),
                    
                ];
            }
        }
        DB::table('t_penjualan_detail')->insert($data);
    }
}
