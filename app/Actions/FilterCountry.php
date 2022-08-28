<?php

namespace App\Actions;

use App\Models\City;
use App\Contracts\FilterCountries;

class FilterCountry implements FilterCountries
{
    public function execute($country, $city_name)
    {
        $statement_ru = str_replace(['%"', '"%'], ["'%", "%'"], "JSON_VALUE(name, '$.ru') LIKE '{$city_name}%'");
        $statement_en = str_replace(['%"', '"%'], ["'%", "%'"], "JSON_VALUE(name, '$.en') LIKE '{$city_name}%'");
        return City::where('country_id', $country)
            ->where(function($query) use($statement_en, $statement_ru) {
                $query->whereRaw($statement_ru)->orWhereRaw($statement_en);
            })->get(['id', 'name']);
    }
}

