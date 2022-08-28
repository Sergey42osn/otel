<?php

namespace App\Traits;

use App\Models\Accommodation;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BelongsToManyAccommodations
{
    public function accomodations(): BelongsToMany
    {
        return $this->belongsToMany(Accommodation::class);
    }
}
