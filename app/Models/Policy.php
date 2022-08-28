<?php

namespace App\Models;

use App\Traits\BelongsToManyAccommodations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;


class Policy extends Model
{
    use HasFactory, BelongsToManyAccommodations, HasTranslations;

    protected $guraded = [];
    public $translatable = ['name'];
}
