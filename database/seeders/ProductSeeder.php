<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'sku' => 'KOFF-001',
                'name' => 'Koffiemachine Basic',
                'brand' => 'Barroc',
                'description' => 'Een betrouwbare instap koffiemachine',
                'category_id' => 1,
                'unit_price' => 799,
                'price' => 899,
                'is_visible_to_customers' => true,
                'stock' => 0
            ],
            [
                'sku' => 'KOFF-002',
                'name' => 'Koffiemachine Premium',
                'brand' => 'Barroc',
                'description' => 'Premium machine met uitgebreide functies',
                'category_id' => 1,
                'unit_price' => 1299,
                'price' => 1499,
                'is_visible_to_customers' => true,
                'stock' => 0
            ]
        ]);
    }
}
