<?php

namespace App\Models;

use App\Traits\BelongsToManyAccommodations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoomService extends Model
{
    use HasFactory, BelongsToManyAccommodations;

    protected $table = 'room_service';

    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
