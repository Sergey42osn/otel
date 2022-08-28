<?php

namespace App\Models;

use App\Traits\HasManyAccommodations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class Type extends Model
{
    use HasFactory, HasManyAccommodations, HasTranslations;
    protected $guarded = [];
    public $translatable = ['name'];
}
