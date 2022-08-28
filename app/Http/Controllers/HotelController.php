<?php

namespace App\Http\Controllers;


use App\Http\Requests\AccommodationUpdateFormRequest;
use App\Models\Accommodation;
use App\Models\Appartment;
use App\Models\City;
use App\Models\Crm;
use App\Models\Lang;
use App\Models\Service;
use App\Models\Type;
use App\Models\Hotel;
use App\Models\Policy;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\Payment;
use App\Models\SalesChannel;
use App\Models\UserPermission;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Actions\CheckInAction;
use App\Actions\CheckOutAction;
use App\Actions\CreateNewHotel;
use Illuminate\Routing\Controller;
use App\Actions\CreateAccommodation;
use App\Contracts\UpdateResidencies;
use App\Actions\AddressCreatorAction;
use App\Actions\UpdateHotel;
use App\Actions\UpdateResidency;
use App\Services\AccommodationService;
use App\Actions\SingleResidencyAction;
use App\Http\Requests\AccommodationFormRequest;

class HotelController extends Controller
{
    protected $accommodationService;
    protected $action;
    public function __construct(AccommodationService $accommodationService,  SingleResidencyAction $action)
    {
        $this->accommodationService = $accommodationService;
        $this->action = $action;
    }
    public function index(): View
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return view(
            'registration.hotel',
            [
                'countries' => Country::all(['id', 'name', 'iso2']),
                'amenities' => Amenity::where('general',1)->get(['id', 'name']),
                'amenities_select' => Amenity::where('general',0)->get(['id', 'name']),
                'langs' => Lang::where('general',1)->get(['id', 'name']),
                'langs_select' => Lang::where('general',0)->get(['id', 'name']),
                'payments' => Payment::all(['id', 'name']),
                'types' => Type::all(['id', 'name', 'type'])->where('type', 'Hotel'),
                'policies' => Policy::all(['id', 'name', 'type']),
                'iso2' => $iso2,
                'services' => Service::all('id', 'name'),
                'ru_sale_channels' => $arr_sale_ru,
                'en_sale_channels' => $arr_sale_en,
                'crm_acc_code' => $crm_code,
                'crm_code_with_sale_id' => $crm_code_with_sale_id
            ]
        );
    }

    public function store(AccommodationFormRequest $request, CreateNewHotel $action, AddressCreatorAction $adressCreator, CheckInAction $checkIn,  CheckOutAction $checkOut, CreateAccommodation $createAccommodation)
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
        return redirect()->route('rooms.create', ['locale' => app()->getLocale(), 'hotel_id' => $residency->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($locale, Hotel $hotel)
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
        $hot = $this->action->execute($hotel);

        $crm_acc_code = Crm::get(['sale_channel_id','accommodation_crm_code','accommodation_id']);
        $crm_acc_id = $hot->id;
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
//        return $hot;
        return view(
            'registration.hotel-show',
            [
                'countries' => Country::all(['id', 'name', 'iso2']),
                'amenities' => Amenity::where('general',1)->get(['id', 'name']),
                'amenities_select' => Amenity::where('general',0)->get(['id', 'name']),
                'langs' => Lang::where('general',1)->get(['id', 'name']),
                'langs_select' => Lang::where('general',0)->get(['id', 'name']),
                'langSelectedId' => Lang::where('general',0)->pluck('id') ,
                'payments' => Payment::all(['id', 'name']),
                'types' => Type::all(['id', 'name', 'type'])->where('type', 'Hotel'),
                'policies' => Policy::all(['id', 'name', 'type']),
                'hotel' => $hot,
                'iso2' => $iso2,
                'ru_sale_channels' => $arr_sale_ru,
                'en_sale_channels' => $arr_sale_en,
                'crms' => Crm::where('accommodation_id',$hot->accommodation->id)->first(),
                'this_acc_id' => $crm_acc_id,
                'crm_acc_code' => $crm_code,
                'crm_code_with_sale_id' => $crm_code_with_sale_id,
                'crm_acc_ids' => $acc_ids
            ]
        );

        // 'hotel' => $this->action->execute($hotel),
        // 'countries' => Country::all(['id', 'name']),
        // 'amenities' => Amenity::all(['id', 'name']),
        // 'langs' => Lang::all(['id', 'name']),
        // 'payments' => Payment::all(['id', 'name']),
        // 'types' => Type::all(['id', 'name', 'type']),
        // 'policies' => Policy::all(['id', 'name', 'type']),
        // 'cities' => City::all(['id', 'name'])
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($locale, Hotel $hotel)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($locale, AccommodationUpdateFormRequest $request, Hotel $hotel, UpdateHotel $action)
    {
        $residency = $this->accommodationService->update($locale,$request, $action, $hotel);
//        return $hotel->id;
        $acc_id = Accommodation::where('accommodationable_id',$hotel->id)->first()->id;
        $crm = Crm::where('accommodation_id',$acc_id)->first();
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
                if($request->sale_channel_id != '' && $request->crm_code != '' ){
                    $acc_id = Accommodation::where('accommodationable_id',$hotel->id)->first()->id;
                    if(!Crm::where([['accommodation_id',$acc_id],['sale_channel_id',$request->sale_channel_id],
                        ['accommodation_crm_code',$request->crm_code]])->first()){
                        Crm::create([
                            'sale_channel_id' => $request->sale_channel_id,
                            'accommodation_crm_code' => $request->crm_code,
                            'accommodation_id' => $acc_id
                        ]);
                    }

                }
            }
        return redirect()->route('user.objects', ['locale' => $locale]);
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
