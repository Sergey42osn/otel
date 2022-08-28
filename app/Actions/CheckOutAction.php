<?php

namespace App\Actions;

use App\Models\CheckOut;

class CheckOutAction
{
    public function execute($data)
    {
        return CheckOut::create($data);
    }
}
