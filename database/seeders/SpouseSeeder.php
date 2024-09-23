<?php

namespace Database\Seeders;

use App\Models\Spouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Spouse::factory(10)->create();
    }
}
