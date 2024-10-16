<?php

namespace Database\Seeders\ShelterSeeders;

use App\Models\Shelter\OriginOfRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OriginOfRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OriginOfRequest::factory(10)->create();
    }
}
