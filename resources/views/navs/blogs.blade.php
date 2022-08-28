@extends("layouts.app")

@section('styles')
    {{--    <link rel="stylesheet" href="{{asset('/public/blog/css/style.css')}}">--}}
@endsection

@section('contents')
    <div id="blog-feed">
        <section class="banner-section">
            <div class="banner-part" style="background-image:url('/images/chris-karidis-QXW1YEMhq_4-unsplash.png')"></div>
        </section>
        <div class="container">
            <nav class="breadcrumb-block" aria-label="breadcrumb">
                <a href="{{ route('home_page',App::getLocale())  }}">{{__("blog.homepage")}}</a>
                <a class="breadcrumb-item active" aria-current="page">{{__("blog.blog")}}</a>
            </nav>
        </div>
        <section>
            <div class="container">
                <div class="title-part">
                    <h1>{{__("blog.blog_title")}}</h1>
                </div>
                <div class="d-block d-md-none filter-button-box">
                    <button  id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle filter-button " data-bs-toggle="dropdown"
                             aria-expanded="false">{{__("blog.all_categories")}}
                        <i><img src="/images/arrow-down-blue.png" alt=""></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        @foreach($categories as $category)
                            <li class="d-md-none">
                                <a class="dropdown-item" href="{{route('blog.showCategory',['category' => $category->slug, 'locale' => app()->getLocale()])}}">{{$category->title}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="blog-filter-block d-none d-md-block">
                    <ul>
                        <li>
                            <a href="{{route("blog",App::getLocale())}}">{{__("blog.all_categories")}}</a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route("blog.showCategory", ['locale' => App::getLocale(),"category" => $category["slug"]])}}">{{$category["title"]}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="blog-feed-block d-flex">
                    @foreach($posts as $post)
                        @foreach($post->categories as $post_category)
                            <div class="blog-block-item">
                                <a href="{{ route('blog.show', ['locale'=>App::getLocale(),'category' => $post_category->slug,"id"=>$post["id"],"slug" => $post["slug"]]) }}">
                                    <figure>
                                        <img class="hover-img" src="/storage/uploads/{{$post->mainImage()}}" alt="blog-img">
                                    </figure>
                                </a>
                                <a href="{{ route('blog.show',['locale'=>App::getLocale(),'category' => $post_category->slug,"id"=>$post["id"],"slug" => $post["slug"]]) }}">
                                    <h3>{{$post["title"]}}</h3>
                                    <p>{{$post["preview_text"]}}</p>
                                </a>
                                <span>{{__("blog.date")}}</span>
                                <span>{{date("d.m.Y", strtotime($post["created_at"]))}}</span>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                <div class="pagination">
                    {{ $posts->links('pagination') }}
                </div>
            </div>
        </section>
        <section class="recommended-section">
            <div class="container">
                <title-part>
                    <h2>{{__("blog.recommended")}}</h2>
                </title-part>
                <div class="blog-block d-flex owl-carousel" id="blog-block">
                    @if(isset($recommendedPosts))
                        @foreach($recommendedPosts as $post)
                            <div class="blog-block-item">
                                <a href="">
                                    <figure>
                                        <img class="hover-img" src="/storage/uploads/{{$post->mainImage()}}" alt="blog-img">
                                    </figure>
                                </a>

                                <a href="#">
                                    <h3>{{$post["title"]}}</h3>
                                </a>
                                <span>{{__("blog.date")}}</span>
                                <span>{{date("d.m.Y", strtotime($post["created_at"]))}}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
        <section class="search-section">
            <div class="container">
                <div class="search-text-block">
                    <h2>{{__("blog.searchByPost")}}</h2>
                    <h3>{{__("blog.countryKeyWord")}}</h3>
                    <div class="blog-search-form">
                        <form action="" class="blog-search-form">
                            <input type="mail" placeholder="{{__("blog.search")}}">
                            <button class="red-btn">{{__("blog.search")}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
