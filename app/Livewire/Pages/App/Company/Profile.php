<?php

namespace App\Livewire\Pages\App\Company;

use Livewire\Component;

class Profile extends Component
{
    public function mount(): void
    {
        $this->authorize('enterprises.update');

        if (! auth()->user()->enterprise) {
            $this->redirect(route('dashboard'));
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('pages.app.company.profile');
    }
}
