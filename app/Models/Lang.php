<?php

namespace App\Models;

use App\Traits\BelongsToManyAccommodations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Lang extends Model
{
    use HasFactory, BelongsToManyAccommodations, HasTranslations;

    protected $guarded = [];
    public $translatable = ['name'];
}
