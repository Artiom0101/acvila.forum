function init() {
    // Geocoder pentru a obține coordonatele din adresă
    var geocoder = new google.maps.Geocoder();

    var mapOptions = {
        zoom: 14, // zoom mai mare, detaliat
        center: { lat: 47.0105, lng: 28.8638 }, // centru provizoriu - Chișinău
        scrollwheel: false,
        styles: [
            {
                "featureType": "administrative.country",
                "elementType": "geometry",
                "stylers": [
                    { "visibility": "simplified" },
                    { "hue": "#ff0000" }
                ]
            }
        ]
    };

    var mapElement = document.getElementById('map');
    var map = new google.maps.Map(mapElement, mapOptions);

    // Adresa pentru geocodare
    var address = "Republica Moldova, Stefan cel Mare 1";

    geocoder.geocode({ 'address': address }, function(results, status) {
        if (status === 'OK') {
            // Setăm centrul hărții pe locația găsită
            map.setCenter(results[0].geometry.location);

            // Plasăm markerul pe hartă
            new google.maps.Marker({
                map: map,
                position: results[0].geometry.location,
                icon: 'images/loc.png' // asigură-te că ai iconița la această cale
            });
        } else {
            alert('Geocodarea nu a reușit din cauza: ' + status);
        }
    });
}

// Asigură-te că încarci API-ul Google Maps cu callback la init
// Exemplu script din HTML:
<script src="https://maps.googleapis.com/maps/api/js?key=API_KEY&callback=init" async defer></script>
