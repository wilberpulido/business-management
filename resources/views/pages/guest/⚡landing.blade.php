<?php

use Livewire\Component;

new class extends Component
{
    public function mount()
    {
        if (auth()->check()) {
            return $this->redirect(route('dashboard'), navigate: true);
        }
    }
};
?>

<x-layouts.guest>
    {{-- Hero --}}
    <x-marketing.hero />
    {{-- Features --}}
    {{-- <x-marketing.features /> --}}
    {{-- Pricing --}}
    {{-- <x-marketing.pricing /> --}}
</x-layouts.guest>
