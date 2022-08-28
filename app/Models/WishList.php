<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WishList extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'wish_list';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'accommodation_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function accommodations()
    {
        return Accommodation::where('id',$this->accommodation_id)->first();
    }

    public function rating()
    {
        if($rating = Rating::where([['accommodation_id',$this->accommodation_id], ['user_id', $this->user_id]])->first()) {
            return $rating->rating;
        }
        return "";
    }
    function getPrice(){
        $acc = Accommodation::where('id',$this->accommodation_id)->first();
        if ($rooms = Room::where('roomable_id',$acc->accommodationable_id)->get()) {
            foreach ($rooms as $room) {
                if ($room->type_id == 1 && $room->price !="" ) {
                    return $room->price;
                }
            }
        }
        return $acc->price;

    }
}
