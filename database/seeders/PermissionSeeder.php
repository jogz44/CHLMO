<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
//        $admin = Role::create(['name' => 'admin']);
//        $editor = Role::create(['name' => 'editor']);
//        $member = Role::create(['name' => 'member']);

        // Define permissions
//        Permission::create(['name' => 'View Dashboard']);
//        Permission::create(['name' => 'Edit User Details']);
//        Permission::create(['name' => 'Edit Applicant Details']);
        Permission::create(['name' => 'manage permissions']);
        Permission::create(['name' => 'manage users']);

        // Assign permissions to roles
//        $admin->givePermissionTo([$viewDashboard, $editUsers, $editApplicantDetails]);
//        $editor->givePermissionTo($viewDashboard, $editApplicantDetails);
//        $member->givePermissionTo([$viewDashboard]);
    }
}
