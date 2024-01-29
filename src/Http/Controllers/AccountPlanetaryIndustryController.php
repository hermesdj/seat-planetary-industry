<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers;

use HermesDj\Seat\SeatPlanetaryIndustry\Helpers\PIHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Seat\Web\Http\Controllers\Controller;

class AccountPlanetaryIndustryController extends Controller
{
    public function home(): View|Factory|Application
    {
        return view('seat-pi::home', [
            'characters' => PIHelper::getPiUser()->piCharacters
        ]);
    }
}