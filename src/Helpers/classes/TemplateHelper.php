<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Helpers\classes;

class TemplateStructure
{
    public string $name;
    public int $cpuRequired;
    public int $powerRequired;
    public float $cost;

    public function __construct(string $name, int $cpuRequired, int $powerRequired, float $cost)
    {
        $this->name = $name;
        $this->cpuRequired = $cpuRequired;
        $this->powerRequired = $powerRequired;
        $this->cost = $cost;
    }
}

class TemplateCommandCenter
{
    public int $level;
    public int $capacity;
    public int $cpuProvided;
    public int $powerProvided;
    public ?float $upgradeCost;

    public function __construct(int $level, int $capacity, int $cpuProvided, int $powerProvided, ?float $upgradeCost)
    {
        $this->level = $level;
        $this->capacity = $capacity;
        $this->cpuProvided = $cpuProvided;
        $this->powerProvided = $powerProvided;
        $this->upgradeCost = $upgradeCost;
    }
}

class TemplateLink
{
    public float $distance;
    public int $cpuRequired;
    public int $powerRequired;

    public function __construct(float $distance, int $cpuRequired, int $powerRequired)
    {
        $this->distance = $distance;
        $this->cpuRequired = $cpuRequired;
        $this->powerRequired = $powerRequired;
    }
}

class TemplateHelper
{
    public static function getStructures(): array
    {
        return [
            new TemplateStructure("Advanced Industry Facility", 500, 700, 250000.00),
            new TemplateStructure("Basic Industry Facility", 200, 800, 75000.00),
            new TemplateStructure("Extractor Control Unit", 400, 2600, 45000.00),
            new TemplateStructure("Extractor Head", 110, 550, 0.00),
            new TemplateStructure("High-Tech Industry Facility", 1100, 400, 525000.00),
            new TemplateStructure("Launchpad", 3600, 700, 900000.00),
            new TemplateStructure("Storage Facility", 500, 700, 250000.00),
        ];
    }

    public static function getCommandCenters(): array
    {
        return [
            new TemplateCommandCenter(0, 500, 1675, 6000, null),
            new TemplateCommandCenter(1, 500, 7057, 9000, 580000.00),
            new TemplateCommandCenter(2, 500, 12136, 12000, 930000.00),
            new TemplateCommandCenter(3, 500, 17215, 15000, 1200000.00),
            new TemplateCommandCenter(4, 500, 21315, 17000, 1500000.00),
            new TemplateCommandCenter(5, 500, 25415, 19000, 2100000.00)
        ];
    }

    public static function getLinks(): array
    {
        return [
            new TemplateLink(2.5, 16, 11),
            new TemplateLink(10, 18, 12),
            new TemplateLink(20, 20, 14),
            new TemplateLink(50, 26, 18),
            new TemplateLink(100, 36, 26),
            new TemplateLink(200, 56, 41),
            new TemplateLink(500, 116, 86),
            new TemplateLink(1000, 215, 160),
            new TemplateLink(2000, 416, 311),
            new TemplateLink(5000, 1016, 761),
            new TemplateLink(40000, 8016, 6001)
        ];
    }

