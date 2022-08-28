// image sliders
function hide() {
    document.getElementById("gallery__lightbox").style.opacity=0;
}
$(document).ready(function() {
    var slideIndex_ = 1
    showSlides(slideIndex_);
    (function() {
        if (slideIndex_==1) {
            if( document.getElementById("prev") ) {
                document.getElementById("prev").style.display = 'none';
            }
        }
    })();
    function plusSlides(n) {
        slideIndex_ += n
        showSlides(slideIndex_);
    }
    $( ".zoom" ).click(function() {
        let n = Number($(this).attr("data-id"));
        document.getElementById("gallery__lightbox-image").src=document.getElementById('img'+n).src;
        document.getElementById("gallery__lightbox").style.opacity=1;
        if (document.getElementById("prev-button") && document.getElementById("prev-button") != null) {
            document.getElementById("prev-button").remove();
        }
        if (document.getElementById("next-button") && document.getElementById("next-button") != null) {
            document.getElementById("next-button").remove();
        }
        document.getElementById("gallery__lightbox-content").innerHTML += '<a id="prev-button" class="my-btn" data-id='+(n-1)+'><img src="/images/left-arrow.png" width="25px" ></a>';
        document.getElementById("gallery__lightbox-content").innerHTML += '<a id="next-button"  class="my-btn" data-id='+(n+1)+'><img src="/images/right-arrow.png" width="25px" ></a>';
    });
    $(document).on("click", ".my-btn" , function() {
        let n = Number($(this).attr("data-id"));
        next(n)
    });

    function next(n) {
        $('#prev-button').attr('data-id', n-1);
        $('#next-button').attr('data-id', n+1);
        let nextButton = document.getElementById("next-button");
        let prevButton = document.getElementById("prev-button");
        if (n<=0) {
            document.getElementById("prev-button").remove();
        }else if(!document.getElementById('img'+n)){
            document.getElementById("next-button").remove();
        }else {
            $('#main-div').find(".dot[data-id='"+n+"']").trigger('click')
            if( !document.getElementById('img'+(n+1)) || !document.getElementById('img'+(n+1)) == null ) {
                document.getElementById("next-button").remove();
            } else if(!nextButton) {
                document.getElementById("gallery__lightbox-content").innerHTML += '<a id="next-button"  class="my-btn" data-id='+(n+1)+'><img src="/images/right-arrow.png" width="25px" ></a>';
            }
            if( (n-1) == 0 ) {
                document.getElementById("prev-button").remove();
            } else if(!prevButton) {
                document.getElementById("gallery__lightbox-content").innerHTML += '<a id="prev-button" class="my-btn" data-id='+(n-1)+'><img src="/images/left-arrow.png" width="25px" ></a>';
            }
        }
    }
    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");

        let Img = slides[slideIndex_-1].getElementsByTagName('img')[0];
        let src = Img != null ? Img.getAttribute('src') : '';
        let ModalImage = document.getElementById('gallery__lightbox-image');
        if( ModalImage != null ) {ModalImage.setAttribute('src',src)}

        if (n > slides.length) {slideIndex_ = 1}
        if (n < 1) {slideIndex_ = slides.length}
        $('.zoom.button').attr('data-id', n);
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex_-1].style.display = "block";
        dots[slideIndex_-1].className += " active";
        if( document.getElementById("next") ) {
            if (slideIndex_==dots.length) {
                document.getElementById("next").style.display = 'none';
            }else {
                document.getElementById("next").style.display = 'block';
            }
        }
        if( document.getElementById("prev") ) {
            if (slideIndex_==1) {
                document.getElementById("prev").style.display = 'none';
            }else {
                document.getElementById("prev").style.display = 'block';
            }
        }
    }
    var sliding,
        dir,
        startClientX = 0,
        prevClientX = 0,
        mainDiv = $('#main-div');

    function move(dir, step) {
        var ul = mainDiv.find('ul'),
            liWidth = ul.find('li').width();
        console.log(ul.offset().left)
        if (ul.offset().left>=-1 && ul.offset().left<=450) {
            ul.animate({
                left: '+=' + (dir * liWidth)
            }, 200);
        } else {
            ul.animate({
                left: 0
            }, 200);
        }
    }
    mainDiv.mousedown(function (event) {
        sliding = true;
        startClientX = event.clientX;
        return false;
    }).mouseup(function (event) {
        var step = event.clientX - startClientX,
            dir = step > 0 ? 1 : -1;
        step = Math.abs(step);
        move(dir, step);
    });
    $(".dot").click(function() {
        let n = Number($(this).attr("data-id"));
        showSlides(slideIndex_ = n);
    });
    $("#prev").click(function() {
        plusSlides(-1)
    });
    $("#next").click(function() {
        plusSlides(1)
    })


    // get url parameter func
    let getUrlParameter = function getUrlParameter(sParam) {
        let sPageURL = window.location.search.substring(1)
        let sURLVariables = sPageURL.split('&')
        let sParameterName = ''
        let i = 0;

        for (;i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };
})


