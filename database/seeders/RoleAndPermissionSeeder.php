<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Roles
        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin      = Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Permissions (ejemplos base — adaptar por proyecto)
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // super-admin y admin obtienen todos los permisos
        $admin->givePermissionTo($permissions);
        // super-admin hereda todos los permisos via Gate::before en config/permission.php
    }
}
