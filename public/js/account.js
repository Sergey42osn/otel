jQuery(document).ready(function(){
    jQuery(".edit").click(function(){
        if ($("#security-page-user").length == 0 && $("#personal-info-user-page").length == 0) {
            jQuery(this).parent().parent().parent().toggleClass("edit-row");
        } else {
            $("form").find(".text-danger").remove();
            $("#changePasswordAjax").find("input").val("");
            jQuery(this).parent().parent().parent().parent().toggleClass("edit-row");
        }
        jQuery(this).parent().parent().parent().parent().find(".save-box").toggleClass("d-flex");
    });

});
jQuery(document).ready(function(){
    jQuery(".cancel").click(function(){
        if ($("#security-page-user").length == 0 && $("#personal-info-user-page").length == 0) {
            jQuery(this).parent().parent().parent().toggleClass("edit-row");
        } else {
            jQuery(this).parent().parent().parent().parent().toggleClass("edit-row");
        }
        jQuery(this).parent().parent().parent().parent().find(".save-box").toggleClass("d-flex");
    });
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).on("submit", "#changePasswordAjax", function() {
    $('#changePasswordAjax').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        console.log(data);
        if (data.status) {
            $(".alert-success").removeClass('d-none');
            jQuery("#changePasswordAjax").parent().toggleClass("edit-row");
            jQuery(".save-box").toggleClass("d-flex");
        }
    }).fail(function(response) {

        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err]) {
                $('#changePasswordAjax').find('#' + err).parent().append("<p class='text-danger'>" + errstr + "</p>");
            }
        }

    });
    return false;
});
$(document).on("submit", "#changeNameAjax", function() {
    $('#changeNameAjax').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        console.log(data);
        if (data.status) {
            window.location.reload();
        }
    }).fail(function(response) {
        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err]) {
                $('#changeNameAjax').find('#' + err).parent().append("<p class='text-danger'>" + errstr + "</p>");
            }
        }
    });
    return false;
});
$(document).on("submit", "#changeGender", function() {
    $('#changeGender').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        console.log(data);
        if (data.status) {
            window.location.reload();
        }
    }).fail(function(response) {
        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err]) {
                $('#changeGender').find('#' + err).parent().append("<p class='text-danger'>" + errstr + "</p>");
            }
        }
    });
    return false;
});
$(document).on("submit", "#changeEmail", function() {
    $('#changeEmail').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        if (data.status) {
            window.location.reload();
        }
    }).fail(function(response) {
        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err]) {
                $('#changeEmail').find('#' + err).parent().append("<p class='text-danger'>" + errstr + "</p>");
            }
        }
    });
    return false;
});
$(document).on("submit", "#changePhone", function() {
    $('#changePhone').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        console.log(data);
        if (data.status) {
            window.location.reload();
        }
    }).fail(function(response) {
        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err]) {
                $('#changePhone').find('#' + err).parent().append("<p class='text-danger'>" + errstr + "</p>");
            }
        }
    });
    return false;
});
$(document).on("submit", "#changeAddress", function() {
    $('#changeAddress').find('.text-danger').remove();
    $.post($(this).attr('action'), $(this).serialize(), function(data) {
        console.log(data);
        if (data.status) {
            window.location.reload();
        }
    }).fail(function(response) {
        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err]) {
                $('#changeAddress').find('#' + err).parent().append("<p class='text-danger'>" + errstr + "</p>");
            }
        }
    });
    return false;
});

function removeFabvorite(el){
    $.post('/update-wish', {'id':el}, function(data) {
        console.log(data);
        if (data.status) {
            window.location.reload();
        }
    });
}
