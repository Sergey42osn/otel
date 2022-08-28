
$(".open-register-modal").click(function (e) {
    e.preventDefault();
    $(this).modal('hide');
    $('#vendorRegisterModal').modal('show');
});

// $(".open-login-modal").click(function (e) {
//     e.preventDefault();
//     $(this).modal('hide');
//     $('#vendorLoginModal').modal('show');
// });

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


