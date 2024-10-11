<?php

namespace Database\Seeders\ShelterSeeders;

use App\Models\Shelter\ShelterApplicant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShelterApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShelterApplicant::factory(10)->create();
    }
}
