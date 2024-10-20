<?php

namespace Database\Seeders;

use App\Models\LotList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LotList::factory(10)->create();
    }
}
