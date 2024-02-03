<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Corporation;

use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Planet\CorporationAssignedPlanet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;

class CorporationProject extends Model
{
    protected $table = 'pi_corporation_projects';

    protected $fillable = [
        'corporation_id',
        'name',
        'description'
    ];

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(CorporationInfo::class, 'corporation_id');
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(CorporationProjectObjective::class, 'corporation_project_id', 'id');
    }

    public function assignations(): HasMany
    {
        return $this->hasMany(CorporationAssignedPlanet::class, 'corporation_project_id', 'id');
    }

    public function planets(): HasManyThrough
    {
        return $this->hasManyThrough(CharacterPlanet::class, CorporationAssignedPlanet::class, 'corporation_project_id', 'id', 'id', 'character_planet_id');
    }
}