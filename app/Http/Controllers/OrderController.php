<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\Crm;
use App\Models\Payment;
use App\Models\Service;
use App\Models\TypeName;
use App\Services\Api\TravelLineService;
use App\Services\RoomService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Services\LifePayService;
use App\Models\Accommodation;
use PHPUnit\Exception;

class OrderController extends Controller
{
    protected $lifePayService;

    public function __construct(LifePayService $lifePayService)
    {
        $this->lifePayService = $lifePayService;
    }

    public function  filterCountry(Request $request){
        $country = Country::where('iso3',$request->country_iso3)->first();
        return City::where('country_id', $country->id)->get(['id', 'name']);
    }

    public function index(Request $request)
    {

//        $user = auth()->user();
//        if($user->id === 2) {
//            return redirect()->route('home');
//        }
//        $request->validate([
//            'check_in' => 'required',
//            'check_out' => 'required',
//            'adults' => 'required',
//            'room' => 'required|exists:rooms,id'
//        ]);
        $rules = [
            'check_in' => 'required',
            'check_out' => 'required',
            'adults' => 'required',
            'room' => 'required_if:accommodation,null',
            'accommodation' => 'required_if:room,null'
        ];

        $messages = [
            'required' => ':attribute is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, ['phone' => 'tel']);

        if ($validator->fails()) {
            $validator->setAttributeNames(['phone' => 'tel']);
            return redirect()->back()->withErrors($validator->errors());
        }

        $countries = Country::get();
        if ($request->room) {
            $room = Room::where('id', $request->room)->with(
                [
                    'type',
                    'roomable.accommodation.city.country',
                    'roomable.accommodation.check_ins',
                    'roomable.accommodation.check_outs',
                    'roomable.accommodation.policies',
                ]
            )->first();
        } else {
            $accommodation = Accommodation::where('id', $request->accommodation)->with(
                [
                    'city.country',
                    'check_ins',
                    'check_outs',
                    'policies',
                ]
            )->first();

            $room = new Room();
            $room->id = $accommodation->id;
            $room->price = $accommodation->price;
            $room->setRelation('roomable', new Appartment());
            $room->roomable->setRelation('accommodation', $accommodation);
        }

        $request_params = $request->except(['place_name', 'place_id', 'place_type', 'room']);

        $check_in = Carbon::createFromFormat('m/d/Y', $request_params['check_in']);
        $check_out = Carbon::createFromFormat('m/d/Y', $request_params['check_out']);
        $request_params['date_diff'] = $check_in->diffInDays($check_out);
        $payment_types = Payment::all(['id', 'name']);
        $acc_id = Accommodation::where('accommodationable_id',$room->roomable_id)->first()->id;
        $crm_code = Crm::where('accommodation_id',$acc_id)->first()->accommodation_crm_code;

        $travelLineApi = new TravelLineService;
        $i =0;
        $child_ages = [];
        while ($request->has('child_age_'.$i)){
            $child_age = 'child_age_'.$i;
            array_push($child_ages,$request->$child_age);
            $i++;
        }
        return view('booking-page', [
            'countries' => $countries,
            'room' => $room,
            'request_params' => $request_params,
            'payment_types' => $payment_types,
            'child_ages' => $child_ages
        ]);
    }

    public function viewOrder($id)
    {
        $order = Order::where('id', $id)->first();
        dd($order);
        return view('success-booking', [
            'order' => $order,
        ]);
    }

    public function viewOrderSuccess(Request $request)
    {
        //$request->validate([
        //    'order_id' => 'required',
        //    'tid' => 'required'
        //]);
        if (!$request->has('order_id')) {
            abort('404');
        }
        $order = Order::where('order_id',$request->order_id)->first();
        $accommodation = Accommodation::find($order->object_id);
        if($order) {
            if($request->has('tid')) {
                $order->update(['transaction_id' => $request->tid]);
            }
//            $travelLineApi = new TravelLineService;
//            $booking_params = json_decode($order->booking_params, true);
//            $booking_create  = $travelLineApi->createBooking($booking_params);
            $mail_data=[
                'recipient' => $order->email,
                'fromEmail' => "ruking@mail.ru",
                'fromName' => 'Ruking',
                'subject' => __('booking.booking_made'),
                'object_name' => $order->object_title,
                'check_in' => $order->check_in,
                'check_out' => $order->check_out,
                'price' => $order->price,
                'lang' => \App::getLocale(),
                'object_id' =>$order->object_id,
                'object_type' => $order->roomType(),
                'guests' =>$order->name." ". $order->lastName
            ];
            try {
            Mail::send('emails.makeOrder',$mail_data,function($message) use($mail_data){
                $message->to($mail_data['recipient'])
                    ->from($mail_data['fromEmail'],$mail_data['fromName'])
                    ->subject($mail_data['subject']);
            });
            } catch (\Exception $e) {
                // $e->getMessage();
            }
            return view('success-booking', [
                'order' => $order,
                'accommodation' => $accommodation
            ]);
        }
        return redirect()->back();
    }

    public function makeOrder($locale, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20', 'min:2'],
            'last_name' => ['required', 'string'],
            'email'=> ['required', 'email'],
            'phone' => ['required'],
            'payment_type_id' => ['required'],
            'cityzen' => 'required'

        ]);

