<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Validation\AccountProject;

use Illuminate\Foundation\Http\FormRequest;

class AccountProjectValidation extends FormRequest
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