<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models;

use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanetContent;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanetPin;
use Seat\Eveapi\Models\Sde\InvType;

class PICharacterPlanetContent extends CharacterPlanetContent
{
    protected $table = 'character_planet_contents';

    public function pin()
    {
        return $this->belongsTo(CharacterPlanetPin::class, 'pin_id', 'pin_id');
    }

    public function product()
    {
        return $this->hasOne(InvType::class, 'typeID', 'type_id')
            ->withDefault();
    }
}