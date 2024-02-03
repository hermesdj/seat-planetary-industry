<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers\Corporation;

use HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\AccountProject\AssignedPlanetProjectValidation;
use HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\AccountProject\ProjectObjectiveValidation;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Corporation\CorporationProject;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Corporation\CorporationProjectObjective;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Planet\CorporationAssignedPlanet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;

class CorpPiProjectController extends Controller
{
    public function addObjective(ProjectObjectiveValidation $request, CorporationInfo $corporation, CorporationProject $project): RedirectResponse
    {
        $objective = new CorporationProjectObjective($request->all());

        $project->objectives()->save($objective);

        return redirect(route('seat-pi::corporation-pi-project', ['corporation' => $corporation->corporation_id, 'project' => $project->id]));
    }

    public function editObjective(ProjectObjectiveValidation $request, CorporationInfo $corporation, CorporationProject $project): RedirectResponse
    {
        CorporationProjectObjective::where('corporation_project_id', $project->id)
            ->where('schematic_id', $request->schematic_id)
            ->update(['target_quantity' => $request->target_quantity]);

        return redirect(route('seat-pi::corporation-pi-project', ['corporation' => $corporation->corporation_id, 'project' => $project->id]));
    }

    public function deleteObjective(CorporationInfo $corporation, CorporationProject $project, int $schematic_id): RedirectResponse
    {
        CorporationProjectObjective::where('corporation_project_id', $project->id)
            ->where('schematic_id', $schematic_id)
            ->delete();

        return redirect(route('seat-pi::corporation-pi-project', ['corporation' => $corporation->corporation_id, 'project' => $project->id]));
    }

    public function assignPlanet(CorporationInfo $corporation, CorporationProject $project, AssignedPlanetProjectValidation $request): RedirectResponse
    {
        $planet = CharacterPlanet::find($request->character_planet_id);

        if (auth()->user()->can('corporation.assign_pi_planet', $planet)) {
            $assignedPlanet = new CorporationAssignedPlanet($request->all());
            $assignedPlanet->corporation_project_id = $project->id;
            $assignedPlanet->save();
            return redirect(route('seat-pi::corporation-pi-project', ['corporation' => $corporation->corporation_id, 'project' => $project->id]));
        } else {
            return redirect(route('seat-pi::corporation-pi-project', ['corporation' => $corporation->corporation_id, 'project' => $project->id]))
                ->with('error', 'Not Authorized to assign this planet');
        }
    }

    public function unassignPlanet(CorporationInfo $corporation, CorporationProject $project, CharacterPlanet $planet): RedirectResponse
    {
        CorporationAssignedPlanet::where('corporation_project_id', $project->id)
            ->where('character_planet_id', $planet->id)
            ->delete();

        return redirect(route('seat-pi::corporation-pi-project', ['corporation' => $corporation->corporation_id, 'project' => $project->id]));
    }
}