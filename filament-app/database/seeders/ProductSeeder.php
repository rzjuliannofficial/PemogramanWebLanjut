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
        // Seed 5 products
        Product::factory(5)->create();

        // Optionally, create some specific products with known data
        Product::create([
            'name' => 'Laptop Gaming Pro',
            'sku' => 'LAP-001',
            'description' => 'Laptop gaming dengan spesifikasi tinggi, prosesor Intel i7, RAM 16GB, SSD 512GB, GPU RTX 3060',
            'price' => 15000000,
            'stock' => 5,
            'image' => null,
            'is_active' => true,
            'is_featured' => true,
        ]);

        Product::create([
            'name' => 'Mouse Gaming RGB',
            'sku' => 'MOU-001',
            'description' => 'Mouse gaming dengan lighting RGB, DPI 12800, 8 tombol programmable',
            'price' => 350000,
            'stock' => 25,
            'image' => null,
            'is_active' => true,
            'is_featured' => false,
        ]);
    }
}
