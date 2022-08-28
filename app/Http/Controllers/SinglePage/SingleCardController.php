<?php

namespace App\Http\Controllers\SinglePage;


use App\Models\City;
use App\Models\Lang;
use App\Models\Type;
use App\Models\Hotel;
use App\Models\Policy;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\Payment;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Actions\CheckInAction;
use App\Actions\CheckOutAction;
use App\Actions\CreateNewHotel;
use Illuminate\Routing\Controller;
use App\Actions\CreateAccommodation;
use App\Contracts\UpdateResidencies;
use App\Actions\AddressCreatorAction;
use App\Actions\UpdateHotel;
use App\Actions\UpdateResidency;
use App\Services\AccommodationService;
use App\Contracts\SingleResidencyActions;
use App\Http\Requests\AccommodationFormRequest;
use App\Http\Requests\AccommodationUpdateFormRequest;

class HotelController extends Controller
{

    /**
     * @param $id
     * @return mixed
     */
    public function showSingle($id): mixed
    {
        $hotel = Hotel::find($id);

        return view(
            'single-page.hotel-show',
            [
                'hotel' => $hotel
            ]
        );
    }

}
