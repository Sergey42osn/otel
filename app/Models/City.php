<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory, HasTranslations;

    const UPDATED_AT = 'updated_on';

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'wikiDataId',
        'country_code',
        'country_id'
    ];

    public $translatable = ['name'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'city_id');
    }
}
