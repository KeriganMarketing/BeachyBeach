<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package KMA_DEMO
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kmaidx' ); ?></a>

    <div id="top">
        <header id="masthead" class="site-header">
            <div class="container wide">
                <div class="row no-gutters justify-content-center">

                    <div class="col-9 col-md-3 col-lg-2">
                        <a href="/" class="navbar-brand"><img src="<?php echo get_template_directory_uri().'/img/beachy-beach-logo.png'; ?>" alt="Beachy Beach Real Estate" ></a>
                    </div>
                    <div class="col-3 hidden-md-up">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-header">
                            <span class="icon-box">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </span>
                        </button>
                    </div>
                    <div class="col-12 col-md-6 col-lg-7">
                        <div class="navbar-collapse navbar-toggleable-md justify-content-end" id="navbar-header">
                            <?php wp_nav_menu(
                                array(
                                    'theme_location'  => 'menu-1',
                                    'container_class' => 'navbar-static',
                                    'container_id'    => 'navbarNavDropdown',
                                    'menu_class'      => 'navbar-nav justify-content-end',
                                    'fallback_cb'     => '',
                                    'menu_id'         => 'menu-1',
                                    'walker'          => new WP_Bootstrap_Navwalker(),
                                )
                            ); ?>
                        </div>
                    </div>
                    <div id="beach-bucket" class="col-md-3 col-lg-2">
                        <div class="">
                            <div id="bucket-left" class="" >
                                <p class="saved-num">
                                    <span style="line-height:5px; font-size:5px;"><br></span>
                                    <img src="<?php echo get_template_directory_uri().'/img/beach-bucket.png'; ?>" alt="Save &amp; Compare Beach Properties"></p>
                            </div>
                            <div id="bucket-right" class="">
                                <p class="not-logged-in"><a class="login-link" href="/property-organizer-login/">Log In</a> to keep favorites in your Beachy Bucket</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>
    </div>
