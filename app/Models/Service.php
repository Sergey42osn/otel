<?php

namespace App\Models;

use App\Traits\BelongsToManyAccommodations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory, BelongsToManyAccommodations, HasTranslations;

    protected $guarded = [];
    public $translatable = ['name'];

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
}
