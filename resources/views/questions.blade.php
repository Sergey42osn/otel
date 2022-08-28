@extends("layouts.main")

@section('contents')
    <main id="faq-page">
        <section class="banner-section">
            <div class="banner-part" style="background-image:url('images/chris-karidis-QXW1YEMhq_4-unsplash.png')"></div>
        </section>
        <nav class="breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home_page')  }}">Homepage</a></li>
                <li class="breadcrumb-item active" aria-current="page">FAQ</li>
            </ol>
        </nav>
        <div class="container">
            <section class="faq-page flex-column flex-md-row">
                <aside class="faq-aside">
                    <div class="title-part">
                        <h1>FAQ</h1>
                    </div>
                </aside>
                <div class="faq-body">
                    <div class="faq-accordion-block">
                        <div>
                            <button class="accordion">Want to change your booking?
                                <i>
                                    <img src="images/arrow-down-blue.png" alt="">
                                </i>
                            </button>
                            <div class="panel">
                                <p>Want to change your booking? Want to change your booking? Want to change your booking?</p>
                            </div>
                        </div>
                        <div>
                            <button class="accordion">Have questions about your property?
                                <i>
                                    <img src="images/arrow-down-blue.png" alt="">
                                </i>
                            </button>
                            <div class="panel">
                                <p>Have questions about your property?Have questions about your property?Have questions about your property?</p>
                            </div>
                        </div>
                        <div>
                            <button class="accordion">Need help with a booking?
                                <i>
                                    <img src="images/arrow-down-blue.png" alt="">
                                </i>
                            </button>
                            <div class="panel">
                                <p>Need help with a booking?Need help with a booking?Need help with a booking?</p>
                            </div>
                            <div>
                                <div>
                                    <button class="accordion">Want to change your booking?
                                        <i>
                                            <img src="images/arrow-down-blue.png" alt="">
                                        </i>
                                    </button>
                                    <div class="panel">
                                        <p>Want to change your booking? Want to change your booking? Want to change your booking?</p>
                                    </div>
                                </div>
                                <div>
                                    <button class="accordion">Have questions about your property?
                                        <i>
                                            <img src="images/arrow-down-blue.png" alt="">
                                        </i>
                                    </button>
                                    <div class="panel">
                                        <p>Have questions about your property?Have questions about your property?Have questions about your property?</p>
                                    </div>
                                </div>
                                <div>
                                    <button class="accordion">Need help with a booking?
                                        <i>
                                            <img src="images/arrow-down-blue.png" alt="">
                                        </i>
                                    </button>
                                    <div class="panel">
                                        <p>Need help with a booking?Need help with a booking?Need help with a booking?</p>
                                    </div>
                                    <div>
                                        <div>
                                            <button class="accordion">Want to change your booking?
                                                <i>
                                                    <img src="images/arrow-down-blue.png" alt="">
                                                </i>
                                            </button>
                                            <div class="panel">
                                                <p>Want to change your booking? Want to change your booking? Want to change your booking?</p>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="accordion">Have questions about your property?
                                                <i>
                                                    <img src="images/arrow-down-blue.png" alt="">
                                                </i>
                                            </button>
                                            <div class="panel">
                                                <p>Have questions about your property?Have questions about your property?Have questions about your property?</p>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="accordion">Need help with a booking?
                                                <i>
                                                    <img src="images/arrow-down-blue.png" alt="">
                                                </i>
                                            </button>
                                            <div class="panel">
                                                <p>Need help with a booking?Need help with a booking?Need help with a booking?</p>
                                            </div>
                                            <div>
                                                <div>
                                                    <button class="accordion">Need help with a booking?
                                                        <i>
                                                            <img src="images/arrow-down-blue.png" alt="">
                                                        </i>
                                                    </button>
                                                    <div class="panel">
                                                        <p>Need help with a booking?Need help with a booking?Need help with a booking?</p>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
            </section>
        </div>
    </main>
@endsection
