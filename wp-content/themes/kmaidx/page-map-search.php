<?php
/**
 * @package idx
 */

global $wpdb;

$mls   = new MLS();

if (isset($_GET['q'])) {
	$query = $mls->mapQuery($_GET);
} else {
	$query = $mls->mapQuery(array());
}

$results         = $wpdb->get_results($query);

get_header(); ?>
<div id="content">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" >

			<?php while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile;

			//echo '<pre>',print_r($results),'</div>';

			?>

        </main><!-- #main -->
    </div><!-- #primary -->

    <div class="container wide" >
        <div class="row">
            <div class="col">
				<?php get_template_part( 'template-parts/mls', 'searchbar' ); ?>
            </div>
        </div>
        <script type="text/javascript">

            var map,
                bounds,
                mapElement,
                markers = [],
                markerClusterer,
                styles = [[{
                    url: '<?php echo get_template_directory_uri() ?>/img/m1.png',
                    height: 50,
                    width: 50,
                    anchor: [0, 0],
                    textColor: '#333333',
                    textSize: 12
                }, {
                    url: '<?php echo get_template_directory_uri() ?>/img/m2.png',
                    height: 60,
                    width: 60,
                    anchor: [0, 0],
                    textColor: '#333333',
                    textSize: 12
                }, {
                    url: '<?php echo get_template_directory_uri() ?>/img/m3.png',
                    width: 70,
                    height: 70,
                    anchor: [0, 0],
                    textColor: '#333333',
                    textSize: 13
                }, {
                    url: '<?php echo get_template_directory_uri() ?>/img/m4.png',
                    width: 80,
                    height: 80,
                    anchor: [0, 0],
                    textColor: '#333333',
                    textSize: 13
                }, {
                    url: '<?php echo get_template_directory_uri() ?>/img/m5.png',
                    width: 90,
                    height: 90,
                    anchor: [0, 0],
                    textColor: '#333333',
                    textSize: 14
                }]];

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

                markers.push(marker);

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
        <div id="map-search"></div>
        <p class="footnote disclaimer" style="font-size: .9em; text-align: center; color: #aaa;">Real estate property information provided by Bay County Association of REALTORS® and Emerald Coast Association of REALTORS®. IDX information is provided exclusively for consumers personal, non-commercial use, and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. This data is deemed reliable but is not guaranteed accurate by the MLS.</p>

    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?v=3&amp;key=AIzaSyCRXeRhZCIYcKhtc-rfHCejAJsEW9rYtt4&callback=initMap" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-marker-clusterer/1.0.0/markerclusterer.js" ></script>
<script>
    markerClusterer = new MarkerClusterer(map, markers, {
        maxZoom: 14,
        gridSize: 60,
        styles: styles[0]
    });
</script>
<?php get_template_part( 'template-parts/mls', 'mortgage-calulator' ); ?>
<?php
wp_enqueue_script( 'search-ajax' );
wp_enqueue_script( 'chart-js' );
wp_enqueue_script( 'mortgage-calc' );
get_footer();
?>

