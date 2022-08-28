<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Crm;
use App\Models\Room;
use App\Models\Type;
use App\Models\TypeName;
use App\Models\Hotel;
use App\Models\Amenity;
use App\Models\Service;
use App\Services\Api\TravelLineService;
use App\Services\RoomService;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Requests\RoomFormRequest;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    protected $roomService;
    protected $travel_line_service;
    public function __construct(RoomService $roomService, TravelLineService $travel_line_service)
    {
        $this->roomService = $roomService;
        $this->travel_line_service = $travel_line_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        $url = 'https://partner.qatl.ru/api/content/v1/properties?since=1000&count=200&include=all';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'X-API-KEY: 47306034-78fc-4767-bfd9-25el8825b003',
            'Content-Type: application/json'
        ]);
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);
        $property_ids = [];
        foreach ($response->properties as $item){
            array_push($property_ids,$item->id);
        }
        $crm = Crm::where('accommodation_id',Accommodation::where('accommodationable_id',$request->hotel_id)->first()->id)->first();
        $response_status = 1;
        $response='{}';
        $roomTypesId = [];
        $roomTypesName = [];
        $ratePlansId = [];
        $ratePlansName = [];
        if($crm){
            if($crm->sale_channel_id == 1){
                $url = 'https://partner.qatl.ru/api/content/v1/properties/'.$crm->accommodation_crm_code;
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, [
                    'X-API-KEY: 47306034-78fc-4767-bfd9-25el8825b003',
                    'Content-Type: application/json'
                ]);

                $response = curl_exec($curl);

                curl_close($curl);
                $response_status = 0;
            }
            $response = json_decode($response);
