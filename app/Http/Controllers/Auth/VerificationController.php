<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function phone_verify (Request $request)
    {

        $user = User::where([['phone',$request->phone],['sms_code',$request->code]])->first();
        if(!$user) {
            return response()->json(["status"=>false,"message"=>__('auth.you can not use this auth key for activate')]);
        } else {
            $user->update([
                'active_phone'=>1,
                'active' => 1
            ]);
            \Auth::loginUsingId($user->id);

            return response()->json(["status"=>true]);
        }
    }

    public function phone_verify_account (Request $request)
    {

        $user = User::where([['phone',$request->phone],['sms_code',$request->code]])->first();
        if(!$user) {
            return response()->json(["status"=>false,"message"=>__('auth.you can not use this auth key for activate')]);
        } else {
            $user->update([
                'active_phone'=> 1
            ]);

            return response()->json(["status"=>true]);
        }
    }



    public function check_register(Request $request) {

        $user = User::where('phone',$request->phone2)->first();
        if( $user->sms_code != $request->code){
            return "wrong";
        } else if($user->sms_code == $request->code){
            return "ok";

        }


    }


    public function verify($locale, $auth_token) {
        $user = User::where('auth_token',$auth_token)->first();
        if(!$user) {
            return __('auth.you can not use this auth key for activate');
        }
        $user->update([
            'active' => 1,
            'active_email' => 1
        ]);
        \Auth::loginUsingId($user->id);
        return redirect('/'.\App::getLocale().'/account');
     }

    public function vendorVerify($locale, $auth_token) {
        $user = User::where('auth_token',$auth_token)->first();
        if(!$user) {
            return __('auth.you can not use this auth key for activate');
        }
        $user->update([
            'active_email' => 1
        ]);
        if($user->active_phone == 1){
            $user->update([
                'active' => 1
            ]);
            \Auth::loginUsingId($user->id);

            return redirect()->route('user.objects', ['locale' => $locale])->with('success', __('auth.now you can login your account'));
        }else{
            return  redirect('/')->with('notActivePhone','1');
        }

    }

    public function vendorPhoneVerify(Request $request)
    {
        $user = User::where([['phone',$request->phone],['sms_code',$request->code]])->first();
        $user1 = User::where([['active_phone',0],['sms_code',$request->code]])->first();
        if(!$user && !$user1) {
            return response()->json(["status"=>false,"message"=>__('auth.you can not use this auth key for activate')]);
        } else {
            if(!$user){
                $user = $user1;
            }
            $user->update([
                'active_phone'=>1,
            ]);

            if($user->active_email == 1){
                $user->update([
                    'active' => 1
                ]);
                \Auth::loginUsingId($user->id);

                return response()->json(["status"=>true]);


            }else{
                return  redirect('/')->with('notActiveEmail','1');
            }
        }
    }


}
