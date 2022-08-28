<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Socialite;

use Auth;

use Exception;

use App\Models\User;

class SocialLoginController extends Controller

{

    use AuthenticatesUsers;

    public function __construct()

    {

        $this->middleware('guest')->except('logout');

    }

    public function redirectToGoogle()

    {

        return Socialite::driver('google')->redirect();

    }

    public function redirectToVk()

    {

        return Socialite::driver('vkontakte')->redirect();

    }
    public function redirectToOk()

    {

        return Socialite::driver('odnoklassniki')->redirect();

    }


    public function handleGoogleCallback()

    {

        //try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('email', $user->email)->first();

            if($finduser){
                if(empty($finduser->password)){
                    Auth::login($finduser);
                    return redirect('/account');
                } else {
                    return redirect('/')->with(['userExist' => __('auth.user already exist'), 'open_login_modal'=> 1]);
                }
            } else {

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'active' => 1
                ]);

                Auth::login($newUser);

                return redirect('/account');

            }

       // } catch (Exception $e) {

          //  return redirect('/');

      //  }

    }
    public function handleVkCallback()

    {

        try {

        $user = Socialite::driver('vkontakte')->user();
        if ($user->email) {
            $email = $user->email;
        } else {
            $email = $user['id']."@mail.ru";
        }
        $finduser = User::where('email', $email)->first();

        if($finduser){
            if(empty($finduser->password)){
                Auth::login($finduser);
                return redirect('/account');
            } else {
                return redirect('/')->with(['userExist' => __('auth.user already exist'), 'open_login_modal'=> 1]);
            }
        } else {

            $newUser = User::create([
                'name' => explode(" ",$user->name)[0],
                'last_name' => explode(" ",$user->name)[1],
                'email' => $email,
                'active' => 1
            ]);

            Auth::login($newUser);

            return redirect('/account');

        }

         } catch (Exception $e) {

          return redirect('/');

          }

    }
    public function handleOkCallback()

    {

        try {

            $user = Socialite::driver('odnoklassniki')->user();
            if ($user->email) {
                $email = $user->email;
            } else {
                $email = $user['uid']."@mail.ru";
            }
            $finduser = User::where('email', $email)->first();

            if($finduser){
                if(empty($finduser->password)){
                    Auth::login($finduser);
                    return redirect('/account');
                } else {
                    return redirect('/')->with(['userExist' => __('auth.user already exist'), 'open_login_modal'=> 1]);
                }
            } else {

                $newUser = User::create([
                    'name' => explode(" ",$user->name)[0],
                    'last_name' => explode(" ",$user->name)[1],
                    'email' => $email,
                    'active' => 1
                ]);




                Auth::login($newUser);

                return redirect('/account');

            }

        } catch (Exception $e) {

         return redirect('/');

         }
    }
}
