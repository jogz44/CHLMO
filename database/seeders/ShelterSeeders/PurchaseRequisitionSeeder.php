<?php

namespace Database\Seeders\ShelterSeeders;

use App\Models\Shelter\PurchaseRequisition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseRequisitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PurchaseRequisition::factory(10)->create();
    }
}
