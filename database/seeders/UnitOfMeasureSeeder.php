<?php

namespace Database\Seeders;

use App\Models\UnitConversion;
use App\Models\UnitOfMeasure;
use Illuminate\Database\Seeder;

class UnitOfMeasureSeeder extends Seeder
{
    public function run(): void
    {
        // ── Unidades ─────────────────────────────────────────────────────────

        $units = [
            // Masa
            ['name' => 'Kilogramo',    'abbreviation' => 'kg',  'type' => 'mass'],
            ['name' => 'Gramo',        'abbreviation' => 'g',   'type' => 'mass'],
            ['name' => 'Miligramo',    'abbreviation' => 'mg',  'type' => 'mass'],
            ['name' => 'Libra',        'abbreviation' => 'lb',  'type' => 'mass'],
            ['name' => 'Onza',         'abbreviation' => 'oz',  'type' => 'mass'],

            // Volumen
            ['name' => 'Litro',        'abbreviation' => 'l',   'type' => 'volume'],
            ['name' => 'Mililitro',    'abbreviation' => 'ml',  'type' => 'volume'],

            // Unidad
            ['name' => 'Pieza',        'abbreviation' => 'pza', 'type' => 'unit'],
            ['name' => 'Docena',       'abbreviation' => 'doc', 'type' => 'unit'],
            ['name' => 'Caja',         'abbreviation' => 'cja', 'type' => 'unit'],
            ['name' => 'Paquete',      'abbreviation' => 'paq', 'type' => 'unit'],
            ['name' => 'Bolsa',        'abbreviation' => 'bol', 'type' => 'unit'],
            ['name' => 'Botella',      'abbreviation' => 'bot', 'type' => 'unit'],
            ['name' => 'Lata',         'abbreviation' => 'lat', 'type' => 'unit'],
        ];

        foreach ($units as $unit) {
            UnitOfMeasure::firstOrCreate(['abbreviation' => $unit['abbreviation']], $unit);
        }

        // ── Conversiones globales estándar ────────────────────────────────────
        // Las conversiones específicas por producto se crean desde la app.

        $get = fn (string $abbr) => UnitOfMeasure::where('abbreviation', $abbr)->value('id');

        $conversions = [
            // Masa: kg ↔ g
            ['from' => 'kg', 'to' => 'g',  'factor' => 1000],
            ['from' => 'g',  'to' => 'kg', 'factor' => 0.001],

            // Masa: g ↔ mg
            ['from' => 'g',  'to' => 'mg', 'factor' => 1000],
            ['from' => 'mg', 'to' => 'g',  'factor' => 0.001],

            // Masa: kg ↔ lb
            ['from' => 'kg', 'to' => 'lb', 'factor' => 2.204623],
            ['from' => 'lb', 'to' => 'kg', 'factor' => 0.453592],

            // Masa: g ↔ oz
            ['from' => 'g',  'to' => 'oz', 'factor' => 0.035274],
            ['from' => 'oz', 'to' => 'g',  'factor' => 28.349523],

            // Volumen: l ↔ ml
            ['from' => 'l',  'to' => 'ml', 'factor' => 1000],
            ['from' => 'ml', 'to' => 'l',  'factor' => 0.001],

            // Unidad: docena ↔ pieza
            ['from' => 'doc', 'to' => 'pza', 'factor' => 12],
            ['from' => 'pza', 'to' => 'doc', 'factor' => 0.083333],
        ];

        foreach ($conversions as $c) {
            UnitConversion::firstOrCreate(
                [
                    'from_unit_id' => $get($c['from']),
                    'to_unit_id'   => $get($c['to']),
                    'product_id'   => null,
                ],
                ['factor' => $c['factor']]
            );
        }
    }
}
