<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Hotel;
use App\Models\Rating;
use App\Models\RatingAnswer;
use App\Models\User;
use App\Models\UserPermission;
use App\Services\Api\NewTelService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChangePasswordFormRequest;

class UserController extends Controller
{
    public $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function objects()
    {
        if (\Auth::user()->role_id==1 || \Auth::user()->role_id==3 ) {
            if(UserPermission::where('user_id',\Auth::user()->id)->first()) {
                return view('auth.vendor.vendor-objects', ['user' => $this->UserService->objects()]);
            }
            return view('auth.vendor.vendor-objects', ['user' => $this->UserService->objects()]);
        } else {
            abort(404);
        }
    }

    public function info()
    {
        return view('auth.vendor.personal-info', ['user' => $this->UserService->companyUser()]);
    }

    public function reviews()
    {
        $user = \Auth::user();
        if ( $user->role_id==3 ) {
            $us = UserPermission::where('user_id', $user->id)->first();
            if ($us && $us->partner_ship_id != 4) {
                $id = $us->owner_id;
                $accommodations = Accommodation::where('user_id',$id)->pluck('id');
                $accs = Accommodation::where('user_id',$id)->get();
                $reviews = Rating::whereIn('accommodation_id', $accommodations)->orderBy('created_at', 'DESC')->get();
                return view('auth.vendor.reviews', ['reviews' => $reviews,'accs' => $accs]);
            }
        } elseif ($user->role_id == 1) {
            $accommodations = Accommodation::where('user_id',$user->id)->pluck('id');
            $reviews = Rating::whereIn('accommodation_id', $accommodations)->orderBy('created_at', 'DESC')->get();
            $accs = Accommodation::where('user_id',$user->id)->get();

            return view('auth.vendor.reviews', ['reviews' => $reviews,'accs' => $accs]);

        }


        abort(404);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->UserService->deleteUser($user);
        Auth::logout();
        return redirect()->route('login');
    }

    public function changePassword(User $user, ChangePasswordFormRequest $request)
    {
        return  $this->UserService->changePassword($user, $request->safe()->new_password);
    }

    public function changeAvatar(Request $request)
    {

        $url = $this->UserService->changeAvatar($request->file);
        $temp = "<img src='" . asset('storage/uploads/' . $url) . "'alt='person'>";
        return $temp;
    }

    public function changeName(Request $request)
    {
        $this->UserService->changeName(Auth::user(), $request->name, $request->last_name);
    }

    public function security(): View
    {
        if(\App\Models\User::getPermission('security')){
            return view('auth.vendor.security');
        }
        abort(404);
    }

    public function existPassword(Request $request)
    {
        return $this->UserService->existPassword($request->password);
    }
    public function changePhone(Request $request)
    {
        $sms_code = rand(1000, 9999);
        $smsservice = new NewTelService();
        $smsservice->send( $request->phone,$sms_code);
        $user = User::find(Auth::user()->id);
        $user->update(['phone'=> $request->phone, 'active_phone'=>0, 'sms_code'=>$sms_code]);
        return response()->json(["status"=>true]);
    }

}
