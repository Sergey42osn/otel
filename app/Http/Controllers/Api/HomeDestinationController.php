<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class HomeDestinationController extends Controller
{
    public function index()
    {
        $place_images = [
            118 => '/images/Moscow.png',
            153 => '/images/Sankt-Petersburg.png',
            954 => '/images/Sochi.png',
            234513 => '/images/Sevastopol.png',
            6998 => '/images/Yerevan.png',
            1265771 => '/images/Tsaghkadzor.jpg'
        ];
        $place_ids = [118,153,954,234513,6998,1265771];
        $place_ids_string = implode(',', $place_ids);
        $places = City::whereIn('id', $place_ids)
            ->with('country:id,name')
            ->orderByRaw("FIELD(id, {$place_ids_string})")
            ->get(['id', 'name', 'country_id']);
        $destinations = $places->map(function($place) use($place_images) {
            return ['id' => $place->id, 'name' => $place->name, 'image' => $place_images[$place->id], 'city' => $place];
        });

        return response()->json(['data' => $destinations]);
    }
}
