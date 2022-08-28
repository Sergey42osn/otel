<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenity;
use App\Models\Service;

class ApiController extends Controller
{
    public function index()
    {
        $amenities = Amenity::all(['id', 'name', 'icon']);
        $services = Service::all(['id', 'name', 'price', 'icon']);
        return response()->json(['data' => ['amenities' => $amenities, 'services' => $services]]);
    }
}
