<?php

namespace App\Http\Controllers;
use App\Mail\SendActivationMail;
use App\Models\Accommodation;
use App\Models\User;
use App\Models\Rating;
use App\Models\Post;
use App\Models\Order;
use App\Models\WishList;
use App\Rules\MatchOldPassword;
use App\Services\Api\NewTelService;
use App\Services\Api\TravelLineService;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use Carbon\Carbon;

class AccountController extends Controller
{

    protected UserService $userService;
    protected TravelLineService $travelLineService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService, TravelLineService $travelLineService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
        $this->travelLineService = $travelLineService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();
        if($user->role_id==1){
            return view('auth.vendor.vendor-objects', ['user' => $this->userService->objects()]);
        }
        if($user->role_id==2){
            return view('account.index', ['user' => $user]);
        }
        abort(404);
    }

    public function security()
    {

        $user = \Auth::user();
        if($user->role_id==2){
            return view('account.security', ['user' => $user]);
        }
        abort(404);

    }

    public function favourites()
    {
        if(\Auth::user()->role_id==2){
            $wishs = WishList::where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC')->get();
            return view('account.favourites', ['wishs' => $wishs]);
        }
        abort(404);
    }



    public function updateWish(Request $request){
        WishList::find($request->id)->delete();
        return response()->json(["status"=>true]);

    }
    public function bookingHistory(Request $request)
    {
        if(\Auth::user()->role_id==2){
            if($request->type!=''){
                $booking_ids = Order::where('user_id',\Auth::user()->id)->pluck('object_id');
                $ids = [];
                foreach ($booking_ids as $booking_id){
                    if($acc=Accommodation::find($booking_id)){
                        if($acc->type == $request->type){
                            array_push($ids,$acc->id);
                        }
                    }
                }
                $bookings = Order::where('user_id',\Auth::user()->id)->whereIn('object_id',$ids)->orderBy('created_at', 'desc')->get();
            }else{
                $bookings = Order::where('user_id',\Auth::user()->id)->orderBy('created_at', 'desc')->get();

            }

            return view('account.booking-history',['bookings' =>$bookings]);
        }
        abort(404);
    }

    public function checkPenalty(Request $request)
    {
        $order = Order::find($request->get('orderId'));
        $penalty_data = ['number' => $order->channel_booking_number, 'cancellationDateTimeUtc' => Carbon::now()->toIso8601ZuluString()];
        $penalty = $this->travelLineService->calculateCancelPenalty($penalty_data);
        return response()->json(['penalty_amount' => $penalty['penaltyAmount'], 'message' => __('booking.penalty_check_message').' '.$penalty['penaltyAmount'].__('rooms.currency')]);
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
            $sms_code = rand(1000, 9999);
            $smsservice = new NewTelService();
            $smsservice->send( $request->phone,$sms_code);
            $user = User::find(\Auth::user()->id);
           $user->update(['phone'=> $request->phone, 'active_phone'=>0, 'sms_code'=>$sms_code]);
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
            User::find(\Auth::user()->id)->update([
                'avatar'=> $name
            ]);
        }
       return back();

    }
}
