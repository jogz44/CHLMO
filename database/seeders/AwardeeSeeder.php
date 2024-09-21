<?php

namespace Database\Seeders;

use App\Models\Awardee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AwardeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Awardee::factory(10)->create();
    }
}
