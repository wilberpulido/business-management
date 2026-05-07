<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Permisos por módulo ───────────────────────────────────────────────

        $permissions = [
            // Empresa
            'enterprises.view',
            'enterprises.update',

            // Sucursales
            'branches.view',
            'branches.create',
            'branches.update',
            'branches.delete',

            // Usuarios
            'users.view',
            'users.create',
            'users.update',
            'users.delete',

            // Productos
            'products.view',
            'products.create',
            'products.update',
            'products.delete',

            // Combos
            'combos.view',
            'combos.create',
            'combos.update',
            'combos.delete',

            // Promociones
            'promotions.view',
            'promotions.create',
            'promotions.update',
            'promotions.delete',

            // Inventario
            'inventory.view',
            'inventory.in',       // registrar ingreso de mercancía
            'inventory.adjust',   // ajuste manual de stock
            'inventory.waste',    // registrar merma

            // Ventas
            'sales.view',
            'sales.create',
            'sales.void',

            // Gastos
            'expenses.view',
            'expenses.create',
            'expenses.update',
            'expenses.delete',

            // Reportes
            'reports.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ── Roles y asignación de permisos ───────────────────────────────────

        // owner: acceso total a su empresa y todas sus sucursales
        $owner = Role::firstOrCreate(['name' => 'owner']);
        $owner->syncPermissions($permissions);

        // branch_manager: gestión operativa de su sucursal asignada
        $branchManager = Role::firstOrCreate(['name' => 'branch_manager']);
        $branchManager->syncPermissions([
            'enterprises.view',
            'branches.view',
            'products.view',
            'combos.view',
            'promotions.view',
            'promotions.create',
            'promotions.update',
            'promotions.delete',
            'inventory.view',
            'inventory.in',
            'inventory.adjust',
            'inventory.waste',
            'sales.view',
            'sales.create',
            'sales.void',
            'expenses.view',
            'expenses.create',
            'expenses.update',
            'expenses.delete',
            'reports.view',
        ]);

        // cashier: operaciones de caja únicamente
        $cashier = Role::firstOrCreate(['name' => 'cashier']);
        $cashier->syncPermissions([
            'products.view',
            'combos.view',
            'promotions.view',
            'inventory.view',
            'sales.view',
            'sales.create',
        ]);
    }
}
