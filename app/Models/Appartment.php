<?php

namespace App\Models;

use App\Traits\MorphManyImages;
use App\Traits\MorphOneAccommodationable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appartment extends Model
{
    use HasFactory, MorphOneAccommodationable, MorphManyImages;

//    protected  $attributes = ['stars_num' => 0];

    protected $fillable = [
        'type_id',
        'single_bed',
        'double_bed',
        'sofa_bed',
        'wide_bed',
        'futon',
        'guest_count',
        'extra_beds',
        'area',
        'bathroom_count',
        'room_no',
        'allow_child',
        'crm',
        'protection_booking'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class)->where('type', 'Appartment');
    }
    public function featured_image()
    {
        return self::images()->where('featured_image', 1)->first();
    }
}
