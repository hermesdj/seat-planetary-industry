<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Corporation;

use HermesDj\Seat\SeatPlanetaryIndustry\Models\Schematic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorporationProjectObjective extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'pi_corporation_project_objectives';

    protected $fillable = [
        'corporation_project_id',
        'schematic_id',
        'target_quantity'
    ];

    protected $primaryKey = [
        'corporation_project_id',
        'schematic_id'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(CorporationProject::class, 'corporation_project_id', 'id');
    }

    public function schematic(): BelongsTo
    {
        return $this->belongsTo(Schematic::class, 'schematic_id', 'schematic_id');
    }
}