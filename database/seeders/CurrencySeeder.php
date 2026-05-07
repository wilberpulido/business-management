<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            ['name' => 'US Dollar',          'slug' => 'us-dollar',          'code' => 'USD', 'symbol' => '$'],
            ['name' => 'Euro',               'slug' => 'euro',               'code' => 'EUR', 'symbol' => '€'],
            ['name' => 'Real Brasileño',     'slug' => 'real-brasileno',     'code' => 'BRL', 'symbol' => 'R$'],
            ['name' => 'Peso Argentino',     'slug' => 'peso-argentino',     'code' => 'ARS', 'symbol' => '$'],
        ];

        foreach ($currencies as $currency) {
            Currency::firstOrCreate(['code' => $currency['code']], $currency);
        }
    }
}
