<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers\Account;

use HermesDj\Seat\SeatPlanetaryIndustry\Helpers\classes\ProjectOverview;
use HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\AccountProject\AccountProjectValidation;
use HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\AccountProject\AssignedPlanetProjectValidation;
use HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\AccountProject\ProjectObjectiveValidation;
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

        return redirect(route('seat-pi::view-account-pi-project', ['project' => $project->id]));
    }

    public function editProject(AccountProject $project, AccountProjectValidation $request): RedirectResponse
    {
        $project->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect(route('seat-pi::view-account-pi-project', ['project' => $project->id]));
    }

    public function deleteProject(AccountProject $project): RedirectResponse
    {
        // TODO Permissions
        $project->delete();
        return redirect(route('seat-pi::account-pi-projects'));
    }

    public function viewProject(AccountProject $project): View|Factory|Application
    {
        // TODO Permissions
        $characters = Auth::user()->characters;
        $projects = AccountProject::where('user_id', Auth::user()->id)->get();
        $tiers = TierInfo::with('schematics')->get();
        $overview = ProjectOverview::fromAccountProject($project);

        $unassignedPlanets = CharacterPlanet::doesntHave('assignedTo')
            ->doesntHave('assignedToCorp')
            ->whereIn('character_id', $characters->pluck('character_id')->all())
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

    public function addObjective(ProjectObjectiveValidation $request, AccountProject $project): RedirectResponse
    {
        $objective = new ProjectObjective($request->all());

        $project->objectives()->save($objective);

        return redirect(route('seat-pi::view-account-pi-project', ['project' => $project->id]));
    }

    public function editObjective(ProjectObjectiveValidation $request, AccountProject $project): RedirectResponse
    {
        ProjectObjective::where('project_id', $project->id)
            ->where('schematic_id', $request->schematic_id)
            ->update(['target_quantity' => $request->target_quantity]);

        return redirect(route('seat-pi::view-account-pi-project', ['project' => $project->id]));
    }

    public function assignPlanet(AssignedPlanetProjectValidation $request, AccountProject $project): RedirectResponse
    {
        $accountAssignedPlanet = new AccountAssignedPlanet($request->all());
        $accountAssignedPlanet->account_project_id = $project->id;

        $accountAssignedPlanet->save();

        return redirect(route('seat-pi::view-account-pi-project', ['project' => $project->id]));
    }

    public function removeObjective(AccountProject $project, int $schematic_id): RedirectResponse
    {
        ProjectObjective::where('project_id', $project->id)
            ->where('schematic_id', $schematic_id)
            ->delete();

        return redirect(route('seat-pi::view-account-pi-project', ['project' => $project->id]));
    }

    public function removeAssignedPlanet(AccountProject $project, CharacterPlanet $planet): RedirectResponse
    {
        AccountAssignedPlanet::where('account_project_id', $project->id)
            ->where('character_planet_id', $planet->id)
            ->delete();

        return redirect(route('seat-pi::view-account-pi-project', ['project' => $project->id]));
    }
}