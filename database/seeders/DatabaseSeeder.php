<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Address;
use App\Models\Applicant;
use App\Models\Awardee;
use App\Models\Blacklist;
use App\Models\Dependent;
use App\Models\Lot;
use App\Models\Occupation;
use App\Models\ShelterMaterial;
use App\Models\Spouse;
use App\Models\Transaction;
use App\Models\TransferredAwardee;
use Database\Factories\DependentFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
        ]);

//        if (Lot::count() == 0){
//            $this->call(LotSeeder::class);
//        }
//
//        if (Address::count() == 0){
//            $this->call(AddressSeeder::class);
//        }
//
//        if (Applicant::count() == 0){
//            $this->call(ApplicantSeeder::class);
//        }
//
//        if (Dependent::count() == 0){
//            $this->call(DependentSeeder::class);
//        }
//
//        if (Awardee::count() == 0){
//            $this->call(AwardeeSeeder::class);
//        }
//
//        if (TransferredAwardee::count() == 0){
//            $this->call(TransferredAwardeeSeeder::class);
//        }
//
//        if (Transaction::count() == 0){
//            $this->call(TransactionSeeder::class);
//        }
//
//        if (Blacklist::count() == 0){
//            $this->call(BlacklistSeeder::class);
//        }
//
//        if (Spouse::count() == 0){
//            $this->call(SpouseSeeder::class);
//        }
//
//        // Shelter seeder
//        if (ShelterMaterial::count() == 0){
//            $this->call(ShelterMaterialSeeder::class);
//        }
    }
}
