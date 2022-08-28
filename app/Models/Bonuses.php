<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonuses extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'promocode'
    ];
}
