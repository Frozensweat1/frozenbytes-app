<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage pages',
            'manage services',
            'manage projects',
            'manage blog',
            'manage reviews',
            'manage contacts',
            'manage settings',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions($permissions);

        $editorRole = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $editorRole->syncPermissions([
            'manage pages',
            'manage services',
            'manage blog',
            'manage users',
        ]);

        $admin = User::where('email', 'test@example.com')->first();
        if ($admin) {
            $admin->assignRole('admin');
        }
    }
}
