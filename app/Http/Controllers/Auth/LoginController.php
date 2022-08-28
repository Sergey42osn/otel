<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    function userlogin(Request $request)
    {

        $email_or_phone =$request->email;
        $email=$email_or_phone_type='';
        if(is_numeric($email_or_phone)) {
            if(!preg_match("/^[+]?[1-9][0-9]{9,14}$/", $email_or_phone)) {
                $email="invalid phone number.";
            }
            $email_or_phone_type = "phone";

        } else {
            if (!filter_var($email_or_phone, FILTER_VALIDATE_EMAIL)) {
                $email="invalid email address.";
            }
            $email_or_phone_type = "email";
        };

        $validator = Validator::make($request->all(), [
            'password' => 'required',

        ]);
        if(!isset($request->email)) {
            $validator->after(function ($validator) {
                $validator->errors()->add('email', __('auth.The email or phone field is required.'));
            });
        }
        elseif(strlen($email)>0) {
            $validator->after(function ($validator) {
                $validator->errors()->add('email', __('auth.Invalid phone or email'));
            });
        };
        if ($validator->fails())
        {
            return response()->json($validator->errors(),422);

        } else {
            if (\Auth::attempt(['email' => $request->email, 'password' => $request->password,'active' => 1, 'role_id' => 2])) {
                return response()->json(["status"=>true]);
            } elseif(\Auth::attempt(['phone' => $request->email, 'password' => $request->password,'active' => 1, 'role_id' => 2])) {
                return response()->json(["status"=>true]);
            }  elseif($email_or_phone_type == "phone" && !\Auth::attempt(['phone' => $request->email, 'password' => $request->password,'active' => 1, 'role_id' => 2])) {
                if(User::where('phone', $request->email)->first() && User::where('phone', $request->email)->first()->active==0){
                    return response()->json(["status"=>false,'code' => true, 'email'=>$request->email]);
                } else {
                    $validator->errors()->add('email', __('auth.Invalid phone or email or password'));
                    return response()->json($validator->errors(),422);
                }
            } else {
                $validator->errors()->add('email', __('auth.Invalid phone or email or password'));
                return response()->json($validator->errors(),422);
            }
        }
    }

    function vendorLogin(Request $request)
    {
        $email_or_phone =$request->email;
        $email=$email_or_phone_type='';
        if(is_numeric($email_or_phone)) {
            if(!preg_match("/^[+]?[1-9][0-9]{9,14}$/", $email_or_phone)) {
                $email="invalid phone number.";
            }
            $email_or_phone_type = "phone";

        } else {
            if (!filter_var($email_or_phone, FILTER_VALIDATE_EMAIL)) {
                $email="invalid email address.";
            }
            $email_or_phone_type = "email";
        };

        $validator = Validator::make($request->all(), [
            'password' => 'required',

        ]);
        if(!isset($request->email)) {
            $validator->after(function ($validator) {
                $validator->errors()->add('email', __('auth.The email or phone field is required.'));
            });
        }
        elseif(strlen($email)>0) {
            $validator->after(function ($validator) {
                $validator->errors()->add('email', __('auth.Invalid phone or email'));
            });
        };


        if ($validator->fails())
        {
            return response()->json($validator->errors(),422);

        } else {
            if ($email_or_phone_type=="email" &&\Auth::attempt(['email' => $request->email, 'password' => $request->password,'active' => 1, 'role_id' => 1])) {
                return response()->json(["status"=>true]);
            } elseif($email_or_phone_type =="phone" &&\Auth::attempt(['phone' => $request->email, 'password' => $request->password,'active' => 1, 'role_id' => 1])) {
                return response()->json(["status"=>true]);
            } elseif($email_or_phone_type =="phone" && !\Auth::attempt(['phone' => $request->email, 'password' => $request->password,'active' => 1, 'role_id' => 1])) {
                if(User::where('phone', $request->email)->first() && User::where('phone', $request->email)->first()->active_phone==0){
                    return response()->json(["status"=>false,'code' => true, 'phone'=>$request->email]);
                } else {
                    $validator->errors()->add('email', __('auth.Invalid phone or email or password'));
                    return response()->json($validator->errors(),422);
                }
            } else {
                $validator->errors()->add('email', __('auth.Invalid phone or email or password'));
                return response()->json($validator->errors(),422);
            }
        }

    }
}
