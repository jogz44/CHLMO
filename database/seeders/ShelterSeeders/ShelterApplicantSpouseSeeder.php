<?php

namespace Database\Seeders\ShelterSeeders;

use App\Models\Shelter\ShelterApplicantSpouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShelterApplicantSpouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShelterApplicantSpouse::factory(10)->create();
    }
}