    public static function getPlanetMapping(): array
    {
        return [
            // Planet (Temperate)
            11 => [
                'basicFactory' => 2481, // Temperate Basic Industry Facility
                'extractor' => 3068, // Temperate Extractor Control Unit,
                'launchPad' => 2256, // Temperate Launch Pad
                'storageFacility' => 2562, // Temperate Storage Facility
            ],
            // Planet (Ice)
            12 => [
                'basicFactory' => 2493, // Ice Basic Industry Facility
                'extractor' => 3061, // Ice Extractor Control Unit,
                'launchPad' => 2552, // Ice Launch Pad
                'storageFacility' => 2257, // Ice Storage Facility
            ],
            // Planet (Gas)
            13 => [
                'basicFactory' => 2492, // Gas Basic Industry Facility
                'extractor' => 3060, // Gas Extractor Control Unit,
                'launchPad' => 2543, // Gas Launch Pad
                'storageFacility' => 2536, // Gas Storage Facility
            ],
            // Planet (Oceanic)
            2014 => [
                'basicFactory' => 2490, // Oceanic Basic Industry Facility
                'extractor' => 3063, // Oceanic Extractor Control Unit,
                'launchPad' => 2542, // Oceanic Launch Pad
                'storageFacility' => 2535, // Oceanic Storage Facility
            ],
            // Planet (Lava)
            2015 => [
                'basicFactory' => 2469, // Lava Basic Industry Facility
                'extractor' => 3062, // Lava Extractor Control Unit,
                'launchPad' => 2555, // Lava Launch Pad
                'storageFacility' => 2558, // Lava Storage Facility
            ],
            // Planet (Barren)
            2016 => [
                'basicFactory' => 2473, // Barren Basic Industry Facility
                'extractor' => 2848, // Barren Extractor Control Unit,
                'launchPad' => 2544, // Barren Launch Pad
                'storageFacility' => 2541, // Barren Storage Facility
            ],
            // Planet (Storm)
            2017 => [
                'basicFactory' => 2483, // Storm Basic Industry Facility
                'extractor' => 3067, // Storm Extractor Control Unit,
                'launchPad' => 2557, // Storm Launch Pad
                'storageFacility' => 2561, // Storm Storage Facility
            ],
            // Planet (Plasma)
            2063 => [
                'basicFactory' => 2471, // Plasma Basic Industry Facility
                'extractor' => 3064, // Plasma Extractor Control Unit,
                'launchPad' => 2556, // Plasma Launch Pad
                'storageFacility' => 2560, // Plasma Storage Facility
            ],
        ];
    }

    public static function getProductMapping(): array
    {
        return [
            // Reactive Metals
            2398 => [
                'planets' => [13, 2015, 2017, 2016, 2063],
                'resource' => 2267, // Base Metals
            ],
            // Biofuels
            2396 => [
                'planets' => [11, 2014, 2016],
                'resource' => 2288 // Carbon Compounds
            ],
            // Bacteria
            2393 => [
                'planets' => [11, 12, 2014, 2016],
                'resource' => 2073 // Microorganisms
            ],
            // Precious Metals
            2399 => [
                'planets' => [2016, 2063],
                'resource' => 2270 // Noble Metals
            ],
            // Water
            3645 => [
                'planets' => [11, 12, 13, 2014, 2016, 2017],
                'resource' => 2268 // Aqueous Liquids
            ],
            // Electrolytes
            2390 => [
                'planets' => [13, 2017],
                'resource' => 2309 // Ionic Solutions
            ],
            // Oxygen
            3683 => [
                'planets' => [12, 13, 2017],
                'resource' => 2310 // Noble Gas
            ],
            // Toxic Metals
            2400 => [
                'planets' => [12, 2015, 2063],
                'resource' => 2272 // Heavy Metals
            ],
            // Biomass
            3779 => [
                'planets' => [12, 2014],
                'resource' => 2286 // Planktic Colonies
            ],
            // Silicon
            9828 => [
                'planets' => [2015],
                'resource' => 2307 // Felsic Magma
            ],
            // Chiral Structures
            2401 => [
                'planets' => [2015, 2063],
                'resource' => 2306 // Non-CS Crystals
            ],
            // Plasmoids
            2389 => [
                'planets' => [2015, 2017, 2063],
                'resource' => 2308 // Suspended Plasma
            ],
            // Industrial Fibers
            2397 => [
                'planets' => [11],
                'resource' => 2305 // Autotrophs
            ],
            // Proteins
            2395 => [
                'planets' => [11, 2014],
                'resource' => 2287 // Complex Organisms
            ],
            // Oxidizing Compound
            2392 => [
                'planets' => [13],
                'resource' => 2311 // Reactive Gas
            ],
        ];
    }
}