function openInput() {
    var checkBox = document.getElementsByClassName("checkService");
    var input = document.getElementsByClassName("checkServiceInput");
    for(let i = 0; i < checkBox.length; i++){
        if (checkBox[i].checked == true) {
            input[i].style.display = "flex";
        } else {
            input[i].style.display = "none";
        }
    }
}

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

// jQuery(document).ready(function () {
//     const wishList = $('.wish-list').val();
//     if(wishList){
//         $('#Icon_ionic-ios-heart').addClass('Icon_ionic-ios-heart-active')
//     }
//     jQuery('#popular-type-block').owlCarousel({
//         loop: false,
//         autoplay: true,
//         smartSpeed: 2000,
//         autoplayTimeout: 6000,
//         margin: 24,
//         responsiveClass: true,
//         dots: false,
//         nav: true,
//         navText: [
//             '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"><g transform="translate(1326 2175) rotate(180)"><rect width="50" height="50" rx="25" transform="translate(1276 2125)" fill="#fff"/><path d="M20.832,18.192,11.75,9.117a1.708,1.708,0,0,1,0-2.422,1.73,1.73,0,0,1,2.429,0l10.29,10.282a1.712,1.712,0,0,1,.05,2.365L14.187,29.7a1.715,1.715,0,0,1-2.429-2.422Z" transform="translate(1282.754 2131.805)" fill=""/></g></svg>',
//             '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"><g transform="translate(-1276 -2125)"><rect width="50" height="50" rx="25" transform="translate(1276 2125)" fill="#fff" opacity="0.9"/><path d="M20.832,18.192,11.75,9.117a1.708,1.708,0,0,1,0-2.422,1.73,1.73,0,0,1,2.429,0l10.29,10.282a1.712,1.712,0,0,1,.05,2.365L14.187,29.7a1.715,1.715,0,0,1-2.429-2.422Z" transform="translate(1282.754 2131.805)" fill=""/></g></svg>'
//         ],
//         responsive: {
//             0: {
//                 items: 1,
//             },
//             768: {
//                 items: 2,
//             },
//             991: {
//                 items: 3,
//             },
//             1200: {
//                 items: 4,
//             },

//         }
//     })
// });

// $(function() {

    // console.log("1");
$(document).ready(function(){
    let conditionElement = document.getElementById('condition_content');
    let learnMore = jQuery('#learn_more');
    let showLess = jQuery('#show_less');

    // let conditionElement = $('#condition_content');
    if(conditionElement) {
        var conditionContent = conditionElement.textContent;
        if( conditionContent.length > 0 ) {
            var span = document.createElement('span');
            span.textContent = conditionContent;
            conditionElement.innerHTML = '';
            conditionElement.appendChild(span);
            let length = span.getClientRects().length;
            if(length > 3) {
                jQuery(learnMore).show(250);
            }
        }
        $(learnMore).click(function() {
            jQuery('#condition_content').css('display', 'block');
            learnMore.hide(250, function(){
                showLess.show(250);
            });
        })
        $(showLess).click(function(){
            jQuery('#condition_content').css('display', '-webkit-box');
            showLess.hide(250, function(){
                learnMore.show(250);
            })
        });
    }
});



    // $("#selectorBoxArea").click(function (e) {
    //     e.stopPropagation();
    // })

    // $(document).click(function () {
    //     if ($('#selectorBoxArea').hasClass('opened-selector')) {
    //         $('#selectorBox').attr('data-status', 'closed')
    //         $("#selectorBoxArea").hide();
    //     }
    // })


    $(".getPath").click(function () {
        let src = $(this).attr('src')
        $("#setPath").attr('src', src)
    })

