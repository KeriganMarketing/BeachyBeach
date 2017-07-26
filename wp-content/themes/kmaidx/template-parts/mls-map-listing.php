<?php

$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . '/wp-load.php';
include_once $path . '/wp-includes/wp-db.php';
include_once $path . '/wp-includes/pluggable.php';

//echo '<h1>'.$_GET['mlsnum'].'</h1>';

$mls = new MLS();
$result = $mls->quickListing($_GET['mlsnum']);

//echo '<pre>',print_r($result),'</pre>';

include( locate_template( 'template-parts/mls-search-listing.php' ) );