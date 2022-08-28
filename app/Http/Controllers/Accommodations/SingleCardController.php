<?php

namespace App\Http\Controllers\Accommodations;

use App\Models\Accommodation;
use App\Models\Crm;
use App\Models\Rating;
use App\Models\Room;
use App\Services\Accommodations\SingleCartService;
use App\Services\Api\TravelLineService;
use App\Services\RoomService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SingleCardController extends Controller
{
    /**
     * @var SingleCartService
     */
    protected SingleCartService $service;
    protected $travel_line_service;
    protected $room_service;

    public function __construct(SingleCartService $service,RoomService $room_service, TravelLineService  $travel_line_service)
    {
        $this->service = $service;
        $this->room_service = $room_service;
        $this->travel_line_service = $travel_line_service;
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(Request $request, $locale = null, $id = null)
    {
        $room_desc = Room::where('roomable_id',Accommodation::where('id',$id)->first()->accommodationable->id)->get();
        $roomDesc = [];
        foreach($room_desc as $item){
            array_push($roomDesc,$item->description);
        }
//        return $roomDesc;

//        Room::where();
        if($id){
            $data = [];
            $rooms = [];
            $available_room_info = [];
            $travel_line_type_id = 1;
            $accommodation = $this->service->show($id);
            if(is_null($accommodation)) {
                return redirect('/');
            }
            if ($accommodation->chanelObject) {
                $channel_object = $this->travel_line_service->getObjectById($accommodation->chanelObject->accommodation_crm_code);
//            $data['room_types'] = array_column(array_map(function($key, $value) {
//                return [$value['id'], $value['name']];
//            }, array_keys($channel_object['roomTypes']), $channel_object['roomTypes']), 1, 0);
                $data['rate_plans'] = array_column(array_map(function($key, $value) {
                    return [$value['id'], $value['name']];
                }, array_keys($channel_object['ratePlans']), $channel_object['ratePlans']), 1, 0);
            }

            $info = $request->all();
            $info['accId'] = $id;
            $period = (isset($info['check_in']) && isset($info['check_out'])) ? $info['check_in'].'-'.$info['check_out'] : '';
            if( $period != '' ) {
                $dates = explode('-', $period);
                if( count($dates) > 1 ) {
                    $check_in = $dates[0];
                    $check_out = $dates[1];
                }
            }
            if( !isset($check_in) && !isset($check_out) ) {
                $check_in = \Illuminate\Support\Carbon::today()->format('m/d/Y');
                $check_out = \Illuminate\Support\Carbon::tomorrow()->format('m/d/Y');
            }
            $carbonIn = \Illuminate\Support\Carbon::createFromFormat('m/d/Y', $check_in);
            $carbonOut = \Illuminate\Support\Carbon::createFromFormat('m/d/Y', $check_out);
            $days = 1;
            $date_diff = $carbonIn->diffInDays($carbonOut);
            if( $date_diff != null && is_numeric($date_diff) && $date_diff > 0 ) {
                $days = $carbonIn->diffInDays($carbonOut);
            }
            $info['datefilter'] = $period;
            $can_review = false;
            if( $user = Auth::user() ) {
                $latest_order = $user->orders()->where('object_id', $id)->latest('check_out')->first();
                if( !is_null($latest_order) ) {
                    $latest_rating = Rating::where(['user_id'=> $user->id,'accommodation_id' => $id])->latest()->first();
                    if( !is_null($latest_rating) ) {
                        $latest_order_date = new Carbon($latest_order->check_out);
                        $diff = $latest_rating->created_at->gt($latest_order_date);
                        if(!$diff) {
                            $can_review = true;
                        }
                    } else {$can_review = true;}
                }
            }
            $data['can_review'] = $can_review;
            $channel_object_id = $accommodation->chanelObject ? $accommodation->chanelObject->accommodation_crm_code : null;
            if( in_array($accommodation->type, ['hotel', 'youth_hotel']) && !is_null($channel_object_id) ) {
                $info['object_id'] = $channel_object_id;
                $book_info = $this->room_service->checkAvailability($info, 'withDC');
                $rooms = $book_info['rooms'];
                $available_room_info = $book_info['available_room_info'];
            } else {
                $rooms = Accommodation::where('id', $accommodation->id)->with(['services', 'amenities', 'images'])->get();
            }
            $country = $accommodation->country()->first();
            $city = $accommodation->city()->first();
            $countryName = $country != null ? ($country->name != '' ? $country->name : '') : '';
            $cityName = $city != null ? ($city->name != '' ? $city->name : '') : '';

            $data['days'] = $days;
            $data['available_room_info'] = $available_room_info;
            $data['rooms'] = $rooms;
//            return $data['rooms'];
            $data['country'] = $countryName;
            $data['city'] = $cityName;
            $data['accommodation'] = $accommodation;
        }
        else {
            return redirect('/');
        }
        $i =1;
        $child_ages = [];
        while ($request->has('child_age_'.$i)){
            $child_age = 'child_age_'.$i;
            array_push($child_ages,$request->$child_age);
            $i++;
        }
        $data['child_ages'] = $child_ages;
//        return $accommodation->chanelObject->accommodation_crm_code;
        if (isset($accommodation->chanelObject->accommodation_crm_code)){
            $travelLineApi = new TravelLineService;
            $dataRoomStays['propertyId'] = $accommodation->chanelObject->accommodation_crm_code;
            $dataRoomStays['adults'] = $request->adults;
            $dataRoomStays['childAges'] = $child_ages;
            $dataRoomStays['arrivalDate'] = isset($_GET['check_in'])?Carbon::createFromFormat('m/d/Y', $request->check_in)->format('Y-m-d'):date('Y-m-d');
            $dataRoomStays['departureDate'] = isset($_GET['check_out'])?Carbon::createFromFormat('m/d/Y', $request->check_out)->format('Y-m-d'):date('Y-m-d', strtotime('tomorrow'));
            $room_stays = $travelLineApi->getAvailableRoomIds($dataRoomStays);
            $data['room_stays'] = $room_stays;
        }

//        dd($data);
        return view('accommodations.single_card',$data);
    }

}
