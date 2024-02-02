<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Corporation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Seat\Eveapi\Models\Corporation\CorporationInfo;

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
        return $this->hasMany(CorporationProjectObjective::class, 'corporation_project_id');
    }
}