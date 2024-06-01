<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Helpers\classes;

use Illuminate\Support\Collection;
use Seat\Eveapi\Models\Sde\InvType;

class Extraction
{
    public InvType $resource;
    public float $extractionNeeded = 0;
    public float $actualExtraction = 0;
    public float $delta = 0;

    public Collection $colonies;
}