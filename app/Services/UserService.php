<?php

namespace App\Services;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Appartment;
use Facades\App\Actions\StoreImages;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Facades\App\Actions\Base64FileUploader;

class UserService
{

    public function index()
    {
    }

    public function objects($type)
    {
//        if($type== ''){
            $user=UserPermission::where('user_id',Auth::user()->id)->first();
            if($user  && ($user->partner_ship_id==1 || $user->partner_ship_id==3)) {
                $owner=User::all()->find($user->owner_id);
                return $owner->load('accommodations');
            }
            return Auth::user()->load(['accommodations' => function($query) {
                $query->orderBy('updated_at', 'DESC');
            }]);
//        }else{
//            $user=UserPermission::where('user_id',Auth::user()->id)->first();
//            if($user  && ($user->partner_ship_id==1 || $user->partner_ship_id==3)) {
//                $owner=User::all()->find($user->owner_id);
//                return $owner->load('accommodations');
//            }
//            return Auth::user()->load(['accommodations' => function($query) {
//                $query->orderBy('updated_at', 'DESC');
//            }]);
//        }
    }

    public function bookings()
    {
        return Auth::user()->load('orders');
    }

    public function create()
    {
    }

    public function update()
    {
    }
    public function delete(User $user)
    {
    }

    public function filter($type)
    {
        $query = auth()->user()->load('accommodations');

        return $query->when($type == 'hotel', function ($q) use ($type) {
            return $q->hotel()->type()->where('type', $type);
        })->when($type == 'youth_hotel', function ($q) use ($type) {
            return $q->hotel()->type()->where('type', $type);
        })->when($type == 'appartment', function ($q) use ($type) {
            return $q->appartment()->type()->where('type', $type);
        })->when($type == 'villa', function ($q) use ($type) {
            return $q->appartment()->type()->where('type', $type);
        })->when($type == '', function ($q) use ($type){
            return $q->orderBy('updated_at', 'DESC');
        });
    }


    public function changePassword(User $user, $new)
    {
        $user->update(['success' => Hash::make($new)]);
        return response()->json(["password" => "Password Changed!"]);
    }

    public function changePhone(User $user, $phone)
    {
        $user->phone = $phone;
        $user->save();

        return response()->json(["success" => "Phone Number Changed!"]);
    }

    public function changeAvatar($file)
    {
        $url = Base64FileUploader::upload($file, '/public/uploads/');
        if (Auth::user()->image) {
            auth()->user()->image->update(['url' => $url]);
        } else {
            StoreImages::execute(auth()->user(), $url);
        }

        return $url;
    }

    public function changeName(User $user, $name, $last)
    {
        $user->name = $name;
        $user->last_name = $last;
        $user->save();
    }

    public function deleteUser(User $user)
    {
        $user->delete();
    }

    public function existPassword($password)
    {
        $message = false;
        if (!Hash::check($password, auth()->user()->password)) {
            $message = 'Password Dosen\'t matched to database records';
            return array($message);
        }
        return "true";
    }

    public function companyUser()
    {
        return Auth::user()->load(['company', 'image']);
    }
}
