<?php

namespace App\Services;

use App\Models\Appartment;

class AppartementService
{
    public function index($type)
    {
        return Appartment::with([
            'accommodation',
            'accommodation.services',
            'accommodation.amenities',
            'accommodation.address',
            'accommodation.policies',
            'accommodation.payments',
            'accommodation.check_outs',
        ])->whereRelation('type', 'type', '=', $type)
            ->get();
    }


    public function filter($country, $city = null, $room = null, $adults = null, $childrens = null, $type)
    {
        return Appartment::with([
            'accommodation',
            'accommodation.services',
            'accommodation.amenities',
            'accommodation.address',
            'accommodation.policies',
            'accommodation.payments',
            'accommodation.check_outs',
            'images'
        ])
            ->when($country, fn ($q) => $q->whereRelation('accommodation', 'country_id', $country))
            ->when($city, fn ($q) => $q->whereRelation('accommodation', 'city_id', $city))
            ->when($type, fn ($q) => $q->whereRelation('type', 'type', $type))
            // ->when($room, function ($query) use ($room) {
            //     $query->withCount('rooms')
            //         ->having('rooms_count', $room);
            // })
            ->when($adults, fn ($q) => $q->whereRelation('rooms', 'guest_count', $adults))
            ->get();
    }
}
