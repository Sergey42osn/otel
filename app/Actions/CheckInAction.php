<?php

namespace App\Actions;

use App\Models\CheckIn;

class CheckInAction
{
    public function execute($data)
    {
        return CheckIn::create($data);
    }
}
