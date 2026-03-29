<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navigation extends Component
{
    public array $menu = [];

    public function __construct()
    {
        $this->menu = [
            ['label' => __('ui.navigation.home'), 'route' => 'home', 'url' => route('guest.landing'), 'active' => request()->routeIs('guest.landing*')],
            ['label' => __('ui.navigation.features'), 'route' => 'features', 'url' => route('guest.features'), 'active' => request()->routeIs('features')],
            ['label' => __('ui.navigation.pricing'), 'route' => 'pricing', 'url' => route('guest.pricing'), 'active' => request()->routeIs('guest.pricing*')],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.navigation');
    }
}
