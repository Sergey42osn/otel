@php
    switch($type) {
        case 'hotel':
            $images = $info_hotel_search['info']->images;
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
            $firstImage = str_replace('{size}','1024x768',$info_hotel_search['info']->images[0]);
            $theRest = $info_hotel_search['info']->images;
           // $count = 1;
        @endphp
        @if($firstImage)
            <a class="prev button" id="prev"><img src="/images/left-arrow.png" class="image-zoom" ></a>
            <a class="next button" id="next"><img src="/images/right-arrow.png" class="image-zoom" ></a>
            <div class="mySlides">
                <img src="{{ $firstImage }}"  id="img1" alt="">
                <a class="zoom button" data-id="1" ><img src="/images/diagonal-resize.png" class="image-zoom" ></a>
            </div>
            <div class="gallery__lightbox" id="gallery__lightbox">
                <div class="gallery__lightbox-content" id="gallery__lightbox-content">
                    <a href="#" class="close" onclick="hide()"></a>
                    <img src="{{ $firstImage }}" class="gallery__lightbox-image"  id="gallery__lightbox-image"/>
                </div>
            </div>
        @endif
        @foreach($theRest as $i => $image)
            <div class="mySlides">
                <img src="{{ str_replace('{size}','1024x768',$image) }}"  id="img{{ $i+1}}" alt="">
                <a class="zoom button" data-id="{{ $i + 1 }}" ><img src="/images/diagonal-resize.png" class="image-zoom" ></a>
            </div>
            <div class="gallery__lightbox" id="gallery__lightbox">
                <div class="gallery__lightbox-content" id="gallery__lightbox-content">
                    <a href="#" class="close" onclick="hide()"></a>
                    <img src="{{ str_replace('{size}','1024x768',$image) }}" class="gallery__lightbox-image"  id="gallery__lightbox-image"/>
                </div>
            </div>
        @endforeach
    @endif
    <div id="main-div" class="blocks">
        <ul>
            @if($firstImage)
                <li><img class="dot" data-id="1"  src="{{$firstImage}}" style="margin-left:0" alt=""> </li>
            @endif
            @php
                $count = 1;
            @endphp
            @foreach($theRest as $i => $image)
                @if($image)
                    <li><img class="dot" data-id="{{ ++$count }}"  src="{{ str_replace('{size}','x220',$image) }}" style="margin-left:0" alt=""> </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>