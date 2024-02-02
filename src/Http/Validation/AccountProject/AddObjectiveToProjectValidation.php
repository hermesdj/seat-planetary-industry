<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\AccountProject;

use Illuminate\Foundation\Http\FormRequest;

class AddObjectiveToProjectValidation extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'schematic_id' => ['integer'],
            'target_quantity' => ['integer'],
        ];
    }
}