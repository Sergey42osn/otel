<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password',
        'agree', 'alt_phone','auth_token','active',
        'gender', 'country', 'city', 'address', 'postal_code', 'avatar', 'role_id','phone',
        'sms_code','active_phone','active_email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function accommodations(): HasMany
    {
        return $this->hasMany(Accommodation::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function images(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    /**
     *
     *@return hasOneThrough | Rating
     *
     */
    public function rating(): HasOneThrough
    {
        return $this->hasOneThrough(Rating::class, Accommodation::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getGender()
    {
        if ($this->gender==0) {
            return __('account.Male');
        }else{
            return __('account.Female');
        }
    }
    public function getStatus()
    {
        if ($this->active==0) {
            return "";
        }else{
            return "text-success";
        }
    }
    public function getAvatar()
    {
        if (empty($this->avatar)) {
            return "/images/users/avatar/no-avatar.png";
        }else{
            return "/images/users/avatar/".$this->avatar;
        }
    }

    public function getAddress(){
        $address="";
        if (!empty($this->country)){
            $address = $this->country;
        }
        if (!empty($this->city)){
            if (!empty($address)){
                $address .=  ", ".$this->city;
            }
        }
        if (!empty($this->address)){
            if (!empty($address)){
                $address .=  ", ".$this->address;
            }
        }
        if (!empty($this->postal_code)){
            if (!empty($address)){
                $address .=  ", ".$this->postal_code;
            }
        }
        if (!empty($address)){
            return $address;
        } else {
            return __('account.Country').", ".__('account.City').", ".__('account.Address').", ".__('account.Postal code');
        }
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    public static function getPermission($text){
        if($text=='security'){
            $user=\Auth::user();
            if($user->role_id==1){
                return true;
            } elseif ($user->role_id==3){
                $us=UserPermission::where('user_id',$user->id)->first();
                if($us && $us->partner_ship_id==1){
                    return true;
                }
            } else{
                return false;
            }
        }
        if($text=='booking_and_reports'){
            $user=\Auth::user();
            if($user->role_id==1){
                return true;
            } elseif ($user->role_id==3){
                $us=UserPermission::where('user_id',$user->id)->first();
                if($us){
                    return true;
                }
            } else{
                return false;
            }
        }
        if($text=='reviews'){
            $user=\Auth::user();
            if($user->role_id==1){
                return true;
            } elseif ($user->role_id==3){
                $us=UserPermission::where('user_id',$user->id)->first();
                if($us && $us->partner_ship_id!=4){
                    return true;
                }
            } else{
                return false;
            }
        }
        if($text=='finance_documents'){
            $user=\Auth::user();
            if($user->role_id==1){
                return true;
            } elseif ($user->role_id==3){
                $us=UserPermission::where('user_id',$user->id)->first();
                if($us && $us->partner_ship_id!=2){
                    return true;
                }
            } else{
                return false;
            }
        }
        if($text=='my_objects'){
            $user=\Auth::user();
            if($user->role_id==1){
                return true;
            } elseif ($user->role_id==3){
                $us=UserPermission::where('user_id',$user->id)->first();
                if($us && ($us->partner_ship_id==1 || $us->partner_ship_id==3) ){
                    return true;
                }
            } else{
                return false;
            }
        }
        if($text=='employees'){
            $user=\Auth::user();
            if($user->role_id==1){
                return true;
            } elseif ($user->role_id==3){
                $us=UserPermission::where('user_id',$user->id)->first();
                if($us && ($us->partner_ship_id==1) ){
                    return true;
                }
            } else{
                return false;
            }
        }

    }
}
