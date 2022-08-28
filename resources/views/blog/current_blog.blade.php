@extends("layouts.app")

@section('main_id'){{'single-blog'}}@stop

@section('styles')
    {{--    <link rel="stylesheet" href="{{asset('/public/blog/css/style.css')}}">--}}
@endsection

@section('contents')
    <section class="banner-section">
        <div class="banner-part" style="background-image:url({{asset('images/chris-karidis-QXW1YEMhq_4-unsplash.png')}})"></div>
    </section>
    <div class="container">  
        <nav class="breadcrumb-block" aria-label="breadcrumb">
            <a href="{{ route('home_page',App::getLocale()) }}">{{__("blog.homepage")}}</a>
            <a href="{{ route('blog',App::getLocale())}}">{{__("blog.blog")}}</a>
            <a class="breadcrumb-item active" aria-current="page">{{$main_post->title}}</a>
        </nav>
    </div>
    <section>
        <div class="container">
            <div class="min-container">
                <div class="title-part">
                    <h1>{!! $main_post->title !!}</h1>
                    <p>
                        <span>{{ __('blog.date') }}</span>
                        <span>{{date("d.m.Y", strtotime($main_post["created_at"]))}}</span>
                    </p>
                </div>
                {!! $main_post->body !!}
            </div>
        </div>
    </section>
    <section class="recommended-section">
        <div class="container">
            <title-part>
                <h2>{{__("blog.recommended")}}</h2>
            </title-part>
            <div class="blog-block d-flex owl-carousel" id="blog-block">
                @foreach($posts as $p)
                    <div class="blog-block-item">
                        <a href="{{route('blog.show',['locale' => App::getLocale(), 'category' => $p['categories'][0]['slug'],'id'=>$p['id'],'slug' => $p['slug']])}}">
                            <figure>
                                <img class="hover-img" src="/storage/uploads/{{$p->mainImage()}}" alt="blog-img">
                            </figure>
                            <h3>{{$p->title}}</h3>
                        </a>
                        <span>{{__("blog.date")}}</span>
                        <span>{{date("d.m.Y", strtotime($p["created_at"]))}}</span>
                    </div>
                @endforeach
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
@endsection
