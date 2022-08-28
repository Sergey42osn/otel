<?php

namespace App\Actions;

use App\Models\Country;

class CountriesAction
{
    public function execute()
    {
        return Country::all(['id', 'name']);
    }
}
