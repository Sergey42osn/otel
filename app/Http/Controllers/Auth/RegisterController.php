<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\Api\NewTelService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Mail;
use App\Mail\SendActivationMail;
use App\Mail\SendActivationVendorMail;
use App\Mail\SendInfoForRegMail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function customerLogin()
    {
        return view('customer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'min:2', 'max:20'],
                'last_name' => ['required', 'string', 'min:2', 'max:20'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:10', 'max:20', 'confirmed'],
                'agree' => ['required']
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create(
            [
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]
        );
    }
  function registration(Request $request)
    {
//        customer
        $auth_token = Str::random(36);
        $sms_code = rand(1000,9999);
        $email_or_phone =$request->email;
        $email='';
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
            'name' => 'required|min:3',
            'last_name' =>  'required|min:3',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'agree' => 'required'
         ]);
          if(!isset($request->email)) {
              $validator->after(function ($validator) {
                  $validator->errors()->add('email', __('auth.The email or phone field is required.'));
              });
          } elseif($email_or_phone_type=="email" && User::where('email',$request->email)->first()) {
              $validator->after(function ($validator) {
                  $validator->errors()->add('email', __('auth.The email has already been taken.'));
              });
          } elseif($email_or_phone_type=="phone" && User::where('phone',$request->email)->first()) {
             $validator->after(function ($validator) {
                  $validator->errors()->add('email', __('auth.The phone number has already been taken.'));
            });
          } elseif(strlen($email)>0) {
              $validator->after(function ($validator) {
                  $validator->errors()->add('email', __('auth.Invalid phone or email'));
              });
          };
        if ($validator->fails())
        {
            return response()->json($validator->errors(),422);
        } else {
          $user1 = User::create(
                [
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => ($email_or_phone_type=="email")?$request->email:'',
                    'phone' => ($email_or_phone_type!="email")?$request->email:'',
                    'sms_code' => ($email_or_phone_type!="email")?$sms_code:'',
                    'password' => Hash::make($request->password),
                    'agree' => 1,
                    'role_id' => 2
                ]
            );
            if ($email_or_phone_type=="email") {
                $new_user  = User::where('email',$request->email)->first();
                $new_user->update([
                    'auth_token' => $auth_token,
                ]);
                $maildata = [
                    'title'=>__('auth.Activation mail title'),
                    'auth_token'=>$auth_token,
                    'body' =>__('auth.Activation mail content'),
                    'submit' =>__('auth.Activate'),
                ];
                Mail::to($request->email)->send(new SendActivationMail($maildata));
                return response()->json(["status"=>true,"email"=>$request->email,'sms_code'=>false]);
            }else if($email_or_phone_type=="phone"){

                $smsservice = new NewTelService();
                $smsservice->send($request->email,$sms_code);
                return response()->json(["status"=>true,"email"=>$request->email,'sms_code'=>true, 'code'=>$sms_code]);
            } else {
                return response()->json(["status"=>true,"email"=>'']);
            }
        }
    }
function registrationVendor(Request $request)
    {
        $auth_token = Str::random(36);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'last_name' =>  'required|min:3',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'agree' => 'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required|numeric|unique:users'
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors(),422);
        } else {
            $sms_code = rand(1000,9999);
            User::create(
                [
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' =>$request->phone,
                    'sms_code' =>$sms_code,
                    'password' => Hash::make($request->password),
                    'agree' => 1,
                    'role_id' => 1
                ]
            );
            $sms = new NewTelService();
            $t = $sms->send($request->phone,$sms_code);

            $new_user  = User::where('email',$request->email)->first();


            $new_user->update([
                'auth_token' => $auth_token,
            ]);
            $maildata = [
                'title'=>__('auth.Activation mail title'),
                'auth_token'=>$auth_token,
                'body' =>__('auth.Activation mail content'),
                'submit' =>__('auth.Activate'),
            ];
            Mail::to($request->email)->send(new SendActivationVendorMail($maildata));
            Mail::to('noreplay@ruking.ru')->send(new SendInfoForRegMail());
            return response()->json(["status"=>true,"email"=>$request->email,"phone"=>$request->phone]);
        }
    }
}
