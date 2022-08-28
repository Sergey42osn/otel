<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerShip extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getPartner(){
        if ($user_permission = UserPermission::where([['partner_ship_id',$this->id],['owner_id',\Auth::user()->id]])->first()){
            if ($user = User::find($user_permission->user_id)) {
                return $user;
            }
        }
        return '';
    }

    public function getPartnerPermission(){
        if ($user_permission = UserPermission::where([['partner_ship_id',$this->id],['owner_id',\Auth::user()->id]])->first()){
            return $user_permission;

        }
        return '';
    }
}
