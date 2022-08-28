<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PartnerShip;
use App\Models\UserPermission;
use App\Mail\SendAccessMail;
use App\Services\UserService;
use Auth;
use Mail;

class EmployeesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function employees(Request $request, UserService $userService)
    {
        if(\App\Models\User::getPermission('employees')){
            $user = \Auth::user();
            $partner_ships = PartnerShip::get();
            return view('auth.vendor.vendor-employees',[
                'user' => $user,
                'partner_ships'=> $partner_ships
            ]);
        }
        abort(404);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|unique:users',
            'phone' => 'required',
            'name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required'
        ]);

        $generated_password = Str::random(8);
        $user=User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' =>  Hash::make($generated_password),
            'active' => 1,
            'role_id' => 3
        ]);
        if($request->permission == ''){
            $request->permission='Administrator';
        }
        $id = \Auth::user()->id;
        if($us = UserPermission::where('user_id',\Auth::user()->id)->first()){
            $id=$us->owner_id;
        }
        $user_permission=UserPermission::create([
            'user_id' => $user->id,
            'permission' => $request->permission,
            'partner_ship_id' => $request->partnership_id,
            'owner_id' => $id
        ]);
        $partner=PartnerShip::where('id',$request->partnership_id)->first();
        $maildata=[
            'login'=>$request->email,
            'password'=>$generated_password,
            'full_name'=> $request->last_name." ".$request->name,
            'code' => $partner->code
        ];

        Mail::to($request->email)->send(new SendAccessMail($maildata));

        return redirect()->back();
    }
    public function delete(Request $request)
    {
        $user_permission= UserPermission::where([['partner_ship_id',$request->id],['owner_id',\Auth::user()->id]])->first();
        User::find($user_permission->user_id)->delete();
        $user_permission->delete();
        return redirect()->back();
    }
}
