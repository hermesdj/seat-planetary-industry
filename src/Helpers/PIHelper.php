<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Helpers;

use HermesDj\Seat\SeatPlanetaryIndustry\Helpers\classes\ProjectOverview;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Account\AccountProject;

class PIHelper
{
    public static function computeProjectFabricationAndExtraction(AccountProject $project): ProjectOverview
    {
        return ProjectOverview::fromAccountProject($project);
    }
}