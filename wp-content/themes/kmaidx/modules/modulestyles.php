<?php
header("Content-type: text/css");

if (file_exists('social/social.css')){
	echo file_get_contents('social/social.css');
}
//if (file_exists('team/team.css')){
//	echo file_get_contents('team/team.css');
//}
//if (file_exists('weather/css/weather.css')){
//	echo file_get_contents('weather/css/weather.css');
//	echo file_get_contents('weather/css/weather-icons.css');
//	echo file_get_contents('weather/css/weather-icons-wind.css');
//}
//if (file_exists('services/services.css')){
//	echo file_get_contents('services/services.css');
//}
//if (file_exists('testimonials/testimonials.css')){
//	echo file_get_contents('testimonials/testimonials.css');
//}
//if (file_exists('photogallery/photogallery.css')){
//	echo file_get_contents('photogallery/photogallery.css');
//}
//if (file_exists('events/events.css')){
//	echo file_get_contents('events/events.css');
//}
if (file_exists('slider/slider.css')){
	echo file_get_contents('slider/slider.css');
}
if (file_exists('idx/idx.css')){
	echo file_get_contents('idx/idx.css');
}
if (file_exists('../css/typography.css')){
	echo file_get_contents('../css/typography.css');
}

