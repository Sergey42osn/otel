<?php

namespace App\Http\Controllers;

use App\Services\Api\TravelLineService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UserPermission;
use Auth;
use Illuminate\Support\Facades\Mail;
use function PHPUnit\Framework\returnArgument;

class BookingAndReportsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, UserService $userService)
    {
        $user = \Auth::user();
        if ( $user->role_id==3 ) {
            $us = UserPermission::where('user_id', $user->id)->first();
            if ($us) {
                $id = $us->owner_id;
                $user = User::find($id);
                $objectids = $user->accommodations->pluck('id');
                $bookings = Order::whereIn('object_id',$objectids);
                if(isset($request->check_in) && isset($request->check_out)) {
                    $bookings = Order::where([['check_in','>=',$request->check_in],['check_out','<=',$request->check_out]])->whereIn('object_id',$objectids);
                }
                if (!empty($_GET['name'])) {
                    $name= $_GET['name'];
                    $bookings=$bookings->orderBy('name',$name);
                }
                if (!empty($_GET['lastName'])) {
                    $lastName= $_GET['lastName'];
                    $bookings=$bookings->orderBy('lastName',$lastName);
                }
                if (!empty($_GET['data_booking'])) {
                    $data_booking= $_GET['data_booking'];
                    $bookings=$bookings->orderBy('data_booking',$data_booking);
                }
                if(isset($_GET['status']) && $_GET['status']!=""){
                    $bookings_all = $bookings->get();
                    if($_GET['status']=='0'){
                        $bookings_with_status = $bookings->whereNull('status')->get();
                    }else{
                        $bookings_with_status = $bookings->where('status',(int)$_GET['status'])->get();
                    }
                    $arr_unset = [];
                    for($i=0;$i<count($bookings_with_status);$i++){
                        for($j=0;$j<count($bookings_all);$j++){
                            if($bookings_with_status[$i]->id==$bookings_all[$j]->id){
                                array_push($arr_unset,$j);
                            }
                        }
                    }
                    foreach($arr_unset as $item){
                        unset($bookings_all[$item]);
                    }
                    $bookings_all = array_merge($bookings_with_status->toArray(),$bookings_all->toArray());
                    $ids = [];
                    foreach($bookings_all as $item){
                        array_push($ids,$item['id']);
                    }
                    $ids_imploed = implode(',', $ids);
                    $bookings = Order::whereIn('object_id',$objectids)->orderByRaw("FIELD(id, $ids_imploed)");
                }
                $bookings = $bookings->paginate(5);
                return view('auth.vendor.vendor-bookings', ['bookings' => $bookings]);
            }
        } elseif ($user->role_id == 1) {
            $objectids = $user->accommodations->pluck('id');
            $bookings = Order::whereIn('object_id',$objectids);
            if(isset($request->check_in) && isset($request->check_out)) {
                $bookings = Order::where([['check_in','>=',$request->check_in],['check_out','<=',$request->check_out]])->whereIn('object_id',$objectids);
            }
            if (!empty($_GET['name'])) {
                $name= $_GET['name'];
                $bookings=$bookings->orderBy('name',$name);
            }
            if (!empty($_GET['lastName'])) {
                $lastName= $_GET['lastName'];
                $bookings=$bookings->orderBy('lastName',$lastName);
            }
            if (!empty($_GET['data_booking'])) {
                $data_booking= $_GET['data_booking'];
                $bookings=$bookings->orderBy('data_booking',$data_booking);
            }
            if(isset($_GET['status']) && $_GET['status']!=""){
                $bookings_all = $bookings->get();
                if($_GET['status']=='0'){
                    $bookings_with_status = $bookings->whereNull('status')->get();
                }else{
                    $bookings_with_status = $bookings->where('status',(int)$_GET['status'])->get();
                }
                $arr_unset = [];
                for($i=0;$i<count($bookings_with_status);$i++){
                    for($j=0;$j<count($bookings_all);$j++){
                        if($bookings_with_status[$i]->id==$bookings_all[$j]->id){
                            array_push($arr_unset,$j);
                        }
                    }
                }
                foreach($arr_unset as $item){
                    unset($bookings_all[$item]);
                }
                $bookings_all = array_merge($bookings_with_status->toArray(),$bookings_all->toArray());
                $ids = [];
                foreach($bookings_all as $item){
                    array_push($ids,$item['id']);
                }
                $ids_imploed = implode(',', $ids);
                $bookings = Order::whereIn('object_id',$objectids)->orderByRaw("FIELD(id, $ids_imploed)");
            }
            $bookings = $bookings->paginate(5);
            return view('auth.vendor.vendor-bookings', ['bookings' => $bookings]);
        }

        abort(404);
    }
    public function cancel(Request $request){
        $booking = Order::find($request->id);
        $datetime = \Carbon\Carbon::now()->toIso8601ZuluString();
        $booking_number = $booking->channel_booking_number;
        $penalty_data = ['number' => $booking_number, 'cancellationDateTimeUtc' => $datetime];
        $travellineService = new TravelLineService();
        $penalty = $travellineService->calculateCancelPenalty($penalty_data);

        if (isset($penalty['errors'])) {
            return redirect()->back()->with('message','Oops! Something happened wrong.');
        }
        $cancel_data = ['number' => $booking_number, 'reason' => $request->canceled_message, 'expectedPenaltyAmount' => $penalty['penaltyAmount']];
        $cancel = $travellineService->cancelBooking($cancel_data);

        if (isset($cancel['errors'])) {
            return redirect()->back()->with('message','Oops! Something happened wrong.');
        }
        $booking->update([
            'canceled_message' => $request->canceled_message,
            'status' => 2,
            'penalty_amount' => (int)$penalty['penaltyAmount']
        ]);
        $mail_data=[
            'recipient' => $booking->email,
            'fromEmail' => "ruking@mail.ru",
            'fromName' => 'Ruking',
            'subject' => __('booking.cancelBooking'),
            'object_name' => $booking->object_title,
            'check_in' => $booking->check_in,
            'check_out' => $booking->check_out,
            'price' => $booking->price,
            'lang' => \App::getLocale(),
            'object_id' =>$booking->object_id,
            'object_type' => $booking->roomType(),
            'guests' =>$booking->name." ". $booking->lastName
        ];
        Mail::send('emails.cancelBooking',$mail_data,function($message) use($mail_data){
            $message->to($mail_data['recipient'])
                ->from($mail_data['fromEmail'],$mail_data['fromName'])
                ->subject($mail_data['subject']);
        });

//        $data['number'] = $booking->travelline_id;
//        $data['cancellationDateTimeUtc'] = date("Y-m-dTh:i:s");
//        $travelLine = new TravelLineService();
//        $calculate_penalty =$travelLine->calculateCancelPenalty($data);
//
//        $dataCancel['number'] = $booking->id;
//        $dataCancel['reason'] = $booking->canceled_message;
//        $dataCancel['expectedPenaltyAmount'] = $calculate_penalty->penaltyAmount;
//        $travelLine = new TravelLineService();
//        $travelLine->cancelBooking($dataCancel);

        return back();
    }
}
