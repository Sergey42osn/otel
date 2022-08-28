<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Appartment;
use App\Models\Hotel;
use App\Models\UserPermission;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ObjectController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, UserService $userService)
    {
        $url = URL::current();
//        dd(URL::to($url.'?type='));
        $auth_user = \Auth::user();
        if ($auth_user->role_id==1 || $auth_user->role_id==3 ) {
            $user = UserPermission::where('user_id',\Auth::user()->id)->first();
//            dd($user->owner_id);

            $accommodations = Accommodation::whereIn('user_id', [$auth_user->id, $user->owner_id ?? 0])->orderBy('created_at', 'DESC')->get();
            if($request->type!=''){
                $accommodations = Accommodation::where('type',$request->type)->whereIn('user_id', [$auth_user->id, $user->owner_id ?? 0])->orderBy('created_at', 'DESC')->get();
            }
            $hotel = Hotel::get();
            if($user && ($user->partner_ship_id==1 || $user->partner_ship_id==3)) {
                return view('auth.vendor.vendor-objects', ['accommodations' => $accommodations,'hotels' => $hotel]);
            }
            return view('auth.vendor.vendor-objects', ['accommodations' => $accommodations,'hotels' => $hotel]);
        } else {
            abort(404);
        }
    }
//    public function filter($type){
//        $accommodations = Accommodation::find($type);
//    }
}
