<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Planet;

use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Corporation\CorporationProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;

class CorporationAssignedPlanet extends Model
{
    public $table = 'pi_corporation_assigned_planets';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = ['character_planet_id', 'corporation_project_id'];

    protected $primaryKey = ['character_planet_id', 'corporation_project_id'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(CorporationProject::class, 'corporation_project_id', 'id');
    }

    public function planet(): BelongsTo
    {
        return $this->belongsTo(CharacterPlanet::class, 'character_planet_id', 'id');
    }
}