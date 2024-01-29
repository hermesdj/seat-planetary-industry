<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Helpers;

use HermesDj\Seat\SeatPlanetaryIndustry\Models\PIUser;
use Illuminate\Support\Facades\Auth;

class PIHelper
{
    public static function getPiUser()
    {
        return PIUser::find(Auth::user()->id);
    }
}