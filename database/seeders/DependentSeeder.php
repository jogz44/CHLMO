<?php

namespace Database\Seeders;

use App\Models\Dependent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DependentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dependent::factory(10)->create();
    }
}
