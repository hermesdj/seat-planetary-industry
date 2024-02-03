<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Acl;

use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Account\AccountProject;
use Illuminate\Auth\Access\Response;
use Seat\Web\Models\User;

class AccountProjectPolicy
{
    public function isOwner(User $user, AccountProject $project): Response
    {
        return $project->user_id == $user->id ? Response::allow() : Response::deny(trans('seat-pi::project.permissions.deny'));
    }
}