<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Seat\Eveapi\Models\Sde\InvType;

class TierInfo extends Model
{
    public $table = 'pi_tier_infos';
    public $timestamps = false;

    protected $fillable = [
        'tier_id',
        'market_group_id',
        'quantity_produced'
    ];
    public $incrementing = false;

    protected $primaryKey = 'tier_id';

    public function invTypes(): HasMany
    {
        return $this->hasMany(InvType::class, 'marketGroupID', 'market_group_id');
    }

    public function schematics(): HasManyThrough
    {
        return $this->hasManyThrough(Schematic::class, InvType::class, 'marketGroupID', 'type_id', 'market_group_id', 'typeID');
    }
}