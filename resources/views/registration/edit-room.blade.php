@extends('layouts.vendor')

@section('contents')

@php




$selectedAmenity = $room->amenities->pluck('id')->toArray();

$selectedService = $room->services()->wherePivot('price', '!=', null)->pluck('services.id')->toArray();






@endphp
<section class="banner-section">
    <div class="banner-part" style="background-image:url('{{asset("images/chris-karidis-QXW1YEMhq_4-unsplash.png")}}')"></div>
</section>
<div id="room-page">
    <div class="container">
        <div class="title-part">
            <h1>{{ __('rooms.title')}}</h1>
            @if($errors->any())
            <div class="alert alert-danger">
                <p><strong>Opps Something went wrong</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        <form action="{{route('rooms.update', ['locale' => App::getLocale(), 'room' => $room])}}" method="POST" class="room-form general-form">
            @csrf
            @method("PUT")
            <section class="room-info-block block">
                <div class="input-block">
                    <p>{{ __('rooms.choose.title')}}</p>
                    @if($response_status == 0)
                        <div class="mb-2">
                            <label for="code_from_api">{{__('rooms.type_crm')}}</label>
                            <select name="code_from_api" id="code_from_api" class="form-control">
                                <option value="">-</option>
                                @foreach($response as $key => $data)
                                    @foreach($ratePlansIds as $key1 => $ratePlansId)
                                        <option value="{{$data}}-{{$ratePlansId}}" {{$data == $room->code_from_api && $ratePlansId == $room->api_plane_id ? 'selected':''}}>{{$roomTypesNames[$key]}} - {{$ratePlansNames[$key1]}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2 mt-2">
                            <input type="checkbox" id="prepayment" name="prepayment" class="checkService checkBtn-label" {{ $room->prepayment == 1 ? 'checked' : '' }}>
                            <label class="checkBtn-label" for="prepayment" style="color: #000;font-size: 15px">{{__('rooms.prepayment')}}</label>
                        </div>
                    @endif
                    <fieldset>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-2">
                                    <label for="type">{{ __('rooms.choose.room_type')}}</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="0">{{ __('hotel.select_type')}}</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}" {{$type->id == $room->type_id ? 'selected':''}}>{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=mb-2" >
                                    <label for="title">{{ __('rooms.choose.room_name')}}</label>
                                    <select name="title" id="title" class="form-control">
                                        <option value="0">{{ __('rooms.room_title')}}</option>
                                        @foreach($type_names as $type_name)
                                            <option value="{{$type_name->id}}" {{$type_name->type_id == $room->type_id && $type_name->id == $room->title_id ? 'selected':''}}>{{$type_name->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2 mt-1">
                                    <label for="quantity">{{ __('rooms.choose.number_of_rooms')}}</label>
                                    <input type="number" name="number" class="form-control" value="{{ old('number', $room->number) ?? ''}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-2">
                                    <label for="type_name"> {{__('rooms.enter_object_type')}} </label>
                                    <input type="text" id="type_name" name="type_name" class="form-control"/>
                                </div>
                                <div class="mb-2">
                                    <label for="title_name">{{ __('rooms.enter_room_title')}}</label>
                                    <input type="text" name="title_name" class="form-control" id="title_name">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-end">
                                <label for="" class="d-block">{{ __('hotel.description')}}</label>
                                <div class="lang-btn-group d-flex justify-content-end lang-change-box">
                                    <button type="button" class="active" id="pyc_desc">Рус</button><button type="button" id="eng_desc">Eng</button>
                                </div>
                            </div>
                            <div class="lang-change-box">
                                <textarea name="description_pyc" id="description_pyc" placeholder="{{ __('hotel.content_placeholder')}}" class="active form-control inputId">{{ $room->getTranslation('description','ru') ?? ''}}</textarea>
                                <textarea name="description" id="description" placeholder="{{ __('hotel.content_placeholder')}}" class="inputId">{{ $room->getTranslation('description','en') ?? ''}}</textarea>
                            </div>
                        </div>
                    </fieldset>
                    <p>{{ __('rooms.beds.beds')}}
                    </p>
                    <fieldset class="d-flex flex-column flex-md-row justify-content-between">
                        <div class="part-block">
                            <div>
                                <label for="">{{ __('rooms.beds.single_bed')}}</label>
                                <select name="single_bed" id="" class="form-control">
                                    <option value="0">{{ __('rooms.number_of_beds')}}</option>
                                    <option value="1" {{ $room->single_bed == '1' ? 'selected' : ''}}>1</option>
                                    <option value="2" {{ $room->single_bed == '2' ? 'selected' : ''}}>2</option>
                                    <option value="3" {{ $room->single_bed == '3' ? 'selected' : ''}}>3</option>
                                    <option value="4" {{ $room->single_bed == '4' ? 'selected' : ''}}>4</option>
                                    <option value="5" {{ $room->single_bed == '5' ? 'selected' : ''}}>5</option>
                                    <option value="6" {{ $room->single_bed == '6' ? 'selected' : ''}}>6</option>
                                    <option value="7" {{ $room->single_bed == '7' ? 'selected' : ''}}>7</option>
                                    <option value="8" {{ $room->single_bed == '8' ? 'selected' : ''}}>8</option>
                                    <option value="9" {{ $room->single_bed == '9' ? 'selected' : ''}}>9</option>
                                    <option value="10" {{ $room->single_bed == '10' ? 'selected' : ''}}>10</option>
                                    <option value="11" {{ $room->single_bed == '11' ? 'selected' : ''}}>11</option>
                                    <option value="12" {{ $room->single_bed == '12' ? 'selected' : ''}}>12</option>
                                    <option value="13" {{ $room->single_bed == '13' ? 'selected' : ''}}>13</option>
                                    <option value="14" {{ $room->single_bed == '14' ? 'selected' : ''}}>14</option>
                                    <option value="15" {{ $room->single_bed == '15' ? 'selected' : ''}}>15</option>
                                </select>
                            </div>
                            <div>
                                <label for="double_bed">{{ __('rooms.beds.double_bed')}}</label>
                                <select name="double_bed" id="" class="form-control">
                                    <option value="0">{{ __('rooms.number_of_beds')}}</option>
                                    <option value="1" {{ $room->double_bed == '1' ? 'selected' : ''}}>1</option>
                                    <option value="2" {{ $room->double_bed == '2' ? 'selected' : ''}}>2</option>
                                    <option value="3" {{ $room->double_bed == '3' ? 'selected' : ''}}>3</option>
                                    <option value="4" {{ $room->double_bed == '4' ? 'selected' : ''}}>4</option>
                                    <option value="5" {{ $room->double_bed == '5' ? 'selected' : ''}}>5</option>
                                    <option value="6" {{ $room->double_bed == '6' ? 'selected' : ''}}>6</option>
                                    <option value="7" {{ $room->double_bed == '7' ? 'selected' : ''}}>7</option>
                                    <option value="8" {{ $room->double_bed == '8' ? 'selected' : ''}}>8</option>
                                    <option value="9" {{ $room->double_bed == '9' ? 'selected' : ''}}>9</option>
                                    <option value="10" {{ $room->double_bed == '10' ? 'selected' : ''}}>10</option>
                                    <option value="11" {{ $room->double_bed == '11' ? 'selected' : ''}}>11</option>
                                    <option value="12" {{ $room->double_bed == '12' ? 'selected' : ''}}>12</option>
                                    <option value="13" {{ $room->double_bed == '13' ? 'selected' : ''}}>13</option>
                                    <option value="14" {{ $room->double_bed == '14' ? 'selected' : ''}}>14</option>
                                    <option value="15" {{ $room->double_bed == '15' ? 'selected' : ''}}>15</option>
                                </select>
                            </div>
                            <div>
                                <label for="wide_bed">{{ __('rooms.beds.wide_bed')}}</label>
                                <select name="wide_bed" id="" class="form-control">
                                    <option value="0">{{ __('rooms.number_of_beds')}}</option>
                                    <option value="1" {{ $room->wide_bed == '1' ? 'selected' : ''}}>1</option>
                                    <option value="2" {{ $room->wide_bed == '2' ? 'selected' : ''}}>2</option>
                                    <option value="3" {{ $room->wide_bed == '3' ? 'selected' : ''}}>3</option>
                                    <option value="4" {{ $room->wide_bed == '4' ? 'selected' : ''}}>4</option>
                                    <option value="5" {{ $room->wide_bed == '5' ? 'selected' : ''}}>5</option>
                                    <option value="6" {{ $room->wide_bed == '6' ? 'selected' : ''}}>6</option>
                                    <option value="7" {{ $room->wide_bed == '7' ? 'selected' : ''}}>7</option>
                                    <option value="8" {{ $room->wide_bed == '8' ? 'selected' : ''}}>8</option>
                                    <option value="9" {{ $room->wide_bed == '9' ? 'selected' : ''}}>9</option>
                                    <option value="10" {{ $room->wide_bed == '10' ? 'selected' : ''}}>10</option>
                                    <option value="11" {{ $room->wide_bed == '11' ? 'selected' : ''}}>11</option>
                                    <option value="12" {{ $room->wide_bed == '12' ? 'selected' : ''}}>12</option>
                                    <option value="13" {{ $room->wide_bed == '13' ? 'selected' : ''}}>13</option>
                                    <option value="14" {{ $room->wide_bed == '14' ? 'selected' : ''}}>14</option>
                                    <option value="15" {{ $room->wide_bed == '15' ? 'selected' : ''}}>15</option>
                                </select>
                            </div>
                        </div>
                        <div class="part-block">
                            <div>
                                <label for="">{{ __('rooms.beds.sofa_bed')}}</label>
                                <select name="sofa_bed" id="" class="form-control">
                                    <option value="0">{{ __('rooms.number_of_beds')}}</option>
                                    <option value="1" {{ $room->sofa_bed == '1' ? 'selected' : ''}}>1</option>
                                    <option value="2" {{ $room->sofa_bed == '2' ? 'selected' : ''}}>2</option>
                                    <option value="3" {{ $room->sofa_bed == '3' ? 'selected' : ''}}>3</option>
                                    <option value="4" {{ $room->sofa_bed == '4' ? 'selected' : ''}}>4</option>
                                    <option value="5" {{ $room->sofa_bed == '5' ? 'selected' : ''}}>5</option>
                                    <option value="6" {{ $room->sofa_bed == '6' ? 'selected' : ''}}>6</option>
                                    <option value="7" {{ $room->sofa_bed == '7' ? 'selected' : ''}}>7</option>
                                    <option value="8" {{ $room->sofa_bed == '8' ? 'selected' : ''}}>8</option>
                                    <option value="9" {{ $room->sofa_bed == '9' ? 'selected' : ''}}>9</option>
                                    <option value="10" {{ $room->sofa_bed == '10' ? 'selected' : ''}}>10</option>
                                    <option value="11" {{ $room->sofa_bed == '11' ? 'selected' : ''}}>11</option>
                                    <option value="12" {{ $room->sofa_bed == '12' ? 'selected' : ''}}>12</option>
                                    <option value="13" {{ $room->sofa_bed == '13' ? 'selected' : ''}}>13</option>
                                    <option value="14" {{ $room->sofa_bed == '14' ? 'selected' : ''}}>14</option>
                                    <option value="15" {{ $room->sofa_bed == '15' ? 'selected' : ''}}>15</option>
                                </select>
                            </div>
                            <div>
                                <label for="">{{ __('rooms.beds.futon')}}</label>
                                <select name="futon" id="" class="form-control">
                                    <option value="0">{{ __('rooms.number_of_beds')}}</option>
                                    <option value="1" {{ $room->futon == '1' ? 'selected' : ''}}>1</option>
                                    <option value="2" {{ $room->futon == '2' ? 'selected' : ''}}>2</option>
                                    <option value="3" {{ $room->futon == '3' ? 'selected' : ''}}>3</option>
                                    <option value="4" {{ $room->futon == '4' ? 'selected' : ''}}>4</option>
                                    <option value="5" {{ $room->futon == '5' ? 'selected' : ''}}>5</option>
                                    <option value="6" {{ $room->futon == '6' ? 'selected' : ''}}>6</option>
                                    <option value="7" {{ $room->futon == '7' ? 'selected' : ''}}>7</option>
                                    <option value="8" {{ $room->futon == '8' ? 'selected' : ''}}>8</option>
                                    <option value="9" {{ $room->futon == '9' ? 'selected' : ''}}>9</option>
                                    <option value="10" {{ $room->futon == '10' ? 'selected' : ''}}>10</option>
                                    <option value="11" {{ $room->futon == '11' ? 'selected' : ''}}>11</option>
                                    <option value="12" {{ $room->futon == '12' ? 'selected' : ''}}>12</option>
                                    <option value="13" {{ $room->futon == '13' ? 'selected' : ''}}>13</option>
                                    <option value="14" {{ $room->futon == '14' ? 'selected' : ''}}>14</option>
                                    <option value="15" {{ $room->futon == '15' ? 'selected' : ''}}>15</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <div class="part-block">
                        <label for="">{{ __('rooms.beds.guest_count')}}</label>
                        <input type="number" name="guest_count" class="form-control" value="{{ old('guest_count',$room->guest_count) ?? ""}}">
                    </div>
                </div>
            </section>
            <section class="more-block block">
                <div class="input-block">
                    <p class="title-text"> {{ __('rooms.additional.title')}}</p>
                    <span>{{ __('rooms.additional.quiz')}}</span>
                    <fieldset class="more-beds d-flex radio-btn-block">
                        <div class="d-flex align-items-center">
                            <input type="radio" name="extra_beds" id="yes" value="1" {{$room->extra_beds == '1' ? 'checked': ''}}>
                            <label for="yes">{{ __('hotel.yes')}}</label>
                        </div>
                        <div class="d-flex align-items-center">
                            <input type="radio" name="extra_beds" id="no" value="0" {{$room->extra_beds == '0' ? 'checked': ''}}>
                            <label for="no">{{ __('hotel.no')}}</label>
                        </div>
                    </fieldset>
                </div>
            </section>
            <section class="appartment-service-block block">
                <div class="title-part">
                    <h2>{{__('rooms.services_title')}}</h2>
                </div>
                <div class="input-block">
                    <div>
                        <fieldset class="d-flex flex-column">
                            @foreach($room->services as $service)
                            <div class="app-service-inner-block service-inner-block">
                                <input type="checkbox" id="service_{{$service->id}}" class="checkService checkBtn-label" {{ in_array($service->id, $selectedService) ? 'checked' : '' }}>
                                <label for="service_{{$service->id}}" class="checkBtn-label">{{ $service->name}} </label>
                                <label for="price_{{$service->id}}" class="checkServiceInput checkBtn-label" style="display:<?php echo in_array($service->id, $selectedService) ? 'flex' : 'none' ?>">
                                    <input type="number" placeholder="0" name="services[{{$service->id}}]" class="price" value="{{$service->pivot->price}}">RUB
                                </label>
                            </div>
                            @endforeach
                                @foreach($services as $service)

                                    <div class="app-service-inner-block service-inner-block">
                                        <input type="checkbox" id="service_{{$service->id}}"class="checkService checkBtn-label">
                                        <label for="service_{{$service->id}}" class="checkBtn-label">{{ $service->name}} </label>
                                        <label for="price_{{$service->id}}" class="checkServiceInput checkBtn-label">
                                            <input type="number" placeholder="0" name="services[{{$service->id}}]" class="price" value="" disabled>
                                        </label>
                                    </div>
                                @endforeach

                        </fieldset>
                    </div>
                </div>
            </section>
            <section class="services-block info-block">
                <div class="input-block">
                    <div class="title-part">
                        <h2>{{ __('hotel.services')}}</h2>
                    </div>
                    <div>
                        <fieldset class="d-flex justify-content-between flex-wrap services-form flex-column flex-md-row">
                            @foreach($amenities as $amenity)
                            <div class="part-block">
                                <input type="checkbox" id="amenity_{{$amenity->id}}" name="amenities[]" value="{{$amenity->id}}" {{ in_array($amenity->id, $selectedAmenity) ? 'checked' : '' }}>
                                <label for="amenity_{{$amenity->id}}" class="checkBtn-label">{{$amenity->name}}</label>
                            </div>
                            @endforeach
                        </fieldset>
                    </div>
                </div>
            </section>
            <x-file-select :images="$room->images" />
            <section class="room-size-block block">
                <div class="input-block">
                    <div class="title-part">
                        <h2>{{ __('rooms.room_size_title')}}</h2>
                    </div>
                    <div>
                        <fieldset>
                            <div class="part-block">
                                <label for="room-size">{{ __('rooms.room_size')}}</label>
                                <input type="number" id="room-size" name="size" value="{{old('size',$room->size)}}">
                            </div>
                        </fieldset>
                    </div>
                </div>
            </section>
            <section class="-block block">
                <div class="input-block">
                    <div class="title-part">
                        <h2>{{ __('rooms.price_title')}}</h2>
                    </div>
                    <div>
                        <fieldset>
                            <div class="part-block position-relative">
                                <label for="room-size">{{ __('rooms.price')}}</label>
                                <input type="number" name="price" class="form-control" value="{{old('size',$room->price)}}">
                                <span class="currency">{{ __('rooms.currency')}}</span>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </section>
            <div class="btn-block">
                <a href="{{ url()->previous() }}" class="btn btn-white btn-back"><i></i> {{ __('hotel.btn_back')}}</a>
                <button class="btn btn-blue " type="submit" >{{ __('hotel.btn_save')}}</button>
                <button class="btn btn-grey">{{ __('rooms.btn_delete')}}</button>

            </div>
        </form>
    </div>
</div>
@endsection
@section("scripts")
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script>
    let locale = '{{App::getLocale()}}';

    $(".checkService").click(function (event){
        if(event.target.checked) {
            $(this).parent().find(".checkServiceInput").attr('style','display:flex');
            $(this).parent().find(".price").val(0);

        } else {
            $(this).parent().find(".checkServiceInput").attr('style','display:none');
            $(this).parent().find(".price").val("");

        }
    });

    $('#type_name').change(function (){
        $('#type').removeClass('is-invalid');
    });
    $('#title_name').change(function (){
        $('#title').removeClass('is-invalid');
    });
    $("#title").on('change', function() {
        $('#type').removeClass('is-invalid');
        $('#title').removeClass('is-invalid');
        $('#title_name').removeClass('is-invalid');
    });

    $("#type").on('change', function() {
        $('#type').removeClass('is-invalid');
        $('#type_name').removeClass('is-invalid');
        $('#title').removeClass('is-invalid');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('filter-room-type')}}",
            type: "POST",
            data: {
                type: $(this).val()
            },
            success: function (data) {
                $('#title').html('');
                if (data.length) {
                    let options = data.map(el => `<option value="${el.id}">${el.name[locale]}</option>`)
                    options = '<option value="0">{{ __('rooms.room_title')}}</option>' + options
                    $('#title').html(options);
                } else {
                    $('#title').html(` <option value="0">{{ __('rooms.room_title')}}</option>`)
                }

            }
        });
    });
    $(() => {
        // Jquery Validations
        $(".room-form").validate({

            errorClass: 'is-invalid invalid-feedback',
            validClass: 'success is-valid',
            errorElement: 'span',
            rules: {
                // single_bed: {
                //     min: 1
                // },
                // sofa_bed: {
                //     min: 1
                // },
                // double_bed: {
                //     min: 1
                // },
                // futon: {
                //     min: 1,
                // },
                // wide_bed: {
                //     min: 1
                // },
                type: {
                    min: function(element){
                        if($("#type_name").val()==""){
                            return 1;
                        } else{
                            return 0;
                        }
                    }
                },
                type_name: {
                    required: function(element){
                        if($("#type").val()==0){
                            return true;
                        } else{
                            return false;
                        }
                    }
                },
                title: {
                    min: function(element){
                        if($("#title_name").val()==""){
                            return 1;
                        } else{
                            return 0;
                        }
                    }
                },
                title_name: {
                    required: function(element){
                        if($("#title").val()==0){
                            return true;
                        } else{
                            return false;
                        }
                    }
                },
                number: {
                    required: true,
                    regex: '^[0-9]+(?:\.[0-9]{1,2})?$'
                },
                guest_count: {
                    required: true,

                    number: {
                        required: true,
                        regex: '^[0-9]+(?:\.[0-9]{1,2})?$'
                    }
                },
                price: {
                    required: true,
                    regex: '^[0-9]+(?:\.[0-9]{1,2})?$'
                },

            },

            messages: {
                type: "Type is required",
                single_bed: "Single Bed is required",
                sofa_bed: "Sofa Bed is required",
                double_bed: "Double Bed is required",
                wide_bed: "Wide Bed is required",
                futon: "Futon is required",

                number: {
                    required: "Please Enter Number of rooms",
                    regex: "Please Enter Valid Number"
                },
                guest_count: {
                    required: "Please enter your Guest number",
                    regex: "Please enter a valid Guest number",
                },
                price: {
                    required: "Please enter your price",
                    regex: "Please enter a valid price"
                }

            },

            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass(validClass);
                $(element).parents("div").siblings('label').addClass('is-invalid').removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid').addClass(validClass);
                $(element).parents("div").siblings('label').removeClass('is-invalid').addClass(validClass);
            },

            submitHandler: function(form) {
                form.submit();
            }
        });


        $.validator.addMethod("regex", function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        });



    });

    $('#pyc_desc').on('click', () => (textAreaChanger(`eng_desc`, `pyc_desc`, 'description', `description_pyc`)))
    $('#eng_desc').on('click', () => (textAreaChanger(`pyc_desc`, `eng_desc`, 'description_pyc', `description`)))

    let textAreaChanger = (from_btn, to_btn, from_id, to_id) => {
        $(`#${from_btn}`).removeClass('active')
        $(`#${to_btn}`).addClass('active')
        $(`#${from_id}`).hide()
        $(`#${to_id}`).show()
    }
</script>
<x-validator />
<x-file-upload />
@endsection
