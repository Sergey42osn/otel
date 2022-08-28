$(document).ready(function() {
    jQuery.extend(jQuery.validator.messages, {
        required: "{{ __('validation.jq_validate_msgs.required') }}",
        remote: "{{ __('validation.jq_validate_msgs.remote') }}",
        email: "{{ __('validation.jq_validate_msgs.email') }}",
        url: "{{ __('validation.jq_validate_msgs.url') }}",
        date: "{{ __('validation.jq_validate_msgs.date') }}",
        dateISO: "{{ __('validation.jq_validate_msgs.dateISO') }}",
        number: "{{ __('validation.jq_validate_msgs.number') }}",
        digits: "{{ __('validation.jq_validate_msgs.digits') }}",
        creditcard: "{{ __('validation.jq_validate_msgs.creditcard') }}",
        equalTo: "{{ __('validation.jq_validate_msgs.equalTo') }}",
        accept: "{{ __('validation.jq_validate_msgs.accept') }}",
        maxlength: jQuery.validator.format("{{ __('validation.jq_validate_msgs.maxlength') }}"),
        minlength: jQuery.validator.format("{{ __('validation.jq_validate_msgs.minlength') }}"),
        rangelength: jQuery.validator.format("{{ __('validation.jq_validate_msgs.rangelength') }}"),
        range: jQuery.validator.format("{{ __('validation.jq_validate_msgs.range') }}"),
        max: jQuery.validator.format("{{ __('validation.jq_validate_msgs.max') }}"),
        min: jQuery.validator.format("{{ __('validation.jq_validate_msgs.min') }}"),
        regex: "{{ __('validation.jq_validate_msgs.regex') }}",
        pwcheck: "{{ __('validation.jq_validate_msgs.pwcheck') }}",

    });

});