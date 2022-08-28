<?php

namespace App\Http\Controllers;
use App\Mail\SendActivationMail;
use App\Models\User;
use App\Models\Rating;
use App\Models\Post;
use App\Models\WishList;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();
        return view('account.index', ['user' => $user]);
    }

    public function security()
    {
        $user = \Auth::user();
        return view('account.security', ['user' => $user]);
    }

    public function favourites()
    {
        $wishs = WishList::where('user_id', \Auth::user()->id)->get();
        return view('account.favourites', ['wishs' => $wishs]);
    }


    public function updateWish(Request $request){
        WishList::find($request->id)->delete();
        return response()->json(["status"=>true]);

    }
    public function bookingHistory()
    {
        return view('account.booking-history');
    }

    public function deleteAccount()
    {
        $posts = Post::where('user_id',\Auth::user()->id)->get();
        foreach ($posts as $post) {
            $post->delete();
        }
        $ratings = Rating::where('user_id',\Auth::user()->id)->get();
        foreach ($ratings as $rating) {
            $rating->delete();
        }
        User::find(\Auth::user()->id)->delete();

        return redirect("/customer");
    }

    public function logout()
    {

        \Session::flush();

        \Auth::logout();
        return redirect("/customer");
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors(),422);

        } else {
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
            return response()->json(["status"=>true]);
        }
    }
    public function changeName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'last_name' => ['required'],
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors(),422);

        } else {
            User::find(auth()->user()->id)->update(['name'=> $request->name,'last_name'=>$request->last_name]);
            return response()->json(["status"=>true]);
        }
    }
    public function changeGender(Request $request)
    {
        User::find(auth()->user()->id)->update(['gender'=> $request->gender]);
        return response()->json(["status"=>true]);

    }
    public function changeEmail(Request $request)
    {
        $auth_token = Str::random(36);
        $user = \Auth::user();

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors(),422);

        } elseif(\Auth::user()->email != $request->email) {
            User::find(auth()->user()->id)->update(['email'=> $request->email,'auth_token' => $auth_token,'active'=>0]);
            $maildata = [
                'title'=>__('auth.Activation mail title'),
                'auth_token'=>$auth_token,
                'body' =>__('auth.Activation mail content'),
                'submit' =>__('auth.Activate'),
            ];
            Mail::to($request->email)->send(new SendActivationMail($maildata));
        }
        return response()->json(["status"=>true]);

    }
    public function changePhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required'],
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors(),422);

        } else {
            User::find(auth()->user()->id)->update(['phone'=> $request->phone]);
            return response()->json(["status"=>true]);
        }
    }
    public function changeAddress(Request $request)
    {
        User::find(auth()->user()->id)->update([
            'country'=> $request->country,
            'city'=> $request->city,
            'address'=> $request->address,
            'postal_code'=> $request->postal_code
        ]);
        return response()->json(["status"=>true]);
    }
    public function uploadAvatar(Request $request)
    {
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $name=time().$file->getClientOriginalName();
            $file->move(public_path().'/images/users/avatar', $name);
            User::find(auth()->user()->id)->update([
                'avatar'=> $name
            ]);

        }
        return back();

    }
}
