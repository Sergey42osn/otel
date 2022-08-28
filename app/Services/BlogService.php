<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;

class BlogService
{
    /**
     * @return Post[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPosts()
    {
        return Post::with('categories')->paginate(6);
    }

    public function getPostsCategories()
    {
        return Category::all();
    }

    public function getPostsWithCurrentCategory($category)
    {
        $posts = Post::with('categories')->whereHas("categories", function ($query) use($category) {
            $query->where('slug', $category);
        })->paginate(6);
        return $posts;
    }

    /**
     * @return Post[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCurrentPost($slug)
    {
        return
            [
                "main_post" => Post::query()->where("is_recommended", 0)->first(),
                "posts" => Post::query()->where("is_recommended", 1)->with('categories')->get(),
            ];
    }

    public function getRecommendedPosts()
    {
        return Post::query()->where("is_recommended", 1)->get();
    }


}
