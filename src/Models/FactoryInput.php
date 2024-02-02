<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Seat\Eveapi\Models\Sde\InvType;

class FactoryInput extends Model
{
    public $table = 'pi_factory_inputs';
    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'schematic_id',
        'input_type_id',
        'quantity_consumed'
    ];

    protected $primaryKey = ['schematic_id', 'input_type_id'];

    public function invType(): BelongsTo
    {
        return $this->belongsTo(InvType::class, 'input_type_id', 'typeID');
    }

    public function schematic(): BelongsTo
    {
        return $this->belongsTo(Schematic::class, 'schematic_id', 'schematic_id');
    }
}