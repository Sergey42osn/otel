<?php

namespace App\Models;

use App\Traits\MorphManyImages;
use App\Traits\MorphManyRooms;
use App\Traits\MorphOneAccommodationable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;


class Hotel extends Model
{
    use HasFactory, MorphOneAccommodationable, MorphManyImages, MorphManyRooms;

    protected $guarded = [];

    protected $casts = [
        'stars_num' => 'integer',
    ];
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * @return MorphMany
     */
    public function rooms(): MorphMany
    {
        return $this->morphMany(Room::class, 'roomable');
    }

    public function featured_image()
    {
        return self::images()->where('featured_image', 1)->first();
    }
}
