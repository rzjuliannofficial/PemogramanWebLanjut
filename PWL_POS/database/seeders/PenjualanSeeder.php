<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'user_id' => 1, // Anggap semua transaksi dilakukan oleh Admin (User ID 1)
                'pembeli' => 'Pelanggan ' . $i,
                'penjualan_kode' => 'PJ' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
            ];
        }
        DB::table('t_penjualan')->insert($data);
    }
}
