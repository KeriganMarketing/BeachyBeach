<?php
/**
 * Created by PhpStorm.
 * User: Bryan
 * Date: 6/7/2017
 * Time: 7:37 PM
 */
?>
<script type="text/javascript">
    var map,
        bounds,
        mapElement;

    //init map using script include callback
    function initMap() {

        var myLatLng = {lat: 30.250795, lng: -85.940390 };
        // Basic options for a simple Google Map
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 11,
            // The latitude and longitude to center the map (always required)
            center: myLatLng,
            disableDefaultUI: true,
            // This is where you would paste any style found on Snazzy Maps.
            styles: [
                {
                    "featureType": "all",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "off"
                        },
                        {
                            "color": "#efebe2"
                        }
                    ]
                },
                {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#efebe2"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#efebe2"
                        }
                    ]
                },
                {
                    "featureType": "poi.attraction",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#efebe2"
                        }
                    ]
                },
                {
                    "featureType": "poi.business",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#efebe2"
                        }
                    ]
                },
                {
                    "featureType": "poi.government",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#dfdcd5"
                        }
                    ]
                },
                {
                    "featureType": "poi.medical",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#dfdcd5"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#bad294"
                        }
                    ]
                },
                {
                    "featureType": "poi.place_of_worship",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#efebe2"
                        }
                    ]
                },
                {
                    "featureType": "poi.school",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#efebe2"
                        }
                    ]
                },
                {
                    "featureType": "poi.sports_complex",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#efebe2"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#dedede"
                        }
                    ]
                },
                {
                    "featureType": "road.highway.controlled_access",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#a5d7e0"
                        }
                    ]
                }
            ]
        };

        // Get the HTML DOM element that will contain your map
        // We are using a div with id="map" seen below in the <body>
        mapElement = document.getElementById('map-search');

        // Create the Google Map using our element and options defined above
        map = new google.maps.Map(mapElement, mapOptions);
        bounds = new google.maps.LatLngBounds();

		<?php
		foreach ($results as $result) {
		$latBounds = ($result->latitude > 29 && $result->latitude < 32 ? TRUE : FALSE );
		$lngBounds = ($result->longitude > -90 && $result->longitude < -83 ? TRUE : FALSE );
		if($latBounds && $lngBounds){ ?>
        addMarker('<?php echo $result->latitude; ?>','<?php echo $result->longitude; ?>','<?php echo $result->property_type; ?>','<?php echo $result->mls_account; ?>','<?php echo strtolower($result->status); ?>');
		<?php } } ?>

    }

    function loadDoc(request,mlsnum) {
        var mls = mlsnum,
            requestedDoc = request,
            xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById(placement).innerHTML = this.responseText;
                console.log(this.responseText);
                var response = this.responseText;
                return response;
            }
        };
        xhttp.open("GET", requestedDoc+'?mlsnum='+mls, true);
        xhttp.send();
    }

    //add the pins
    function addMarker(lat,lng,type,mlsnum,status) {
        var pinLocation = new google.maps.LatLng(parseFloat(lat),parseFloat(lng)),
            contentString = '',
            mls = mlsnum,
            pin;

        switch(type) {
            case 'G':
            case 'A':
                pin = '<?php echo get_template_directory_uri() ?>/img/residential-'+status+'-pin.png';
                break;
            case 'E':
            case 'J':
            case 'F':
                pin = '<?php echo get_template_directory_uri() ?>/img/commercial-'+status+'-pin.png';
                break;
            case 'C':
                pin = '<?php echo get_template_directory_uri() ?>/img/land-'+status+'-pin.png';
                break;
            default:
                pin = 'http://mt.googleapis.com/vt/icon/name=icons/spotlight/spotlight-poi.png&scale=1';
        }

        var infowindow = new google.maps.InfoWindow({
            maxWidth: 300,
            padding: 0,
            borderRadius: 0,
            arrowSize: 10,
            borderWidth: 0,
            hideCloseButton: true,
            backgroundClassName: 'transparent',
            content: contentString
        });

        var marker = new google.maps.Marker({
            position: pinLocation,
            map: map,
            icon: pin
        });
	    
        marker.addListener('click', function(){
            var requestedDoc = '/wp-content/themes/kmaidx/template-parts/mls-map-listing.php',
                xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //document.getElementById(placement).innerHTML = this.responseText;

                    var response = this.responseText.replace(/(\r\n|\n|\r)/gm,"");

                    infowindow.close(); // Close previously opened infowindow
                    infowindow.setContent('<div class="listing-tile map-search">' + response + '</div>');
                    infowindow.open(map, marker);
                    //console.log(response);
                }
            };
            xhttp.open("GET", requestedDoc+'?mlsnum='+mls, true);
            xhttp.send();



        });

        bounds.extend(pinLocation);
        map.fitBounds(bounds);

    }

</script>
<div id="map-search" class="mini"></div>
<script src="https://maps.googleapis.com/maps/api/js?v=3&amp;key=AIzaSyCRXeRhZCIYcKhtc-rfHCejAJsEW9rYtt4&callback=initMap" ></script>
