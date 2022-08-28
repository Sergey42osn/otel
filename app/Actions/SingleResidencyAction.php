<?php

namespace App\Actions;

use App\Contracts\SingleResidencyActions;


class SingleResidencyAction implements SingleResidencyActions
{
    public function execute($mapper)
    {
        return $mapper->with([
            'accommodation',
            'accommodation.check_ins',
            'accommodation.check_outs',
            'accommodation.services',
            'accommodation.amenities',
            'accommodation.address',
            'accommodation.policies',
            'accommodation.payments',
            'accommodation.check_outs',
            'accommodation.city',
            'accommodation.country',
            'rooms',
            'images'
        ])->where('id', $mapper->id)
            ->first();
    }
}
