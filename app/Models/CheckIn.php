<?php

namespace App\Models;

use App\Traits\HasManyAccommodations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    protected $guarded = [];
}
