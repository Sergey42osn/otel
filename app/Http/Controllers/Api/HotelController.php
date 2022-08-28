<?php

namespace App\Http\Controllers\Api;

use App\Actions\SingleResidencyAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use App\Services\HotelService;
use Illuminate\Http\Request;
use App\Models\Accommodation;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HotelService $service)
    {
        return HotelResource::collection($service->index('Hotel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
    }

    public function filter(Request $request, HotelService $service)
    {
        $request = $request->all()['request'];
        return HotelResource::collection($service->filter($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SingleResidencyAction $action)
    {
        // return HotelResource::collection($action->execute(Hotel::find($request->id)));
        $accomodation = Accommodation::find($request->id)->accommodationable()->with([
            'accommodation',
            'accommodation.check_ins',
            'accommodation.check_outs',
            'accommodation.services',
            'accommodation.amenities',
            'accommodation.address:accommodation_id,street_house,map',
            'accommodation.policies',
            'accommodation.payments:id,name',
            'accommodation.check_outs',
            'accommodation.city:id,name',
            'accommodation.country:id,name',
            'accommodation.langs:id,name',
            'images:id,imageable_id,url'
        ])->get();
        return response()->json($accomodation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
