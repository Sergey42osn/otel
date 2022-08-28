<?php

namespace App\Models;

use App\Traits\MorphManyImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use App\Models\Image;

class Post extends Model
{
    use HasFactory, MorphManyImages, HasTranslations;

    public $translatable = ['title','second_title','preview_text','body'];


    public function categories(){
        return $this->belongsToMany(Category::class, 'posts_category', 'post_id', 'category_id');
    }

    public function images() {
        return $this->BelongsTo(Image::class);
    }

    public function mainImage() {
        $image =  Image::where([['imageable_type','App\Models\Post'],['imageable_id',$this->id]])->first();
        return $image->url;
    }
}
