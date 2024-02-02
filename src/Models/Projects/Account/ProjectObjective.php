<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Account;

use HermesDj\Seat\SeatPlanetaryIndustry\Models\Schematic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectObjective extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'pi_project_objectives';

    protected $fillable = [
        'project_id',
        'schematic_id',
        'target_quantity'
    ];

    protected $primaryKey = [
        'project_id',
        'schematic_id'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(AccountProject::class, 'project_id', 'id');
    }

    public function schematic(): BelongsTo
    {
        return $this->belongsTo(Schematic::class, 'schematic_id', 'schematic_id');
    }
}