<?php

namespace App\Actions;

use App\Contracts\AddressCreatorActions;
use App\Models\Address;

class AddressCreatorAction implements AddressCreatorActions
{
    public function execute($data)
    {
        return Address::create($data);
    }
}
