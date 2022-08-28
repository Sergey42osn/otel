<?php

namespace App\Contracts\Api;

Interface TravelLineContract
{
    /**
     * @param $data
     * @return mixed
     */
    public function getAccommodationIds($data);
}
