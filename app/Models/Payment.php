<?php

namespace App\Models;

use App\Traits\BelongsToManyAccommodations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Payment extends Model
{
    use HasFactory, BelongsToManyAccommodations, HasTranslations;

    protected $translatable = ['name'];
}
