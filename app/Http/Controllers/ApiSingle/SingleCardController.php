<?php

namespace App\Http\Controllers\ApiSingle;

use App\Models\Accommodation;
use App\Models\Crm;
use App\Models\Rating;
use App\Models\Room;

use App\Services\IslandService;

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
    protected Accommodation $service;
    protected IslandService $IslandService;
    protected $travel_line_service;
    protected $room_service;

    protected $id;

    public function __construct(IslandService $IslandService)
    {
        $this->IslandService = $IslandService;

       // $this->service = $service;

        //$this->init();
    }

    public function getInfoHotelById()
    {
        //dd('123');

        $res = $this->IslandService->getInfoHotelById($this->id);

        if($res->status == 'ok' && !$res->error){
           // dd($res->data);

            return $res->data;
        }

        return false;

        //dd($res);
    }

    public function getInfoHotelSearchById()
    {
        //dd('123');

        $data = [
            'id' => $this->id
        ];

        $res = $this->IslandService->getInfoHotelSearchById($data);

        //dd($res);

        if($res){
           // dd($res->data);

            return $res;
        }

        return false;

        //dd($res);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(Request $request, $locale = null, $slug = null)
    {
        //dd($slug);

       $id = str_replace("-","_",$slug);

       // $room_desc = Room::where('roomable_id',Accommodation::where('id',$id)->first()->accommodationable->id)->get();
        //$roomDesc = [];
       // foreach($room_desc as $item){
         //   array_push($roomDesc,$item->description);
        //}
//        return $roomDesc;

//        Room::where();
        if($id){

            // dd($id);

            $this->id = $id;

            //$info_hotel = $this->getInfoHotelById();

           $info_hotel_search = $this->getInfoHotelSearchById();

            if(!$info_hotel_search){

                $data = false;

                return redirect('/');

                return view('apisingle.single_card',$data);
            }

            //dd($info_hotel_search);

            $data = [];
            $rooms = [];
            $available_room_info = [];
            $travel_line_type_id = 1;
           // $accommodation = $this->service->show($id);

            $IslandService = $this->IslandService;

           // $images = $this->getImagesHotel($info_hotel->images);

            $images_room = $this->getImagesHotelRooms($info_hotel_search);

           /* if($images){
                $info_hotel->slider = $images;
            }*/
            
            /*if ($accommodation->chanelObject) {
                $channel_object = $this->travel_line_service->getObjectById($accommodation->chanelObject->accommodation_crm_code);
//            $data['room_types'] = array_column(array_map(function($key, $value) {
//                return [$value['id'], $value['name']];
//            }, array_keys($channel_object['roomTypes']), $channel_object['roomTypes']), 1, 0);
                $data['rate_plans'] = array_column(array_map(function($key, $value) {
                    return [$value['id'], $value['name']];
                }, array_keys($channel_object['ratePlans']), $channel_object['ratePlans']), 1, 0);
            }*/

            $info = $request->all();

            $night_count = $this->getNightCount($request);

            if($night_count){
                $info['night_count'] = $night_count;
            }

            //dd($info);

            $info['accId'] = $id;
           /* $period = (isset($info['check_in']) && isset($info['check_out'])) ? $info['check_in'].'-'.$info['check_out'] : '';
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
            }*/
            //$carbonIn = \Illuminate\Support\Carbon::createFromFormat('m/d/Y', $check_in);
            //$carbonOut = \Illuminate\Support\Carbon::createFromFormat('m/d/Y', $check_out);
            $days = 1;
            //$date_diff = $carbonIn->diffInDays($carbonOut);
          /*  if( $date_diff != null && is_numeric($date_diff) && $date_diff > 0 ) {
                $days = $carbonIn->diffInDays($carbonOut);
            }*/
           // $info['datefilter'] = $period;
            $can_review = false;
            if( $user = Auth::user() ) {
                $latest_order = $user->orders()->where('object_id', $id)->latest('check_out')->first();
                /*if( !is_null($latest_order) ) {
                    $latest_rating = Rating::where(['user_id'=> $user->id,'accommodation_id' => $id])->latest()->first();
                    if( !is_null($latest_rating) ) {
                        $latest_order_date = new Carbon($latest_order->check_out);
                        $diff = $latest_rating->created_at->gt($latest_order_date);
                        if(!$diff) {
                            $can_review = true;
                        }
                    } else {$can_review = true;}
                }*/
            }
            $data['can_review'] = $can_review;
           // $channel_object_id = $accommodation->chanelObject ? $accommodation->chanelObject->accommodation_crm_code : null;
           /* if( in_array($accommodation->type, ['hotel', 'youth_hotel']) && !is_null($channel_object_id) ) {
                $info['object_id'] = $channel_object_id;
                $book_info = $this->room_service->checkAvailability($info, 'withDC');
                $rooms = $book_info['rooms'];
                $available_room_info = $book_info['available_room_info'];
            } else {
                $rooms = Accommodation::where('id', $accommodation->id)->with(['services', 'amenities', 'images'])->get();
            }*/
           /* $country = $accommodation->country()->first();
            $city = $accommodation->city()->first();
            $countryName = $country != null ? ($country->name != '' ? $country->name : '') : '';
            $cityName = $city != null ? ($city->name != '' ? $city->name : '') : '';

            $data['days'] = $days;
            $data['available_room_info'] = $available_room_info;
            $data['rooms'] = $rooms;
//            return $data['rooms'];
            $data['country'] = $countryName;
            $data['city'] = $cityName;
            $data['accommodation'] = $accommodation;*/
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
        /*if (isset($accommodation->chanelObject->accommodation_crm_code)){
            $travelLineApi = new TravelLineService;
            $dataRoomStays['propertyId'] = $accommodation->chanelObject->accommodation_crm_code;
            $dataRoomStays['adults'] = $request->adults;
            $dataRoomStays['childAges'] = $child_ages;
            $dataRoomStays['arrivalDate'] = isset($_GET['check_in'])?Carbon::createFromFormat('m/d/Y', $request->check_in)->format('Y-m-d'):date('Y-m-d');
            $dataRoomStays['departureDate'] = isset($_GET['check_out'])?Carbon::createFromFormat('m/d/Y', $request->check_out)->format('Y-m-d'):date('Y-m-d', strtotime('tomorrow'));
            $room_stays = $travelLineApi->getAvailableRoomIds($dataRoomStays);
            $data['room_stays'] = $room_stays;
        }*/

       $data['info'] = $info;

        $data['info_hotel_search'] = $info_hotel_search ? $info_hotel_search : '';

        $data['rooms_images'] = $images_room ? $images_room : '';

        //dd($data);
        return view('apisingle.single_card',$data);
    }

    protected function getNightCount($request)
    {
        //dd($request);

        if(!$request->has('check_in') || !$request->has('check_out') ){
            return false;
        }

        $check_in = $request->get('check_in');

        $check_out = $request->get('check_out');

        $day = strtotime($check_out) - strtotime($check_in);

        $night = $day/86400;

        if($night){
            return $night;
        }

        return false;

        //dd($night);
    }

    protected function getImagesHotelRooms($info_hotel_search){
        //dd($info_hotel_search['res'][0]->rates);

        $data = [];

        if($info_hotel_search['res'][0]->rates){

            foreach ($info_hotel_search['res'][0]->rates as $key => $row) {

                if($info_hotel_search['info']->room_groups){
                    
                   //dd($info_hotel_search['info']->room_groups);

                    foreach ($info_hotel_search['info']->room_groups as $v) {

                        //var_dump($row->room_name);

                       // var_dump($v->name);
                        
                        if($row->room_data_trans->main_name == $v->name_struct->main_name){
                            $data[$row->room_data_trans->main_name] = $v->images;
                        }

                    }
                }

            }

            //dd($data);

            return $data;

        }else{
            return false;
        }
    }

    public function getImagesHotel($images)
    {
        if($images){

            $data = [];

            foreach ($images as $key => $img) {
                if($key == 0){
                    $image = str_replace("{size}","1024x768",$img);

                    $data['first'] = $image;

                    $data['theRest'][] = str_replace("{size}","x220",$img);
                }else{
                    $data['theRest'][] = str_replace("{size}","x220",$img);
                }
            }
        }

        if($data){
            return $data;
        }else{
            return false;
        }
    }

    public function checkAvailability(Request $request)
    {
        //dd($request);

        if(!$request->has('posts')){
            return response(['result' => false], 400)
                  ->header('Content-Type', 'application/json');
        }

        $posts = [];

        parse_str($request->get('posts'),$posts);

        $info_hotel_search = $this->IslandService->getInfoHotelSearchById($posts);

        if(!$info_hotel_search){
            return response([
                'result' => false,
                'res'    => false,
                'msg'   => '<p>Данных нет!</p>'
            ],
            200)->header('Content-Type', 'application/json');
        }

        $data = [];

        $images_room = $this->getImagesHotelRooms($info_hotel_search);

        $info = $posts;

        $night_count = $this->getNightCount($request);

        if($night_count){
            $info['night_count'] = $night_count;
        }

        $i =1;
        $child_ages = [];
        while (isset($posts['child_age_'.$i])){
            $child_age = 'child_age_'.$i;
            array_push($child_ages,$request->$child_age);
            $i++;
        }
        $data['child_ages'] = $child_ages ? $child_ages : '';

        $data['info'] = $info;

        $data['info_hotel_search'] = $info_hotel_search ? $info_hotel_search : '';

        $data['rooms_images'] = $images_room ? $images_room : '';

        //dd($data);


        $html = $this->getHtmlSingleAjax($data);//view('apisingle.single_card',$data);

        //dd($html);

        return response([
            'result' => true,
            'html'    => view('apisingle.single_card',$data)
        ],
        200)->header('Content-Type', 'application/json');
    }

    protected function getHtmlSingleAjax($data)
    {
        //dd($data);

        if($data['info_hotel_search']['res']){
            dd($data['info']);

            foreach ($data['info_hotel_search']['res'][0]->rates as $k_r => $row) {
                //dd($row);

                $images = $data['rooms_images'][$row->room_data_trans->main_name];

                $html = '<div class="d-flex table-body flex-column flex-md-row room_acc">
                            <div class="table-column">
                                <input type="hidden" value="'.$row->book_hash.'" class="room_b">
                                <input type="hidden" value="'.$row->match_hash.'" class="room_m">
                                <div class="d-flex" style="position: relative;align-items: center">';
                                    if(!empty($images)){
                                        //var_dump($images);
                                        if($images){
                                        $html .= '<figure>
                                                <a data-fancybox="gallery'.$k_r.'" href="'.str_replace("{size}","1024x768", $images[0]) . '">
                                                    <img src="'. str_replace("{size}","x220", $images[0]) .'" />
                                                    <span style="position: absolute;color:#000;top: 5%;
                                                                font-size: 13px;
                                                                padding-left: 8px;
                                                                font-weight: 600;"
                                                    >'.$row->room_name .'</span>
                        
                                                </a>
                                            </figure>';
                                            foreach($images as $image){
                                                if($image !='1'){
                                                    $html .= '<figure class="d-none">
                                                        <a data-fancybox="gallery'.$k_r .'" href="' . str_replace("{size}","1024x768", $image) . '">
                                                            <img src="' . str_replace("{size}","x220", $image) . '" />
                                                        </a>
                                                    </figure>';
                                                }
                                            }
                                        }else{
                                            foreach($images as $image){
                                                if($loop->index==0){
                                                    $html .= '<figure>
                                                        <a data-fancybox="gallery' . $k_r . '" href="' . str_replace("{size}","1024x768", $image) .'">
                                                            <img src="' . str_replace("{size}","x220", $image) . '" />
                                                            <span style="position: absolute;color:#000;top: 5%;
                                                                font-size: 13px;
                                                                padding-left: 8px;
                                                                font-weight: 600;"
                                                            >' . $row->room_name . '</span>
                                                        </a>
                                                    </figure>';
                                                }else{
                                                    $html .= '<figure class="d-none">
                                                        <a data-fancybox="gallery' . $k_r . '" href="' . str_replace("{size}","1024x768", $image) .'">
                                                            <img src="' . str_replace("{size}","x220", $image) . '" />
                                                        </a>
                                                    </figure>';
                                                }
                                            }
                                        }
                                        $html .= '<h3>' . $row->room_name . '</h3>';
                                    }
                                $html .= '</div>
                                <div class="table-text-box">';
                                
                                    if($row->amenities_data){
                                     $html .= '<ul>';
                                            foreach($row->amenities_data as $amenity){
                                                $html .= '<li class="list-item">' . $amenity . '</li>';
                                            }
                                $html .= '</ul>';
                                    }
                                       
                                    if(isset($room_size)){
                                        $html .= '<p>' . __('rooms.room_size_title').' - '. $room_size." ".__('rooms.m2') . '</p>';
                                    }
                        
                                    if(isset($room->prepayment)){
                                        $html .= '<p>' . __('rooms.prepayment_single') . '</p>';
                                    }
                        
                                $html .= '<p></p>
                                    <p></p>
                                </div>
                            </div>
                            <div class="table-column">
                                <span class="d-block d-md-none">' .__('accommodation.priceFor') .'</span>
                                <span class="price">' .number_format($row->daily_prices[0]*$info['night_count'], 0, '.', ' ') . ' ' .__('rooms.currency') . '</span>
                            </div>
                            <div class="table-column">
                               
                            </div>
                            <div class="table-column">
                                <span class="d-block d-md-none">' .lang('accommodation.pleaseChoose') .'</span>';
                                if(!empty($availability)){
                                    $html .= '<select class="selectRoomCount" name="count_room">';
                                        for($i = 1; $i <= min([$availability, $adult_count]); $i++){
                                            $html .= '<option ' . $i==0 ? 'selected' : '' .' value="' .$i .'">' .$i .'</option>';
                                        }
                                    $html .= '</select>';
                                }
                        
                        $html .= '</div>
                            <div class="table-column">';
                                    if(isset($url) && Auth::user()->role_id == 2){
                                        $html .= '<a href="' . $url . '"  class="btn-blue book-now">' . lang('booking.book_now') . '</a>';
                                    }else{
                                        $html .= '<a data-bs-toggle="modal" data-bs-target="#loginModal" class="btn-blue">' . lang('booking.book_now') . '</a>';
                                    }
                            $html .= '</div>
                        </div>
                        
                        
                        <script>
                            let x = $(".room_id").val();
                            Fancybox.bind("[data-fancybox="gallery"+x+"]", {
                        
                            });
                        
                        </script>';
            }
        }

        if($html){
            return $html;
        }else{
            return false;
        }
    }

}
