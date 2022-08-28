<?php

namespace App\Traits;

use App\Models\Accommodation;
use Illuminate\Database\Eloquent\Relations\MorphOne;


trait MorphOneAccommodationable
{

    public function accommodation(): MorphOne
    {
        return $this->morphOne(Accommodation::class, 'accommodationable');
    }
}
