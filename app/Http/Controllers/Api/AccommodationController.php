<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AccommodationService;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{

    protected $service;

    public function __construct(AccommodationService $service)
    {
        $this->service = $service;
    }

    public function search(Request $request) {
        $request->merge([
            'check_in' => $request->start_date,
            'check_out' => $request->end_date,
            'accommodations' => $request->type
        ]);
        if (isset($request->city_id)) {
            $request->merge(['place_id' => $request->city_id, 'place_type' => 'city']);
        } elseif (isset($request->country_id)) {
            $request->merge(['place_id' => $request->country_id, 'place_type' => 'country']);
        }
        if (isset($request->order_by)) {
            if ($request->order_by == 'price' && $request->order_dir == 'asc') {
                $request->merge(['sort' => 'price_high']);
            }
            if ($request->order_by == 'price' && $request->order_dir == 'desc') {
                $request->merge(['sort' => 'price_lower']);
            }
            if ($request->order_by == 'stars' && $request->order_dir == 'asc') {
                $request->merge(['sort' => 'stars_least']);
            }
            if ($request->order_by == 'stars' && $request->order_dir == 'desc') {
                $request->merge(['sort' => 'stars_highest']);
            }
        }
        $data = $this->service->search($request, true)->toArray();
        foreach ($data as $index => &$acc) {
            $acc['accommodation']['city']['name'] = $acc['city']['name'];
            $acc['accommodation']['country']['name'] = $acc['country']['name'];
        }
        return response()->json(['data' => $data]);
    }
}
