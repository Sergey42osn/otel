let roomCount = roomCountVar;
let adultCount = adultCountVar;
let childCount = childCountVar;
let lang = $('html').attr('lang');
let childMaxAge = 10;
$(document).ready(function() {

    $('input.datefilter').daterangepicker({
        minDate: new Date(),
        autoUpdateInput: false,
        locale: datePickerLocale,
        // startDate: "07/18/2022",
        // endDate: "07/21/2022",
        startDate: moment(checkInDate,'MM/DD/YYYY').locale(lang).format('MM/DD/YYYY'),
        endDate: moment(checkOutDate,'MM/DD/YYYY').locale(lang).format('MM/DD/YYYY'),
    });

    $('input.datefilter').on('show.daterangepicker', function(){
        let type = $(this).attr('data-type');
        let id = $(this).attr('data-id');
    });

    $('input.datefilter').on('apply.daterangepicker', function(ev, picker) {
        let $format = 'dd, D MMM YYYY';
            $format = 'dd, D MMM';
        let type = $(this).attr('data-type');
        let id = $(this).attr('data-id');
        checkInDate = picker.startDate.format('MM/DD/YYYY');
        checkOutDate = picker.endDate.format('MM/DD/YYYY');

        let dateFilters = $(`input.datefilter[data-id="${id}"]`);
        dateFilters.each(function(index,val){
            $(val).data('daterangepicker').setStartDate(checkInDate);
            $(val).data('daterangepicker').setEndDate(checkOutDate);
        });

        let startDateText = moment(checkInDate,'MM/DD/YYYY').locale(lang).format($format)
        let endDateText = moment(checkOutDate,'MM/DD/YYYY').locale(lang).format($format)

        if( type == 'search' ) {
            // let parent = $(this).parents('.single-calendar-input-box');
            // let mobile = $(this).parents('.calendar-input-box');
            let parent = $('.single-calendar-input-box');
            let mobile = $('.calendar-input-box');
            if( parent ) {
                $(parent).find('.check_in').attr('value', startDateText);
                $(parent).find('.check_out').attr('value', endDateText);
                $(parent).find('.check_in_hidden').attr('value', checkInDate);
                $(parent).find('.check_out_hidden').attr('value', checkOutDate);
            }
            if( mobile ) {
                $(mobile).find('.check-in-text').text(startDateText);
                $(mobile).find('.check-out-text').text(endDateText);

                $(mobile).find('.datefilter').attr('value',checkInDate+'-'+checkOutDate);
            }
        } else {
            console.log($(this));
            $(this).attr('value',checkInDate + '-' + checkOutDate);
            $(`.check_in[data-id="${id}"]`).text(startDateText);
            $(`.check_out[data-id="${id}"]`).text(endDateText);
            $('.check_in_hidden').attr('value', checkInDate);
            $('.check_out_hidden').attr('value', checkOutDate);
        }
    });

    $('.selectorBox').click(function (event) {
        let id = $(this).attr('data-id');
        event.stopPropagation();
        if ($(this).attr('data-status') == 'closed') {
            $(this).parents('.people-input-box').addClass('opened');
            $(this).attr('data-status', 'opened')
            $(`.selectorBoxArea[data-id='${id}']`).show();
            $(`.selectorBoxArea[data-id='${id}']`).addClass('opened-selector')
        } else {
            $(this).parents('.people-input-box').removeClass('opened');
            $(this).attr('data-status', 'closed')
            $(`.selectorBoxArea[data-id='${id}']`).hide();
            $(`.selectorBoxArea[data-id='${id}']`).removeClass('opened-selector')
        }
    })

    $(".roomMinus").click(function () {
        if (roomCount > 1) {
            roomCount--;
            updateSelectorBox('roomCount', roomCount);
        }
    })

    $(".roomPlus").click(function () {
        roomCount++;
        updateSelectorBox('roomCount', roomCount);
    })

    $(".adultMinus").click(function () {
        if (adultCount > 1) {
            adultCount--;
            updateSelectorBox('adultCount', adultCount);
        }
    })

    $(".adultPlus").click(function () {
        adultCount++;
        updateSelectorBox('adultCount', adultCount);
    })

    $(".childMinus").click(function () {
        if (childCount > 0) {
            childAgeInputManipulation($(this),childCount, 'remove');
            childCount--;
            updateSelectorBox('childCount', childCount);
        }
    })

    $(".childPlus").click(function () {
        childCount++;
        childAgeInputManipulation($(this),childCount, 'add');
        updateSelectorBox('childCount', childCount);
    })

    $('.search-btn').click(function(e){
        e.preventDefault();
        let form = $(this).parent('form');
        let inputs = $(form).find('input');
        let selects = $(form).find('select');
        let errors = false;
        inputs.each(function(index,val){
            if( $(val).val() == '' || $(val).val() == null ) {
                $('.validation-text').show();
                errors = true;
            } else {
                $(val).css({'border' : "unset"});
            }
        });
        selects.each(function(index,val){
            if( $(val).val() == '' || $(val).val() == null ) {
                errors = true;
            } else {
                $(val).css({'border' : "unset"});
            }
        });
        if(!errors) {
            $(form).submit();
        }
    });

    function childAgeInputManipulation(button, childcount = 1, type = 'add') {
        let parent = $(button).parents('.selectorBoxArea');
        let childAgesBlock = $(parent).find('.child-ages')[0];
        let selects = $(childAgesBlock).find('.child-age-select');
        if( type == 'add' ) {
            if( selects.length < childcount ) {
                let select = createChildAgeSelect('child-age-select', `child_age_${childcount}`);
                $(childAgesBlock).append(select);
            }
        } else if(type == 'remove') {
            $(`.child-age-select[name="child_age_${childcount}"]`).remove();
        }
    }
    function createChildAgeSelect(Class = '', Name = '', Id = '') {
        let text = GetText(lang, 'childAge', 0);
        let select = `<select required style="font-size: 12px" class='mt-2 col-6 ${Class}' name='${Name}' id='${Id}' >`;
            select += `<option value="" selected disabled>${text}</option>`
        for( let i = 1; i <= childMaxAge; i++ ) {
            select += `<option value="${i}">${i}</option>`
        }
        select += '</select>';
        return select;
    }

    function updateSelectorBox(id, val) {
        $('.selectorBoxArea.opened-selector .' + id).html(val);

        let lang = $('html').attr('lang');
        let SelectorInfo, SelectorText, SelectorType = $('.selectorBox[data-status="opened"]').attr('data-type');

        SelectorType = $('.selectorBox[data-status="opened"]').attr('data-type');

        let RoomCountText = ''; //(roomCount > 0) ? roomCount + ' ' + GetText(lang, 'room', roomCount) + ' - ' : '';
        let AdultCountText = (adultCount > 0) ? adultCount : '';
        let ChildCountText = (childCount > 0) ? childCount : '';

        let SelectorNewValue =
            RoomCountText +
            AdultCountText + ' ' + GetText(lang, 'adult', adultCount);

        if( childCount > 0 ) {
            SelectorNewValue += ' - ' +
                ChildCountText + ' ' + GetText(lang, 'child', childCount);
        }

        if( SelectorType == 'search' ) {
            $('.selectorBox[data-status="opened"]').find('p').text(SelectorNewValue);
        } else {
            $('.selectorBox[data-status="opened"]').val(SelectorNewValue);
        }

        $(".people-input-box.opened .hiddenRoomCount").val(roomCount)
        $(".people-input-box.opened .hiddenAdultCount").val(adultCount)
        $(".people-input-box.opened .hiddenChildCount").val(childCount)
    }

    $(document).on('click', function (event) {
        let selectBoxArea = $('.selectorBoxArea');
        let accept = false;
        selectBoxArea.each(function(index, val){
            if (!jQuery(val).has(event.target).length) {
            } else { accept = true; }
        })
        if( !accept ) {
            $('.selectorBox').attr('data-status', 'closed')
            $('.people-input-box').removeClass('opened');
            $(".selectorBoxArea").hide();
            $(".selectorBoxArea").removeClass('opened-selector')
        }
    })

    $(document).on('click',".placeRow",function(){

        $('#placersContainer').hide()
        let _self = $(this);
        let id = _self.data("id")
        let type = _self.data("type")
        let place_name = _self.data("name")
        $('[name=place_id]').val(id)
        $('[name=place_name]').val(place_name)
        $('[name=place_type]').val(type)
    });

    //Check Availability
    $('.checkAvailability').click(function (event) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let errors = false;
        let selects = $('.child-age-select');
        let id = $(this).attr('data-id');
        let data = {
            hotelId: $(`.hotelId[data-id="${id}"]`).val(),
            accId: $(`.accId[data-id="${id}"]`).val(),
            rooms: $(`.hiddenRoomCount[data-id="${id}"]`).val(),
            adults: $(`.hiddenAdultCount[data-id="${id}"]`).val(),
            children: $(`.hiddenChildCount[data-id="${id}"]`).val(),
            datefilter: $(`.datefilter[data-id="${id}"]`).val()
        }
        selects.each(function(index,val){
            if($(val).val() == '' || $(val).val() == null) {
                errors = true;
            } else {
                data[$(val).attr('name')] = $(val).val();
            }
        });

        if(!errors){
            $.ajax({
                method: "POST",
                url: '/' + $(".hidden-appLocale").text() + '/accommodation/check/availability',
                data: data,
                success: function (data) {
                    let text = data.days + ' ' + GetText(lang, 'night', data.days );
                    $('#rooms-list').html('');
                    $('#rooms-list').append(data.view);
                    $("#setNights").html(text);
                }
            })
        }
    })

    function GetText( lang, type, count) {
        switch(lang) {
            case 'ru':
                switch(type) {
                    case 'childAge':
                        return 'Укажите возраст';
                    break;
                    case 'room':
                        switch(true) {
                            case(count > 4):
                                return 'номеров';
                                break;
                            case(count > 1):
                                return 'номера';
                                break;
                            case(count == 1):
                                return 'номер';
                                break;
                            default: return '';
                                break;
                        }
                        break;
                    case 'adult':
                        switch(true){
                            case(count > 1):
                                return 'взрослых';
                                break;
                            case(count == 1):
                                return 'взрослый';
                                break;
                            default: return '';
                                break;
                        }
                        break;
                    case 'child':
                        switch(true) {
                            case(count > 4):
                                return 'детей';
                                break;
                            case(count > 1):
                                return 'ребенка';
                                break;
                            case(count == 1):
                                return 'ребенок';
                                break;
                            default: return '';
                                break;
                        }
                        break;
                    case 'night':
                        switch(true) {
                            case(count > 3):
                                return 'Ночей'
                                break;
                            case(count > 1):
                                return 'Ночи';
                                break;
                            case(count == 1):
                                return 'Ночь';
                                break;
                            default: '';
                                break;
                        }
                    break;
                }
                break;
            case 'en':
                switch(type) {
                    case 'childAge':
                        return 'Age needed';
                    break;
                    case 'room':
                        switch(true) {
                            case(count > 1):
                                return 'rooms';
                                break;
                            case(count == 1):
                                return 'room';
                                break;
                            default: return '';
                        }
                        break;
                    case 'adult':
                        switch(true){
                            case(count > 1):
                                return 'adults';
                                break;
                            case(count == 1):
                                return 'adult';
                                break;
                            default: return '';
                        }
                        break;
                    case 'child':
                        switch(true) {
                            case(count > 1):
                                return 'childs';
                                break;
                            case(count == 1):
                                return 'child';
                                break;
                            default: return '';
                        }
                        break;
                    case 'night':
                        switch(true) {
                            case(count > 1):
                                return 'Nights';
                                break;
                            case(count == 1):
                                return 'Night';
                                break;
                            default: '';
                                break;
                        }
                        break;
                }
                break;
        }

    }
})
