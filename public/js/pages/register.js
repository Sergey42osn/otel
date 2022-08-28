/*$(document).ready(function () {
    $(".login_backimg").backstretch([
        "/img/images/login2.png",
         "/img/images/login13.jpg",
         "/img/images/login10.png"
    ], {duration: 3000, fade: 750});
})*/
$(".open-register-modal").click(function (e) {
    e.preventDefault();
    $('#loginModal').modal('hide');
    $('#registerModal').modal('show');
});

$("#open-vendor-register").click(function (e) {
    e.preventDefault();
    $('#vendorLoginModal').modal('hide');
    $('#vendorRegisterModal').modal('show');
});

$(".open-login-modal").click(function (e) {
    e.preventDefault();
    $('#registerModal').modal('hide');
    $('#loginModal').modal('show');
});

$("#open-vendor-login").click(function (e) {
    e.preventDefault();
    $('#vendorRegisterModal').modal('hide');
    $('#vendorLoginModal').modal('show');
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).on("submit", "#handleRegisterAjax", function() {
    $('#handleRegisterAjax').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        if (data.status && data.email.length>0 && !data.sms_code) {
            $('.email_confirm').append('<a class="conf_mail">'+data.email+'</a>');
            $('#registerModal').modal('hide');
            $('#registerModal').find("input").html("");
            $('#registerModal').find("input").val("");
            $('#confirmModal').modal('show');
        }else if(data.status && data.email.length>0 && data.sms_code){
            $('.phone_confirm').append('<a class="conf_mail">'+data.email+'</a>');
            $('#confirmPhoneModal #form_group').append('<input type="hidden" id="phone_with_code" name="phone" value="'+data.email+'">');
            $('#registerModal').modal('hide');
            $('#registerModal').find("input").html("");
            $('#registerModal').find("input").val("");
            $('#confirmPhoneModal').modal('show');
        }

    }).fail(function(response) {
        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err]) {
                $('#handleRegisterAjax').find('#' + err).parent().append("<p class='text-danger'>" + errstr + "</p>");
            }
        }
    });
    return false;
});

$(document).on("submit", "#vendorRegisterAjax", function() {
    $('#vendorRegisterAjax').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        if (data.status && data.email.length>0 &&data.phone.length>0 ) {
            $('.email_confirm').append('<a class="conf_mail">'+data.email+'</a>');
            $('.phone_confirm').append('<a class="conf_mail">'+data.phone+'</a>');
            $('.form-group').append('<input type="hidden" id="phone_with_code2" name="phone9" value="'+data.phone+'">');
        }
        $('#vendorRegisterModal').modal('hide');
        $('#vendorRegisterModal').find("input").html("");
        $('#vendorRegisterModal').find("input").val("");
        $('#vendorConfirmModal').modal('show');
    }).fail(function(response) {
        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err]) {
                $('#vendorRegisterAjax').find('#' + err).parent().append("<p class='text-danger'>" + errstr + "</p>");
            }
        }
    });
    return false;
});

$(document).on("submit", "#customerLoginForm", function() {
    $('#customerLoginForm').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        if (data.status) {
            // window.location.assign('/' + $('html').attr('lang') + "/account")
            location.reload();
        }else{
            if(data.code){
                $('.phone_confirm').append('<a class="conf_mail">'+data.email+'</a>');
                $('#confirmPhoneModal #form_group').append('<input type="hidden" id="phone_with_code" name="phone" value="'+data.email+'">');
                $('#registerModal').modal('hide');
                $('#registerModal').find("input").html("");
                $('#registerModal').find("input").val("");
                $("#modal_login2").css('display',"none");
                $('#confirmPhoneModal').modal('show');

            }
        }
    }).fail(function(response) {

        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err]) {
                $('#customerLoginForm').find('#' + err).parent().append("<p class='text-danger'>" + errstr + "</p>");
            }
        }

    });
    return false;
});


$(document).on("submit", "#vendorLoginForm", function() {
    $('#vendorLoginForm').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        if (data.status) {
            window.location.assign("/")
        } else {
            if(data.code){
                $('.phone_confirm').append('<a class="conf_mail">'+data.phone+'</a>');
                $('#form_group').append('<input type="hidden" id="phone_with_code" name="phone" value="'+data.phone+'">');
                $('#vendorLoginModal').modal('hide');
                $('#vendorLoginForm').find("input").html("");
                $('#vendorLoginForm').find("input").val("");
                $("#vendorLoginModal").css('display',"none");
                $(".confirm-body").css('display',"none");
                $('#vendorConfirmModal').modal('show');

            }
        }
    }).fail(function(response) {

        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err]) {
                $('#vendorLoginForm').find('#' + err).parent().append("<p class='text-danger'>" + errstr + "</p>");
            }
        }

    });
    return false;
});

$(document).ready(function () {
    $("#vendor-agree").on("keyup change", function(e) {
        if($('#vendorRegisterModal').find('#name').val()=='' || $('#vendorRegisterModal').find('#last_name').val()==''
            || $('#vendorRegisterModal').find('#email').val()=='' || $('#vendorRegisterModal').find('#password').val()=='' ||
            $('#vendorRegisterModal').find('#password_confirmation').val()=='' ||  !$('#vendorRegisterModal').find('#vendor-agree').is(':checked')){
            $('#vendorRegisterModal').find('.reg-btn').attr('disabled', true);
        } else {
            $('#vendorRegisterModal').find('.reg-btn').attr('disabled', false);

        }
    });

    $("#agree").on("keyup change", function(e) {
        if($('#registerModal').find('#name').val()=='' || $('#registerModal').find('#last_name').val()=='' || $('#registerModal').find('#email').val()=='' || $('#registerModal').find('#password').val()=='' || $('#registerModal').find('#password_confirmation').val()=='' ||  !$('#registerModal').find('#agree').is(':checked')){
            $('#registerModal').find('.reg-btn').attr('disabled', true);
        } else {
            $('#registerModal').find('.reg-btn').attr('disabled', false);

        }
    });

});
