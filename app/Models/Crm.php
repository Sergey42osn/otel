<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crm extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'sale_channel_id',
        'accommodation_id',
        'accommodation_crm_code'
    ];
}
