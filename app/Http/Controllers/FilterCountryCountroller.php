<?php

namespace App\Http\Controllers;

use App\Actions\FilterCountry;
use App\Contracts\FilterCountries;
use App\Http\Resources\FilterCountryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterCountryCountroller extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, FilterCountry $action): JsonResource
    {
        return FilterCountryResource::collection($action->execute($request->parent_id, $request->city_name ? $request->city_name['term'] : ""));
    }
}

