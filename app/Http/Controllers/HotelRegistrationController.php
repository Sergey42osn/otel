<?php

namespace App\Http\Controllers;


use App\Models\Lang;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Actions\CheckInAction;
use App\Actions\CheckOutAction;
use App\Contracts\CreateNewResidencyContarct;
use App\Actions\CreateAccommodation;
use App\Http\Controllers\Controller;
use App\Actions\AddressCreatorAction;
use App\Actions\CreateNewHotel;
use App\Services\AccommodationService;
use App\Http\Requests\AccommodationFormRequest;
use App\Models\Policy;
use App\Models\Type;

class HotelRegistrationController extends Controller
{
    protected $accommodationService;

    public function __construct(AccommodationService $accommodationService)
    {
        $this->accommodationService = $accommodationService;
    }
    public function index(): View
    {
        return view(
            'registration.hotel',
            [
                'countries' => Country::all(['id', 'name']),
                'services' => Service::all(['id', 'name']),
                'langs' => Lang::all(['id', 'name']),
                'payments' => Payment::all(['id', 'name']),
                'types' => Type::all(['id', 'name', 'type']),
                'policies' => Policy::all(['id', 'name', 'type'])
            ]
        );
    }

    public function store(AccommodationFormRequest $request, CreateNewHotel $action, AddressCreatorAction $adressCreator, CheckInAction $checkIn,  CheckOutAction $checkOut, CreateAccommodation $createAccommodation)
    {

        $residency = $this->accommodationService->store($request, $action, $adressCreator, $checkIn, $checkOut, $createAccommodation);

        return redirect()->route('rooms.create', ['hotel_id' => $residency->id]);
    }
}
