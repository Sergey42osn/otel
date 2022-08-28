<?php

namespace App\Traits;

use App\Models\Room;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait MorphManyRooms
{
    public function rooms(): MorphMany
    {
        return $this->morphMany(Room::class, 'roomable');
    }
}
