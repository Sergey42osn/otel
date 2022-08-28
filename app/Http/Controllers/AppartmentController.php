<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Crm;
use App\Models\SalesChannel;
use App\Models\Lang;
use App\Models\Type;
use App\Models\Policy;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Appartment;
use App\Actions\CheckInAction;
use App\Actions\CheckOutAction;
use Illuminate\Routing\Controller;
use App\Actions\CreateAccommodation;
use App\Actions\CreateNewAppartment;
use App\Actions\AddressCreatorAction;
use App\Actions\AppartmentAction;
use App\Actions\UpdateAppartment;
use App\Services\AccommodationService;
use App\Http\Resources\AppartmentResource;
use App\Http\Requests\AccommodationUpdateFormRequest;
use App\Http\Requests\AccommodationFormRequest;

class AppartmentController extends Controller
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

        return view('registration.appartment', [
            'services' => Service::all(['id', 'name']),
            'amenities' => Amenity::where('general',1)->get(['id', 'name']),
            'amenities_select' => Amenity::where('general',0)->get(['id', 'name']),
            'types' => Type::all(['id', 'name', 'type'])->where('type', 'Appartment'),
            'countries' => Country::all(['id', 'name','iso2']),
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
        return redirect()->route('user.objects', ['locale' => app()->getLocale()]);
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
    public function show($locale, Appartment $appartment, AppartmentAction $action)
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
        $app = $action->execute($appartment);

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
            'registration.appartment-show',
            [
                'countries' => Country::all(['id', 'name', 'iso2']),
                'amenities' => Amenity::where('general',1)->get(['id', 'name']),
                'amenities_select' => Amenity::where('general',0)->get(['id', 'name']),
                'langs' => Lang::where('general',1)->get(['id', 'name']),
                'langs_select' => Lang::where('general',0)->get(['id', 'name']),
                'langSelectedId' => Lang::where('general',0)->pluck('id') ,
                'payments' => Payment::all(['id', 'name']),
                'types' => Type::all(['id', 'name', 'type'])->where('type', 'Appartment'),
                'policies' => Policy::all(['id', 'name', 'type']),
                'appartment' => $app,
                'services' => Service::all(['id', 'name'])->whereNotIn('id', $appartment->accommodation->services->pluck('id')),
                // 'cities' => City::all(['id', 'name'])
                'iso2' => $iso2,
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($locale, AccommodationUpdateFormRequest $request, Appartment $appartment, UpdateAppartment $action)
    {
        $appartment->update([
            'bathroom_count' => $request->bathroom_count,
            'guest_count' => $request->guest_count,
            'crm' => $request->crm,
            'single_bed' =>$request->single_bed,
            'double_bed' => $request->double_bed,
            'wide_bed' => $request->wide_bed,
            'sofa_bed' => $request->sofa_bed,
            'futon' => $request->futon
        ]);
        $this->accommodationService->update($locale,$request, $action, $appartment);
        $crm = Crm::where('accommodation_id',$appartment->id)->first();
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
                $acc_id = Accommodation::where('accommodationable_id',$appartment->id)->first()->id;
                if(!Crm::where([['accommodation_id',$acc_id],['sale_channel_id',$request->sale_channel_id],['accommodation_crm_code',$request->crm_code]])->first()){
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
