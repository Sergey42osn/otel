@php
    switch($type) {
        case 'hotel':
            $images = $accommodation->accommodationable->images;
            $functional_image = $accommodation->hotel()->images;
        break;
        case 'villa':
            $images = $functional_image = $accommodation->appartment()->images;
        break;
        case 'youth_hotel':
            $images = $functional_image = $accommodation->hotel()->images;
        break;
        case 'appartment':
            $images = $functional_image = $accommodation->appartment()->images;
        break;
    }
    //$featured_image = $accommodation->featured_image;
@endphp
<div class="slideshow-container">
    @if(isset($images))
        @php
            $firstImage = $images->first(function($image) {
                return $image->featured_image == 1 && $image->url;
            });
            $theRest = $functional_image->filter(function($image) {
                return $image->featured_image == 0 && $image->url;
            });
            $count = 1;
        @endphp
        @if($firstImage)
            <a class="prev button" id="prev"><img src="/images/left-arrow.png" class="image-zoom" ></a>
            <a class="next button" id="next"><img src="/images/right-arrow.png" class="image-zoom" ></a>
            <div class="mySlides">
                <img src="{{ asset('storage/uploads/' . $firstImage->url) }}"  id="img1" alt="">
                <a class="zoom button" data-id="1" ><img src="/images/diagonal-resize.png" class="image-zoom" ></a>
            </div>
            <div class="gallery__lightbox" id="gallery__lightbox">
                <div class="gallery__lightbox-content" id="gallery__lightbox-content">
                    <a href="#" class="close" onclick="hide()"></a>
                    <img src="{{ asset('storage/uploads/' . $firstImage->url) }}" class="gallery__lightbox-image"  id="gallery__lightbox-image"/>
                </div>
            </div>
        @endif
        @foreach($theRest as $i => $image)
            <div class="mySlides">
                <img src="{{ asset('storage/uploads/' . $image->url) }}"  id="img{{ ++$count }}" alt="">
                <a class="zoom button" data-id="{{ $i + 1 }}" ><img src="/images/diagonal-resize.png" class="image-zoom" ></a>
            </div>
            <div class="gallery__lightbox" id="gallery__lightbox">
                <div class="gallery__lightbox-content" id="gallery__lightbox-content">
                    <a href="#" class="close" onclick="hide()"></a>
                    <img src="{{ asset('storage/uploads/' . $image->url) }}" class="gallery__lightbox-image"  id="gallery__lightbox-image"/>
                </div>
            </div>
        @endforeach
    @endif
    <div id="main-div" class="blocks">
        <ul>
            @if($firstImage)
                <li><img class="dot" data-id="1"  src="{{asset('storage/uploads/'. $firstImage->url)}}" style="margin-left:0" alt=""> </li>
            @endif
            @php
                $count = 1;
            @endphp
            @foreach($theRest as $i => $image)
                @if($image->url)
                    <li><img class="dot" data-id="{{ ++$count }}"  src="{{asset('storage/uploads/'. $image->url)}}" style="margin-left:0" alt=""> </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>