<h1>{{__('auth.mail.mail')}}</h1>

{{__('auth.mail.text')}}
<a href="{{ route('reset-password-page', ['locale' => App::getLocale(),'token' => $token]) }}">{{__('auth.resetPassword.reset_pass')}}</a>