//WISHLIST
    $('.heart-box.auth').click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const auth = $('.auth').val();
        const accommodation = $('.accommodation').val();
        const wishList = $('.wish-list').val();
        if (!auth) {
            window.location.href = '/login'
        } else {
            if (wishList) {
                $.ajax({
                    method: "POST",
                    url: '/' + $(".hidden-appLocale").text() + '/accommodation/wishlist/delete',
                    data: {
                        id: wishList
                    },
                    success: function (data) {
                        $('.wish-list').val('');
                        $('#Icon_ionic-ios-heart').removeClass('Icon_ionic-ios-heart-active')
                    }
                })
            } else {
                $.ajax({
                    method: "POST",
                    url: '/' + $(".hidden-appLocale").text() + '/accommodation/wishlist/create',
                    data: {
                        user_id: auth,
                        accommodation_id: accommodation,
                    },
                    success: function (data) {
                        $('.wish-list').val(data.id);
                        $('#Icon_ionic-ios-heart').addClass('Icon_ionic-ios-heart-active')
                    }
                })
            }
        }

    })
//WISHLIST HOMEPAGE
    $('.heart-box-container').click(function (event) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const auth = $(this).siblings('.auth').val();
        const accommodation = $(this).siblings('.hotel').val();
        const wishList = $(this).siblings('.wish-list').val();
        let added = $(this).attr('data-like')
        if (!auth) {
            window.location.href = '/login'
        } else {
            if (added == 1) {
                $.ajax({
                    method: "POST",
                    url: '/' + $(".hidden-appLocale").text() + '/accommodation/wishlist/delete',
                    data: {
                        id: wishList
                    },
                    success: function (data) {
                        $(this).closest('.wish-list').val('');
                        $(this).attr('data-like', 0)
                    }
                })
            } else {
                $.ajax({
                    method: "POST",
                    url: '/' + $(".hidden-appLocale").text() + '/accommodation/wishlist/create',
                    data: {
                        user_id: auth,
                        accommodation_id: accommodation,
                    },
                    success: function (data) {
                        $(this).closest('.wish-list').val(data.id);
                        $(this).attr('data-like', 1)
                    }
                })
            }
        }

    })

    $(".star").click(function () {
        let stars = document.getElementsByClassName('getStar');
        if ($(this).is(':checked')) {
            for (let i = 0; i < 5; i++) {
                stars[i].style.fill = 'transparent'
            }
            for (let i = 0; i < $(this).val(); i++) {
                stars[i].style.fill = '#faaf40'
            }
        }
    })

    $("#addRating").click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let lang = $('html').attr('lang');
        let data = {
            user_id: $('.auth').val(),
            accommodation_id: $('.hidden-accommodation').text(),
            rating: $('input[name="ratingStars"]:checked').val(),
            comment: $('#ratingDescription').val(),
        }

        $.ajax({
            method: "POST",
            url: `/${lang}/accommodation/rating`,
            data: data,
            success: function (data) {
                let actStars = '';
                let pasStars = '';
                for (let i = 0; i < data.rating; i++) {
                    actStars += '<svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>';
                }
                for (let i = 0; i < 5 - data.rating; i++) {
                    pasStars += '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>';
                }
                let reviewElement = `<div class="item"><div class="reviews-slider-item">
                        <div class="d-flex reviews-slider-heading">`;
                if( data.user.image ) {
                    reviewElement += `<span><img src="images/${data.user.image ? data.user.image.url : ''}"></span>`;
                }
                reviewElement += `<div>
                                            <h3>${data.user.name}</h3>
                                            <span>${data.created_at}</span>
                                        </div>
                                    </div>
                                    <div class="stars">
                                        ${actStars} ${pasStars}
                                    </div>
                                    <div class="review-text">
                                        <p>${data.comment}</p>
                                    </div>
                                </div></div>`;
                $('#reviews-slider').trigger('add.owl.carousel', [
                        reviewElement
                    ]).trigger('refresh.owl.carousel');
                $('#ratingDescription').val('');
                $('input[name="ratingStars"]:checked').prop('checked', false);
                if( $('.add-review-block') ) {
                    $('.add-review-block').remove();
                }
            }
        })
    })
    // Room Count Change
    $('.selectRoomCount').on('change',function(){
         let count = $(this).val();
         let parent = $(this).parents('.table-body');
         let button = $(parent).find('.book-now');
         if( button != null ) {
             let url = button.attr('href');
             let urlPath = url.split('?')[1];
             let paramsVar = urlPath.split('&');
             let params = paramsVar.map(function(val){
                 return val.split('=')[0];
             })
             if( params.includes('room_count') ) {
                 let index = url.lastIndexOf('&');
                 url = url.slice(0, index);
             }
             url = url + `&room_count=${count}`;
             button.attr('href', url);

         }
    });

