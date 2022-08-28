<?php

namespace App\Http\Controllers\Api;

use App\Actions\AppartmentAction;
use App\Actions\ResidenciesAction;
use App\Models\Appartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\SingleResidencyActions;
use App\Http\Resources\AppartmentResource;
use App\Services\AppartementService;

class AppartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AppartementService $action)
    {
        return AppartmentResource::collection($action->index("Appartment"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show($id, AppartmentAction $action)
    {

        return AppartmentResource::collection($action->execute(Appartment::find($id)));
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


    public function filter(Request $request, AppartementService $service)
    {
        return AppartmentResource::collection($service->filter($request->country_id, $request->city_id, $request->room, $request->adults, $request->children, "Appartment"));
    }
}
