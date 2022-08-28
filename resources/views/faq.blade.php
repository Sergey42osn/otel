@extends("layouts.app")

@section('contents')
    <main id="faq-page">
        <section class="banner-section">
            <div class="banner-part" style="background-image:url('/images/chris-karidis-QXW1YEMhq_4-unsplash.png')"></div>
        </section>
        <div class="container">
            <nav class="breadcrumb-block" aria-label="breadcrumb">
                <a href="{{ route('home_page',App::getLocale())  }}">{{__("page.faq.homepage")}}</a>
                <a class="breadcrumb-item active" aria-current="page">{{__("page.faq.faq")}}</a>
            </nav>
        </div>
        <div class="container">
            <section class="faq-page flex-column flex-md-row">
                <aside class="faq-aside">
                    <div class="title-part">
                        <h1>{{__("page.faq.faq")}}</h1>
                    </div>
                </aside>
                <div class="faq-body">
                    <div class="faq-accordion-block">
                        <div>
                            <button class="accordion">{{__("page.faq.question_1")}}
                                <i>
                                    <img src="/images/arrow-down-blue.png" alt="">
                                </i>
                            </button>
                            <div class="panel">
                                <p>{{__("page.faq.answer_1")}}</p>
                            </div>
                        </div>
                        <div>
                            <button class="accordion">{{__("page.faq.question_2")}}
                                <i>
                                    <img src="/images/arrow-down-blue.png" alt="">
                                </i>
                            </button>
                            <div class="panel">
                                <p>{{__("page.faq.answer_2")}}</p>
                            </div>
                        </div>
                        <div>
                            <button class="accordion">{{__("page.faq.question_3")}}
                                <i>
                                    <img src="/images/arrow-down-blue.png" alt="">
                                </i>
                            </button>
                            <div class="panel">
                                <p>{{__("page.faq.answer_3")}}</p>
                            </div>
                        </div>
                        <div>
                            <button class="accordion">{{__("page.faq.question_4")}}
                                <i>
                                    <img src="/images/arrow-down-blue.png" alt="">
                                </i>
                            </button>
                            <div class="panel">
                                <p>{{__("page.faq.answer_4")}}</p>
                            </div>
                        </div> 
                        <div>
                            <button class="accordion">{{__("page.faq.question_5")}}
                                <i>
                                    <img src="/images/arrow-down-blue.png" alt="">
                                </i>
                            </button>
                            <div class="panel">
                                <p>{{__("page.faq.answer_5")}}</p>
                            </div>
                        </div>
                        <div>
                            <button class="accordion">{{__("page.faq.question_6")}}
                                <i>
                                    <img src="/images/arrow-down-blue.png" alt="">
                                </i>
                            </button>
                            <div class="panel">
                                <p>{{__("page.faq.answer_6")}}</p>
                            </div>
                        </div>
                        <div>
                            <button class="accordion">{{__("page.faq.question_7")}}
                                <i>
                                    <img src="/images/arrow-down-blue.png" alt="">
                                </i>
                            </button>
                            <div class="panel">
                                <p>{{__("page.faq.answer_7")}}</p>
                            </div>
                        </div>      
                        <div>
                            <button class="accordion">{{__("page.faq.question_8")}}
                                <i>
                                    <img src="/images/arrow-down-blue.png" alt="">
                                </i>
                            </button>
                            <div class="panel">
                                <p>{{__("page.faq.answer_8")}}</p>
                            </div>
                        </div>
                        <div>
                           
                        </div>                     
                    </div>
                   
                </div>
            </section>
        </div>
        @include("accommodations.subscription")
    </main>
@endsection
