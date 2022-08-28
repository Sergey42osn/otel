<?php

namespace App\Services;

use App\Models\Accommodation;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Type;
use App\Http\Requests\RoomFormRequest;
use App\Models\Room;
use App\Services\Api\TravelLineService;
use DateTime;
use App\Models\TypeName;
use Facades\App\Actions\Base64FileUploader;
use Facades\App\Actions\StoreImages;
use Illuminate\Support\Facades\DB;


class RoomService
{

    protected $travel_line_service;

    public function __construct(TravelLineService $travel_line_service) {
        $this->travel_line_service = $travel_line_service;
    }
    public function store(RoomFormRequest $request)
    {

        $type_id = $request->type;
        $title_id = $request->title;
        if($request->type_name!=''){
            $type_name=Type::create([
                'name' => $request->type_name,
                'type' => "Room",
                'user_id' => \Auth::user()->id
            ]);
            $type_id = $type_name->id;
        }
        if($request->title_name!=''){
            $title_name=TypeName::create([
                'name' => $request->title_name,
                'type_id' => $type_id,
                'user_id' => \Auth::user()->id
            ]);
            $title_id = $title_name->id;
        }

        $hotel = Hotel::findOrFail($request->hotel_id);

        $api_plane_room_id = explode('-',$request->code_from_api);

        $room = $hotel->rooms()->create([
            'number' => $request->safe()->number,
            'price' => $request->safe()->price,
            'size' => $request->size,
            'single_bed' => $request->single_bed,
            'sofa_bed' => $request->sofa_bed,
            'double_bed' => $request->double_bed,
            'wide_bed' => $request->wide_bed,
            'futon' => $request->futon,
            'extra_beds' => $request->extra_beds,
            'guest_count' => $request->safe()->guest_count,
            'type_id' => $type_id,
            'title_id' => $title_id,
            'code_from_api' => $api_plane_room_id[0],
            'api_plane_id' => $api_plane_room_id[1] ?? null,
            'prepayment' => $request->prepayment ? 1 : 0
        ]);
        $room
            ->setTranslation('description', 'en', $request->description)
            ->setTranslation('description', 'ru', $request->description_pyc);
        $room->update();
        if($request->type==2){
            Accommodation::where('accommodationable_id',$request->hotel_id)->update([
                'price' => $request->price
            ]);
        }
        $services = collect(
            $request->input('services', [])
        )->map(function ($services) {
            return ['price' => $services];
        })->filter(fn ($service) => $service !== null);

        $room->services()->sync($services);
        $room->amenities()->attach($request->amenities);



        foreach ($request->Upload as $file) {
            $url = Base64FileUploader::upload($file, '/public/uploads/');
            if ($request->file == $file) {
                StoreImages::execute($room, $url, true);
            } else {
                StoreImages::execute($room, $url, false);
            }
        }


        return $hotel;
        // Uploading File and Saving into db ....
    }

