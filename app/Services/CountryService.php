<?php

namespace App\Services;

use App\Models\City;
use App\Models\Country;

class CountryService
{
    public function filter($name)
    {
        $countries = Country::where('name', 'LIKE', "%$name%")->get(['id', 'name']);
        $cities = City::where('name', 'LIKE', "%$name%")->get(['id', 'name', 'country_id']);
        $result = $countries->merge($cities);
        return $result;
    }
}
