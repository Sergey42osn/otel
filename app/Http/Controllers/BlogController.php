<?php

namespace App\Http\Controllers;
use App\Services\BlogService;
use App\Models\Post;
use App\Models\Image;

class BlogController extends Controller
{
    protected $service;
    public $categories;
    public $recommendedPosts;

    public function __construct(BlogService $service)
    {
        $this->service = $service;
        $this->categories = $this->service->getPostsCategories();
        $this->recommendedPosts = $this->service->getRecommendedPosts();
    }

    public function index()
    {

        $posts = $this->service->getPosts();

        return view("navs.blogs",
                ["posts" => $posts,
                 "categories" => $this->categories,
                 "recommendedPosts" => $this->recommendedPosts]);
    }

    public function category($category)
    {
        $posts = $this->service->getPostsWithCurrentCategory($category);
        return view("navs.blogs",
               ["posts" => $posts,
               "categories" => $this->categories,
               'currentCategory' => $category,
               "recommendedPosts" => $this->recommendedPosts]);
    }

    public function show($locale,$category,$slug)
    {
        $posts = $this->service->getCurrentPost($slug);
        $main_post = Post::where('slug',$slug)->first();
        //return Image::where('imageable_type','App\Models\Post')->get();
        return view("blog.current_blog", ["main_post" => $main_post, "posts" => $posts["posts"]]);
    }
}
