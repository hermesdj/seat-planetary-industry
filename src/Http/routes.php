<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web', 'auth', 'locale'],
    'prefix' => '/pi',
    'namespace' => 'HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers\Account'
], function () {
    Route::get('/')
        ->name('seat-pi::account-pi-home')
        ->uses('AccountPlanetaryIndustryController@home');
    Route::get('/extractors')
        ->name('seat-pi::account-pi-extractors')
        ->uses('AccountPlanetaryIndustryController@extractors');
    Route::get('/factories')
        ->name('seat-pi::account-pi-factories')
        ->uses('AccountPlanetaryIndustryController@factories');
    Route::get('/planets')
        ->name('seat-pi::account-pi-planets')
        ->uses('AccountPlanetaryIndustryController@planets');
    Route::get('/storage')
        ->name('seat-pi::account-pi-storage')
        ->uses('AccountPlanetaryIndustryController@storage');

    // Projects
    Route::group([
        'prefix' => 'projects'
    ], function (): void {
        Route::get('/')
            ->name('seat-pi::account-pi-projects')
            ->uses('AccountPiProjectController@projects');

        Route::post('/')
            ->name('seat-pi::create-account-pi-project')
            ->uses('AccountPiProjectController@createProject');

        Route::get('/{project}')
            ->name('seat-pi::view-account-pi-project')
            ->uses('AccountPiProjectController@viewProject')
            ->can('pi.project.owner', 'project');

        Route::post('/{project}')
            ->name('seat-pi::edit-account-pi-project')
            ->uses('AccountPiProjectController@editProject')
            ->can('pi.project.owner', 'project');

        Route::delete('/{project}')
            ->name('seat-pi::delete-account-pi-project')
            ->uses('AccountPiProjectController@deleteProject')
            ->can('pi.project.owner', 'project');

        Route::post('/{project}/objectives')
            ->name('seat-pi::add-project-objective')
            ->uses('AccountPiProjectController@addObjective')
            ->can('pi.project.owner', 'project');

        Route::post('/{project}/objectives/{schematic_id}')
            ->name('seat-pi::edit-project-objective')
            ->uses('AccountPiProjectController@editObjective')
            ->where('schematic_id', '[0-9]+')
            ->can('pi.project.owner', 'project');

        Route::delete('/{project}/objectives/{schematic_id}')
            ->name('seat-pi::remove-project-objective')
            ->uses('AccountPiProjectController@removeObjective')
            ->where('schematic_id', '[0-9]+')
            ->can('pi.project.owner', 'project');

        Route::post('/{project}/planets')
            ->name('seat-pi::assign-planet-to-project')
            ->uses('AccountPiProjectController@assignPlanet')
            ->can('pi.project.owner', 'project');

        Route::delete('/{project}/planets/{planet}')
            ->name('seat-pi::remove-assigned-planet')
            ->uses('AccountPiProjectController@removeAssignedPlanet')
            ->where('character_planet_id', '[0-9]+')
            ->can('pi.project.owner', 'project');
    });
});

Route::group([
    'middleware' => ['web', 'auth', 'locale'],
    'prefix' => '/corp-pi',
    'namespace' => 'HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers\Corporation'
], function () {
    Route::get('/')
        ->name('seat-pi::corporation-pi-home')
        ->uses('CorpPlanetaryIndustryController@home');

    Route::get('/{corporation}')
        ->name('seat-pi::corporation-pi')
        ->uses('CorpPlanetaryIndustryController@corporationPiHome')
        ->can('corporation.view_pi_projects', 'corporation');

    // Project routes

    Route::get('/{corporation}/projects/{project}')
        ->name('seat-pi::corporation-pi-project')
        ->uses('CorpPlanetaryIndustryController@viewProject')
        ->can('corporation.view_pi_projects', 'corporation');

    Route::post('/{corporation}/projects')
        ->name('seat-pi::create-corporation-pi-project')
        ->uses('CorpPlanetaryIndustryController@createProject')
        ->can('corporation.manage_pi_projects', 'corporation');

    Route::post('/{corporation}/projects/{project}')
        ->name('seat-pi::edit-corporation-pi-project')
        ->uses('CorpPlanetaryIndustryController@editProject')
        ->can('corporation.manage_pi_projects', 'corporation');

    Route::delete('/{corporation}/projects/{project}')
        ->name('seat-pi::delete-corporation-pi-project')
        ->uses('CorpPlanetaryIndustryController@deleteProject')
        ->can('corporation.manage_pi_projects', 'corporation');

    // Objectives routes

    Route::post('/{corporation}/projects/{project}/objectives')
        ->name('seat-pi::add-corp-pi-project-objective')
        ->uses('CorpPiProjectController@addObjective')
        ->can('corporation.manage_pi_objectives', 'corporation');

    Route::post('/{corporation}/projects/{project}/objectives/{schematic_id}')
        ->name('seat-pi::edit-corp-pi-project-objective')
        ->uses('CorpPiProjectController@editObjective')
        ->can('corporation.manage_pi_objectives', 'corporation')
        ->where('schematic_id', '[0-9]+');

    Route::delete('/{corporation}/projects/{project}/objectives/{schematic_id}')
        ->name('seat-pi::remove-corp-pi-project-objective')
        ->uses('CorpPiProjectController@deleteObjective')
        ->can('corporation.manage_pi_objectives', 'corporation')
        ->where('corporation_id', '[0-9]+');

    // Planets routes

    Route::post('/{corporation}/projects/{project}/planets')
        ->name('seat-pi::assign-corp-pi-project-planet')
        ->uses('CorpPiProjectController@assignPlanet');

    Route::delete('/{corporation}/projects/{project}/planets/{planet}')
        ->name('seat-pi::unassign-corp-pi-project-planet')
        ->uses('CorpPiProjectController@unassignPlanet')
        ->can('corporation.assign_pi_planet', 'planet')
        ->where('character_planet_id', '[0-9]+');
});

Route::group([
    'middleware' => ['web', 'auth', 'locale'],
    'prefix' => '/tools/planetary-survey',
    'namespace' => 'HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers\Tools'
], function () {
    Route::get('/')
        ->name('seat-pi::survey')
        ->uses('PlanetarySurveyController@home')
        ->can('planetary.survey_read');
    Route::post('/')
        ->name('seat-pi::store-survey')
        ->uses('PlanetarySurveyController@storeSurvey')
        ->can('planetary.survey_manage');

    // JSON
    Route::get('/lookup/systems')
        ->name('seat-pi::survey-systems-lookup')
        ->uses('PlanetarySurveyController@lookupSystems')
        ->can('planetary.survey_manage');
});