@extends('layouts.account')

@section('title') Reset Password @endsection


@section('contents')
    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6">
            @if(session('err'))
                <div class="alert alert-danger alert-dismissible fade show text-center mt-5" role="alert">
                    {{ session('err') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="col-md-3"> </div>
    </div>

    <div class="forget-pass-content">
        <h1 class="mt-5">
            {{__('auth.resetPassword.reset_pass')}}
        </h1>
        <form action="{{ route('reset-password',['locale' => App::getLocale()]) }}" method="post" class="form_class mb-5">
            @csrf
            
            <div class="mb-3 mt-3 form-group">
                <input type="hidden" class="form-control" name="token" value="{{ $token }}">
                <input type="hidden" class="form-control" name="email" value="{{ $email }}">
            </div>
            <div class="mb-3 mt-3 form-group">
                <label>{{__('auth.resetPassword.password')}}</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" 
                       value="{{ old('password')}}"
                       placeholder="{{__('auth.resetPassword.password')}}">
                @if ($errors->has('password'))
                    @error('password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                @endif
            </div>
            <div class="mb-3 mt-3 form-group">
                <label>{{__('auth.resetPassword.confirm_pass')}}</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                       name="password_confirmation" 
                       value="{{ old('password_confirmation')}}"
                       placeholder="{{__('auth.resetPassword.confirm_pass')}}">
                @if ($errors->has('password_confirmation'))
                    @error('password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                @endif
            </div>
            <button type="submit" class="btn btn-primary w-100">{{__('auth.resetPassword.reset_pass')}}</button>
        </form>
    </div>
@endsection