share = {
    fb: function() {
        var uriLocation;
        if (typeof fb_post_id != 'undefined') {
            uriLocation = "https://www.facebook.com/raznogo/posts/"+fb_post_id;
        }else if (typeof fb_post_link != 'undefined') {
            uriLocation = fb_post_link;
        }else {
            uriLocation = window.location.href;
        };
        url = 'https://www.facebook.com/sharer.php?u=' + encodeURIComponent(uriLocation);
        share.popup(url);
    },
    vk: function() {
        image = jQuery('.image-popup').attr('href');
        url = 'http://vk.com/share.php?url=' + encodeURIComponent(window.location.href);
        url += '&image='+encodeURIComponent(image);
        share.popup(url);

    },
    clip: function(){
        navigator.clipboard.writeText(window.location.href);
    },
    popup: function(url) {
        var width = 600;
        var height = 400;
        var top = (screen.height/2)-(height/2);
        var left = (screen.width/2)-(width/2);
        window.open(url,'','toolbar=0,status=0,width='+width+',height='+height+',top='+top+',left='+left);
    }
};
// })
// $(function() {
//     var owl = $('.owl-carousel'),

//         owlOptions = {
//             loop: false,
//             autoplay: true,
//             smartSpeed: 2000,
//             autoplayTimeout: 6000,
//             margin: 24,
//             responsiveClass: true,
//             dots: false,
//             nav: true,
//             navText: ['<svg xmlns="http://www.w3.org/2000/svg" width="12.579" height="22" viewBox="0 0 12.579 22"><path d="M15.038,17.192l8.325-8.319a1.566,1.566,0,0,0,0-2.22,1.585,1.585,0,0,0-2.227,0L11.7,16.079a1.569,1.569,0,0,0-.046,2.168l9.471,9.491a1.572,1.572,0,1,0,2.227-2.22Z" transform="translate(-11.246 -6.196)" fill="#2576ec" opacity="1"/></svg>',
//                 '<svg xmlns="http://www.w3.org/2000/svg" width="12.579" height="22" viewBox="0 0 12.579 22"><path d="M15.038,17.192l8.325-8.319a1.566,1.566,0,0,0,0-2.22,1.585,1.585,0,0,0-2.227,0L11.7,16.079a1.569,1.569,0,0,0-.046,2.168l9.471,9.491a1.572,1.572,0,1,0,2.227-2.22Z" transform="translate(23.825 28.196) rotate(180)" fill="#2576ec" opacity="1"/></svg>'],
//             items: 1
//         };

//     if ( $(window).width() < 768 ) {
//         var owlActive = owl.owlCarousel(owlOptions);
//     } else {
//         owl.addClass('off');
//     }

//     $(window).resize(function() {
//         if ( $(window).width() < 768 ) {
//             if ( $('.owl-carousel').hasClass('off') ) {
//                 var owlActive = owl.owlCarousel(owlOptions);
//                 owl.removeClass('off');
//             }
//         } else {
//             if ( !$('.owl-carousel').hasClass('off') ) {
//                 owl.addClass('off').trigger('destroy.owl.carousel');
//                 owl.find('.owl-stage-outer').children(':eq(0)').unwrap();
//             }
//         }
//     });


//     //SLIDE
//     $("#owlSlideCarousel").owlCarousel({
//         loop: false,
//         autoplay: false,
//         smartSpeed: 500,
//         margin: 24,
//         responsiveClass: true,
//         dots: false,
//         nav: false,
//         items: 4.2
//     });

