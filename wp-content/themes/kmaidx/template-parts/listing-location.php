<?php
/**
 * Created by PhpStorm.
 * User: Bryan
 * Date: 5/22/2017
 * Time: 2:08 PM
 */
?>
<div class="col mb-2" >
    <div class="card" style="border-bottom:1px solid #ddd;">
	<table class="table table-striped listing-data mb-0">
		<tbody>
		<?php if( isset($listingInfo->lot_description) ){ ?>
            <tr><td class="title">Area</td><td class="data">$<?php echo $listingInfo->lot_description; ?></td></tr>
		<?php } ?>
		<?php if( isset($listingInfo->waterfront) && $listingInfo->waterfront != null){ ?>
        <tr><td class="title">Waterfront</td><td class="data"><?php echo $listingInfo->waterfront; ?></td></tr>
		<?php }else{ echo '<tr><td class="title">Waterfront</td><td class="data">No</td></tr>'; } ?>
		<?php if( isset($listingInfo->waterview_description) && $listingInfo->waterview_description != null ){ ?>
        <tr><td class="title">Waterfront</td><td class="data"><?php echo $listingInfo->waterview_description; ?></td></tr>
		<?php } ?>
		<?php if( isset($listingInfo->elementary_school) ){ ?>
            <tr><td class="title">Elementary School</td><td class="data"><?php echo $listingInfo->elementary_school; ?></td></tr>
		<?php } ?>
		<?php if( isset($listingInfo->middle_school) ){ ?>
            <tr><td class="title">Middle School</td><td class="data"><?php echo $listingInfo->middle_school; ?></td></tr>
		<?php } ?>
		<?php if( isset($listingInfo->high_school) ){ ?>
            <tr><td class="title">High School</td><td class="data"><?php echo $listingInfo->high_school; ?></td></tr>
		<?php } ?>
		<?php if( isset($listingInfo->county) ){ ?>
		<tr><td class="title">County</td><td class="data"><?php echo $listingInfo->county; ?></td></tr>
		<?php } ?>
		<?php if( isset($listingInfo->zip) ){ ?>
		<tr><td class="title">Zip Code</td><td class="data"><?php echo $listingInfo->zip; ?></td></tr>
		<?php } ?>
		<?php if( isset($listingInfo->sub_area) ){ ?>
		<tr><td class="title">Sub-area</td><td class="data"><?php echo $listingInfo->sub_area; ?></td></tr>
		<?php } ?>
		<?php if( isset($listingInfo->subdivision) ){ ?>
		<tr><td class="title">Subdivision</td><td class="data"><?php echo $listingInfo->subdivision; ?></td></tr>
		<?php } ?>
		</tbody>
	</table>
</div>
</div>
<div class="col-md-7">
	<script type="text/javascript">

        var map,
            marker,
            mapElement,
            status = '<?php echo($listingInfo->status != '' ? strtolower($listingInfo->status) : ''); ?>',
            type = '<?php echo($listingInfo->property_type != '' ? $listingInfo->property_type : ''); ?>',
            pin;

            console.log(type);
            console.log(status);

        //init map using script include callback
        function initMap() {

            var myLatLng = {lat: <?php echo $listingInfo->latitude; ?>, lng: <?php echo $listingInfo->longitude; ?> };
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
                                "visibility": "off"
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
                        "featureType": "road.arterial",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#fbfbfb"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "geometry.stroke",
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
            mapElement = document.getElementById('listing-map');

            // Create the Google Map using our element and options defined above
            map = new google.maps.Map(mapElement, mapOptions);
            bounds = new google.maps.LatLngBounds();

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

            marker = new google.maps.Marker({
                title: '<?php echo $listingInfo->mls_account; ?>',
                position: myLatLng,
                map: map,
                icon: pin
            });

        }

	</script>
	<div id="listing-map" style="height: 100%; min-height:200px; height: 350px;"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRXeRhZCIYcKhtc-rfHCejAJsEW9rYtt4&callback=initMap" async defer></script>
</div>
