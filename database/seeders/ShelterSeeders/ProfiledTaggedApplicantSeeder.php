<?php

namespace Database\Seeders\ShelterSeeders;

use App\Models\Shelter\ProfiledTaggedApplicant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfiledTaggedApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfiledTaggedApplicant::factory(10)->create();
    }
}
