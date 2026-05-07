<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EnterpriseFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->company();

        return [
            'user_id'       => User::factory(),
            'slug'          => Str::slug($name) . '-' . Str::lower(Str::random(6)),
            'trade_name'    => $name,
            'business_name' => $name . ' S.A.',
            'tax_id'        => null,
            'address'       => null,
            'country_id'    => null,
            'state_id'      => null,
            'city_id'       => null,
            'phone'         => null,
            'email'         => null,
            'website'       => null,
        ];
    }
}
