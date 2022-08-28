<script type="text/javascript">
// image sliders
function hide() {
    document.getElementById("gallery__lightbox").style.opacity=0;
}
$(document).ready(function() {
    var slideIndex_ = 1
    showSlides(slideIndex_);
    (function() {
        if (slideIndex_==1) {
            document.getElementById("prev").style.display = 'none';
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
        if (document.getElementById("prev-button")) {
            document.getElementById("prev-button").remove();
        }
        if (document.getElementById("next-button")) {
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
        console.log(n)
        if (n==0) {
            document.getElementById("prev-button").remove();
        }else if(!document.getElementById('img'+n)){
            document.getElementById("next-button").remove();
        }else {
            console.log($('.mySlides').find("[data-id='"+n+"']"))
            $('.mySlides').find("[data-id='"+n+"']").trigger('click')
        }
    }
    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex_ = 1}
        if (n < 1) {slideIndex_ = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex_-1].style.display = "block";
        dots[slideIndex_-1].className += " active";
        if (slideIndex_==dots.length) {
            document.getElementById("next").style.display = 'none';
        }else {
            document.getElementById("next").style.display = 'block';
        }
        if (slideIndex_==1) {
            document.getElementById("prev").style.display = 'none';
        }else {
            document.getElementById("prev").style.display = 'block';

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
</script>
