<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Helpers\classes;

use HermesDj\Seat\SeatPlanetaryIndustry\Models\Schematic;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\TierInfo;

class Fabrication
{
    public Schematic $schematic;
    public TierInfo $tier;
    public float $factoriesNeeded = 0;
    public float $actualFactories = 0;
    public float $productionNeeded = 0;
    public float $actualProduction = 0;
    public float $delta = 0;
}