<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers\Account;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanetPin;
use Seat\Web\Http\Controllers\Controller;

class AccountPlanetaryIndustryController extends Controller
{
    public function home(): RedirectResponse
    {
        return redirect(route('seat-pi::account-pi-extractors'));
    }

    public function extractors(): View|Factory|Application
    {
        $characters = Auth::user()->characters;
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
            2541, 2536, 2257, 2558, 2535, 2560, 2561, 2562, // Storage Facility
            2544, 2543, 2552, 2555, 2542, 2556, 2557, 2256  // Launch Pad
        ];

        $containers = CharacterPlanetPin::whereIn('character_id', auth()->user()->associatedCharacterIds())
            ->whereIn('type_id', $containerIds)
            ->select('character_id', 'planet_id', 'type_id', 'pin_id')
            ->get();

        return view('seat-pi::account.storage', compact('containers'));
    }
}