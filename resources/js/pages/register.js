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

$(".open-login-modal").click(function (e) {
    e.preventDefault();
    $('#registerModal').modal('hide');
    $('#loginModal').modal('show');
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).on("submit", "#handleRegisterAjax", function() {
    $('#handleRegisterAjax').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        if (data.status && data.email.length>0) {
            $('.email_confirm').append('<a class="conf_mail">'+data.email+'</a>');
        }
        $('#registerModal').modal('hide');
        $('#registerModal').find("input").html("");
        $('#registerModal').find("input").val("");
        $('#confirmModal').modal('show');
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
$(document).on("submit", "#handleAjax", function() {
    $('#handleAjax').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        console.log(data);
        if (data.status) {
            window.location.assign("/account")
        }
    }).fail(function(response) {

        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err]) {
                $('#handleAjax').find('#' + err).parent().append("<p class='text-danger'>" + errstr + "</p>");
            }
        }

    });
    return false;
});
    $(".inputId").on("keyup change", function(e) {
    if($('#registerModal').find('#name').val()=='' || $('#registerModal').find('#last_name').val()=='' || $('#registerModal').find('#email').val()=='' || $('#registerModal').find('#password').val()=='' || $('#registerModal').find('#password_confirmation').val()=='' ||  !$('#registerModal').find('#agree').is(':checked')){
        $('#registerModal').find('.reg-btn').attr('disabled', true);
    } else {
        $('#registerModal').find('.reg-btn').attr('disabled', false);

    }
});