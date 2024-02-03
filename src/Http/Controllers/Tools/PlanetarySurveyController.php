<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Controllers\Tools;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PlanetarySurveyController extends Controller
{
    public function home(): View|Factory|Application
    {
        return view('seat-pi::survey.home');
    }

    public function storeSurvey(): RedirectResponse
    {
        return redirect(route('seat-pi::survey.home'));
    }

    public function lookupSystems(Request $request): JsonResponse
    {
        $systems = DB::table('invUniqueNames')->where('groupID', 5)
            ->where('itemName', 'like', $request->input('query') . '%')
            ->take(10)->get();

        return response()->json(['suggestions' => $systems->map(function ($system) {
            return ['value' => $system->itemName, 'data' => $system->itemID];
        })]);
    }
}