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

use Includes\Modules\MLS\BeachyBucket;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php
wp_head();
$current_user = wp_get_current_user();
$bb = new BeachyBucket();
?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kmaidx' ); ?></a>

    <div id="top">
        <header id="masthead" class="site-header">
            <div class="container wide nopad">
                <div class="row no-gutters justify-content-center">
                    <div id="beach-bucket" class="col-md-4 col-lg-3 col-xl-2">
                        <div class="">
                            <div id="bucket-left" class="" >
                                <p class="saved-num">
                                    <?php echo (is_user_logged_in() ? $bb->getNumberOfBucketItems($current_user->ID) : '0'); ?>
                                </p>
	                            <?php echo (is_user_logged_in() ? '<a href="/beachy-bucket/">' : ''); ?>
                                <img src="<?php echo get_template_directory_uri().'/img/beach-bucket.png'; ?>" alt="Save &amp; Compare Beach Properties">
	                            <?php echo (is_user_logged_in() ? '</a>' : ''); ?>
                            </div>
                            <div id="bucket-right" >
                                <?php if(is_user_logged_in()){ ?>
                                    <p class="logged-in"><a href="/beachy-bucket/"><span class="user-name" ><?php echo ( $current_user->user_firstname != '' ? $current_user->user_firstname : $current_user->user_login ); ?>'s</span>Beachy Bucket</a></p><p class="logout-link"><a class="logout-link" href="<?php echo wp_logout_url('/'); ?>">logout</a> </p>
                                <?php }else{ ?>
                                    <p class="not-logged-in"><a class="login-link" href="/user-login/">Log In</a> to keep favorites in your Beachy Bucket</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2 col-lg-2 text-center text-md-left mb-sm-2">
                        <a href="/" class="navbar-brand"><img src="<?php echo get_template_directory_uri().'/img/beachy-beach-logo.png'; ?>" alt="Beachy Beach Real Estate" ></a>
                    </div>
                    <div class="col-sm-4 col-md-5 text-center hidden-lg-up my-auto">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                            <span class="btn-text" >MENU</span>
                            <span class="icon-box">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </span>
                        </button>
                    </div>
                    <div class="col-12 col-md-6 col-lg-7 hidden-md-down text-center my-auto mx-auto">
                        <div class="navbar-collapse navbar-toggleable-sm" id="navbar-header">
                            <?php wp_nav_menu(
                                array(
                                    'theme_location'  => 'menu-1',
                                    'container_class' => 'navbar-static',
                                    'container_id'    => 'navbarNavDropdown',
                                    'menu_class'      => 'navbar-nav justify-content-center',
                                    'fallback_cb'     => '',
                                    'menu_id'         => 'menu-1',
                                    'walker'          => new WP_Bootstrap_Navwalker(),
                                )
                            ); ?>
                        </div>
                    </div>


                </div>
            </div>
            <div class="clearfix"></div>
        </header>

    </div>
    <div class="hidden-lg-up">
        <div class="navbar-collapse navbar-toggleable-lg text-center" id="navbar-mobile">
            <?php wp_nav_menu(
                array(
                    'theme_location'  => 'menu-3',
                    'container_class' => 'navbar-static',
                    'container_id'    => 'navbarNavDropdown',
                    'menu_class'      => 'navbar-nav justify-content-end',
                    'fallback_cb'     => '',
                    'menu_id'         => 'menu-3',
                    'walker'          => new WP_Bootstrap_Navwalker(),
                )
            ); ?>
        </div>
    </div>
