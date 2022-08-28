<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class Room extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];

    public $translatable = ['description'];

    protected $fillable = [
        'title',
        'description',
        'number',
        'price',
        'size',
        'type_id',
        'single_bed',
        'double_bed',
        'sofa_bed',
        'wide_bed',
        'futon',
        'guest_count',
        'extra_beds',
        'title_id',
        'code_from_api',
        'api_plane_id',
        'prepayment'
    ];

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function roomable(): MorphTo
    {
        return $this->morphTo();
    }
    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot(['price']);
    }
    public function type()
    {
        return $this->belongsTo(Type::class)->where('type', 'Room');
    }

    public function name()
    {
        return $this->hasOne(TypeName::class, 'id', 'title_id');
    }

    public function roomServices()
    {
        return $this->hasMany(RoomService::class);
    }
    public function roomServicesSelected()
    {
        return RoomService::where('room_id',$this->id)->whereNotNull('price')->get();
    }
    public function roomServicesSelectedName()
    {
        $rooms = RoomService::where('room_id',$this->id)->whereNotNull('price')->pluck('service_id');
        return Service::whereIn('id',$rooms)->get();
    }

}
