<?php

namespace App\Models;

use App\Traits\HasManyAccommodations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    use HasFactory, HasManyAccommodations;
    protected $guarded = [];
}
