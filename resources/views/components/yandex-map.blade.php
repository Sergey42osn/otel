<script>
    ymaps.ready(init);

    vals = '{{ $coords}}'.split(',');
    if(!vals){
        vals = [55.753994, 37.622093];
    }
    function init() {
        var myPlacemark,
            myMap = new ymaps.Map('mymap', {
                center: vals,
                zoom: 9
            }, {
                searchControlProvider: 'yandex#search'
            });
        if (myPlacemark) {

            myPlacemark.geometry.setCoordinates(vals);
        } else {
            myPlacemark = createPlacemark(vals);
            myMap.geoObjects.add(myPlacemark);
            // Listening for the dragging end event on the placemark.
            myPlacemark.events.add('dragend', function() {
                getAddress(myPlacemark.geometry.getCoordinates());
                $('input[name=map]').val(vals.toString())
            });
            getAddress('33.356624', '65.797642')
        }

        const AddressFilter = (...res) => {

            ymaps.geocode(res.join(', '), {
                results: 1
            }).then(function(res) {
                // Selecting the first result of geocoding.
                var firstGeoObject = res.geoObjects.get(0),
                    // The coordinates of the geo object.
                    coords = firstGeoObject.geometry.getCoordinates(),
                    // The viewport of the geo object.
                    bounds = firstGeoObject.properties.get('boundedBy');
                $('input[name=map]').val(coords.toString())
                myMap.setBounds(bounds, {
                    // Checking the availability of tiles at the given zoom level.
                    checkZoomRange: true
                });
                if (myPlacemark) {
                    myPlacemark.geometry.setCoordinates(coords);
                    getAddress(coords)
                } else {
                    myPlacemark = createPlacemark(coords);
                    myMap.geoObjects.add(myPlacemark);
                    // Listening for the dragging end event on the placemark.
                    myPlacemark.events.add('dragend', function() {
                        getAddress(myPlacemark.geometry.getCoordinates());
                        $('input[name=map]').val(coords.toString())
                    });
                    getAddress(coords)
                }


            });
        }

        AddressFilter(vals)

        $('#country').on('change', function() {
            AddressFilter($(this).find(":selected").text())
        })
        $('#city').on('change', function() {
            AddressFilter($('#country').find(":selected").text(), $(this).find(":selected").text());
        });


        $('#street').on('keyup keypress', function() {

            AddressFilter($('#country').find(":selected").text(), $('#city').find(":selected").text(), $(this).val());
        });

        // // Listening for a click on the map
        myMap.events.add('click', function(e) {
            var coords = e.get('coords');
            $('input[name=map]').val(coords.toString())
            console.log($('input[name=map]').val())
            // Moving the placemark if it was already created
            // Moving the placemark if it was already created
            if (myPlacemark) {
                myPlacemark.geometry.setCoordinates(coords);
            }
            // Otherwise, creating it.
            else {
                myPlacemark = createPlacemark(coords);
                myMap.geoObjects.add(myPlacemark);
                // Listening for the dragging end event on the placemark.
                myPlacemark.events.add('dragend', function() {
                    getAddress(myPlacemark.geometry.getCoordinates());
                });
            }
            getAddress(coords);
        });

        // Creating a placemark
        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'searching...'
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: true
            });
        }

        // Determining the address by coordinates (reverse geocoding).
        function getAddress(coords) {
            myPlacemark.properties.set('iconCaption', 'searching...');
            ymaps.geocode(coords).then(function(res) {
                var firstGeoObject = res.geoObjects.get(0);

                myPlacemark.properties
                    .set({
                        // Forming a string with the object's data.
                        iconCaption: [
                            // The name of the municipality or the higher territorial-administrative formation.
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Getting the path to the toponym; if the method returns null, then requesting the name of the building.
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ].filter(Boolean).join(', '),
                        // Specifying a string with the address of the object as the balloon content.
                        balloonContent: firstGeoObject.getAddressLine()
                    });
            });
        }
    }
</script>
