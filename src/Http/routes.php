<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web', 'auth', 'locale'],
    'prefix' => '/pi',
    'namespace' => 'HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers'
], function () {
    Route::get('/')
        ->name('seat-pi::account-pi-home')
        ->uses('Account\AccountPlanetaryIndustryController@home');
    Route::get('/extractors')
        ->name('seat-pi::account-pi-extractors')
        ->uses('Account\AccountPlanetaryIndustryController@extractors');
    Route::get('/factories')
        ->name('seat-pi::account-pi-factories')
        ->uses('Account\AccountPlanetaryIndustryController@factories');

    // Projects
    Route::group([
        'prefix' => 'projects'
    ], function (): void {
        Route::get('/')
            ->name('seat-pi::account-pi-projects')
            ->uses('Account\AccountPiProjectController@projects');

        Route::post('/')
            ->name('seat-pi::create-account-pi-project')
            ->uses('Account\AccountPiProjectController@createProject');

        Route::get('/{id}')
            ->name('seat-pi::view-account-pi-project')
            ->uses('Account\AccountPiProjectController@viewProject')
            ->where('id', '[0-9]+');

        Route::post('/{id}')
            ->name('seat-pi::edit-account-pi-project')
            ->uses('Account\AccountPiProjectController@editProject')
            ->where('id', '[0-9]+');

        Route::delete('/{id}')
            ->name('seat-pi::delete-account-pi-project')
            ->uses('Account\AccountPiProjectController@deleteProject')
            ->where('id', '[0-9]+');

        Route::post('/{id}/objectives')
            ->name('seat-pi::add-project-objective')
            ->uses('Account\AccountPiProjectController@addObjective')
            ->where('id', '[0-9]+');

        Route::post('/{id}/objectives/{schematic_id}')
            ->name('seat-pi::edit-project-objective')
            ->uses('Account\AccountPiProjectController@editObjective')
            ->where('id', '[0-9]+')
            ->where('schematic_id', '[0-9]+');

        Route::post('/{id}/planets')
            ->name('seat-pi::assign-planet-to-project')
            ->uses('Account\AccountPiProjectController@assignPlanet')
            ->where('id', '[0-9]+');

        Route::delete('/{id}/objectives/{schematic_id}')
            ->name('seat-pi::remove-project-objective')
            ->uses('Account\AccountPiProjectController@removeObjective')
            ->where('id', '[0-9]+')
            ->where('schematic_id', '[0-9]+');

        Route::delete('/{id}/planets/{character_planet_id}')
            ->name('seat-pi::remove-assigned-planet')
            ->uses('Account\AccountPiProjectController@removeAssignedPlanet')
            ->where('id', '[0-9]+')
            ->where('character_planet_id', '[0-9]+');
    });
});