<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{

    /*
     *
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */





    public function index($locale){
        return view('auth.reset_forgot_password.forgetPassword');
    }

    public function submitForgotLink(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
        ], [
            'email' => __('auth.forgotPassword.email_email'),
            'email.exists' => __('auth.forgotPassword.email_exists')
        ]);

        $user_password = User::where('email',$request->email)->first()->password;
        if($user_password == ''){
            return back()->with('err', __('auth.forgotPassword.no'));
        }
        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $mail_data=[
            'recipient' => $request->email,
            'fromEmail' => "ruking@mail.ru",
            'fromName' => 'Ruking',
            'subject' => __('auth.resetPassword.reset_pass'),
            'token' => $token
        ];
        Mail::send('emails.forgetPassword',$mail_data,function($message) use($mail_data){
            $message->to($mail_data['recipient'])
                ->from($mail_data['fromEmail'],$mail_data['fromName'])
                ->subject($mail_data['subject']);
        });

        return back()->with('mess', __('auth.forgotPassword.ok'));
    }


}
