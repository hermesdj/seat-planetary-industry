<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models;

use Seat\Eveapi\Models\Character\CharacterInfo;

class PICharacterInfo extends CharacterInfo
{
    protected $table = 'character_infos';

    public function piColonies()
    {
        return $this->hasMany(PICharacterPlanet::class, 'character_id', 'character_id');
    }
}