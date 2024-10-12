<?php

namespace Database\Seeders\ShelterSeeders;

use App\Models\Shelter\Grantee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GranteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grantee::factory(10)->create();
    }
}
