<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $barang_id = 1;
        for ($supp = 1; $supp <= 3; $supp++) {     // 3 Supplier
            for ($i = 1; $i <= 5; $i++) {          // 5 Barang per Supplier
                $data[] = [
                    'supplier_id' => $supp,
                    'barang_id' => $barang_id,
                    'user_id' => 1, // Admin yang input stok
                    'stok_tanggal' => now(),
                    'stok_jumlah' => 50,
                    'created_at' => now(),
                ];
                $barang_id++;
            }
        }
        DB::table('t_stok')->insert($data);
    }
}