//            return $response;

            if(isset($response->errors)){
                $response_status = 1;
            }
            if($response_status == 0) {
                foreach ($response->roomTypes as $item) {
                    array_push($roomTypesName,$item->name);
                    array_push($roomTypesId, $item->id);
                }
//                $roomTypesName = ['roomType1' , 'roomType2'];
//                $roomTypesId = ['3','4'];
                foreach ($response->ratePlans as $item) {
                    array_push($ratePlansName,$item->name);
                    array_push($ratePlansId, $item->id);
                }
            }
        }
        return view('registration.room-planing', [
            'services' => Service::all(['id', 'name']),
            'amenities' => Amenity::where('general',1)->get(['id', 'name']),
            'types' => Type::where('type', 'Room')->orWhere('user_id', Auth::user()->id)->get(['id', 'name', 'type']),
            'hotel_id' => request()->hotel_id,
            'response'=> $roomTypesId,
            'roomTypesNames' => $roomTypesName,
            'ratePlansIds' => $ratePlansId,
            'ratePlansNames' => $ratePlansName,
            'response_status' => $response_status
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomFormRequest $request)
    {
        $hotel = $this->roomService->store($request);

        if($request->type==2){
            Accommodation::where('accommodationable_id',$hotel->accommodationable_id)->update([
                'price' => $request->price
            ]);
        }

        $acc_type = Accommodation::where('accommodationable_id',$request->hotel_id)->first()->type;
        if($acc_type == 'hotel'){
            return redirect()->route('hotels.show', ['locale' => app()->getLocale(), 'hotel' => $hotel]);
        }
        if ($acc_type == 'youth_hotel'){
            return redirect()->route('youth-hotels.show', [ 'locale' => app()->getLocale(),'youth_hotel' => $hotel]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($locale, Room $room, Request $request)
    {
        $url = 'https://partner.qatl.ru/api/content/v1/properties?since=1000&count=200&include=all';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'X-API-KEY: 47306034-78fc-4767-bfd9-25el8825b003',
            'Content-Type: application/json'
        ]);
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);
        $property_ids = [];
        foreach ($response->properties as $item){
            array_push($property_ids,$item->id);
        }
//        return $property_ids;


        $crm = Crm::where('accommodation_id',Accommodation::where('accommodationable_id',$room->roomable_id)->first()->id)->first();
        $response_status = 1;
        $response='{}';
        $roomTypesId = [];
        $roomTypesName = [];
        $ratePlansId = [];
        $ratePlansName = [];
        if($crm){
//            return $crm;
            if($crm->sale_channel_id == 1){
                $url = 'https://partner.qatl.ru/api/content/v1/properties/'.$crm->accommodation_crm_code;
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, [
                    'X-API-KEY: 47306034-78fc-4767-bfd9-25el8825b003',
                    'Content-Type: application/json'
                ]);

                $response = curl_exec($curl);
                curl_close($curl);
                $response_status = 0;
            }
            $response = json_decode($response);
            if(isset($response->errors)){
                $response_status = 1;
            }

            if($response_status == 0) {
                foreach ($response->roomTypes as $item) {
                    array_push($roomTypesName,$item->name);
                    array_push($roomTypesId, $item->id);
                }
//                $roomTypesName = ['roomType1' , 'roomType2'];
//                $roomTypesId = ['3','4'];
                foreach ($response->ratePlans as $item) {
                    array_push($ratePlansName,$item->name);
                    array_push($ratePlansId, $item->id);
                }
            }
        }
        return view('registration.edit-room', [
            'room' => $room,
            'types' => Type::where('type', 'Room')->orWhere('user_id', Auth::user()->id)->get(['id', 'name', 'type']),
            'type_names' => TypeName::where('type_id',$room->type_id)->get(),
            'services' => Service::all(['id', 'name'])->whereNotIn('id', $room->services->pluck('id')),
            'amenities' => Amenity::where('general',1)->get(['id', 'name']),
            'response'=> $roomTypesId,
            'roomTypesNames' => $roomTypesName,
            'ratePlansIds' => $ratePlansId,
            'ratePlansNames' => $ratePlansName,
            'response_status' => $response_status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($locale, RoomFormRequest $request, Room $room)
    {
        if($request->type==2){
            Accommodation::where('accommodationable_id',$room->roomable_id)->update([
                'price' => $request->price
            ]);
        }
        $this->roomService->update($request, $room);
        $hotel = Hotel::find($room->roomable_id);
        $acc_type = Accommodation::where('accommodationable_id',$hotel->id)->first()->type;
        if($acc_type == 'hotel'){
            return redirect()->route('hotels.show', ['locale' => app()->getLocale(), 'hotel' => $hotel]);
        }
        if ($acc_type == 'youth_hotel'){
            return redirect()->route('youth-hotels.show', [ 'locale' => app()->getLocale(),'youth_hotel' => $hotel]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($locale,Room $room)
    {
        if (request()->ajax()) {

            $res = response()->json(["id" => $room->id]);
            $this->roomService->delete($room);
            return $res;
        }

        $this->roomService->delete($room);
        return back();
    }
    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function checkAvailability(Request $request)
    {
        $not_found_text = '<p class="not-found ms-2 mt-2">'.__('rooms.not_found').'</p>';
        $child_ages = [];
        $errors = false;
        $child_max_age = 12;

        $data = $request->all();
        $child_count = $request->input('children');
        $accommodation_id = $request->input('accId');
        $accommodation = Accommodation::find($accommodation_id);
        $data['object_id'] = $accommodation->chanelObject->accommodation_crm_code;
        $book_info = $this->roomService->checkAvailability($data, 'withDC');
        $days = isset($book_info['days']) ? $book_info['days'] : 1;
        $rooms = $book_info['rooms'];
        $child_ages = isset($book_info['child_ages']) ? $book_info['child_ages'] : [];
        $available_room_info = isset($book_info['available_room_info']) ? $book_info['available_room_info'] : [];
        $channel_object = $this->travel_line_service->getObjectById($accommodation->chanelObject->accommodation_crm_code);
        $rate_plans = array_column(array_map(function($key, $value) {
            return [$value['id'], $value['name']];
        }, array_keys($channel_object['ratePlans']), $channel_object['ratePlans']), 1, 0);
        $view = '';
        if( in_array($accommodation->type, ['hotel', 'youth_hotel']) ) {
            if( $rooms->isNotEmpty() ) {
                foreach( $rooms as $room ) {
                    if(isset($available_room_info[$room->code_from_api][$room->api_plane_id])) {
                        $view .= view('accommodations.room', compact(['room', 'accommodation', 'child_ages', 'available_room_info', 'rate_plans']));
                    }
                }
            } else {$errors = true;}
        } else {
            if($accommodation != null) {
                $room = $accommodation;
                $view .= view('accommodations.room', compact(['room', 'accommodation', 'child_ages']));
            } else {
                $errors = true;
            }
        }
        if( $errors ) { $view = $not_found_text;}
        return compact('view', 'days');
    }

    public function filter(Request $request){
        return TypeName::where('type_id', $request->type)
            ->get(['id', 'name', 'type_id']);
    }
}
