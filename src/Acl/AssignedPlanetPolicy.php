<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Acl;

use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;
use Seat\Web\Acl\Policies\AbstractEntityPolicy;
use Seat\Web\Acl\Response;
use Seat\Web\Models\User;

class AssignedPlanetPolicy extends AbstractEntityPolicy
{
    public function __call($method, $args)
    {
        if (count($args) < 2) {
            return false;
        }

        $user = $args[0];
        $colony = $args[1];

        if (is_numeric($colony)) {
            $colony = CharacterPlanet::find($colony);
        }

        $message = trans('seat-pi::corporation.permissions.assign_planet.deny');

        return $this->userHasPermission($user, $this->ability, function () use ($user, $colony) {
            if ($this->isOwner($user, $colony))
                return true;

            $acl = $this->permissionsFrom($user);

            $permissions = $acl->filter(function ($permission) use ($colony) {
                logger()->debug($permission->title);
                if ($permission->title != $this->ability)
                    return false;

                if (!$permission->hasFilters())
                    return true;

                return false;
            });

            return $permissions->isNotEmpty();
        }, $colony->id) ? Response::allow() : Response::deny($message);
    }

    public function isOwner(User $user, CharacterPlanet $colony): bool
    {
        return collect($user->associatedCharacterIds())->contains($colony->character_id);
    }
}