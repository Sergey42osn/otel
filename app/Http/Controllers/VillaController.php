<?php

namespace App\Http\Controllers;

use App\Models\Crm;
use App\Models\SalesChannel;
use App\Models\Address;
use App\Models\CheckIn;
use App\Models\CheckOut;
use App\Models\Lang;
use App\Models\Type;
use App\Models\Policy;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Appartment;
use App\Models\Accommodation;
use Illuminate\Http\Request;
use App\Actions\CheckInAction;
use App\Actions\CheckOutAction;
use App\Actions\AppartmentAction;
use App\Actions\UpdateAppartment;
use Illuminate\Routing\Controller;
use App\Actions\CreateAccommodation;
use App\Actions\CreateNewAppartment;
use App\Actions\AddressCreatorAction;
use App\Http\Resources\AppartmentResource;
use App\Services\AccommodationService;
use App\Http\Requests\AccommodationUpdateFormRequest;
use App\Http\Requests\AccommodationFormRequest;
use Illuminate\Support\Facades\DB;

class VillaController extends Controller
{
    protected $accommodationService;

    public function __construct(AccommodationService $accommodationService)
    {
        $this->accommodationService = $accommodationService;
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

    public function create()
    {
        $iso2_nlc= Country::all('iso2');
        $iso2='';
        foreach ($iso2_nlc as $code){
            $code1=strtolower($code->iso2);
            if ($code1 !='') {
                if ($iso2 == '') {
                    $iso2='"'.$code1.'"';
                } else  {
                    $iso2.=', "'.$code1.'"';
                }
            }
        }
        $sale_title_ru = SalesChannel::all(['title']);
        $sale_title_ru = json_decode($sale_title_ru);
        $arr_sale_ru=[];
        foreach ($sale_title_ru as $item) {
            $ru = json_decode($item->title)->ru;
            array_push($arr_sale_ru,$ru);
        }

        $sale_title_en = SalesChannel::all(['title']);
        $sale_title_en = json_decode($sale_title_en);
        $arr_sale_en=[];
        foreach ($sale_title_en as $item) {
            $en = json_decode($item->title)->en;
            array_push($arr_sale_en,$en);
        }

        $crm_acc_code = Crm::get(['sale_channel_id','accommodation_crm_code']);
        $crm_code_with_sale_id ='';$i=0;$crm_code ='';
        foreach ( $crm_acc_code as $code){
            if($i < count($crm_acc_code)-1){
                $crm_code_with_sale_id .=$code->sale_channel_id.',';
                $crm_code .=$code->accommodation_crm_code.',';
            } else {
                $crm_code_with_sale_id .=$code->sale_channel_id;
                $crm_code .=$code->accommodation_crm_code;
            } $i++;
        }

        return view('registration.villa', [
            'services' => Service::all(['id', 'name']),
            'amenities' => Amenity::where('general',1)->get(['id', 'name']),
            'amenities_select' => Amenity::where('general',0)->get(['id', 'name']),
            'countries' => Country::all(['id', 'name','iso2']),
            'types' => Type::all(['id', 'name', 'type'])->where('type', 'Villa'),
            'langs' => Lang::where('general',1)->get(['id', 'name']),
            'langs_select' => Lang::where('general',0)->get(['id', 'name']),
            'payments' => \App\Models\Payment::all(['id', 'name']),
            'policies' => Policy::all(['id', 'name', 'type']),
            'iso2' => $iso2,
            'ru_sale_channels' => $arr_sale_ru,
            'en_sale_channels' => $arr_sale_en,
            'crm_acc_code' => $crm_code,
            'crm_code_with_sale_id' => $crm_code_with_sale_id
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccommodationFormRequest $request, CreateNewAppartment $action, AddressCreatorAction $adressCreator, CheckInAction $checkIn,  CheckOutAction $checkOut, CreateAccommodation $createAccommodation)
    {

        $residency = $this->accommodationService->store($request, $action, $adressCreator, $checkIn, $checkOut, $createAccommodation);
        $acc_id = Accommodation::where('accommodationable_id',$residency->id)->first()->id;
        if($request->sale_channel_id!='' && $request->crm_code!=''){
            Crm::create([
                'sale_channel_id' => $request->sale_channel_id,
                'accommodation_crm_code' => $request->crm_code,
                'accommodation_id' => $acc_id
            ]);
        }
        return redirect()->route('user.objects', ['locale' => app()->getLocale()]);;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($locale, $id, AppartmentAction $action)
    {
        return AppartmentResource::collection($action->execute(Appartment::find($id)));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($locale, $id, AppartmentAction $action)
    {

        $iso2_nlc= Country::all('iso2');
        $iso2='';
        foreach ($iso2_nlc as $code){
            $code1=strtolower($code->iso2);
            if ($code1 !='') {
                if ($iso2 == '') {
                    $iso2='"'.$code1.'"';
                } else  {
                    $iso2.=', "'.$code1.'"';
                }
            }
        }
        $sale_title_ru = SalesChannel::all(['title']);
        $sale_title_ru = json_decode($sale_title_ru);
        $arr_sale_ru=[];
        foreach ($sale_title_ru as $item) {
            $ru = json_decode($item->title)->ru;
            array_push($arr_sale_ru,$ru);
        }

        $sale_title_en = SalesChannel::all(['title']);
        $sale_title_en = json_decode($sale_title_en);
        $arr_sale_en=[];
        foreach ($sale_title_en as $item) {
            $en = json_decode($item->title)->en;
            array_push($arr_sale_en,$en);
        }
        $app=$action->execute(Appartment::find($id));

        $crm_acc_code = Crm::get(['sale_channel_id','accommodation_crm_code','accommodation_id']);
        $crm_acc_id = $app->id;
        $crm_code_with_sale_id ='';$i=0;$crm_code ='';$acc_ids = '';
        foreach ( $crm_acc_code as $code){
            if($i < count($crm_acc_code)-1){
                $crm_code_with_sale_id .=$code->sale_channel_id.',';
                $crm_code .=$code->accommodation_crm_code.',';
                $acc_ids.=$code->accommodation_id.',';
            } else {
                $crm_code_with_sale_id .=$code->sale_channel_id;
                $crm_code .=$code->accommodation_crm_code;
                $acc_ids.=$code->accommodation_id;
            } $i++;
        }
        return view(
            'registration.villa-edit',
            [
                'countries' => Country::all(['id', 'name','iso2']),
                'amenities' => Amenity::where('general',1)->get(['id', 'name']),
                'amenities_select' => Amenity::where('general',0)->get(['id', 'name']),
                'langs' => Lang::where('general',1)->get(['id', 'name']),
                'langs_select' => Lang::where('general',0)->get(['id', 'name']),
                'payments' => Payment::all(['id', 'name']),
                'types' => Type::where('type', 'Villa')->get(['id', 'name', 'type']),
                'policies' => Policy::all(['id', 'name', 'type']),
                'appartment' => $app,
                'services' => Service::all(['id', 'name'])->whereNotIn('id', Appartment::find($id)->accommodation->services->pluck('id')),
                // 'cities' => City::all(['id', 'name'])
                'iso2' => $iso2,
                'id' => $id,
                'ru_sale_channels' => $arr_sale_ru,
                'en_sale_channels' => $arr_sale_en,
                'crms' => Crm::where('accommodation_id',$app->accommodation->id)->first(),
                'this_acc_id' => $crm_acc_id,
                'crm_acc_code' => $crm_code,
                'crm_code_with_sale_id' => $crm_code_with_sale_id,
                'crm_acc_ids' => $acc_ids
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $locale
     * @param AccommodationFormRequest $request
     * @param $appartment_id
     * @param UpdateAppartment $action
     * @return \Illuminate\Http\Response
     */

    public function update($locale, AccommodationUpdateFormRequest $request, Appartment $villa, UpdateAppartment $action)
    {
//       $villa = Appartment::find($request->obj_id);
////        $villa->update([
////            'bathroom_count' => $request->bathroom_count,
////            'guest_count' => $request->guest_count,
////            'crm' => $request->crm,
////            'room_no' => $request->room_no,
////            'single_bed' => $request->single_bed,
////            'double_bed' => $request->double_bed,
////            'sofa_bed' => $request->sofa_bed,
////            'wide_bed' => $request->wide_bed,
////            'futon' => $request->futon,
////            'extra_beds' => $request->extra_beds,
////            'area' => $request->area,
////            'price' => $request->price,
////            'type_id' => $request->type
////
////        ]);
//        $accommodation_data = [
////            'title' => $request->title_pyc,
//            "country_id" => $request->country,
//            'city_id' => $request->city,
//            'allow_pets' => $request->allow_pets,
//            'allow_child' => $request->allow_child,
//            'agree_terms' => $request->agree_terms,
//            'certify_terms' => $request->certify_terms,
////            'other_rules' => $request->other_rules_pyc,
////            'description' => $request->description_pyc,
//            'protection_booking' => $request->protection_booking,
//            'phone' => $request->phone,
//            'alt_phone' => $request->alt_phone,
//            'contact_person' => $request->contact_person,
//            'extra_beds' => $request->extra_beds,
//            'price' => $request->price,
//            'sales_channel' => $request->sales_channel!='on'?1:0,
////            'child_policy' => $request->child_policy_pyc,
//            'type' => 'villa'
//        ];
//        $acc = Accommodation::where('accommodationable_id',$request->obj_id)->first();
//        $acc->update($accommodation_data);
//        $address = Address::where('accommodation_id',$acc->id)->first();
//        $address->update([
//            'street_house' => $request->street_house,
//            'zip_code' => $request->zip_code,
//            'map' => $request->map
//        ]);
//
//        $check_in = CheckIn::where('accommodation_id',$acc->id)->first();
//        $check_in->update([
//            'from' => $request->check_in_from
//        ]);
//
//        $check_out = CheckOut::where('accommodation_id',$acc->id)->first();
//        $check_out->update([
//            'to' => $request->check_out_to
//        ]);
//
//        $langs = $request->langs;
//        DB::table('accommodation_lang')->where('accommodation_id', $acc->id)->delete();
//        if ($request->has('langs'))
//        {
//            foreach ($langs as $lang) {
//                DB::table('accommodation_lang')->insert([
//                    'accommodation_id' => $acc->id,
//                    'lang_id' => $lang
//                ]);
//            }
//        }
//
//        $payments = $request->payments;
//        DB::table('accommodation_payment')->where('accommodation_id', $acc->id)->delete();
//        if ($request->has('payments'))
//        {
//            foreach ($payments as $payment) {
//                DB::table('accommodation_payment')->insert([
//                    'accommodation_id' => $acc->id,
//                    'payment_id' => $payment
//                ]);
//            }
//        }
//        if ($request->has('amenities')) {
//            $amenities = $request->amenities;
//            DB::table('accommodation_amenity')->where('accommodation_id', $acc->id)->delete();
//            foreach ($amenities as $amenity) {
//                DB::table('accommodation_amenity')->insert([
//                    'accommodation_id' => $acc->id,
//                    'amenity_id' => $amenity
//                ]);
//            }
//        }
//
//        $policies = $request->policies;
//        DB::table('accommodation_policy')->where('accommodation_id', $acc->id)->delete();
//        foreach ($policies as $policy) {
//            DB::table('accommodation_policy')->insert([
//                'accommodation_id' => $acc->id,
//                'policy_id' => $policy
//            ]);
//        }
//
//        if ($request->has('services')) {
//            $services = collect(
//                $request->input('services', [])
//            )->map(function ($services) {
//                return ['price' => $services];
//            });
//            DB::table('accommodation_service')->where('accommodation_id', $acc->id)->delete();
//            foreach ($services as $key => $service) {
//                DB::table('accommodation_service')->insert([
//                    'accommodation_id' => $acc->id,
//                    'service_id' => $key,
//                    'price' => $service['price']
//                ]);
//            }
//        }

        $this->accommodationService->update($locale,$request, $action, $villa);
        $crm = Crm::where('accommodation_id',$villa->id)->first();
        if($crm){
            if($request->sale_channel_id != '' && $request->crm_code != ''){
                $crm->update([
                    'sale_channel_id' => $request->sale_channel_id,
                    'accommodation_crm_code' => $request->crm_code
                ]);
            } else{
                $crm->delete();
            }
        } else {
            if($request->sale_channel_id != '' && $request->crm_code != ''){
                $acc_id = Accommodation::where('accommodationable_id',$villa->id)->first()->id;
                if(!Crm::where([['accommodation_id',$acc_id],['sale_channel_id',$request->sale_channel_id],['accommodation_crm_code',$request->crm_code]])->first()) {
                    Crm::create([
                        'sale_channel_id' => $request->sale_channel_id,
                        'accommodation_crm_code' => $request->crm_code,
                        'accommodation_id' => $acc_id
                    ]);
                }
            }
        }
        return redirect()->route('user.objects',['locale'=>$locale]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
