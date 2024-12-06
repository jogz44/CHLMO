<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    protected static ?string $password;

    public function run(): void
    {
//        User::create([
//            'username' => 'admin_1',
//            'first_name' => 'Sheldon',
//            'middle_name' => 'Shelly',
//            'last_name' => 'Cooper',
//            'password' => Hash::make('password'),
//            'is_disabled' => false, // Explicitly set this
//            'two_factor_secret' => null,
//            'two_factor_recovery_codes' => null,
//            'profile_photo_path' => null,
//        ])->assignRole('Housing System Admin');

//        User::create([
//            'username' => 'housingAdmin_1',
//            'first_name' => 'Sabrina',
//            'middle_name' => 'Car',
//            'last_name' => 'Painter',
//            'password' => Hash::make('password'), // Make consistent with admin
//            'is_disabled' => false, // Explicitly set this
//            'two_factor_secret' => null,
//            'two_factor_recovery_codes' => null,
//            'profile_photo_path' => null,
//        ])->assignRole('Shelter System Admin');

        User::create([
            'username' => 'super_admin',
            'first_name' => 'Mark',
            'middle_name' => 'Jason',
            'last_name' => 'Suazo',
            'password' => Hash::make('password'), // Make consistent with admin
            'is_disabled' => false, // Explicitly set this
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'profile_photo_path' => null,
        ])->assignRole('Super Admin');

    }
}
