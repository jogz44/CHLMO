<?php

namespace Database\Seeders;

use App\Models\TransferredAwardee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransferredAwardeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransferredAwardee::factory(10)->create();
    }
}
