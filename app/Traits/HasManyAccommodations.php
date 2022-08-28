<?php

namespace App\Traits;

use App\Models\Accommodation;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyAccommodations
{

    public function accommodations(): HasMany
    {
        return $this->hasMany(Accommodation::class);
    }
}
