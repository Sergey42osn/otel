<?php

namespace App\Actions;

use App\Models\Type;
use App\Models\TypeName;
use App\Contracts\FilterCountries;

class FilterTypes implements FilterCountries
{
    public function execute($search_text)
    {

        return TypeName::where('type_id', $search_text)
            ->get(['id', 'name', 'type_id']);
    }
}
