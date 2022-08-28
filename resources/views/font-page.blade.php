@extends("layouts.vendor")

@section('contents')
    <div id="home-page">
        <section class="banner-section">
            <div class="banner-part" style="background-image:url('{{ asset("images/chris-karidis-QXW1YEMhq_4-unsplash.png")}}')"></div>
        </section>
        <div>
            <div class="container">
                <div class="title-part">
                    <h2 class="main-title">Best Hotel Deals</h2>
                </div>
                <section class="best-offer-section">
                    <div class="row best-offer-block">
                        <div class="col-12 col-md-4">
                            <a href="#">
                                <figure class="best-offer">
                                    <figcaption>
                                            <span class="img-box">
                                                <img src="images/best-offer.png" alt="best-offer-icon">
                                            </span>
                                        <span>Best Hotel Deals</span>
                                    </figcaption>
                                    <img class="hover-img" src="images/best1.png" alt="">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="#">
                                <figure class="sale">
                                    <figcaption>
                                            <span class="img-box">
                                                <img src="images/sale.png" alt="best-offer-icon">
                                            </span>
                                        <span>Best Hotel Deals</span>
                                    </figcaption>
                                    <img class="hover-img" src="images/best2.png" alt="">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="#">
                                <figure class="free-tour">
                                    <figcaption>
                                        <span class="img-box">
                                            <img src="images/free-tour.png" alt="best-offer-icon">
                                        </span>
                                        <span>Best Hotel Deals</span>
                                    </figcaption>
                                    <img class="hover-img" src="images/best3.png" alt="">
                                </figure>
                            </a>
                        </div>
                    </div>
                </section>
                <section class="best-tour-city-section">
                    <div class="row owl-carousel" id="best-tour-city-section">
                        <div class="col-12 col-md-4 best-tour-city-box">
                            <a href="#">
                                <figure>
                                    <figcaption>
                                        <h3>Lake Ritsa</h3>
                                        <h4>8 hotels - 9 apartments - 6 villas</h4>
                                        <h5>7 Youth hostel</h5>
                                    </figcaption>
                                    <img class="hover-img" src="images/best1.png" alt="">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-4 best-tour-city-box">
                            <a href="#">
                                <figure>
                                    <figcaption>
                                        <h3>Lake Ritsa</h3>
                                        <h4>8 hotels - 9 apartments - 6 villas</h4>
                                        <h5>7 Youth hostel</h5>
                                    </figcaption>
                                    <img class="hover-img" src="images/best1.png" alt="">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-4 best-tour-city-box">
                            <a href="#">
                                <figure>
                                    <figcaption>
                                        <h3>Lake Ritsa</h3>
                                        <h4>8 hotels - 9 apartments - 6 villas</h4>
                                        <h5>7 Youth hostel</h5>
                                    </figcaption>
                                    <img class="hover-img" src="images/best1.png" alt="">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 best-tour-city-box">
                            <a href="#">
                                <figure>
                                    <figcaption>
                                        <h3>Lake Ritsa</h3>
                                        <h4>8 hotels - 9 apartments - 6 villas</h4>
                                        <h5>7 Youth hostel</h5>
                                    </figcaption>
                                    <img class="hover-img" src="images/best1.png" alt="">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 best-tour-city-box">
                            <a href="#">
                                <figure>
                                    <figcaption>
                                        <h3>Lake Ritsa</h3>
                                        <h4>8 hotels - 9 apartments - 6 villas</h4>
                                        <h5>7 Youth hostel</h5>
                                    </figcaption>
                                    <img class="hover-img" src="images/best1.png" alt="">
                                </figure>
                            </a>
                        </div>
                    </div>
                </section>
                <section class="property-type-search-section">
                    <div class="title-part">
                        <h2 class="main-title">Search by property type</h2>
                    </div>
                    <div class="row property-type-block">
                        <div class="col-12 col-md-3">
                            <a href="#">
                                <figure>
                                    <figcaption>
                                        <h3>Hotels</h3>
                                    </figcaption>
                                    <img class="hover-img" src="images/best2.png" alt="">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="#">
                                <figure>
                                    <figcaption>
                                        <h3>Apartments</h3>
                                    </figcaption>
                                    <img class="hover-img" src="images/best2.png" alt="">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="#">
                                <figure>
                                    <figcaption>
                                        <h3>Villas</h3>
                                    </figcaption>
                                    <img class="hover-img" src="images/best2.png" alt="">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="#">
                                <figure>
                                    <figcaption>
                                        <h3>youth hostel</h3>
                                    </figcaption>
                                    <img class="hover-img" src="images/best2.png" alt="">
                                </figure>
                            </a>
                        </div>
                    </div>
                </section>
                <section class="popular-type-search-section">
                    <div class="title-part">
                        <h2 class="main-title">Popular hotels around the world</h2>
                    </div>
                    <div class="owl-carousel" id="popular-type-block">
                        <div>
                            <a href="#">
                                <figure>
                                    <img class="hover-img" src="images/hotel2.png" alt="">
                                </figure>
                                <h3>North Avenue Hotel Yerevan</h3>
                            </a>
                            <div class="star-block">
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            </div>
                            <h4>Тбилиси, Грузия</h4>
                            <div class="price-box">
                                <span>From</span>
                                <span class="price">7838 руб.</span>
                            </div>
                            <div class="rating-box">
                                <span>Rating</span>
                                <span>4</span>
                            </div>
                        </div>
                        <div>
                            <a href="#">
                                <figure>
                                    <img class="hover-img" src="images/hotel1.png" alt="">
                                </figure>
                                <h3>North Avenue Hotel Yerevan</h3>
                            </a>
                            <div class="star-block">
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            </div>
                            <h4>Тбилиси, Грузия</h4>
                            <div class="price-box">
                                <span>From</span>
                                <span class="price">7838 руб.</span>
                            </div>
                            <div class="rating-box">
                                <span>Rating</span>
                                <span>4</span>
                            </div>
                        </div>
                        <div>
                            <a href="#">
                                <figure>
                                    <img class="hover-img" src="images/hotel1.png" alt="">
                                </figure>
                                <h3>North Avenue Hotel Yerevan</h3>
                            </a>
                            <div class="star-block">
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            </div>
                            <h4>Тбилиси, Грузия</h4>
                            <div class="price-box">
                                <span>From</span>
                                <span class="price">7838 руб.</span>
                            </div>
                            <div class="rating-box">
                                <span>Rating</span>
                                <span>4</span>
                            </div>
                        </div>
                        <div>
                            <a href="#">
                                <figure>
                                    <img class="hover-img" src="images/hotel2.png" alt="">
                                </figure>
                                <h3>North Avenue Hotel Yerevan</h3>
                            </a>
                            <div class="star-block">
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            </div>
                            <h4>Тбилиси, Грузия</h4>
                            <div class="price-box">
                                <span>From</span>
                                <span class="price">7838 руб.</span>
                            </div>
                            <div class="rating-box">
                                <span>Rating</span>
                                <span>4</span>
                            </div>
                        </div>
                        <div>
                            <a href="#">
                                <figure>
                                    <img class="hover-img" src="images/hotel1.png" alt="">
                                </figure>
                                <h3>North Avenue Hotel Yerevan</h3>
                            </a>
                            <div class="star-block">
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            </div>
                            <h4>Тбилиси, Грузия</h4>
                            <div class="price-box">
                                <span>From</span>
                                <span class="price">7838 руб.</span>
                            </div>
                            <div class="rating-box">
                                <span>Rating</span>
                                <span>4</span>
                            </div>
                        </div>
                        <div>
                            <a href="#">
                                <figure>
                                    <img class="hover-img" src="images/hotel1.png" alt="">
                                </figure>
                                <h3>North Avenue Hotel Yerevan</h3>
                            </a>
                            <div class="star-block">
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg class="filled" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            </div>
                            <h4>Тбилиси, Грузия</h4>
                            <div class="price-box">
                                <span>From</span>
                                <span class="price">7838 руб.</span>
                            </div>
                            <div class="rating-box">
                                <span>Rating</span>
                                <span>4</span>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="suggestion-part">
                    <div class="title-part">
                        <h2 class="main-title">Where do you want to go?</h2>
                    </div>
                    <div class="suggest-block">
                        <a href="">
                            <div class="suggest-inner-block">
                                    <span>
                                        <img src="images/star-tick.png" alt="star">
                                    </span>
                                <h2>Where to go</h2>
                                <h3>Take the test and get ideas for travel</h3>
                            </div>
                            <a href="">
                                <figure>
                                    <img src="images/banner-img.png" alt="" class="hover-img">
                                </figure>
                            </a>
                        </a>
                    </div>
                </section>
                <section class="blog-section">
                    <div class="title-part">
                        <h2 class="main-title">Be inspired</h2>
                    </div>
                    <div class="blog-block row owl-carousel" id="blog-block">
                        <div class="blog-block-item col-12 col-md-4">
                            <a href="">
                                <figure>
                                    <img class="hover-img" src="images/150239829.png" alt="blog-img">
                                </figure>
                            </a>
                            <a href="">
                                <h3>The most spectacular houses in the worldon the trees</h3>
                                <p>No matter how old you are, spend the night high in the trees - breathtaking No matter how old you are, spend the night high in the trees - breathtaking</p>
                            </a>
                        </div>
                        <div class="blog-block-item col-12 col-md-4">
                            <a href="">
                                <figure>
                                    <img class="hover-img" src="images/149523110.png" alt="blog-img">
                                </figure>
                            </a>
                            <a href="">
                                <h3>The most spectacular houses in the worldon the trees</h3>
                                <p>No matter how old you are, spend the night high in the trees - breathtaking No matter how old you are, spend the night high in the trees - breathtaking</p>
                            </a>
                        </div>
                        <div class="blog-block-item col-12 col-md-4">
                            <a href="">
                                <figure>
                                    <img class="hover-img" src="images/149523110.png" alt="blog-img">
                                </figure>
                            </a>
                            <a href="">
                                <h3>The most spectacular houses in the worldon the trees</h3>
                                <p>No matter how old you are, spend the night high in the trees - breathtaking No matter how old you are, spend the night high in the trees - breathtaking</p>
                            </a>
                        </div>
                    </div>
                </section>
            </div>
            <section class="subscribe-section">
                <div class="subscribe-text-block">
                    <h2>Subscribe</h2>
                    <h3>Sign up and we'll send the best deals to you</h3>
                    <div class="subscribe-form">
                        <form action="" class="subscribe-form">
                            <input type="mail" placeholder="E-mail">
                            <button class="red-btn">Subscribe</button>
                        </form>
                    </div>
                </div>
                <figure class="subscribe-block">
                    <img src="images/pietro-de-grandi-T7K4aEPoGGk-unsplash.png" alt="">
                </figure>
            </section>
        </div>
        <section class="category-section">
            <div class="container">
                <div class="title-part">
                    <h1>{{ __('hotel.title')}}</h1>
                </div>
                <div class="category-block d-flex">
                    <div class="category-item">
                        <figure>
                            <img src="{{ asset('images/image-pool.png')}}" alt="hotel">
                            <figcaption>{{ __('hotel.hotel')}}</figcaption>
                        </figure>
                        <a class="btn-blue" href="{{route('hotels.create')}}">{{ __('hotel.register_property')}}</a>
                    </div>
                    <div class="category-item">
                        <figure>
                            <img src="{{ asset('images/image-building.png')}}" alt="appartment">
                            <figcaption>{{ __('hotel.appartment')}}</figcaption>
                        </figure>
                        <a class="btn-blue" href="{{route('appartments.create')}}">{{ __('hotel.register_property')}}</a>
                    </div>
                    <div class="category-item">
                        <figure>
                            <img src="images/image-villa.png" alt="villa">
                            <figcaption>{{ __('hotel.villa')}}</figcaption>
                        </figure>
                        <a class="btn-blue" href="{{route('villas.create')}}">{{ __('hotel.register_property')}}</a>
                    </div>
                    <div class="category-item">
                        <figure>
                            <img src="images/image-home.png" alt="youth-hotel">
                            <figcaption>{{ __('hotel.youth')}}</figcaption>
                        </figure>
                        <a class="btn-blue" href="{{route('youth-hotels.create')}}">{{ __('hotel.register_property')}}</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
