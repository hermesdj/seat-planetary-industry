<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\CorporationProject;

use Illuminate\Foundation\Http\FormRequest;

class CorporationProjectValidation extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['string'],
            'description' => ['nullable', 'string'],
        ];
    }
}