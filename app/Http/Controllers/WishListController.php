<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishListRequest;
use App\Models\Lang;
use App\Models\Type;
use App\Models\Policy;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\Service;
use App\Services\WishListService;
use Illuminate\Http\Request;
use App\Actions\CheckInAction;
use App\Actions\CheckOutAction;
use Illuminate\Routing\Controller;
use App\Actions\CreateAccommodation;
use App\Actions\CreateNewAppartment;
use App\Actions\AddressCreatorAction;
use App\Services\AccommodationService;
use App\Http\Requests\AccommodationFormRequest;
use App\Http\Requests\AccommodationUpdateFormRequest;

class WishListController extends Controller
{
    /**
     * @var WishListService
     */
    protected WishListService $wishListService;

    /**
     * @param WishListService $wishListService
     */
    public function __construct(WishListService $wishListService)
    {
        $this->wishListService = $wishListService;
    }

    /**
     * @param WishListRequest $request
     * @return mixed
     */
    public function create()
    {
        //
    }

    public function store(WishListRequest $request): mixed
    {
        $data = $request->validated();
        $data['user_id'] = \Auth::user()->id;

        return $this->wishListService->store($data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request): mixed
    {
        $data = $request->all();

        return $this->wishListService->delete($data);
    }

}
