<?php

namespace App\Livewire\Company;

use App\Livewire\Forms\EnterpriseProfileForm;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Livewire\Component;

class EnterpriseProfile extends Component
{
    public EnterpriseProfileForm $form;

    public function mount(): void
    {
        $enterprise = auth()->user()->enterprise;

        $this->form->fill([
            'trade_name'    => $enterprise->trade_name,
            'business_name' => $enterprise->business_name ?? '',
            'tax_id'        => $enterprise->tax_id ?? '',
            'address'       => $enterprise->address ?? '',
            'country_id'    => $enterprise->country_id ?? Country::where('code', 'AR')->value('id'),
            'state_id'      => $enterprise->state_id,
            'city_id'       => $enterprise->city_id,
            'phone'         => $enterprise->phone ?? '',
            'email'         => $enterprise->email ?? '',
            'website'       => $enterprise->website ?? '',
        ]);
    }

    public function updatedFormStateId(): void
    {
        $this->form->city_id = null;
    }

    public function save(): void
    {
        $this->authorize('enterprises.update');

        $enterprise = auth()->user()->enterprise;

        abort_unless($enterprise, 403);

        $validated = $this->form->validate();

        $nullables = ['business_name', 'tax_id', 'address', 'country_id', 'state_id', 'city_id', 'phone', 'email', 'website'];
        foreach ($nullables as $field) {
            $validated[$field] = $validated[$field] ?: null;
        }

        $enterprise->update($validated);

        session()->flash('success', __('company.profile.saved'));
        $this->redirect(route('company.profile'));
    }

    public function render(): \Illuminate\View\View
    {
        $states = State::where('country_id', $this->form->country_id)
            ->orderBy('name')
            ->pluck('name', 'id');

        $cities = $this->form->state_id
            ? City::where('state_id', $this->form->state_id)->orderBy('name')->pluck('name', 'id')
            : collect();

        return view('livewire.company.enterprise-profile', compact('states', 'cities'));
    }
}
