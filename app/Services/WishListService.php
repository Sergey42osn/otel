<?php

namespace App\Services;

use App\Models\Accommodation;
use App\Models\WishList;

class WishListService
{
    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return  WishList::firstOrCreate($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function delete(array $data): mixed
    {
        return  WishList::where('id', $data['id'])->delete();
    }
}
