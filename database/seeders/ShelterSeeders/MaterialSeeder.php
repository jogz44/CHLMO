<?php

namespace Database\Seeders\ShelterSeeders;

use App\Models\Shelter\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::factory(10)->create();
    }
}
