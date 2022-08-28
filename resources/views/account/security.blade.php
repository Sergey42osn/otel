@extends("layouts.account")
@section('title', __('account.security'))

@section('contents')
    <section class="banner-section">
        <div class="banner-part" style="background-image:url('{{ asset("images/chris-karidis-QXW1YEMhq_4-unsplash.png")}}')"></div>
    </section>
    <section class="category-section">
        <div class="container">
            <div id="security-page-user">
                <div class="container">

                    <div class="alert alert-success alert-dismissible d-none" role="alert">
                        <strong>{{ __('account.password changed')}}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="d-flex flex-column flex-md-row partial-block">
                        @include('account.sidebar')
                        <section class="large">
                            <div class="title-part">
                                <h1>{{ __('account.security')}}</h1>
                                <p>{{ __('account.Adjust your security settings')}}</p>
                            </div>
                            <div class="table-block">
                                <div class="table-inner-block">
                                    @if(  $user->password!=null)
                                    <form id="changePasswordAjax" action="{{route('change.password',  ['locale' => App::getLocale()])}}" method="post">
                                        <div class="table-row">
                                            <div class="d-flex flex-column flex-lg-row title-content-box password-block">
                                                <div class="title-td">
                                                    <span>{{ __('account.Password')}}</span>
                                                </div>
                                                <div class="content-td">
                                                    <span>**************</span>
                                                </div>
                                                <div class="edit-block">
                                                    <div>
                                                        <label for="">{{ __('account.Current Password')}}</label>
                                                        <input type="password" name="current_password" id="current_password">
                                                    </div>
                                                    <div>
                                                        <label for="">{{ __('account.New Password')}}</label>
                                                        <input type="password" name="new_password" id="new_password">
                                                    </div>
                                                    <div>
                                                        <label for="">{{ __('account.Repeat your new Password')}}</label>
                                                        <input type="password" name="new_confirm_password" id="new_confirm_password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="link-td">
                                                <button type="button" class="edit">{{ __('account.change')}}</button>
                                                <button type="button" class="cancel">{{ __('account.Cancel')}}</button>
                                            </div>
                                        </div>
                                        <div class="save-box">
                                            <button type="submit" class="save btn-blue justify-content-end">{{ __('account.Save')}}</button>
                                        </div>
                                    </form>
                                    @else
                                        <div class="table-row">
                                            <div class="d-flex flex-column flex-lg-row title-content-box password-block">
                                                <div class="title-td">
                                                    <span>{{ __('account.Password')}}</span>
                                                </div>
                                                <div class="content-td">
                                                    <span>{{ __('account.You are signed in with a social profile')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="table-inner-block">
                                    <div class="table-row">
                                        <div class="d-flex flex-column flex-lg-row title-content-box">
                                            <div class="title-td">
                                                <span>{{ __('account.Double autentification')}}</span>
                                            </div>
                                            <div class="content-td autentification-td">
                                                <span>{{ __('account.Add phone number to configurate double autentification')}}</span>
                                            </div>
                                            <div class="edit-block">
                                                <div>
                                                    <label for="">{{ __('account.Tel.')}}</label>
                                                    <input type="number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="link-td">
                                            <button class="edit d-none" >{{ __('account.configurate')}}</button>
                                            <button class="cancel">{{ __('account.Cancel')}}</button>
                                        </div>
                                    </div>
                                    <div class="save-box">
                                        <button class="save btn-blue justify-content-end">{{ __('account.Save')}}</button>
                                    </div>
                                </div>
                                <div class="table-inner-block">
                                    <div class="table-row">
                                        <div class="d-flex flex-column flex-lg-row title-content-box">
                                            <div class="title-td">
                                                <span>{{ __('account.Delete account')}}</span>
                                            </div>
                                            <div class="content-td">
                                                <span>{{ __('account.permanently delete account')}}</span>
                                            </div>
                                        </div>
                                        <div class="link-td">
                                            <button data-bs-toggle="modal" data-bs-target="#deleteModal">{{ __('account.delete')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
