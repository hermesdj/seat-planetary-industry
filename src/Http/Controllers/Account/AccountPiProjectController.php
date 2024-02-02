<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers\Account;

use HermesDj\Seat\SeatPlanetaryIndustry\Helpers\classes\ProjectOverview;
use HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\AccountProject\AccountProjectValidation;
use HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\AccountProject\AddObjectiveToProjectValidation;
use HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\AccountProject\AssignPlanetToProjectValidation;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Account\AccountProject;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Account\ProjectObjective;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Planet\AccountAssignedPlanet;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\TierInfo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;

class AccountPiProjectController extends Controller
{
    public function projects(): View|Factory|Application
    {
        $projects = AccountProject::where('user_id', Auth::user()->id)->get();

        return view('seat-pi::account.projects', compact('projects'));
    }

    public function createProject(AccountProjectValidation $request): RedirectResponse
    {
        $project = new AccountProject($request->all());
        $project->user_id = Auth::user()->id;

        $project->save();

        return redirect(route('seat-pi::view-account-pi-project', ['id' => $project->id]));
    }

    public function editProject(int $id, AccountProjectValidation $request): RedirectResponse
    {
        // TODO permissions
        AccountProject::where('id', $id)
            ->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

        return redirect(route('seat-pi::view-account-pi-project', ['id' => $id]));
    }

    public function deleteProject(int $id): RedirectResponse
    {
        // TODO Permissions
        AccountProject::where('id', $id)->delete();
        return redirect(route('seat-pi::account-pi-projects'));
    }

    public function viewProject(string $id): View|Factory|Application
    {
        // TODO Permissions
        $characters = Auth::user()->characters;
        $projects = AccountProject::where('user_id', Auth::user()->id)->get();
        $project = AccountProject::find($id);
        $tiers = TierInfo::with('schematics')->get();
        $overview = ProjectOverview::fromAccountProject($project);

        $unassignedPlanets = CharacterPlanet::doesntHave('assignedTo')
            ->get()
            ->groupBy(function ($item, $key) {
                return $item->character->name;
            })
            ->all();

        return view(
            'seat-pi::account.projects',
            compact(
                'projects',
                'project',
                'tiers',
                'overview',
                'characters',
                'unassignedPlanets'
            )
        );
    }

    public function addObjective(AddObjectiveToProjectValidation $request, int $id): RedirectResponse
    {
        $project = AccountProject::find($id);
        $objective = new ProjectObjective($request->all());

        $project->objectives()->save($objective);

        return redirect(route('seat-pi::view-account-pi-project', ['id' => $project->id]));
    }

    public function editObjective(AddObjectiveToProjectValidation $request, int $id): RedirectResponse
    {
        ProjectObjective::where('project_id', $id)
            ->where('schematic_id', $request->schematic_id)
            ->update(['target_quantity' => $request->target_quantity]);

        return redirect(route('seat-pi::view-account-pi-project', ['id' => $id]));
    }

    public function assignPlanet(AssignPlanetToProjectValidation $request, int $id): RedirectResponse
    {
        $project = AccountProject::find($id);
        $accountAssignedPlanet = new AccountAssignedPlanet($request->all());
        $accountAssignedPlanet->account_project_id = $id;

        $accountAssignedPlanet->save();

        return redirect(route('seat-pi::view-account-pi-project', ['id' => $project->id]));
    }

    public function removeObjective(int $id, int $schematic_id): RedirectResponse
    {
        ProjectObjective::where('project_id', $id)
            ->where('schematic_id', $schematic_id)
            ->delete();

        return redirect(route('seat-pi::view-account-pi-project', ['id' => $id]));
    }

    public function removeAssignedPlanet(int $id, int $character_planet_id): RedirectResponse
    {
        AccountAssignedPlanet::where('account_project_id', $id)
            ->where('character_planet_id', $character_planet_id)
            ->delete();

        return redirect(route('seat-pi::view-account-pi-project', ['id' => $id]));
    }
}