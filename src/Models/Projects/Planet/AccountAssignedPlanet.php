<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Planet;

use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Account\AccountProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;

class AccountAssignedPlanet extends Model
{
    public $table = 'pi_account_assigned_planets';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = ['character_planet_id', 'account_project_id'];

    protected $primaryKey = ['character_planet_id', 'account_project_id'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(AccountProject::class, 'account_project_id', 'id');
    }

    public function planet(): BelongsTo
    {
        return $this->belongsTo(CharacterPlanet::class, 'character_planet_id', 'id');
    }
}