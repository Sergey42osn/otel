<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyService
{
    public function create($name)
    {
        $userCompany = Company::where('user_id', Auth::id())->first();
        if ($userCompany) {
            $userCompany->name = $name;
            $userCompany->save();
        } else {
            $company = new Company;
            $company->user_id = Auth::id();
            $company->name = $name;
            $company->save();
        }

        return $name;
    }

    public function updateName(Company $company, $name)
    {
        $company->$name = $name;
        $company->save();
    }

    public function updateAddress($country, $city, $address, $postal_code)
    {
        $userCompany = Company::where('user_id', Auth::id())->first();
        if ($userCompany) {
            $userCompany->country = $country;
            $userCompany->city = $city;
            $userCompany->address = $address;
            $userCompany->postal_code = $postal_code;
            $userCompany->save();
        } else {
            $company = new Company();
            $company->country = $country;
            $company->city = $city;
            $company->address = $address;
            $company->postal_code = $postal_code;
            $company->save();
        }
    }
    public function updateTin($phone)
    {
        $userCompany = Company::where('user_id', Auth::id())->first();
        if ($userCompany) {
            $userCompany->tin = $phone;
            $userCompany->save();
        } else {
            $company = new Company();
            $company->tin = $phone;
            $company->save();
        }
    }

    public function updateDirector($name, $last)
    {

        $userCompany = Company::where('user_id', Auth::id())->first();

        if ($userCompany) {
            $userCompany->director_name = $name;
            $userCompany->director_last_name = $last;
            $userCompany->save();
        } else {
            $company = new Company;
            $company->user_id = Auth::id();
            $company->director_name = $name;
            $company->director_last_name = $last;
            $company->save();
        }
    }
}
