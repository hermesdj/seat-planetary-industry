<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web', 'auth', 'locale'],
    'prefix' => '/planetary-industry',
    'namespace' => 'HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers'
], function () {
    Route::get('/')
        ->name('seat-pi::account-pi-home')
        ->uses('AccountPlanetaryIndustryController@home');
});