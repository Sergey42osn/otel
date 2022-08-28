<?php

namespace App\Http\Controllers\Api;

use App\Models\Accommodation;
use Illuminate\Http\Request;
use App\Contracts\FilterCountries;
use App\Http\Controllers\Controller;
use App\Http\Resources\FilterCountryResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Country;
use App\Models\City;

class CountryFilterCountroller extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, FilterCountries $action): JsonResource
    {

        return FilterCountryResource::collection($action->execute($request->country_id, $request->city_name));
    }


    public function searchByName(Request $request) {
        $cities = City::where('name', 'like', '%'.$request->name.'%')->where('country_id', '>', 0)->with('country:id,name')->offset(0)->limit(5)->get(['id', 'name', 'country_id']);
        $countries = Country::where('name', 'like', '%'.$request->name.'%')->offset(0)->limit(5)->get(['id', 'name']);
        $locations = $countries->merge($cities)->toArray();
        foreach ($locations as &$location) {
            $location['name'] = $location['name']['ru'];
            if(isset($location['country'])) {
                $location['country']['name'] = $location['country']['name']['ru'];
            }
        }
        return response()->json(['data' => $locations]);
    }

    public function locationByName(Request $request) {
        $search_keyword = $request->get('name');
        $locale = app()->getLocale();
        $statement_ru = str_replace(['%"', '"%'], ["'%", "%'"], "JSON_VALUE(title, '$.ru') LIKE '%{$search_keyword}%'");
        $statement_en = str_replace(['%"', '"%'], ["'%", "%'"], "JSON_VALUE(title, '$.en') LIKE '%{$search_keyword}%'");
        $statement_country_ru = str_replace(['%"', '"%'], ["'%", "%'"], "JSON_VALUE(name, '$.ru') LIKE '{$search_keyword}%'");
        $statement_country_en = str_replace(['%"', '"%'], ["'%", "%'"], "JSON_VALUE(name, '$.en') LIKE '{$search_keyword}%'");
        $statement_city_ru = str_replace(['%"', '"%'], ["'%", "%'"], "JSON_VALUE(name, '$.ru') LIKE '{$search_keyword}%'");
        $statement_city_en = str_replace(['%"', '"%'], ["'%", "%'"], "JSON_VALUE(name, '$.en') LIKE '{$search_keyword}%'");
//        $cities = City::where('name', 'like', '%'.$request->name.'%')->offset(0)->limit(5)->where('country_id', '>', 0)->with('country:id,name')->get(['id', 'name', 'country_id']);
        $cities = City::whereRaw($statement_city_ru)->orWhereRaw($statement_city_en)->offset(0)->limit(5)->where('country_id', '>', 0)->with('country:id,name')->get(['id', 'name', 'country_id']);
//        $countries = Country::where('name', 'like', '%'.$request->name.'%')->offset(0)->limit(5)->get(['id', 'name']);
        $countries = Country::whereRaw($statement_country_ru)->orWhereRaw($statement_country_en)->offset(0)->limit(5)->get(['id', 'name']);
        $accommodations = Accommodation::whereRaw($statement_ru)->orWhereRaw($statement_en)->with(['city:id,name', 'country:id,name'])->offset(0)->limit(5)->get(['id', 'title as name', 'city_id', 'country_id', 'type'])->map(function($accommodation) {
            $accommodation->name = json_decode($accommodation->name);
            return $accommodation;
        });
        return response()->json(['data' => $accommodations->merge($cities)->merge($countries)]);
    }
}

