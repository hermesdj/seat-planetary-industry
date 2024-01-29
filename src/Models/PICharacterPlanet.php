<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;

class PICharacterPlanet extends CharacterPlanet
{
    protected $table = 'character_planets';

    public function contents(): HasMany
    {
        return $this->hasMany(PICharacterPlanetContent::class, 'planet_id', 'planet_id')
            ->where('character_id', $this->character_id);
    }

    public function groupedContents(): Collection
    {
        return $this->contents()
            ->select('type_id')
            ->groupBy('type_id')
            ->selectRaw('sum(amount) as amount')->get();
    }
}