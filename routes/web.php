<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::guest.landing')->name('guest.landing');
Route::livewire('/features', 'pages::guest.features')->name('guest.features');
Route::livewire('/pricing', 'pages::guest.pricing')->name('guest.pricing');

Route::middleware('auth')->group(function () {
    Route::livewire('/dashboard', 'pages::app.dashboard')->name('dashboard');
    Route::livewire('/profile', 'pages::app.profile')->name('profile');
});
