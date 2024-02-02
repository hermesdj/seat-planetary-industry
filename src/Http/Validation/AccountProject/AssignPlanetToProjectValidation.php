<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\AccountProject;

use Illuminate\Foundation\Http\FormRequest;

class AssignPlanetToProjectValidation extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'character_planet_id' => ['integer']
        ];
    }
}