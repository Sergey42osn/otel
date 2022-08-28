<?php

namespace App\Services;

use App\Models\Hotel;
use App\Models\Appartment;

class HotelService
{
    public function index($type)
    {
        return Hotel::with([
            'accommodation',
            'accommodation.services',
            'accommodation.amenities',
            'accommodation.address',
            'accommodation.policies',
            'accommodation.payments',
            'accommodation.check_outs',
            'rooms'
        ])->whereRelation('type', 'type', '=', $type)
            ->get();
    }

    public function filter($request)
    {
        $country = isset($request['country_id']) ? $request['country_id'] : null;
        $city = isset($request['city_id']) ? $request['city_id'] : null;
        $room = $request['rooms'];
        $adults = $request['adults'];
        $children = $request['children'];
        $properties = isset($request['property']) ? $request['property'] : [];
        $types = (isset($request['type']) && empty($properties)) ? $request['type'] : [];
        $stars = isset($request['stars']) ? $request['stars'] : [];
        $property_types = array_merge($properties, $types);

        if (!empty(array_intersect(['hotel', 'youth'], $property_types))) {
            $hotels = Hotel::with([
                'accommodation',
                'accommodation.services',
                'accommodation.amenities',
                'accommodation.address',
                'accommodation.policies',
                'accommodation.payments',
                'accommodation.check_outs',
                'accommodation.city',
                'accommodation.country',
                'rooms',
                'images'
            ])
            ->when($country, fn ($q) => $q->whereRelation('accommodation', 'country_id', $country))
            ->when($city, fn ($q) => $q->whereRelation('accommodation', 'city_id', $city))
            ->when(!empty($stars), fn ($q) => $q->whereIn('stars_num', $stars))
            ->get();
        } else {
            $hotels = collect();
        }

        if (!empty(array_intersect(['apartment', 'villa'], $property_types))) {
            $apartments = Appartment::with([
                'accommodation',
                'accommodation.services',
                'accommodation.amenities',
                'accommodation.address',
                'accommodation.policies',
                'accommodation.payments',
                'accommodation.check_outs',
                'accommodation.city',
                'accommodation.country',
                'images'
            ])
            ->when($country, fn ($q) => $q->whereRelation('accommodation', 'country_id', $country))
            ->when($city, fn ($q) => $q->whereRelation('accommodation', 'city_id', $city))
            ->get();
        } else {
            $apartments = collect();
        }
        if(isset($request['order_by'])) {
            if ($request['order_by'] == 'price') {

            }
        }
        return $hotels->merge($apartments);

    }


    public function show(int $id): mixed
    {
        return Hotel::find($id);
    }
}
