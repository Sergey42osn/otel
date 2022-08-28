var $range = $(".js-range-slider"),
    $form = $(".from"),
    $to = $(".to"),
    range,
    min = $range.data('min'),
    max = $range.data('max'),
    from,
    to;

var updateValues = function () {
    $form.prop("value", from);
    $to.prop("value", to);
};

// $range.ionRangeSlider({
//     onChange: function (data) {
//         from = data.from;
//         to = data.to;
//         updateValues();
//     }
// });

// range = $range.data("ionRangeSlider");
// var updateRange = function () {
//     range.update({
//         from: from,
//         to: to
//     });
// };

$form.on("input", function () {
    from = +$(this).prop("value");
    if (from < min) {
        from = min;
    }
    if (from > to) {
        from = to;
    }
    updateValues();
    updateRange();
});

$to.on("input", function () {
    to = +$(this).prop("value");
    if (to > max) {
        to = max;
    }
    if (to < from) {
        to = from;
    }
    updateValues();
    updateRange();
});


// From Search

$( document ).ready(function() {

    $("#filter-form input").not(".range").on("change",function (){
        let _self = $(this);
        let filter_form = _self.parents("form")
        let search_form = $("#search-form")
        let search_form_input = search_form.find('input')
        let search_form_hidden_input = $(`<div style="display: none"></div>`)
        // $.each(search_form_input,function (index,val){
        //     search_form_hidden_input.append(val)
        // })
        // filter_form.append(search_form_hidden_input)
        filter_form.submit();
    })
});
$('.show-services').click(function () {
    $(".services").toggleClass('d-none')
});

$('.show-amenities').click(function () {
    $(".amenities").toggleClass('d-none')
});

let rangeOne = document.querySelector('input[name="rangeOne"]'),
    rangeTwo = document.querySelector('input[name="rangeTwo"]'),
    outputOne = document.querySelector('.outputOne'),
    outputTwo = document.querySelector('.outputTwo'),
    inclRange = document.querySelector('.incl-range');
    if( rangeOne != null && rangeTwo != null && outputOne != null && outputTwo != null && inclRange != null ) {

        let updateView = function () {
            if (parseInt(rangeOne.value) + 1000 > parseInt(rangeTwo.value)) {
                if (this.getAttribute('name') === 'rangeOne') {
                    this.value = rangeOne.value = rangeTwo.value;
                    this.value = parseInt(this.value) - 1000;
                } else if (this.getAttribute('name') === 'rangeTwo') {
                    this.value = rangeTwo.value = rangeOne.value;
                    this.value = parseInt(this.value) + 1000;
                }
            }

            let currencies = {en: 'rub.', ru: 'руб.'};
            let curLang = $('html').attr('lang');

            if (this.getAttribute('name') === 'rangeOne') {
                outputOne.innerHTML = formatCurrency(this.value) + ' ' + currencies[curLang];
                outputOne.style.left = this.value / this.getAttribute('max') * 100 + '%';
            } else {
                outputTwo.style.left = this.value / this.getAttribute('max') * 100 + '%';
                outputTwo.innerHTML = formatCurrency(this.value) + ' ' + currencies[curLang];
            }
            if (parseInt(rangeOne.value) > parseInt(rangeTwo.value)) {
                inclRange.style.width = (rangeOne.value - rangeTwo.value) / this.getAttribute('max') * 100 + '%';
                inclRange.style.left = rangeTwo.value / this.getAttribute('max') * 100 + '%';
            } else {
                inclRange.style.width = (rangeTwo.value - rangeOne.value) / this.getAttribute('max') * 100 + '%';
                inclRange.style.left = rangeOne.value / this.getAttribute('max') * 100 + '%';
            }

        };

        function formatCurrency(number) {
            return number; //number.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, " ");
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateView.call(rangeOne);
            updateView.call(rangeTwo);
            $('input[type="range"]').on('mouseup', function() {
                this.blur();
            }).on('mousedown input', function () {
                updateView.call(this);
            });
        });
    }



function placeRow(place){
    let typeClass = place.type ? 'object' : 'location';
    return `<div style="cursor: pointer" data-name='${place.name[lang]}' data-id=${place.id} data-type= ${place.type ? "object" : (place.country ? "city" : "country")} class="placeRow ${typeClass}">
    <span>${place.name[lang]}</span>
        ${place.country ? `<span style="font-weight: normal">${place.country.name[lang]}</span>` : ""}
        ${place.city ? `<span style="font-weight: normal">, ${place.city.name[lang]}</span>` : ""}
</div>`
}


$(document).ready(function() {
    $('#place_name').on('input',function (e){
        $('[name=place_id]').siblings('.validation-text').hide()
        let name = $(this).val();
        if(name.length > 2) {
            $("#placersContainer").html("")
            $.ajax({
                url: "/api/filter-locations",
                method: 'post',
                data: {name : name},
                success: function (data) {
                    $('#placersContainer').show()
                    $.each(data.data,function (index,val){
                        let row = placeRow(val)
                        $("#placersContainer").append(row)
                    })
                }
            })
        }
    })

    $('#toggle-filters').click(function () {
        $('#sidebar-filter').toggle()
    })
})

