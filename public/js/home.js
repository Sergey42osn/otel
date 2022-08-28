function openInput() {
    var checkBox = document.getElementsByClassName("checkService");
    var input = document.getElementsByClassName("checkServiceInput");
    for(let i = 0; i < checkBox.length; i++){
        if (checkBox[i].checked == true){
            input[i].style.display = "flex";
        } else {
            input[i].style.display = "none";
        }
    }
}
jQuery(document).ready(function () {

    jQuery('#certificates').owlCarousel({
        loop: true,
        autoplay: true,
        smartSpeed: 2000,
        autoplayTimeout: 6000,
        margin: 24,
        responsiveClass: true,
        dots: true,
        nav: false,
        navText:  ['<svg xmlns="http://www.w3.org/2000/svg" width="12.579" height="22" viewBox="0 0 12.579 22"><path d="M15.038,17.192l8.325-8.319a1.566,1.566,0,0,0,0-2.22,1.585,1.585,0,0,0-2.227,0L11.7,16.079a1.569,1.569,0,0,0-.046,2.168l9.471,9.491a1.572,1.572,0,1,0,2.227-2.22Z" transform="translate(-11.246 -6.196)" fill="#2576ec" opacity="1"/></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" width="12.579" height="22" viewBox="0 0 12.579 22"><path d="M15.038,17.192l8.325-8.319a1.566,1.566,0,0,0,0-2.22,1.585,1.585,0,0,0-2.227,0L11.7,16.079a1.569,1.569,0,0,0-.046,2.168l9.471,9.491a1.572,1.572,0,1,0,2.227-2.22Z" transform="translate(23.825 28.196) rotate(180)" fill="#2576ec" opacity="1"/></svg>'],

        responsive: {
            0: {
                items: 1.2,
                dots: false,
                margin: 14,
            },
            577: {
                items: 2,
            },
            991: {
                items: 4,
            },


        }
    })
});
// Photo book main photo

// let $radioButtons = $('input[type="radio"]');
// $radioButtons.click(function() {
//     $radioButtons.each(function() {
//         $(this).parents(".photoFigure").toggleClass('active', this.checked);
//     });
// });


// $radioButtons.click(function() {
//     $radioButtons.each(function() {
//         $(this).parents(".sales-channel-inner-form").toggleClass('active', this.checked);
//     });
// });

// $radioButtons.click(function() {
//     $radioButtons.each(function() {
//         $(this).parent().parent().toggleClass('active', this.checked);
//     });
// });


jQuery(document).ready(function () {

    jQuery('#popular-type-block').owlCarousel({
        loop: true,
        autoplay: true,
        smartSpeed: 2000,
        autoplayTimeout: 6000,
        // margin: 24,
        responsiveClass: true,
        dots: false,
        nav: true,
        navText: ['<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"><g transform="translate(1326 2175) rotate(180)"><rect width="50" height="50" rx="25" transform="translate(1276 2125)" fill="#fff"/><path d="M20.832,18.192,11.75,9.117a1.708,1.708,0,0,1,0-2.422,1.73,1.73,0,0,1,2.429,0l10.29,10.282a1.712,1.712,0,0,1,.05,2.365L14.187,29.7a1.715,1.715,0,0,1-2.429-2.422Z" transform="translate(1282.754 2131.805)" fill=""/></g></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"><g transform="translate(-1276 -2125)"><rect width="50" height="50" rx="25" transform="translate(1276 2125)" fill="#fff" opacity="0.9"/><path d="M20.832,18.192,11.75,9.117a1.708,1.708,0,0,1,0-2.422,1.73,1.73,0,0,1,2.429,0l10.29,10.282a1.712,1.712,0,0,1,.05,2.365L14.187,29.7a1.715,1.715,0,0,1-2.429-2.422Z" transform="translate(1282.754 2131.805)" fill=""/></g></svg>'],
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            991: {
                items: 3,
            },
            1200: {
                items: 4,
            },

        }
    })
});

