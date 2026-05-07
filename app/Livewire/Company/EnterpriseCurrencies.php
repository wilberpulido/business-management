<?php

namespace App\Livewire\Company;

use App\Models\Currency;
use App\Models\Enterprise;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EnterpriseCurrencies extends Component
{
    public ?Enterprise $enterprise = null;

    public ?string $error = null;

    public function mount(): void
    {
        $this->enterprise = auth()->user()->enterprise;
    }

    #[Computed]
    public function currencyList(): Collection
    {
        $active = $this->enterprise->currencies()->withPivot('is_default')->get()->keyBy('id');

        return Currency::all()->map(function (Currency $currency) use ($active) {
            $currency->is_active = $active->has($currency->id);
            $currency->is_default_for_enterprise = $active->get($currency->id)?->pivot->is_default ?? false;

            return $currency;
        });
    }

    public function attach(int $currencyId): void
    {
        $this->authorize('enterprises.update');

        $this->error = null;

        $isFirst = $this->enterprise->currencies()->count() === 0;

        $this->enterprise->currencies()->attach($currencyId, ['is_default' => $isFirst]);

        unset($this->currencyList);
    }

    public function detach(int $currencyId): void
    {
        $this->authorize('enterprises.update');

        $this->error = null;

        $currency = $this->enterprise->currencies()
            ->wherePivot('currency_id', $currencyId)
            ->first();

        if ($currency?->pivot->is_default) {
            $this->error = __('company.currencies.error_remove_default');

            return;
        }

        $this->enterprise->currencies()->detach($currencyId);

        unset($this->currencyList);
    }

    public function setDefault(int $currencyId): void
    {
        $this->authorize('enterprises.update');

        $this->error = null;

        DB::transaction(function () use ($currencyId) {
            DB::table('currency_enterprise')
                ->where('enterprise_id', $this->enterprise->id)
                ->update(['is_default' => false]);

            $this->enterprise->currencies()->updateExistingPivot($currencyId, ['is_default' => true]);
        });

        unset($this->currencyList);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.company.enterprise-currencies');
    }
}
