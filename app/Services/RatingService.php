<?php

namespace App\Services;

use App\Models\Accommodation;
use App\Models\Rating;
use Facades\App\Actions\Base64FileUploader;
use Facades\App\Actions\StoreImages;

class RatingService
{
    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        $rating = Rating::create($data);
        return $rating->load(['user' => function($query){
            $query->with('image');
        }]);
    }

    public function updateAvarageRating(Rating $rating)
    {
        $average_rating = Rating::where('accommodation_id', $rating->accommodation_id)->avg('rating');
        Accommodation::where('id', $rating->accommodation_id)->update(['avg_rating' => $average_rating]);
    }
}