$(function() {

    // console.log("1");

    // $('input[name="datefilter"]').daterangepicker({
    //     minDate: new Date(),
    //     autoUpdateInput: false,
    //     locale: {
    //         cancelLabel: datePickerButtons.clear,
    //         applyLabel: datePickerButtons.apply
    //     }
    // });
    //
    // $('input[name="datefilter"]').on('show.daterangepicker', function(ev, picker) {
    //     $('#calendar-input-box').addClass('opened');
    // });
    //
    // $('input[name="datefilter"]').on('hide.daterangepicker', function(ev, picker) {
    //     $('#calendar-input-box').removeClass('opened');
    // });
    //
    // $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
    //     $(this).val(picker.startDate.format('MM/DD/YYYY') + '-' + picker.endDate.format('MM/DD/YYYY'));
    //     $('#check-in').text(picker.startDate.format('MM/DD/YYYY'));
    //     $('#check-out').text(picker.endDate.format('MM/DD/YYYY'));
    //   });
    //
    //   $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
    //         $('#check-in').val($('#check-in-init').val());
    //         $('#check-out').val($('#check-out-init').val());
    //   });

});


$(function() {
    var owl = $('.owl-carousel'),

        owlOptions = {
            loop: true,
            autoplay: true,
            smartSpeed: 2000,
            autoplayTimeout: 6000,
            // margin: 15,
            responsiveClass: true,
            dots: false,
            nav: true,
            navText: ['<svg xmlns="http://www.w3.org/2000/svg" width="12.579" height="22" viewBox="0 0 12.579 22"><path d="M15.038,17.192l8.325-8.319a1.566,1.566,0,0,0,0-2.22,1.585,1.585,0,0,0-2.227,0L11.7,16.079a1.569,1.569,0,0,0-.046,2.168l9.471,9.491a1.572,1.572,0,1,0,2.227-2.22Z" transform="translate(-11.246 -6.196)" fill="#2576ec" opacity="1"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="12.579" height="22" viewBox="0 0 12.579 22"><path d="M15.038,17.192l8.325-8.319a1.566,1.566,0,0,0,0-2.22,1.585,1.585,0,0,0-2.227,0L11.7,16.079a1.569,1.569,0,0,0-.046,2.168l9.471,9.491a1.572,1.572,0,1,0,2.227-2.22Z" transform="translate(23.825 28.196) rotate(180)" fill="#2576ec" opacity="1"/></svg>'],
            items: 1
        };

    if ( $(window).width() < 768 ) {
        var owlActive = owl.owlCarousel(owlOptions);
    } else {
        owl.addClass('off');
    }

    $(window).resize(function() {
        if ( $(window).width() < 768 ) {
            if ( $('.owl-carousel').hasClass('off') ) {
                var owlActive = owl.owlCarousel(owlOptions);
                owl.removeClass('off');
            }
        } else {
            if ( !$('.owl-carousel').hasClass('off') ) {
                owl.addClass('off').trigger('destroy.owl.carousel');
                owl.find('.owl-stage-outer').children(':eq(0)').unwrap();
            }
        }
    });
});
$('.favorite.auth').click(function (event) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const accommodation = $(this).attr('data-acc');
    let added = $(this).attr('data-id')
    let favItem = $(this)
    if (added != 0) {
        $.ajax({
            method: "POST",
            url: '/' + $("html").attr('lang').substring(0,2) + '/accommodation/wishlist/delete',
            data: {
                id: added
            },
            success: function (data) {
                favItem.attr('data-id', 0)
                favItem.children('img').attr('src', '/images/heart.png')
                console.log(favItem.children('img'))
            }
        })
    } else {
        $.ajax({
            method: "POST",
            url: '/' + $("html").attr('lang').substring(0,2) + '/accommodation/wishlist/create',
            data: {
                accommodation_id: accommodation,
            },
            success: function (data) {
                favItem.attr('data-id', data.id)
                favItem.children('img').attr('src', '/images/heart-fill.png')
                console.log(favItem.children('img'))
            }
        })
    }
})

var acc = document.getElementsByClassName("accordion");
var i;
for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}


