<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Account;

use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Planet\AccountAssignedPlanet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;
use Seat\Web\Models\User;

class AccountProject extends Model
{
    protected $table = 'pi_account_projects';

    protected $fillable = [
        'user_id',
        'name',
        'description'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(ProjectObjective::class, 'project_id');
    }

    public function planets(): HasManyThrough
    {
        return $this->hasManyThrough(CharacterPlanet::class, AccountAssignedPlanet::class, 'account_project_id', 'id', 'id', 'character_planet_id');
    }
}