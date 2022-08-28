<?php

namespace App\Contracts;

interface FilterCountries
{
    public function execute($country,$city_name);
}

