<?php

namespace App\Services\Accommodations;

use App\Models\Accommodation;

class SingleCartService
{
    /**
     * @param int $id
     * @return mixed
     */
    public function show(int $id): mixed
    {
        return Accommodation::find($id);
    }
}
