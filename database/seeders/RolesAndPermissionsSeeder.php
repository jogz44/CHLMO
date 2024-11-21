<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Define permissions
        $permissions = [
            'manage entire system',

            'manage housing system',
            'housing system user',
            'tag housing applicants',

            'manage shelter system',
            'shelter system user',
            'tag shelter applicants',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles and assign permissions
        $roles = [
            'Super Admin' => ['manage entire system'],

            'Housing System Admin' => ['manage housing system', 'housing system user'],
            'Housing System Staff' => ['housing system user'],
            'Housing System Tagger' => ['tag housing applicants'],

            'Shelter System Admin' => ['manage shelter system', 'shelter system user'],
            'Shelter System Staff' => ['shelter system user'],
            'Shelter System Tagger' => ['tag shelter applicants'],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
