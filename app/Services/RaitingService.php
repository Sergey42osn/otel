<?php

namespace App\Services;

use App\Models\Accommodation;
use App\Actions\CheckInAction;
use App\Actions\CheckOutAction;
use App\Contracts\CreateNewResidencyContarct;
use App\Actions\CreateAccommodation;
use App\Actions\AddressCreatorAction;
use App\Contracts\AddressCreatorActions;
use App\Contracts\UpdateResidencies;
use App\Http\Requests\AccommodationFormRequest;
use App\Http\Requests\AccommodationUpdateFormRequest;
use Illuminate\Support\Facades\Auth;
use Facades\App\Actions\Base64FileUploader;

class AccommodationService
{
    public function create()
    {
    }
    public function edit()
    {
    }
    public function update(AccommodationUpdateFormRequest $request, UpdateResidencies $action, $model)
    {
        $residency = $action->execute($model, $request);

        $data = $this->accommodationData($request);


        $residency->accommodation()->update($data);


        $address['street_house'] = $request->street_house;
        $address['zip_code'] = $request->zip_code;
        $address['map'] = $request->map;

        $residency->accommodation->address()->update($address);
        // Check_in
        $check_out = [];
        $check_out['from'] = $request->check_out_from;
        $check_out['to'] = $request->check_out_to;

        $residency->accommodation->check_outs()->update($check_out);

        // Checkin data
        $check_in = [];
        $check_in['from'] = $request->check_in_from;
        $check_in['to'] = $request->check_in_to;
        $residency->accommodation->check_ins()->update($check_in);
        $accommodation = $residency->accommodation;
        $accommodation->policies()->sync($request->policies);
        if ($request->has('services')) {
            $services = collect(
                $request->input('services', [])
            )->map(function ($services) {
                return ['price' => $services];
            })->filter(fn ($service) => $service !== null);
            $accommodation->services()->sync($services);
        }
        if ($request->has('amenities')) {

            $accommodation->amenities()->sync($request->amenities);
        }
        $accommodation->langs()->sync($request->langs);
        $accommodation->payments()->sync($request->payments);

        $accommodation
            ->setTranslation('description', 'en', $request->description)
            ->setTranslation('other_rules', 'en', $request->other_rules)
            ->setTranslation('child_policy', 'en', $request->child_policy)
            ->setTranslation('description', 'ru', $request->description_pyc)
            ->setTranslation('other_rules', 'ru', $request->other_rules_pyc)
            ->setTranslation('child_policy', 'ru', $request->child_policy_pyc);
        $accommodation->update();
    }
    public function delete(Accommodation $accommodation): void
    {
        $accommodation->delete();
    }

    public function store(AccommodationFormRequest $request, CreateNewResidencyContarct $action, AddressCreatorActions $adressCreator, CheckInAction $checkIn, CheckOutAction $checkOut, CreateAccommodation $createAccommodation)
    {

        $residency = $action->create($request);

        $data =  $this->accommodationData($request);
        $data['user_id'] = Auth::id();
        $accommodation = $createAccommodation->execute(
            $residency,
            $data
        );


        // Translations
        $accommodation
            ->setTranslation('description', 'en', $request->description)
            ->setTranslation('other_rules', 'en', $request->other_rules)
            ->setTranslation('child_policy', 'en', $request->child_policy)
            ->setTranslation('description', 'ru', $request->description_pyc)
            ->setTranslation('other_rules', 'ru', $request->other_rules_pyc)
            ->setTranslation('child_policy', 'ru', $request->child_policy_pyc);
        $accommodation->update();

        $accommodation->policies()->sync($request->policies);
        if ($request->has('services')) {
            $services = collect(
                $request->input('services', [])
            )->map(function ($services) {
                return ['price' => $services];
            })->filter(fn ($service) => $service !== null);
            $accommodation->services()->sync($services);
        }
        if ($request->has('amenities')) {

            $accommodation->amenities()->sync($request->amenities);
        }
        $accommodation->langs()->sync($request->langs);
        $accommodation->payments()->sync($request->payments);

        // Address Data
        $address = [];
        $address['accommodation_id'] = $accommodation->id;
        $address['street_house'] = $request->street_house;
        $address['zip_code'] = $request->zip_code;
        $address['map'] = $request->map;
        $adressCreator->execute($address);

        // Check_in
        $check_out = [];
        $check_out['from'] = $request->check_out_from;
        $check_out['to'] = $request->check_out_to;
        $check_out['accommodation_id'] = $accommodation->id;
        $checkOut->execute($check_out);

        // Checkin data
        $check_in = [];
        $check_in['from'] = $request->check_in_from;
        $check_in['to'] = $request->check_in_to;
        $check_in['accommodation_id'] = $accommodation->id;

        $checkIn->execute($check_in);

        return $residency;
    }

    private function accommodationData($request)
    {

        $accommodation_data = [
            'title' => $request->name,
            "country_id" => $request->country,
            'city_id' => $request->city,
            'allow_pets' => $request->allow_pets,
            'allow_child' => $request->allow_child,
            'agree_terms' => $request->agree_terms,
            'certify_terms' => $request->certify_terms,
            'other_rules' => $request->other_rules_pyc,
            'description' => $request->description_pyc,
            'protection_booking' => $request->protection_booking,
            'phone' => $request->phone,
            'alt_phone' => $request->alt_phone,
            'contact_person' => $request->contact_person,
            'extra_beds' => $request->extra_beds,
            'price' => $request->price,
            'child_policy' => $request->child_policy_pyc
        ];
        return $accommodation_data;
    }



    // public function get(Hotel, $type)
    // {
    //     $query = $accommodation::query()
    //         ->with([
    //             'services',
    //             'amenities',
    //             'address',
    //             'policies',
    //             'payments',
    //             'check_outs',
    //             'accommodationable'
    //         ])
    //         ->where('accommodationable_type', "App\\Models\\" . $type)
    //         ->where('accommodationable_type', "App\\Models\\" . $type)
    //         ->get();
    // }
}
