<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphManyImages
{
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function featured_image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->where("featured_image",1);
    }
}
