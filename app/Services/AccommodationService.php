<?php

namespace App\Services;

use App\Actions\UpdateHotel;
use App\Models\Accommodation;
use App\Models\UserPermission;
use App\Actions\CheckInAction;
use App\Actions\CheckOutAction;
use App\Contracts\CreateNewResidencyContarct;
use App\Actions\CreateAccommodation;
use App\Actions\AddressCreatorAction;
use App\Contracts\AddressCreatorActions;
use App\Http\Requests\AccommodationFormRequest;
use App\Http\Requests\AccommodationUpdateFormRequest;
use App\Models\WishList;
use App\Services\Api\TravelLineService;
use Illuminate\Support\Facades\Auth;
use Facades\App\Actions\Base64FileUploader;
use App\Models\Hotel;
use App\Models\Crm;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccommodationService
{
    public function create()
    {
    }

    public function edit()
    {
    }

    public function update($locale, \App\Http\Requests\AccommodationUpdateFormRequest $request, $action, $model)
    {
        $residency = $action->execute($model, $request);
        $data = $this->accommodationData($request);
        $data['type'] =  $residency->accommodation->type;
        $arrTitle=['ru'=>$request->title_pyc, 'en'=>$request->title];
        $titleJson=json_encode($arrTitle);
        $data['title'] =  $titleJson;

        $arrDesc=['ru'=>$request->description_pyc, 'en'=>$request->description];
        $titleJson=json_encode($arrDesc);
        $data['description'] =  $titleJson;

        $arrChildPolicy=['ru'=>$request->child_policy_pyc, 'en'=>$request->child_policy];
        $childPolicyJson=json_encode($arrChildPolicy);
        $data['child_policy'] =  $childPolicyJson;

        $arrOtherRules=['ru'=>$request->other_rules_pyc, 'en'=>$request->other_rules];
        $otherRulesJson=json_encode($arrOtherRules);
        $data['other_rules'] =  $otherRulesJson;

        $residency->accommodation()->update($data);


        $address['street_house'] = $request->street_house;
        $address['zip_code'] = $request->zip_code;
        $address['map'] = $request->map;
        $residency->accommodation->address()->update($address);
        // Check_in
        $check_out = [];
        $check_out['from'] = $request->check_out_from;
        $check_out['to'] = $request->check_out_to;

        $residency->accommodation->check_outs()->update($check_out);

        // Checkin data
        $check_in = [];
        $check_in['from'] = $request->check_in_from;
        $check_in['to'] = $request->check_in_to;
        $residency->accommodation->check_ins()->update($check_in);
        $accommodation = $residency->accommodation;
        $accommodation->policies()->sync($request->policies);
        if ($request->has('services')) {
            $services = collect(
                $request->input('services', [])
            )->map(function ($services) {
                return ['price' => $services];
            });

            // dd($services);
            $accommodation->services()->sync($services);
        }
        $accommodation->amenities()->sync($request->amenities);
        $accommodation->langs()->sync($request->langs);
        $accommodation->payments()->sync($request->payments);

       $accommodation
           ->setTranslation('description', 'en', $request->description)
           ->setTranslation('title', 'en', $request->title)
           ->setTranslation('other_rules', 'en', $request->other_rules)
           ->setTranslation('child_policy', 'en', $request->child_policy)
           ->setTranslation('description', 'ru', $request->description_pyc)
           ->setTranslation('title', 'ru', $request->title_pyc)
           ->setTranslation('other_rules', 'ru', $request->other_rules_pyc)
           ->setTranslation('child_policy', 'ru', $request->child_policy_pyc);
        $accommodation->update();
    }

    public function delete(Accommodation $accommodation): void
    {
        $accommodation->delete();
    }

    public function store(AccommodationFormRequest $request, CreateNewResidencyContarct $action, AddressCreatorActions $adressCreator, CheckInAction $checkIn, CheckOutAction $checkOut, CreateAccommodation $createAccommodation)
    {

        $residency = $action->create($request);

        $data =  $this->accommodationData($request);
        $id = \Auth::user()->id;
        if($us = UserPermission::where('user_id',\Auth::user()->id)->first()){
            $id=$us->owner_id;
        }
        $data['user_id'] = $id;
        $accommodation = $createAccommodation->execute(
            $residency,
            $data
        );

        // Translations
        $accommodation
            ->setTranslation('description', 'en', $request->description)
            ->setTranslation('title', 'en', $request->title)
            ->setTranslation('other_rules', 'en', $request->other_rules)
            ->setTranslation('child_policy', 'en', $request->child_policy)
            ->setTranslation('description', 'ru', $request->description_pyc)
            ->setTranslation('title', 'ru', $request->title_pyc)
            ->setTranslation('other_rules', 'ru', $request->other_rules_pyc)
            ->setTranslation('child_policy', 'ru', $request->child_policy_pyc);

//        dd($request->all(), $accommodation);

        $accommodation->update();

        $accommodation->policies()->sync($request->policies);

        if ($request->has('services')) {
            $services = collect(
                $request->input('services', [])
            )->map(function ($services) {
                return ['price' => $services];
            })->filter(fn ($service) => $service !== null);
            $accommodation->services()->sync($services);
        }
        $accommodation->amenities()->sync($request->amenities);
        $accommodation->langs()->sync($request->langs);
        $accommodation->payments()->sync($request->payments);

        // Address Data
        $address = [];
        $address['accommodation_id'] = $accommodation->id;
        $address['street_house'] = $request->street_house;
        $address['zip_code'] = $request->zip_code;
        $address['map'] = $request->map;
        $adressCreator->execute($address);

        // Check_in
        $check_out = [];
        $check_out['from'] = $request->check_out_to;
        $check_out['to'] = $request->check_out_to;
        $check_out['accommodation_id'] = $accommodation->id;
        $checkOut->execute($check_out);

        // Checkin data
        $check_in = [];
        $check_in['from'] = $request->check_in_from;
        $check_in['to'] = $request->check_in_from;
        $check_in['accommodation_id'] = $accommodation->id;

        $checkIn->execute($check_in);

        return $residency;
    }

    private function accommodationData($request)
    {

        $accommodation_data = [
            'type' => $request->accommodation_type,
            'title' => $request->name_pyc,
            "country_id" => $request->country,
            'city_id' => $request->city,
            'allow_pets' => $request->allow_pets,
            'allow_child' => $request->allow_child,
            'agree_terms' => $request->agree_terms,
            'certify_terms' => $request->certify_terms,
            'other_rules' => $request->other_rules_pyc,
            'description' => $request->description_pyc,
            'protection_booking' => $request->protection_booking,
            'phone' => $request->phone,
            'alt_phone' => $request->alt_phone,
            'contact_person' => $request->contact_person,
            'extra_beds' => $request->extra_beds,
            'price' => $request->price,
            'sales_channel' => $request->sales_channel!='on'?1:0,
            'child_policy' => $request->child_policy_pyc,
        ];
        return $accommodation_data;
    }

    public function search(Request $request, $api = false)
    {

        $accommodationQuery = Accommodation::query();

//        $accommodationQuery->when($request->has("rangeOne") && $request->has("rangeTwo"), function ($q) use ($request) {
//            $q->whereBetween('accommodations.price',[(int)$request->get("rangeOne"),(int)$request->get("rangeTwo")]);
//        });

        $accommodationQuery->when($request->has("rooms"), function ($q) use ($request) {
            // TO DO
        });

        $accommodationQuery->when($request->has("adults"), function ($q) use ($request) {
            // TO DO
        });

        $accommodationQuery->when($request->has("children"), function ($q) use ($request) {
            // TO DO
        });

        $accommodationQuery->when($request->has("place_id") && $request->has("place_type"), function ($q) use ($request) {
            if ($request->get("place_type") == "city") {
                $q->where('city_id', $request->get("place_id"));
            }

            if ($request->get("place_type") == "country") {
                $q->where('country_id', $request->get("place_id"));
            }

            if ($request->get("place_type") == "object") {
                $q->where('id', $request->get("place_id"));
            }
        });

        $accommodationQuery->when($request->has("check_in"), function ($q) use ($request) {
            // TO DO
        });

        $accommodationQuery->when($request->has("check_out"), function ($q) use ($request) {
//            $q->whereHas('check_outs', function ($q) use ($request) {
//                $check_out = $request->get('check_out');
//                return $q->whereTime('from', '<=', $check_out)->whereTime('to', '>=', $check_out);
//            });
            // TO DO
        });

        if ($request->has('accommodations')){
            $accommodations = $request->get('accommodations');

            $accommodationQuery->where(function ($q) use ($accommodations) {

                if (in_array("hotel", $accommodations)) {
                    $q->orHotel();
                }

                if (in_array("apartment", $accommodations)) {
                    $q->orApartment();
                }

                if (in_array("villa", $accommodations)) {
                    $q->orVilla();
                }

                if (in_array("youth-hotel", $accommodations)) {
                    $q->orYouthHotel();
                }

            });

        }


        if ($request->has("amenities")) {
            $amenities = $request->get('amenities');
            $allowAmenitiesIds = DB::table('accommodation_amenity')
                ->whereIn('amenity_id',$amenities)
                ->groupBy('accommodation_id')
                ->select('accommodation_id',DB::raw('count(accommodation_id) as count'),)
                ->having("count",'=', count($amenities))
                ->get('accommodation_id')->pluck('accommodation_id')->toArray();
            $accommodationQuery->whereIn('accommodations.id',$allowAmenitiesIds);
        }

        if ($request->has("services")) {
            $services = $request->get('services');
            $allowAmenitiesIds = DB::table('accommodation_service')
                ->whereIn('service_id',$services)
                ->groupBy('accommodation_id')
                ->select('accommodation_id',DB::raw('count(accommodation_id) as count'),)
                ->having("count",'=', count($services))
                ->get('accommodation_id')->pluck('accommodation_id')->toArray();
            $accommodationQuery->whereIn('accommodations.id',$allowAmenitiesIds);
        }

//        if ($request->has("sort")) {
//            if ($request->get("sort") == 'price_lower') {
//                $accommodationQuery->orderBy('price',"desc");
//            }
//
//            if ($request->get("sort") == 'stars_highest') {
//                $accommodationQuery->with('accommodationable',function ($q){
//                    $q->orderByRaw('ISNULL(stars_num)',"desc");
//                });
//            }
//        }

        if ($request->has('star_rating')){

            $star_rating = $request->get('star_rating');

//            $accommodationQuery->orWhereHas('ratings',function ($q) use ($star_rating){
//                //    $exists_tar_sum = $q->hasColumn('stars_num');
//                    foreach ($star_rating as $star){
//                            $q->select(DB::raw("SUM(rating) / count(*) as r"))
//                                ->having('r', '>', $star - 1)
//                                ->having('r', '<', $star)
//                                ->orHaving('r', '=', $star);
//                    }
//
//            });
            $accommodationQuery->where(function($q) use($star_rating) {
                foreach ($star_rating as $star) {
                    $q->orWhereBetween('avg_rating', [(float)$star - 0.9, (float)$star] );
                }
            });
        }

        //    dd($accommodationQuery->get());

        $dataCountStar = [];
        for ($i = 1; $i <= 5; $i++) {
            $key = 'star_' . $i . '_count';
            $tempOjb = clone $accommodationQuery;
            $dataCountStar[$key] = $tempOjb
                ->whereHasMorph('accommodationable', Hotel::class, function ($q) use ($i) {
                    $q->where('stars_num', $i);
                })->count();
        }


        if ($request->has('star')){
            $stars = $request->get('star');

            $accommodationQuery->whereHas('accommodationable_hotel',function ($q) use ($stars){
                //    $exists_tar_sum = $q->hasColumn('stars_num');
                $q->where(function ($q) use ($stars) {
                    foreach ($stars as $star){
                        $q->orWhere("stars_num", '=', (integer)$star);
                    }
                });
            });
        }

        $data = $this->filterPropertiesCounts($accommodationQuery);
        $data = array_merge($data,$dataCountStar);

        $accommodationIds = $accommodationQuery->get('id')->pluck("id");
        $data['amenities'] = DB::table('accommodation_amenity')
            ->join('amenities','amenities.id','accommodation_amenity.amenity_id')
            ->whereIn('accommodation_id',$accommodationIds)
            ->select( DB::raw('count(amenities.name) as count'), 'amenities.name', 'amenities.id')
            ->groupBy('amenities.name')
            ->groupBy('amenities.id')
            ->orderBy('count','desc')
            ->get();

        $data['services'] = DB::table('accommodation_service')
            ->join('services','services.id','accommodation_service.service_id')
            ->whereIn('accommodation_id',$accommodationIds)
            ->select( DB::raw('count(services.name) as count'), 'services.name', 'services.id')
            ->groupBy('services.name')
            ->groupBy('services.id')
            ->orderBy('count','desc')
            ->get();




        $child_arr=[];

        for($i =1; $i<=10;$i++){
            if($request->has('child_age_'.$i)){
                array_push($child_arr, (int)$request->get('child_age_'.$i));
            }
        }

        $clone = clone $accommodationQuery;
        $channel_ids = $clone->with('chanelObject')->get()->filter(function ($item) {
            return !is_null($item->chanelObject);
        })->map(function ($item) {
            return $item->chanelObject->accommodation_crm_code;
        })->values()->toArray();

        $acc_datas['propertyIds'] = $channel_ids;
        $acc_datas['adults'] = isset($_GET['adults'])?$_GET['adults']:1;
        $acc_datas['childAges'] = $child_arr;
        $acc_datas['arrivalDate'] = isset($_GET['check_in'])?date("Y-m-d", strtotime($_GET['check_in'])):date('Y-m-d');
        $acc_datas['departureDate'] = isset($_GET['check_out'])?date("Y-m-d", strtotime($_GET['check_out'])):date('Y-m-d', strtotime('tomorrow'));
        $travelLineApi = new TravelLineService;
        $channel_data_raw  = $travelLineApi->getAccommodationIds($acc_datas);

        $min_price = $request->rangeOne ?? 0;
        $max_price = $request->rangeTwo ?? 1000000;
        $channel_data = array_filter($channel_data_raw, function($item) use($min_price, $max_price) {
            return $item >= $min_price && $item <= $max_price;
        });

        if ($request->has("sort")) {
            if ($request->get("sort") == 'price_lower') {
                $price_high = $channel_data;
                arsort($price_high);
                $price_keys = array_keys($price_high);
                $ids = [];
                $price_keys_imploed = implode(',', $price_keys);
                foreach (Crm::whereIn('accommodation_crm_code',$price_keys)->orderByRaw("FIELD(accommodation_crm_code, $price_keys_imploed)")->pluck('accommodation_id') as $item1){
                    if (!in_array($item1,$ids)){
                        array_push($ids,$item1);
                    }
                }
                $ids_imploed = implode(',', $ids);
                $accommodationQuery->whereIn('id',$ids)->orderByRaw("FIELD(id, $ids_imploed)");
            }

            if ($request->get("sort") == 'price_high') {
                $price_high = $channel_data;
                asort($price_high);
                $price_keys = array_keys($price_high);
                $ids = [];
                $price_keys_imploed = implode(',', $price_keys);
                foreach (Crm::whereIn('accommodation_crm_code',$price_keys)->orderByRaw("FIELD(accommodation_crm_code, $price_keys_imploed)")->pluck('accommodation_id') as $item1){
                    if (!in_array($item1,$ids)){
                        array_push($ids,$item1);
                    }
                }
                $ids_imploed = implode(',', $ids);
                $accommodationQuery->whereIn('id',$ids)->orderByRaw("FIELD(id, $ids_imploed)");
            }

            if ($request->get("sort") == 'stars_highest' && $accommodationQuery->count()!=1) {
//                $accommodationQuery->orderByRaw("FIELD(type, 'hotel', 'youth_hotel') ")->with('accommodationable',function ($q){
//                    $q->orderBy('stars_num',"desc");
//                });
                $accommodationQuery
                    ->leftJoin('hotels', 'hotels.id', 'accommodationable_id')
//                    ->leftJoin('appartments', 'appartments.id', 'accommodationable_id')
                    ->select('accommodations.price as price', 'accommodations.*')
                    ->orderBy('hotels.stars_num', 'desc');
//                    ->orderBy('accommodations.id', 'asc');
            }

            if ($request->get("sort") == 'stars_least' && $accommodationQuery->count()!=1) {
                //->orderByRaw("FIELD(type, 'hotel', 'youth_hotel', 'apartment', 'villa') ASC")
//                $accommodationQuery->with('accommodationable',function ($q){
//                    $q->orderBy(DB::raw('ISNULL(stars_num), stars_num'),"asc");
//                });
                $accommodationQuery
                    ->leftJoin('hotels', 'hotels.id', 'accommodationable_id')
                    ->leftJoin('appartments', 'appartments.id', 'accommodationable_id')
                    ->select('accommodations.price as price', 'accommodations.*')
                    ->orderBy('hotels.stars_num', 'asc');
            }

            if ($request->get("sort") == 'guest_rating') {
                $accommodationQuery->orderBy('avg_rating', 'desc');
            }
        }

        $accommodationQuery=$accommodationQuery->whereHas('chanelObject', function($query) use($channel_data) {
            $query->whereIn('accommodation_crm_code',array_keys($channel_data));
        });
//        dd($accommodationQuery->count());

        $data['count'] = $accommodationQuery->count();
        if ($api) {
            return $accommodationQuery->with(['accommodationable.images' => function($q) {
                $q->where('featured_image', 1);
            }, 'country', 'city', 'amenities'])->get();
        } else {
            $notSortProducts = $accommodationQuery->with(['accommodationable', 'chanelObject'])->paginate(9)->appends($request->all());

            $data['products'] = $notSortProducts;
            $data['price_min'] = 0; //Accommodation::min('price')
            $data['price_max'] = !empty($channel_data_raw) ? max(array_values($channel_data_raw)) : 100000; //Accommodation::max('price')
            $data['favorites'] = \Auth::check() ? WishList::where('user_id', \Auth::user()->id)->get(['id', 'accommodation_id'])->keyBy('accommodation_id')->map(function($item) {
                return $item['id'];
            })->toArray() : [];
            $data['prices'] = $channel_data;
        }

       // var_dump('123');

        return $data;

    }

    private function filterPropertiesCounts($query)
    {

        $data = [];

        $apartmentCountQuery = clone $query;
        $data['apartment_count'] = $apartmentCountQuery->apartment()->count();

        $hotelCountQuery = clone $query;
        $data['hotel_count'] = $hotelCountQuery->hotel()->count();

        $villasCountQuery = clone $query;
        $data['villas_count'] = $villasCountQuery->villa()->count();

        $youthHotelCountQuery = clone $query;
        $data['youth_hotel_count'] = $youthHotelCountQuery->youthHotel()->count();

        // for hotel star count calculation
//        for ($i = 1; $i <= 5; $i++) {
//            $key = 'star_' . $i . '_count';
//            $tempOjb = clone $query;
//            $data[$key] = $tempOjb
//                ->whereHasMorph('accommodationable', Hotel::class, function ($q) use ($i) {
//                    $q->where('stars_num', $i);
//                })->count();
//        }

        // for Rating star count calculation
        for ($i = 1; $i <= 5; $i++) {
            $key = 'rating_star_' . $i . '_count';
            $tempOjb = clone $query;
            $data[$key] = $tempOjb->whereHas('ratings', function ($q) use ($i) {
                $q->select(DB::raw("SUM(rating) / count(*) as r"))->having('r', '>', $i - 1)->having('r', '<', $i);
                $q->orHaving('r', '=', $i);
            })->count();
        }

        return $data;
    }

    // public function get(Hotel, $type)
    // {
    //     $query = $accommodation::query()
    //         ->with([
    //             'services',
    //             'amenities',
    //             'address',
    //             'policies',
    //             'payments',
    //             'check_outs',
    //             'accommodationable'
    //         ])
    //         ->where('accommodationable_type', "App\\Models\\" . $type)
    //         ->where('accommodationable_type', "App\\Models\\" . $type)
    //         ->get();
    // }
}
