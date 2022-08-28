<?php

namespace App\Models;

use App\Models\Accommodation;
use App\Models\Image;
use App\Models\User;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'rating',
        'comment',
        'user_id',
        'accommodation_id',
        'created_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accommodation(): BelongsTo
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function getUserInfo() {
        return User::find($this->user_id);
    }
    public function getObject() {
        return Accommodation::find($this->accommodation_id);
    }
    public function getImage() {
        if(Image::where('imageable_id',$this->accomodation_id)->first()){
            return "/storage/uploads/".Image::where('imageable_id',$this->accomodation_id)->first()->url;
        }
        return  "";
    }

    public function getComments() {
        return self::where('accommodation_id',$this->accommodation_id)->orderBy('created_at','DESC')->paginate(5);
    }
    public function getComment() {
        return self::where('accommodation_id',$this->accommodation_id)->orderBy('created_at','DESC')->get();
    }

    public function accommodations()
    {
        return Accommodation::find($this->accommodation_id);

    }
    public function getBooking() {
        return Order::where([['object_id',$this->accommodation_id],['user_id',$this->user_id]])->orderBy('id', 'DESC')->first();
    }


    public function getAnswer() {
        return RatingAnswer::where([['rating_id',$this->id],['type',1]])->first();
    }

    public function getAnswerAdmin() {
        return RatingAnswer::where([['rating_id',$this->id],['type',2]])->first();
    }
}
