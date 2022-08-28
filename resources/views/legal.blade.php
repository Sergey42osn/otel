@extends("layouts.app")
@section('contents')
    <main id="legal-info-page">
    <section class="banner-section">
			<div class="banner-part" style="background-image:url('/images/chris-karidis-QXW1YEMhq_4-unsplash.png')"></div>
		</section>
        <div class="container">
            <nav class="breadcrumb-block" aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home_page',App::getLocale())  }}">{{__("page.legal.homepage")}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__("page.legal.legal_information")}}</li>
                </ul>
            </nav>
            <div class="min-container">
                <div class="title-part">
                    <h1> {{ $title  }}</h1>
                </div>
                <div class="text-block">
                    <p>{!! $content !!}</p>
                </div>
                <div class="legal-info-row d-flex flex-column flex-md-row">
						<div class="info-title">
							<h2>{{__("page.legal.contact_information")}}</h2>
						</div>
						<div class="info-text">
							<p>{{__("page.legal.tel")}}<a href="tel:+88001011180">+ 8 800 101 11 80</a></p>
                            <p>{{__("page.legal.email")}}<a href="mailto:contact@ruking.test">info@ruking.ru</a></p>
						</div>
					</div>
					<div class="legal-info-row d-flex flex-column flex-md-row">
						<div class="info-title">
							<h2>{{__("page.legal.registration_data_companies")}}</h2>
						</div>
						<div class="info-text">
                            <span>ИНН 9728061125 ОГРН 1227700202025</span>
						</div>
					</div>
            </div>
        </div>
        <!-- <section>
			<div class="container">
				<h2 class="certificate-title">Certificates</h2>
				<div class="owl-carousel" id="certificates">
					<div>
						<figure>
							<img src="images/example7.png" alt="">
						</figure>
					</div>
					<div>
						<figure>
							<img src="images/example4.png" alt="certificate">
						</figure>
					</div>
					<div>
						<figure>
							<img src="images/example5.png" alt="certificate">
						</figure>
					</div>
					<div>
						<figure>
							<img src="images/example6.png" alt="certificate">
						</figure>
					</div>
					<div>
						<figure>
							<img src="images/example7.png" alt="certificate">
						</figure>
					</div>
				</div>
			</div>
		</section> -->
    </main>
@endsection
