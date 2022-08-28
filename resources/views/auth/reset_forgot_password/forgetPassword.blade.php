@extends('layouts.vendor')

@section('title') Forgot Password @endsection


@section('contents')
    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6">
            @if(session('mess'))
                <div class="alert alert-success alert-dismissible fade show text-center mt-5" role="alert">
                    {{ session('mess') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="col-md-3"> </div>
    </div>
    <div class="forget-pass-content">
        <h1 class="mt-5">
            {{__('auth.forgotPassword.forgot_pass')}}
        </h1>
        <p>
            Ничего страшного! Мы отправим вам ссылку для смены пароля. 
            Введите адрес электронной почты, с которой вы заходите на Ruking.ru
        </p>
        <form action="{{route('forgot-password', ['locale' => App::getLocale()])}}" method="post" class="form_class mb-5">
            @csrf
            <div class="mb-3 mt-3 form-group">
                <label>{{__('auth.forgotPassword.email')}}</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}" >
                @if ($errors->has('email'))
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                @endif
                @if(session('err'))
                    <div class="text-danger">{{ session('err') }}</div>
                @endif
            </div>
            <button type="submit"  class="btn btn-primary w-100">{{__('auth.forgotPassword.sendLink')}}</button>
        </form>
    </div>
@endsection