    public function update(RoomFormRequest $request, Room $room)
    {
        $type_id = $request->type;
        $title_id = $request->title;
        if($request->type_name!=''){
            $type_name=Type::create([
                'name' => $request->type_name,
                'type' => "Room",
                'user_id' => \Auth::user()->id
            ]);
            $type_id = $type_name->id;
        }
        if($request->title_name!=''){
            $title_name=TypeName::create([
                'name' => $request->title_name,
                'type_id' => $type_id,
                'user_id' => \Auth::user()->id
            ]);
            $title_id = $title_name->id;
        }
        $api_plane_room_id = explode('-',$request->code_from_api);
        $room->update([
            'number' => $request->safe()->number,
            'price' => $request->safe()->price,
            'size' => $request->size,
            'single_bed' => $request->single_bed,
            'sofa_bed' => $request->sofa_bed,
            'double_bed' => $request->double_bed,
            'wide_bed' => $request->wide_bed,
            'futon' => $request->futon,
            'extra_beds' => $request->extra_beds,
            'guest_count' => $request->safe()->guest_count,
            'type_id' => $type_id,
            'title_id' => $title_id,
            'code_from_api' => isset($api_plane_room_id[0])?$api_plane_room_id[0]:"",
            'api_plane_id' => isset($api_plane_room_id[1])?$api_plane_room_id[1]:"",
            'prepayment' => $request->prepayment?1:0

        ]);

        $services = collect(
            $request->input('services', [])
        )->map(function ($services) {
            return ['price' => $services];
        })->filter(fn ($service) => $service !== null);
        $room->services()->sync($services);
//dd($services);
        $room->amenities()->sync($request->amenities);

        $deleted_files = $request->deleteFiles;
        $deleted_files = explode(',',$deleted_files);
        foreach($deleted_files as $file){
            DB::table('images')->where([['imageable_id', $room->id],['url',$file]])->delete();
        }

        if($request->headFile!=null){
            $arr_images = Image::where([['imageable_id', $room->id],['imageable_type','App\Models\Room']])->get();
            foreach ($arr_images as $img){
                $img->update([
                    'featured_image' => 0
                ]);
            }
        }
        if($request->headFile!=null && Image::where([['imageable_id', $room->id],['url',$request->headFile]])->first()){
            $img = Image::where([['imageable_id', $room->id],['url',$request->headFile]])->first()->update([
                'featured_image' => 1
            ]);
        }
        if($request->Upload) {
            foreach ($request->Upload as $file) {
                if (substr($file, 0, 5) == 'data:') {
                    $url = Base64FileUploader::upload($file, '/public/uploads/');
                    if ($request->headFile != null && $request->headFile == $file) {
                        $room->images()->update(['featured_image' => false]);
                        StoreImages::execute($room, $url, true);
                    } else {
                        StoreImages::execute($room, $url, false);
                    }
                }
            }
        }
        $room
            ->setTranslation('description', 'en', $request->description)
            ->setTranslation('description', 'ru', $request->description_pyc);
        $room->update();
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function checkAvailability($data, $type = '')
    {
        $travel_line_type_id = 1;
        $child_ages = [];
        $available_room_info = [];
        $accommodation_id = $data['accId'];
        $accommodation = Accommodation::find($accommodation_id);
        $adults = isset($data['adults']) ? $data['adults'] : 2;
        $childs = isset($data['children']) ? $data['children'] : 0;
        $period = isset($data['datefilter']) ? $data['datefilter'] : '';
        $travel_line_object = $accommodation->chanelObject()->where('sale_channel_id', $travel_line_type_id)->first();
        if($childs != null && $childs > 0) {
            for($i = 1; $i <= $childs; $i++) {
                $age = $data['child_age_'.$i];
                if( $age != null && $age > 0 ) {
                    $child_ages[$i] = $age;
                }
            }
        }
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
        $days = $carbonIn->diffInDays($carbonOut);
        $available_room_type_ids=[];

        if( $travel_line_object ) {
            $travel_line_id = $travel_line_object->id;
            if( $travel_line_id != null && $travel_line_id > 0 ) {
                $book_info['propertyId'] = $data['object_id'];
                $book_info['arrivalDate'] = $carbonIn->format('Y-m-d');
                $book_info['departureDate'] = $carbonOut->format('Y-m-d');
                $book_info['adults'] = (int)$adults;
                $book_info['childAges'] = $child_ages;
                $available_room_info = $this->travel_line_service->getAvailableRoomIds($book_info);
                if( !empty($available_room_info) && count($available_room_info) > 0 ) {
                    $available_room_type_ids = array_keys($available_room_info);
                }

            }
        }
        $rooms = Room::whereIn('code_from_api', $available_room_type_ids)->where('roomable_id', $accommodation->accommodationable->id)->with(['name', 'type', 'services', 'amenities', 'images'])->get();
        if( $type == 'withDC' ) {
            return ['rooms' => $rooms, 'days' => $days, 'child_ages' => $child_ages, 'available_room_info' => $available_room_info];
        }
        return ['rooms' => $rooms];
    }

    public function delete(Room $room)
    {
        $room->delete();
    }
}
