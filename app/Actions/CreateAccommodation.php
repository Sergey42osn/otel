<?php

namespace App\Actions;

class CreateAccommodation
{
    public function execute($mapper, array $data)
    {
        return $mapper->accommodation()->create($data);
    }
}
