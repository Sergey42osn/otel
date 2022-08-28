<?php

namespace App\Actions;

class ResidenciesAction
{
    public function execute($mapper, $type)
    {
        return $mapper->with([
            'accommodation',
            'accommodation.services',
            'accommodation.amenities',
            'accommodation.address',
            'accommodation.policies',
            'accommodation.payments',
            'accommodation.check_outs',
        ])->whereRelation('type', 'type', '=', $type)
            ->get();
    }
}
