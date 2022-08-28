<?php

namespace App\Actions;

use App\Models\Appartment;

class AppartmentAction
{
    public function execute(Appartment $appartment)
    {
        return $appartment->with([
            'accommodation',
            'accommodation.check_ins',
            'accommodation.check_outs',
            'accommodation.services',
            'accommodation.amenities',
            'accommodation.address',
            'accommodation.policies',
            'accommodation.payments',
            'accommodation.check_outs',
            'images'
        ])->where('id', $appartment->id)
            ->first();
    }
}
