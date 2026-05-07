<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class GeoSeeder extends Seeder
{
    public function run(): void
    {
        $argentina = Country::create(['name' => 'Argentina', 'code' => 'AR']);

        $states = [
            'Buenos Aires',
            'Catamarca',
            'Chaco',
            'Chubut',
            'Ciudad Autónoma de Buenos Aires',
            'Córdoba',
            'Corrientes',
            'Entre Ríos',
            'Formosa',
            'Jujuy',
            'La Pampa',
            'La Rioja',
            'Mendoza',
            'Misiones',
            'Neuquén',
            'Río Negro',
            'Salta',
            'San Juan',
            'San Luis',
            'Santa Cruz',
            'Santa Fe',
            'Santiago del Estero',
            'Tierra del Fuego, Antártida e Islas del Atlántico Sur',
            'Tucumán',
        ];

        foreach ($states as $stateName) {
            State::create(['country_id' => $argentina->id, 'name' => $stateName]);
        }

        // Caso testigo: principales localidades de Buenos Aires
        $buenosAires = State::where('country_id', $argentina->id)
            ->where('name', 'Buenos Aires')
            ->first();

        $citiesBsAs = [
            'Almirante Brown',
            'Avellaneda',
            'Bahía Blanca',
            'Berazategui',
            'Campana',
            'Ensenada',
            'Florencio Varela',
            'General San Martín',
            'José C. Paz',
            'La Matanza',
            'La Plata',
            'Lanús',
            'Lomas de Zamora',
            'Luján',
            'Malvinas Argentinas',
            'Mar del Plata',
            'Merlo',
            'Moreno',
            'Morón',
            'Pilar',
            'Quilmes',
            'San Isidro',
            'San Miguel',
            'San Nicolás de los Arroyos',
            'Tandil',
            'Tigre',
            'Tres de Febrero',
            'Vicente López',
            'Zárate',
        ];

        foreach ($citiesBsAs as $cityName) {
            City::create(['state_id' => $buenosAires->id, 'name' => $cityName]);
        }
    }
}
