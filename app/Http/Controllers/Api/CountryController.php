<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Actions\CountriesAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;

class CountryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, CountriesAction $action)
    {
        return CountryResource::collection($action->execute());
    }
}
