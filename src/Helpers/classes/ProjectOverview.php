<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Helpers\classes;

use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Account\AccountProject;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Corporation\CorporationProject;
use Illuminate\Support\Collection;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanetPin;

class ProjectOverview
{
    public Collection $fabrications;
    public Collection $extractions;

    public static function fromAccountProject(AccountProject $project): ProjectOverview
    {
        return self::process($project->objectives, $project->planets);
    }

    public static function fromCorporationProject(CorporationProject $project): ProjectOverview
    {
        return self::process($project->objectives, $project->planets);
    }

    private static function process(Collection $objectives, Collection $planets): ProjectOverview
    {
        $fabrications = collect();
        $extractions = collect();

        foreach ($objectives as $objective) {
            self::processSchematic($fabrications, $extractions, $objective->schematic, $objective->target_quantity);
        }

        foreach ($planets as $colony) {
            self::processColony($extractions, $fabrications, $colony);
        }

        $overview = new ProjectOverview();
        $overview->fabrications = $fabrications;
        $overview->extractions = $extractions;

        return $overview;
    }

    private static function processSchematic($fabrications, $extractions, $schematic, $target_quantity): void
    {
        if ($target_quantity == 0 || is_infinite($target_quantity)) return;

        $fabrication = new Fabrication();
        if (!$fabrications->has($schematic->schematic_id)) {
            $fabrication->schematic = $schematic;
            $fabrication->tier = $schematic->tier;
            $fabrications->put($schematic->schematic_id, $fabrication);
        } else {
            $fabrication = $fabrications->get($schematic->schematic_id);
        }

        $cyclePerHour = 3600 / $schematic->cycle_time;
        $productionPerHour = ($schematic->tier->quantity_produced) * $cyclePerHour;
        $factoriesNeeded = $target_quantity / $productionPerHour;
        $productionNeeded = $productionPerHour * $factoriesNeeded;

        $fabrication->factoriesNeeded += $factoriesNeeded;
        $fabrication->productionNeeded += $productionNeeded;

        foreach ($schematic->inputs as $input) {
            $totalConsumption = $input->quantity_consumed * $factoriesNeeded * $cyclePerHour;
            $invType = $input->invType;

            if (isset($invType->schematic)) {
                self::processSchematic($fabrications, $extractions, $invType->schematic, $totalConsumption);
            } else {
                $extraction = new Extraction();
                if (!$extractions->has($input->input_type_id)) {
                    $extraction->resource = $input->invType;
                    $extractions->put($input->input_type_id, $extraction);
                } else {
                    $extraction = $extractions->get($input->input_type_id);
                }

                $extraction->extractionNeeded += $totalConsumption;
            }
        }
    }

    private static function processColony(Collection $extractions, Collection $fabrications, CharacterPlanet $colony): void
    {
        foreach ($colony->extractors as $extractor) {
            $product = $extractor->product;
            if ($extractions->has($extractor->product_type_id)) {
                $extraction = $extractions->get($extractor->product_type_id);
                $cyclesPerHours = 3600 / $extractor->cycle_time;
                $quantityPerHour = $cyclesPerHours * $extractor->qty_per_cycle;

                $extraction->actualExtraction += $quantityPerHour;
            } else {
                logger()->debug("Extraction not found for product $product->typeName");
            }
        }

        $pins = CharacterPlanetPin::where('character_id', $colony->character_id)
            ->where('planet_id', $colony->planet_id)->get();

        foreach ($pins as $pin) {
            if (isset($pin->schematic_id)) {
                if ($fabrications->has($pin->schematic_id)) {
                    $fabrication = $fabrications->get($pin->schematic_id);

                    $schematic = $pin->schematic;
                    $cyclePerHour = 3600 / $schematic->cycle_time;
                    $productionPerHour = ($schematic->tier->quantity_produced) * $cyclePerHour;

                    $fabrication->actualFactories += 1;
                    $fabrication->actualProduction += $productionPerHour;
                }
            }
        }
    }
}