//     //Review slider
    $("#reviews-slider").owlCarousel({
        loop: false,
        autoplay: false,
        smartSpeed: 500,
        margin: 24,
        responsiveClass: true,
        dots: false,
        nav: false,


        responsive: {
            0: {
                nav:false,
                items: 1,
            },
            768: {
                nav:false,
                items: 2,
            },
            991: {
                items: 3,
                nav: true,
                navText: ['<svg xmlns="http://www.w3.org/2000/svg" width="12.579" height="22" viewBox="0 0 12.579 22"><path d="M15.038,17.192l8.325-8.319a1.566,1.566,0,0,0,0-2.22,1.585,1.585,0,0,0-2.227,0L11.7,16.079a1.569,1.569,0,0,0-.046,2.168l9.471,9.491a1.572,1.572,0,1,0,2.227-2.22Z" transform="translate(-11.246 -6.196)" fill="#2576ec" opacity="1"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="12.579" height="22" viewBox="0 0 12.579 22"><path d="M15.038,17.192l8.325-8.319a1.566,1.566,0,0,0,0-2.22,1.585,1.585,0,0,0-2.227,0L11.7,16.079a1.569,1.569,0,0,0-.046,2.168l9.471,9.491a1.572,1.572,0,1,0,2.227-2.22Z" transform="translate(23.825 28.196) rotate(180)" fill="#2576ec" opacity="1"/></svg>'],
            },


        }
    });

// });


// let slideIndex = 1;
// showSlides(slideIndex);
// (function() {
//     if (slideIndex==1) {
//         document.getElementById("prev").style.display = 'none';
//     }
// })();
// function plusSlides(n) {
//     slideIndex += n
//     showSlides(slideIndex);
// }
// $( ".zoom" ).click(function() {
//     let n = Number($(this).attr("data-id"));
//     document.getElementById("gallery__lightbox-image").src=document.getElementById('img'+n).src;
//     document.getElementById("gallery__lightbox").style.opacity=1;
//     if (document.getElementById("prev-button")) {
//         document.getElementById("prev-button").remove();
//     }
//     if (document.getElementById("next-button")) {
//         document.getElementById("next-button").remove();
//     }
//     document.getElementById("gallery__lightbox-content").innerHTML += '<a id="prev-button" class="my-btn" data-id='+(n-1)+'><img src="/images/left-arrow.png" width="25px" ></a>';
//     document.getElementById("gallery__lightbox-content").innerHTML += '<a id="next-button"  class="my-btn" data-id='+(n+1)+'><img src="/images/right-arrow.png" width="25px" ></a>';
// });
// function hide() {
//     document.getElementById("gallery__lightbox").style.opacity=0;
// }


// $(document).on("click", ".my-btn" , function() {
//     let n = Number($(this).attr("data-id"));
//     next(n)
// });
// function next(n) {
//     console.log(n)
//     if (n==0) {
//         document.getElementById("prev-button").remove();
//     }else if(!document.getElementById('img'+n)){
//         document.getElementById("next-button").remove();
//     }else {
//         console.log($('.mySlides').find("[data-id='"+n+"']"))
//         $('.mySlides').find("[data-id='"+n+"']").trigger('click')
//     }
// }
// function showSlides(n) {
//     let i;
//     let slides = document.getElementsByClassName("mySlides");
//     let dots = document.getElementsByClassName("dot");
//     if (n > slides.length) {slideIndex = 1}
//     if (n < 1) {slideIndex = slides.length}
//     for (i = 0; i < slides.length; i++) {
//         slides[i].style.display = "none";
//     }
//     for (i = 0; i < dots.length; i++) {
//         dots[i].className = dots[i].className.replace(" active", "");
//     }
//     slides[slideIndex-1].style.display = "block";
//     dots[slideIndex-1].className += " active";
//     if (slideIndex==dots.length) {
//         document.getElementById("next").style.display = 'none';
//     }else {
//         document.getElementById("next").style.display = 'block';
//     }
//     if (slideIndex==1) {
//         document.getElementById("prev").style.display = 'none';
//     }else {
//         document.getElementById("prev").style.display = 'block';

//     }
// }
// var sliding,
//     dir,
//     startClientX = 0,
//     prevClientX = 0,
//     mainDiv = $('#main-div');

// function move(dir, step) {
//     var ul = mainDiv.find('ul'),
//     liWidth = ul.find('li').width();
//     console.log(ul.offset().left)
//     if (ul.offset().left>=-1 && ul.offset().left<=450) {
//         ul.animate({
//             left: '+=' + (dir * liWidth)
//         }, 200);
//     } else {
//         ul.animate({
//             left: 0
//         }, 200);
//     }
// }
// mainDiv.mousedown(function (event) {
//     sliding = true;
//     startClientX = event.clientX;
//     return false;
// }).mouseup(function (event) {
//     var step = event.clientX - startClientX,
//     dir = step > 0 ? 1 : -1;
//     step = Math.abs(step);
//     move(dir, step);
// });

