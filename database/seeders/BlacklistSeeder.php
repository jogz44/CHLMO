<?php

namespace Database\Seeders;

use App\Models\Blacklist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlacklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blacklist::factory(10)->create();
    }
}
