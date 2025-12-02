<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        ProductCategory::insert([
            ['name' => 'Koffiemachines'],
            ['name' => 'Onderdelen'],
            ['name' => 'Accessoires'],
        ]);
    }
}
