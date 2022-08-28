<section class="photo-block info-block">
    <input type="hidden" id="deleteFiles" name="deleteFiles"/>
    <input type="hidden" id="headFile" name="headFile"/>
    <div class="input-block">
        <div class="title-part">
            <h2>{{ __('hotel.photos_title')}}*</h2>
            <span>{{ __('hotel.recommendation_photo')}}</span>
        </div>
        <div style="margin-top: 10px" class="photo-inner-block flex-column flex-md-row d-flex">

            <fieldset class="photo-form">
                <div class="download-img-box">
                    <img src="{{asset('images/icon-download-image.png')}}" alt="download">
                </div>
                <label for="fileUpload" class="fileUpload-label">
                    <span></span>
                    {{ __('hotel.upload_photo')}}</label>
                <input type="file" name="files" size="40" class="fileUpload inputId" id="fileUpload" accept=".jpg,.png" aria-required="true" aria-invalid="false" multiple>
            </fieldset>
            <div class="each-photo-block" id="each-photo-block">
                @if(!empty($images))
                @forelse($images as $image)
                @if($image->featured_image == true)
                <input type="hidden" value="{{$image->url}}" name="file" id="fileInput" class="form-control">
                @else
                @endif

                <figure @class([ 'photoFigure' , 'active'=> $image->featured_image])>
                    <span class="img-title">{{ __('hotel.main_photo')}}</span>
                    <img src="{{ asset('storage/uploads/'.$image->url)}}" />
                    <input type="hidden" value="{{$image->url}}" name="Upload[]" id="Upload" class="form-control">
                    <figcaption @class([ 'active'=> $image->featured_image])>
                        <span class="round"></span>
                        <button type="button" id="img" name="downloaded-img" class="radioBtn">{{ __('hotel.main_photo')}}</button>
                    </figcaption>
                    <button class="close-btn" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_85" data-name="Group 85" transform="translate(-981 -281)">
                                <rect id="Rectangle_151" data-name="Rectangle 151" width="21.213" height="1.414" transform="translate(982 281) rotate(45)" fill="#1d1d1d" />
                                <rect id="Rectangle_152" data-name="Rectangle 152" width="21.213" height="1.415" transform="translate(997 282.001) rotate(135)" fill="#1d1d1d" />
                            </g>
                        </svg>
                    </button>
                </figure>

                @empty

                @endforelse
                @else
                <input type="hidden" value="" name="file" id="fileInput" class="form-control">
                @endif

            </div>
        </div>
    </div>
</section>
