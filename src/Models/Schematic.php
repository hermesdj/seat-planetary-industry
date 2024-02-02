<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Seat\Eveapi\Models\Sde\InvMarketGroup;
use Seat\Eveapi\Models\Sde\InvType;

class Schematic extends Model
{
    protected $table = 'universe_schematics';
    public $timestamps = false;
    protected $fillable = [
        'schematic_id',
        'cycle_time',
        'schematic_name',
        'type_id'
    ];
    public $incrementing = false;

    protected $primaryKey = 'schematic_id';

    public function invType(): HasOne
    {
        return $this->hasOne(InvType::class, 'typeID', 'type_id');
    }

    public function marketGroup(): HasOneThrough
    {
        return $this->hasOneThrough(InvMarketGroup::class, InvType::class, 'marketGroupID', 'marketGroupID', 'type_id', 'typeID');
    }

    public function tier(): HasOneThrough
    {
        return $this->through('invType')->has('pi_tier');
    }

    public function inputs(): HasMany
    {
        return $this->hasMany(FactoryInput::class, 'schematic_id', 'schematic_id');
    }
}