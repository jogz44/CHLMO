<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Address;
use App\Models\Applicant;
use App\Models\Awardee;
use App\Models\Blacklist;
use App\Models\Dependent;
use App\Models\LotList;
use App\Models\Occupation;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\Material;
use App\Models\Shelter\OriginOfRequest;
use App\Models\Shelter\ProfiledTaggedApplicant;
use App\Models\Shelter\PurchaseOrder;
use App\Models\Shelter\PurchaseRequisition;
use App\Models\Shelter\ShelterApplicant;
use App\Models\ShelterMaterial;
use App\Models\Spouse;
use App\Models\Transaction;
use App\Models\TransferredAwardee;
use Database\Factories\DependentFactory;
use Database\Seeders\ShelterSeeders\GranteeSeeder;
use Database\Seeders\ShelterSeeders\MaterialSeeder;
use Database\Seeders\ShelterSeeders\OriginOfRequestSeeder;
use Database\Seeders\ShelterSeeders\ProfiledTaggedApplicantSeeder;
use Database\Seeders\ShelterSeeders\PurchaseOrderSeeder;
use Database\Seeders\ShelterSeeders\PurchaseRequisitionSeeder;
use Database\Seeders\ShelterSeeders\ShelterApplicantSeeder;
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
//            AddressSeeder::class,
//            ApplicantSeeder::class,
//            ShelterApplicantSeeder::class,
//            PeopleSeeder::class,
        ]);

        // if (OriginOfRequest::count() == 0){
        //     $this->call(ShelterSeeders\OriginOfRequestSeeder::class);
        // }

        // if (ShelterApplicant::count() == 0){
        //     $this->call(ShelterSeeders\ShelterApplicantSeeder::class);
        // }

        if (PurchaseRequisition::count() == 0){
            $this->call(ShelterSeeders\PurchaseRequisitionSeeder::class);
        }

        if (PurchaseOrder::count() == 0){
            $this->call(ShelterSeeders\PurchaseOrderSeeder::class);
        }

        if (Material::count() == 0){
            $this->call(ShelterSeeders\MaterialSeeder::class);
        }

        if (Address::count() == 0){
            $this->call(AddressSeeder::class);
        }

        // if (ProfiledTaggedApplicant::count() == 0){
        //     $this->call(ShelterSeeders\ProfiledTaggedApplicantSeeder::class);
        // }

        // if (Grantee::count() == 0){
        //     $this->call(ShelterSeeders\GranteeSeeder::class);
        // }

//        if (LotList::count() == 0){
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
