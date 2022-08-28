@extends("layouts.account")
@section('title', __('account.personal information'))

@section('contents')
    <section class="banner-section">
        <div class="banner-part" style="background-image:url('{{ asset("images/chris-karidis-QXW1YEMhq_4-unsplash.png")}}')"></div>
    </section>
    <section class="category-section">
        <div class="container">
            <div class="alert alert-success alert-dismissible d-none" role="alert">
                <strong>{{ __('account.Information changed successfuly')}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div id="personal-info-user-page">
                <div class="container">
                    <div class="d-flex flex-column flex-md-row partial-block">
                        @include('account.sidebar')
                        <section class="large">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">
                                <div class="title-part">
                                    <h1>{{__('account.personal information')}}</h1>
                                    <p>{{__('account.Update your information')}}</p>
                                </div>
                                <div class="d-flex personal-img-block">
                                    <label for="personFileUpload" class="personFileUpload-label">
                                        {{__('account.Choose an image')}}</label>
                                    <form id="uploadPhoto" action="{{route('upload.avatar',  ['locale' => App::getLocale()])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="image" size="40" class="fileUpload" id="personFileUpload" accept=".jpg,.png" aria-required="true" aria-invalid="false" onchange="$('#uploadPhoto').submit()">
                                    </form>
                                    <figure>
                                        <img src="{{$user->getAvatar()}}" alt="person">
                                    </figure>
                                </div>
                            </div>
                            <div class="table-block">
                                <div class="table-inner-block">
                                    <form id="changeNameAjax" action="{{url('change-name')}}" method="post">
                                        <div class="table-row">
                                            <div class="d-flex flex-column flex-lg-row title-content-box">
                                                <div class="title-td">
                                                    <span>{{__('account.Name')}} {{__('account.Surname')}}</span>
                                                </div>
                                                <div class="content-td">
                                                    <span>{{$user->name." ". $user->last_name}}</span>
                                                </div>
                                                <div class="edit-block part-plock">
                                                    <div>
                                                        <label for="">{{__('account.Name')}}</label>
                                                        <input type="text" name="name" id="name" value="{{$user->name}}">
                                                    </div>
                                                    <div>
                                                        <label for="">{{__('account.Surname')}}</label>
                                                        <input type="text" name="last_name" id="last_name" value="{{$user->last_name}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="link-td">
                                                <button type="button" class="edit">{{__('account.edit')}}</button>
                                                <button type="button" class="cancel">{{__('account.Cancel')}}</button>
                                            </div>
                                        </div>
                                        <div class="save-box">
                                            <button type="submit" class="save btn-blue justify-content-end">{{__('account.Save')}}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-inner-block">
                                    <form id="changeGender" action="{{url('change-gender')}}" method="post">
                                        <div class="table-row ">
                                            <div class="d-flex flex-column flex-lg-row title-content-box">
                                                <div class="title-td">
                                                    <span>{{__('account.Gender')}}</span>
                                                </div>
                                                <div class="content-td">
                                                    <span>{{$user->getGender()}}</span>
                                                </div>
                                                <div class="edit-block">
                                                    <div>
                                                        <label for="">{{__('account.Gender')}}</label>
                                                        <select name="gender">
                                                            @if($user->gender == 0)
                                                                <option value="1">{{__('account.Female')}}</option>
                                                                <option value="0" selected>{{__('account.Male')}}</option>
                                                            @else
                                                                <option value="1" selected>{{__('account.Female')}}</option>
                                                                <option value="0">{{__('account.Male')}}</option>
                                                            @endif

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="link-td">
                                                <button type="button"  class="edit">{{__('account.edit')}}</button>
                                                <button type="button"  class="cancel">{{__('account.Cancel')}}</button>
                                            </div>
                                        </div>
                                        <div class="save-box">
                                            <button type="submit"  class="save btn-blue justify-content-end">{{__('account.Save')}}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-inner-block">
                                    <form id="changeEmail" action="{{url('change-email')}}" method="post">
                                        <div class="table-row">
                                            <div class="d-flex flex-column flex-lg-row title-content-box">
                                                <div class="title-td">
                                                    <span>{{__('account.E-mail')}}</span>
                                                </div>
                                                <div class="content-td">
                                                    <span>{{$user->email}}</span>
                                                    @if($user->active_email==1)
                                                        <span class="checked-mail {{$user->getStatus()}}">{{__('account.checked')}}</span>
                                                    @else
                                                        <span class="checked-tel  text-warning">{{__('account.not verified')}}</span>
                                                    @endif
                                                </div>
                                                <div class="edit-block">
                                                    <div>
                                                        <label for="">{{__('account.E-mail')}}</label>
                                                        <input type="email" name="email" id="email" value="{{$user->email}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="link-td">
                                                <button type="button"  class="edit">{{__('account.edit')}}</button>
                                                <button type="button"  class="cancel">{{__('account.Cancel')}}</button>
                                            </div>
                                        </div>
                                        <div class="save-box">
                                            <button type="submit"  class="save btn-blue justify-content-end">{{__('account.Save')}}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-inner-block">
                                    <form id="changePhone" action="{{url('change-phone')}}" method="post">
                                        <div class="table-row">
                                            <div class="d-flex flex-column flex-lg-row title-content-box">
                                                <div class="title-td">
                                                    <span>{{__('account.Tel.')}}</span>
                                                </div>
                                                <div class="content-td">
                                                    @if(empty($user->phone))
                                                        <span>{{__('account.Tel.')}}</span>
                                                    @else
                                                        {{$user->phone}}
                                                    @endif
                                                    @if($user->active_phone==1)
                                                            <span class="checked-mail text-success">{{__('account.checked')}}</span>
                                                        @else
                                                            <span class="checked-tel text-warning">{{__('account.not verified')}}</span>
                                                        @endif
                                                </div>
                                                <div class="edit-block">
                                                    <div>
                                                        <label for="">{{__('account.Tel.')}}</label>
                                                        <input type="text" name="phone" id="alt_phone" value="{{$user->phone}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="link-td">
                                                <button type="button"  class="edit">{{__('account.edit')}}</button>
                                                @if($user->active_phone == 0 && !empty($user->phone))
                                                  <button type="button" class="auth-link" data-bs-toggle="modal" data-bs-target="#confirmPhoneModal" >{{ __('auth.verify_code_account') }}</button>
                                                @endif
                                                <button type="button"  class="cancel">{{__('account.Cancel')}}</button>
                                            </div>
                                        </div>
                                        <div class="save-box">
                                            <button type="submit"  class="save btn-blue justify-content-end">{{__('account.Save')}}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-inner-block">
                                    <form id="changeAddress" action="{{url('change-address')}}" method="post">
                                        <div class="table-row">
                                            <div class="d-flex flex-column flex-lg-row title-content-box">
                                                <div class="title-td">
                                                    <span>{{__('account.Address')}}</span>
                                                </div>
                                                <div class="content-td">
                                                    <span>{{$user->getAddress()}}</span>
                                                </div>
                                                <div class="edit-block">
                                                    <div>
                                                        <label for="">{{__('account.Country')}}</label>
                                                        <input type="text" name="country" id="country" value="{{$user->country}}">
                                                    </div>
                                                    <div>
                                                        <label for="">{{__('account.City')}}</label>
                                                        <input type="text" name="city" id="city" value="{{$user->city}}">
                                                    </div>
                                                    <div>
                                                        <label for="">{{__('account.Address')}}</label>
                                                        <input type="text" name="address" id="address" value="{{$user->address}}">
                                                    </div>
                                                    <div>
                                                        <label for="">{{__('account.Postal code')}}</label>
                                                        <input type="text" name="postal_code" id="postal_code" value="{{$user->postal_code}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="link-td">
                                                <button type="button"  class="edit">{{__('account.edit')}}</button>
                                                <button type="button"  class="cancel">{{__('account.Cancel')}}</button>
                                            </div>
                                        </div>
                                        <div class="save-box">
                                            <button type="submit" class="save btn-blue justify-content-end">{{__('account.Save')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <div class="modal fade" id="confirmPhoneModal" tabindex="-1" aria-labelledby="confirmPhoneModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title lato-bold" id="confirmPhoneModalLabel">{{__('auth.Confirm account')}}</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class=" confirm-body">
                            <span>{{__('auth.Confirm phone text')}}</span>
                            <a class="phone_confirm"></a>
{{--                            <p>{{__('auth.Confirm phone text2')}}<p>--}}
                        </div>

                        <div class=" confirm-body1">
                            <form method="post" action="{{route('customer.activate_phone_account')}}">
                                @csrf
                                <div class="form-group" id="form_group">
                                    <label for="sms_code_account">{{__('auth.sms_code')}}</label>
                                    <input type="hidden" value="{{$user->phone}}" name="phone_with_code_very" id="phone_with_code_very">
                                    <input type="text" class="form-control inputId" id="sms_code_account" name="sms_code_account">
                                    <div class="text-danger" style="display:none" id="wrong_code_very">wrong code</div>
                                    <button type="button" id="check_buttons_verify" class="btn  btn-primary mt-2" >{{__('auth.Send')}}</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // $('#but_1').click(function (){
        //     console.log('log');
        // });
        $("#save_phone3").click(function (){
            $("#show_verify_modal").css("display","block");
        });


        $("#check_buttons_verify").click(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('customer.activate_phone_account')}}",
                type: "POST",
                data: {
                    code: $("#sms_code_account").val(),
                    phone: $("#phone_with_code_very").val()
                },

                success: function(response) {
                    console.log("5454");
                    console.log(response);
                    if(response.status){
                        $("#wrong_code_very").css("display","none");
                        $("#check_buttons_verify").attr("type","submit");
                        // console.log("ok");
                        location.reload();
                    } else {
                        $("#wrong_code_very").html(response.message);
                        $("#check_buttons_verify").attr("type","button");
                        $("#wrong_code_very").css("display","block");
                        // console.log("wrong");
                    }
                }
            });
        });

    </script>
@endsection
