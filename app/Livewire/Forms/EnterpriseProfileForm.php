<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class EnterpriseProfileForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $trade_name = '';

    #[Validate('nullable|string|max:255')]
    public string $business_name = '';

    #[Validate('nullable|string|max:50')]
    public string $tax_id = '';

    #[Validate('nullable|string|max:255')]
    public string $address = '';

    #[Validate('nullable|exists:countries,id')]
    public ?int $country_id = null;

    #[Validate('nullable|exists:states,id')]
    public ?int $state_id = null;

    #[Validate('nullable|exists:cities,id')]
    public ?int $city_id = null;

    #[Validate('nullable|string|max:50')]
    public string $phone = '';

    #[Validate('nullable|email|max:255')]
    public string $email = '';

    #[Validate('nullable|url|max:255')]
    public string $website = '';
}
