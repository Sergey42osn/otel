<?php

namespace App\Actions;

class StoreImages
{
    public function execute($mapper, $url, $featured = false)
    {
        return $mapper->images()->create(['url' => $url, 'featured_image' => $featured]);
    }
}
