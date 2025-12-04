<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppointmentType;

class AppointmentTypeSeeder extends Seeder
{
    public function run(): void
    {
        AppointmentType::insert([
            ['name' => 'routine'],
            ['name' => 'storing'],
        ]);
    }
}
