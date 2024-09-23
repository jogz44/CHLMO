<?php

namespace Database\Seeders;

use App\Models\ShelterMaterial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShelterMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShelterMaterial::factory(10)->create();
    }
}
