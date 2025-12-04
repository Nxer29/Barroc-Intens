<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\Product;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (Product::all() as $product) {
            Inventory::create([
                'product_id' => $product->id,
                'quantity' => rand(10, 50),
                'min_threshold' => rand(5, 10),
                'location' => 'Magazijn A',
                'updated_at' => now(),
            ]);
        }
    }
}