        $input = $request->all();

        $carbonIn = \Illuminate\Support\Carbon::createFromFormat('m/d/Y', $input['checkin_date']);
        $carbonOut = \Illuminate\Support\Carbon::createFromFormat('m/d/Y', $input['checkout_date']);
        $date_diff = $carbonIn->diffInDays($carbonOut);
        if (isset($input['room_id'])) {
            $room = Room::where('id', $input['room_id'])->with(
                [
                    'type',
                    'roomable.accommodation.city.country',
                    'roomable.accommodation.check_ins',
                    'roomable.accommodation.check_outs',
                    'roomable.accommodation.policies'
                ]
            )->first();
            $accommodation = $room->roomable->accommodation;
        } else {
            $accommodation = Accommodation::where('id', $request->accommodation)->with(
                [
                    'city.country',
                    'check_ins',
                    'check_outs',
                    'policies'
                ]
            )->first();
            $room = new Room();
            $room->id = $accommodation->id;
            $room->price = $accommodation->price;
            $room->setRelation('roomable', new Appartment());
            $room->roomable->setRelation('accommodation', $accommodation);
        }

        $placements_arr = explode('_', $request->placement_code);
        $placements = [];
        foreach ($placements_arr as $placement) {
            $placements[]['code'] = $placement;
        }
        $data_verify['propertyId'] = $accommodation->chanelObject->accommodation_crm_code;
        $data_verify['arrivalDateTime'] = Carbon::createFromFormat('m/d/Y', $request->checkin_date)->format('Y-m-d').'T14:00';
        $data_verify['departureDateTime'] = Carbon::createFromFormat('m/d/Y', $request->checkout_date)->format('Y-m-d').'T12:00';
        $data_verify['rate_plan_id'] = $request->rate_plan_id;
        $data_verify['room_type_id'] = $room->code_from_api;
        $data_verify['code'] = $request->placement_code;
        $data_verify['count'] = $request->room_count;
        $data_verify['firstName'] = $request->name;
        $data_verify['lastName'] = $request->last_name;
        $data_verify['middleName'] = '';
        $data_verify['citizenship'] = $request->cityzen;
        $data_verify['sex'] = $request->gender;
        $data_verify['adultCount'] = $request->adults;
        $data_verify['childAges'] = $request->child_ages;
        $data_verify['service_id'] = [];
        $data_verify['checksum'] = $request->checksum;
        $data_verify['service_id2'] = [];
        $data_verify['phone'] = $request->phone;
        $data_verify['email'] = $request->email;

        $travelLineApi = new TravelLineService;

