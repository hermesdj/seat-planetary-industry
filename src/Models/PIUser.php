<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Models;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Seat\Eveapi\Models\RefreshToken;
use Seat\Web\Models\User;

class PIUser extends User
{
    protected $table = 'users';

    public function piCharacters(): HasManyThrough
    {

        return $this->hasManyThrough(PICharacterInfo::class, RefreshToken::class, 'user_id', 'character_id');
    }
}