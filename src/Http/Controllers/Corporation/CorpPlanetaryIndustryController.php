<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers\Corporation;

use HermesDj\Seat\SeatPlanetaryIndustry\Helpers\classes\ProjectOverview;
use HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\CorporationProject\CorporationProjectValidation;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Corporation\CorporationProject;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\TierInfo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;

class CorpPlanetaryIndustryController extends Controller
{
    public function home(): RedirectResponse
    {
        $user = Auth::user();

        return redirect(route('seat-pi::corporation-pi', ['corporation' => $user->main_character->affiliation->corporation_id]));
    }

    public function corporationPiHome(CorporationInfo $corporation): View|Factory|Application
    {
        $projects = CorporationProject::where('corporation_id', $corporation->corporation_id)->get();
        return view('seat-pi::corporation.home', compact('corporation', 'projects'));
    }

    public function viewProject(CorporationInfo $corporation, CorporationProject $project): View|Factory|Application
    {
        $characters = Auth::user()->characters;
        $corporation = CorporationInfo::find($corporation->corporation_id);
        $projects = CorporationProject::where('corporation_id', $corporation->corporation_id)->get();
        $project = CorporationProject::find($project->id);
        $tiers = TierInfo::with('schematics')->get();
        $overview = ProjectOverview::fromCorporationProject($project);

        $unassignedPlanets = CharacterPlanet::doesntHave('assignedToCorp')
            ->doesntHave('assignedTo')
            ->whereIn('character_id', $characters->pluck('character_id')->all())
            ->get()
            ->groupBy(function ($item, $key) {
                return $item->character->name;
            })
            ->all();

        return view('seat-pi::corporation.projects',
            compact(
                'corporation',
                'projects',
                'project',
                'tiers',
                'overview',
                'unassignedPlanets'
            )
        );
    }

    public function createProject(CorporationInfo $corporation, CorporationProjectValidation $request): RedirectResponse
    {
        $project = new CorporationProject($request->all());
        $project->corporation_id = $corporation->corporation_id;

        $project->save();

        return redirect(route('seat-pi::corporation-pi-project', [
            'corporation' => $corporation->corporation_id,
            'project' => $project->id
        ]));
    }

    public function editProject(CorporationInfo $corporation, CorporationProject $project, CorporationProjectValidation $request): RedirectResponse
    {
        $project->update($request->all());
        return redirect(route('seat-pi::corporation-pi-project', ['corporation' => $corporation->corporation_id, 'project' => $project->id]));
    }

    public function deleteProject(CorporationInfo $corporation, CorporationProject $project): RedirectResponse
    {
        $project->delete();
        return redirect(route('seat-pi::corporation-pi', ['corporation' => $corporation->corporation_id]));
    }
}