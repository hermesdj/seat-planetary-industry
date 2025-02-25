<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers\Account;

use HermesDj\Seat\SeatPlanetaryIndustry\Helpers\classes\TemplateHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanetPin;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\Web\Http\Controllers\Controller;

class AccountPlanetaryIndustryController extends Controller
{
    public function home(): RedirectResponse
    {
        return redirect(route('seat-pi::account-pi-extractors'));
    }

    public function extractors(): View|Factory|Application
    {
        $characters = Auth::user()->characters->sortBy('name');

        return view('seat-pi::account.extractors', compact('characters'));
    }

    public function factories(): View|Factory|Application
    {
        $factories = CharacterPlanetPin::whereIn('character_id', auth()->user()->associatedCharacterIds())
            ->whereNotNull('schematic_id')
            ->select('schematic_id', 'character_id', 'planet_id', DB::raw('COUNT(pin_id) as nbFactories'))
            ->groupBy('schematic_id', 'character_id', 'planet_id')
            ->get();

        return view('seat-pi::account.factories', compact('factories'));
    }

    public function planets(): View|Factory|Application
    {
        $planets = CharacterPlanet::whereIn('character_id', auth()->user()->associatedCharacterIds())
            ->get();

        return view('seat-pi::account.planets', compact('planets'));
    }

    public function storage(): View|Factory|Application
    {
        $containerIds = [
            2541, // Storage Facility
            2536, // Storage Facility
            2257, // Storage Facility
            2558, // Storage Facility
            2535, // Storage Facility
            2560, // Storage Facility
            2561, // Storage Facility
            2562, // Storage Facility
            2544, // Launch Pad
            2543, // Launch Pad
            2552, // Launch Pad
            2555, // Launch Pad
            2542, // Launch Pad
            2556, // Launch Pad
            2557, // Launch Pad
            2256  // Launch Pad
        ];

        $containers = CharacterPlanetPin::whereIn('character_id', auth()->user()->associatedCharacterIds())
            ->whereIn('type_id', $containerIds)
            ->select('character_id', 'planet_id', 'type_id', 'pin_id')
            ->get();

        return view('seat-pi::account.storage', compact('containers'));
    }

    public function templates(): View|Factory|Application
    {
        $commandCenters = TemplateHelper::getCommandCenters();
        $structures = TemplateHelper::getStructures();
        $planetMapping = TemplateHelper::getPlanetMapping();
        $productMapping = TemplateHelper::getProductMapping();

        $characters = Auth::user()->characters->sortBy('name');

        $planetOverview = CharacterPlanet::whereIn('character_id', auth()->user()->associatedCharacterIds())
            ->get();

        $planetTypes = InvType::whereIn('typeID', collect($productMapping)->pluck('planets')->flatten()->unique()->toArray())
            ->orderBy('typeName', 'asc')
            ->get();

        $productTypes = InvType::whereIn('typeID', array_keys($productMapping))
            ->orderBy('typeName', 'asc')
            ->get();

        $resourceMapping = InvType::whereIn('typeID', collect($productMapping)->pluck('resource')->unique()->toArray())
            ->orderBy('typeName', 'asc')
            ->get()
            ->keyBy('typeID')
            ->map(fn($item) => [
                'typeId' => $item->typeID,
                'name' => $item->typeName
            ])
            ->toArray();

        return view('seat-pi::account.templates', [
            'characters' => $characters,
            'commandCenters' => $commandCenters,
            'planetMapping' => $planetMapping,
            'planetOverview' => $planetOverview,
            'planetTypes' => $planetTypes,
            'productMapping' => $productMapping,
            'productTypes' => $productTypes,
            'resourceMapping' => $resourceMapping,
            'structures' => $structures,
        ]);
    }
}
