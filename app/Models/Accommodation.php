<?php

namespace App\Models;

use App\Models\Address;
use App\Traits\MorphOneAccommodationable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Accommodation extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];
    public $translatable = ['title','description', 'other_rules', 'child_policy'];

//    protected $fillable = [
//        'title',
//        'price',
//        'sales_channel',
//        'description',
//        'extra_beds',
//        'agree_terms',
//        'certify_terms',
//        'allow_pets',
//        'allow_child',
//        'child_policy',
//        'country_id',
//        'city_id',
//        'other_rules',
//        'protection_booking',
//        'contact_person',
//        'phone',
//        'alt_phone',
//        'banner_image',
//        'user_id',
//        'type'
//    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot(['price']);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function  chanelObject(): hasOne
    {
        return $this->hasOne(Crm::class, 'accommodation_id' ,'id');
    }

    public function policies(): BelongsToMany
    {
        return $this->belongsToMany(Policy::class);
    }

    public function langs(): BelongsToMany
    {
        return $this->belongsToMany(Lang::class);
    }

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class);
    }

    public function cancellation(): HasOne
    {
        return $this->hasOne(Cancellation::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function ratings_number()
    {
        return $this->ratings()->count() > 0 ? number_format((float)$this->ratings()->sum("rating") / $this->ratings()->count() ,1) : 0;
    }

    public function accommodationable(): MorphTo
    {
        return $this->morphTo();
    }

    public function accommodationable_hotel(): HasMany
    {
        return $this->HasMany(Hotel::class,"id","accommodationable_id")->where("accommodationable_type",Hotel::class);
    }

    public function check_ins()
    {
        return $this->hasOne(CheckIn::class);
    }

    public function check_outs()
    {
        return $this->hasMany(CheckOut::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeHotel($query)
    {
        return $query->where('type','hotel');
    }
    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }

    public function scopeVilla($query)
    {
        return $query->where('type','villa');
    }

    public function scopeApartment($query)
    {
        return $query->where('type','apartment');
    }

    public function scopeYouthHotel($query)
    {
        return $query->where('type', 'youth_hotel');
    }

    public function scopeOrHotel($query)
    {
        return $query->orWhere('type', 'hotel');
    }

    public function scopeOrVilla($query)
    {
        return $query->orWhere('type', 'villa');
    }

    public function scopeOrApartment($query)
    {
        return $query->orWhere('type', 'apartment');
    }

    public function scopeOrYouthHotel($query)
    {
        return $query->orWhere('type', 'youth_hotel');
    }

    /**
     * @return HasOne
     */
    public function wishList(): HasOne
    {
        return $this->hasOne(WishList::class);
    }

    /**
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class)->orderBy('id','desc');
    }


    public function ratingCount(): ?float
    {
        $ratings = Rating::where('accommodation_id', $this->id)->get();
        $sum = null;
        foreach ($ratings as $rating){
            $sum += $rating->rating;
        }
        if ($ratings && $sum){

            return round($sum/$ratings->count(), 1);
        }

        return 0;

    }

    public function hotel()
    {
        return Hotel::with('images')->find($this->accommodationable_id);
    }

    public function appartment()
    {
        return Appartment::with('images')->find($this->accommodationable_id);
    }

    public function getImage(){
        return "";
    }

    public function featured_image() {
        return $this->accommodationable->images()->where('featured_image', 1)->first();
    }
    public function city_name() {
        return City::find($this->city_id)?City::find($this->city_id)->name:"";
    }

}
