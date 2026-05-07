<?php

namespace Database\Seeders;

use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            CurrencySeeder::class,
            UnitOfMeasureSeeder::class,
            GeoSeeder::class,
        ]);

        // Usuario de desarrollo con rol owner
        $owner = User::factory()->create([
            'name'     => 'Owner',
            'username' => 'owner',
            'email'    => 'owner@example.com',
        ]);
        $owner->assignRole('owner');

        Enterprise::factory()->create([
            'user_id'       => $owner->id,
            'slug'          => 'mi-negocio',
            'trade_name'    => 'Mi Negocio',
            'business_name' => 'Mi Negocio S.A.',
        ]);

        // Usuario de desarrollo con rol branch_manager
        $manager = User::factory()->create([
            'name'     => 'Branch Manager',
            'username' => 'manager',
            'email'    => 'manager@example.com',
        ]);
        $manager->assignRole('branch_manager');

        // Usuario de desarrollo con rol cashier
        $cashier = User::factory()->create([
            'name'     => 'Cashier',
            'username' => 'cashier',
            'email'    => 'cashier@example.com',
        ]);
        $cashier->assignRole('cashier');
    }
}
