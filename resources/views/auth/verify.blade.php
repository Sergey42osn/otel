@extends('layouts.vendor')

@section('contents')
<!-- Verify Modal -->
<div class="modal fade modal-style" id="verifyModal" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title lato-bold" id="verifyModalLabel">Verify your account</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="verify-content">
                    <p class="lato-medium text-center">
                        We have sent you an email with a confirmation link to
                        <a href="mailto:{{Auth::user()->email}}" class="lato-medium">{{Auth::user()->email}}</a>
                    </p>
                    <p class="lato-medium text-center">
                        To verify your account, please follow the link in the email we just sent.
                    </p>
                    <!--
                    <p class="lato-medium text-center">
                        {{ __('If you did not receive the email') }}
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                    </p> -->


                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(function() {
        $('#verifyModal').modal('toggle');
    });
</script>
@endsection
