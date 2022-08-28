<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface SingleResidencyActions
{
    public function execute($mapper);
}
