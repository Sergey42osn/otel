<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryCityFilterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, CountryService $service)
    {
        return CountryResource::collection($service->filter($request->name));
    }
}
