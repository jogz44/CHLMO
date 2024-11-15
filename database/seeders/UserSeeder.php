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
        User::create([
            'username' => 'admin_1',
            'first_name' => 'Sheldon',
            'middle_name' => 'Shelly',
            'last_name' => 'Cooper',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role_id' => 1,
            'is_disabled' => false, // Explicitly set this
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'profile_photo_path' => null,
        ])->assignRole('Admin');
//
        User::create([
            'username' => 'editor_1',
            'first_name' => 'Missy',
            'middle_name' => 'Sissy',
            'last_name' => 'Cooper',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Make consistent with admin
            'role_id' => 2,
            'is_disabled' => false, // Explicitly set this
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'profile_photo_path' => null,
        ])->assignRole('Editor');
//
        User::create([
            'username' => 'shelterAdmin_1',
            'first_name' => 'Sheila',
            'middle_name' => 'Allea',
            'last_name' => 'Cooper',
            'email' => 'shelter@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Make consistent with admin
            'role_id' => 3,
            'is_disabled' => false, // Explicitly set this
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'profile_photo_path' => null,
        ])->assignRole('ShelterAdmin');
    }
}
