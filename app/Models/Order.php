<?php

namespace App\Models;

use App\Traits\MorphManyImages;
use App\Traits\MorphManyRooms;
use App\Traits\MorphOneAccommodationable;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use PHPUnit\Exception;
use Spatie\Translatable\HasTranslations;


class Order extends Model
{
    use HasFactory, MorphOneAccommodationable, MorphManyImages, MorphManyRooms, HasTranslations;

    protected $guarded = [];
    public $translatable = ['object_title', 'room_name'];

    public function type()
    {
        return $this->belongsTo(User::class);
    }

    public function accommodations()
    {
        return Accommodation::find($this->object_id);
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'object_id', 'id');
    }

    public function getCountry() {
        return Country::find($this->country_id)?Country::find($this->country_id)->name:"";
    }

    public function getCity() {
        return City::find($this->city_id)?City::find($this->city_id)->name:"";
    }

    public function getStatus(){
        if ($this->status == 0) {
            return '<span class="status waiting">'.__("hotel.booking_history.process").'</span>';
        } elseif ($this->status == 1) {
            return '<span class="status ">'.__("hotel.booking_history.finished").'</span>';

        } else {
            return '<span class="status " style="color:gray">'.__("hotel.booking_history.cancelStatus").'</span>';
        }
    }

    public function getPaymentLink() {
        $this->update([
            'order_id' => strtotime("now")
        ]);
        $payment_url = 'https://partner.life-pay.ru/alba/input';
        $key = env('LIFEPAY_KEY');
        $request_data = array(
            'key' => $key,
            'cost' => $this->price,
            'name' => $this->name,
            'default_email' => $this->email,
            'order_id' => $this->order_id
        );
        $http_query_params = http_build_query($request_data);
        return $payment_url.'?'.$http_query_params;
    }

    public function getPaymentStatus() {
        if ($this->payment == 1) {
            return __('account.order.Cash on delivery');
        } elseif ($this->payment != 1 && !empty($this->transaction_id)) {
            return __('account.order.Paid');
        }
        return __('account.order.Not paid');
    }
    public function allowedPayment()
    {
        if ($this->payment != 1 && empty($this->transaction_id) && $this->canceled_message=='') {
            return true;
        }
        return false;
    }

    public function getDuration()
    {
        $date1=date_create($this->check_out);
        $date2=date_create($this->check_in);
        $diff=date_diff($date1,$date2);
        return $diff->format("%a");
    }

    public function roomType()
    {
        if ($room = Room::find($this->room_id)) {
            if ($type = TypeName::find($room->type_id)){
                return $type->name;
            }
        }
        return "";

    }
}
