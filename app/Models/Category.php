<?php

namespace App\Models;

use App\Traits\MorphManyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, MorphManyImages, HasTranslations;

    protected $table = 'category';
    public $translatable = ['title'];

    public function posts(){
        return $this->belongsToMany(Post::class, 'posts_category', 'category_id', 'post_id');
    }
}
