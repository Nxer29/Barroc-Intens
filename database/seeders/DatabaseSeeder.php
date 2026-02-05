<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            ProductCategorySeeder::class,
            ProductSeeder::class,
            InventorySeeder::class,
            AppointmentTypeSeeder::class,
        ]);

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'finance']);
        Role::create(['name' => 'sales']);
        Role::create(['name' => 'inkoop']);
        Role::create(['name' => 'maintenance']);


        $Admin = User::create([
            'name' => 'Admin',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
        ]);

        $finance = User::create([
            'name' => 'Finance Medewerker',
            'email' => 'finance@example.com',
            'password' => bcrypt('secret'),
        ]);

        $Sales = User::create([
            'name' => 'Sales Medewerker',
            'email' => 'sales@example.com',
            'password' => bcrypt('secret'),
        ]);

        $Inkoop = User::create([
            'name' => 'Inkoop Medewerker',
            'email' => 'inkoop@example.com',
            'password' => bcrypt('secret'),
        ]);

        $Maintenance = User::create([
            'name' => 'Maintenance Medewerker',
            'email' => 'maintenance@example.com',
            'password' => bcrypt('secret'),
        ]);

        $Admin->assignRole('Admin');
    }
}