        $acc_id = Accommodation::where('accommodationable_id',$room->roomable_id)->first()->id;
        $crm_code = Crm::where('accommodation_id',$acc_id)->first()->accommodation_crm_code;

        $verify  = $travelLineApi->verifyBooking($data_verify);
//        dd( $verify);
        $verify_response = $verify['verify_response'];
        $booking_params = $verify['booking_params'];

        if (is_null($verify['verify_response']) || isset($verify_response['errors'])) {
            return redirect()->back()->with('message','Oops! Something happened wrong.');
        } else {
            $booking_params['booking']['createBookingToken'] = $verify_response['booking']['createBookingToken'];
            if($input['payment_type_id']==1){
                $bookingCreate  = $travelLineApi->createBooking($booking_params);
            } else {

            }
        }
        if(isset($bookingCreate['errors'])) {
            return redirect()->back()->with('message','Oops! Something happened wrong.');
        }

        $order = Order::create([
            'name' => $input['name'],
            'lastName' => $input['last_name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
//            'country_id' => $input['country'],
//            'city_id' => $input['city'],
//            'address' => $input['address'],
//            'postcode' => $input['post_code'],
            'user_id' => Auth::user()->id,
//            'room_name' => $room->name->getRawOriginal('name'),
            'object_id' => $room->roomable->accommodation->id,
//            'object_title' => $room->roomable->accommodation->getRawOriginal('title'),
            'data_booking' => date('Y-m-d'),
            'room_id' => $room->id,
            'check_in' => $input['checkin_date'],
            //'check_in_time' => $room->roomable->accommodation->check_ins->from,
            'check_out' => $input['checkout_date'],
            //'check_out_time' => $room->roomable->accommodation->check_outs[0]->to,
            'adults' => $input['adults'],
            'children' => $input['children'],
            'price' => $input['price'],
            'payment' => $input['payment_type_id'],
            //'policies' => '123',
            'special_wishes' => $input['comment'],
            'child_ages' => isset($input['child_ages']) ? json_encode($input['child_ages']) : null,
            'gender' => $input['gender'],
            'citizenship' => $input['cityzen'],
            'channel_id' => 1,
            'booking_params' => json_encode($booking_params, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
            'channel_booking_number' => isset($bookingCreate) ? $bookingCreate['booking']['number'] : null,
            'cancel1' =>$request->cancel1,
            'cancel2' =>$request->cancel2
        ]);


        $available_locales = config('app.available_locales');
        foreach ($available_locales as $available_locale) {
            if(isset($input['room_id'])) {
                $order->setTranslation('room_name', $available_locale, $room->name->getTranslation('name', $available_locale));
            }
            $order->setTranslation('object_title', $available_locale, $room->roomable->accommodation->getTranslation('title', $available_locale));
        }
        $order->update();

        $check_in = Carbon::createFromFormat('m/d/Y', $order->check_in);
        $check_out = Carbon::createFromFormat('m/d/Y', $order->check_out);
        $order->duration = $check_in->diffInDays($check_out);

        if($order['payment'] == 2) {
            $this->lifePayService->process($order);
        } else {
            $mail_data=[
                'recipient' => $order->email,
                'fromEmail' => "ruking@mail.ru",
                'fromName' => 'Ruking',
                'subject' => __('booking.booking_made'),
                'object_name' => $order->object_title,
                'check_in' => $order->check_in,
                'check_out' => $order->check_out,
                'price' => $order->price,
                'lang' => \App::getLocale(),
                'object_id' =>$order->object_id,
                'object_type' => $order->roomType(),
                'guests' =>$order->name." ". $order->lastName
            ];
            try {
                Mail::send('emails.makeOrder',$mail_data,function($message) use($mail_data){
                    $message->to($mail_data['recipient'])
                        ->from($mail_data['fromEmail'],$mail_data['fromName'])
                        ->subject($mail_data['subject']);
                });
            } catch (\Exception $e) {
                // $e->getMessage();
            }
            return view('success-booking', ['order' => $order, 'accommodation' => $accommodation]);
        }
    }
}
