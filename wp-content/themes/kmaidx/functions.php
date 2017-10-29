<?php
/**
 * KMA IDX functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package KMA_DEMO
 */

use Includes\Modules\MLS\Offices;
use Includes\Modules\Agents\Agents;
use Includes\Modules\Helpers\CleanWP;
use Includes\Modules\Layouts\Layouts;
use Includes\Modules\Members\Members;
use Includes\Modules\MLS\Communities;
use Includes\Modules\Leads\AdminLeads;
use Includes\Modules\MLS\BeachyBucket;
use Includes\Modules\Leads\RequestInfo;
use Includes\Modules\Leads\HomeValuation;
use Includes\Modules\Social\SocialSettingsPage;

require('vendor/autoload.php');

new CleanWP();

$members = new Members();

$socialLinks = new SocialSettingsPage();
if (is_admin()) {
    $socialLinks->createPage();
}

$layouts = new Layouts();
$layouts->createPostType();
$layouts->createDefaultFormats();

$agents = new Agents();
$agents->createPostType();

$leads = new RequestInfo;
$leads->setupAdmin();

$leads = new HomeValuation;
$leads->setupAdmin();

$offices = new Offices();
$offices->createPostType();

$communities = new Communities();
$communities->createPostType();

function getSvg($file = '')
{
    $activeTemplateDir     = get_template_directory_uri() . '/inc/modules/MLS/assets/';
    $templateFileRequested = $file . '.svg';

    return $activeTemplateDir . $templateFileRequested;
}

if ( ! function_exists('kmaidx_setup')) :

    function kmaidx_setup()
    {

        add_action('init', 'startSession', 1);
        add_action('wp_logout', 'endSession');
        add_action('wp_login', 'endSession');

        ini_set('session.bug_compat_warn', 0);
        ini_set('session.bug_compat_42', 0);

        function startSession()
        {
            if ( ! session_id()) {
                session_start();
            }
        }

        function endSession()
        {
            session_destroy();
        }

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on KMA IDX, use a find and replace
         * to change 'kmaidx' to the name of your theme in all the template files.
         */
        load_theme_textdomain('kmaidx', wp_normalize_path(get_template_directory() . '/languages'));

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in these locations.
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'kmaidx'),
            'menu-2' => esc_html__('Footer', 'kmaidx'),
            'menu-3' => esc_html__('Mobile', 'kmaidx'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        require wp_normalize_path(get_template_directory() . '/inc/bootstrap-wp-navwalker.php');
        //require wp_normalize_path(get_template_directory() . '/inc/cpt.php');
        //require wp_normalize_path(get_template_directory() . '/inc/editor.php');
        //require wp_normalize_path(get_template_directory() . '/helpers/MLS.php');
        //require wp_normalize_path(get_template_directory() . '/helpers/Listing.php');
        //require wp_normalize_path(get_template_directory() . '/helpers/BeachyBucket.php');
        //require wp_normalize_path(get_template_directory() . '/helpers/Offices.php');
        //require wp_normalize_path(get_template_directory() . '/helpers/Communities.php');
    }
endif;
add_action('after_setup_theme', 'kmaidx_setup');

function kmaidx_scripts()
{

    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js', false, false,
        true);

    //styles
    wp_register_style('fullcalendar-style', '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/fullcalendar.min.css',
        null);
    wp_register_style('lightbox-styles', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/css/lightbox.min.css',
        false);
    wp_register_style('select2-styles', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css',
        false);

    //scripts
    wp_register_script('tether', 'https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js',
        array('jquery'), null, true);
    wp_register_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js',
        array('jquery'), null, true);
    wp_register_script('images-loaded',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.1/imagesloaded.min.js', array('jquery'), null,
        true);
    wp_register_script('custom-scripts', get_template_directory_uri() . '/js/scripts.js', array(), null, true);
    wp_register_script('lightbox', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/js/lightbox.min.js',
        array('jquery'), null, true);
    wp_register_script('lazy-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.4/jquery.lazy.min.js',
        array('jquery'), null, true);
    wp_register_script('select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
        array('jquery'), null, true);
    wp_register_script('jquery-ui-slider', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'), null,
        true);
    //wp_register_script('chart-js', get_template_directory_uri() . '/js/chartjs/Chart.js', array('jquery'), null, true);
    wp_register_script('chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js',
        array('jquery'), null, true);
    wp_register_script('mortgage-calc', get_template_directory_uri() . '/js/mortgagecalc.js', array('jquery'), null,
        true);
    wp_register_script('listing-js', get_template_directory_uri() . '/js/listing.js', array('jquery'), null, true);
    wp_register_script('team-js', get_template_directory_uri() . '/js/team.js', array('jquery'), null, true);

    //wp ajax scripts
    wp_register_script('communities-ajax', get_template_directory_uri() . '/js/communities.ajax.js', array('jquery'),
        null, true);
    wp_localize_script('communities-ajax', 'wpAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
    wp_register_script('search-ajax', get_template_directory_uri() . '/js/search.ajax.js', array('jquery'), null, true);
    wp_localize_script('search-ajax', 'wpAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
    wp_register_script('office-ajax', get_template_directory_uri() . '/js/office.ajax.js', array('jquery'), null, true);
    wp_localize_script('office-ajax', 'wpAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

    //enqeue
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('tether');
    wp_enqueue_script('bootstrap-js');
    wp_enqueue_script('custom-scripts');
    wp_enqueue_script('lazy-js');
    wp_enqueue_style('select2-styles');
    wp_enqueue_script('select2-js');

}

add_action('wp_enqueue_scripts', 'kmaidx_scripts');

function prefix_add_footer_styles()
{
    wp_enqueue_style('kmaidx-footer-styles', get_template_directory_uri() . '/style.css');
}

;
add_action('get_footer', 'prefix_add_footer_styles');

function disable_wp_stuff()
{

    remove_action('wp_head', 'rsd_link'); // Removes the Really Simple Discovery link
    remove_action('wp_head', 'wlwmanifest_link'); // Removes the Windows Live Writer link
    remove_action('wp_head', 'wp_generator'); // Removes the WordPress version
    remove_action('wp_head', 'start_post_rel_link'); // Removes the random post link
    remove_action('wp_head', 'index_rel_link'); // Removes the index page link
    remove_action('wp_head', 'adjacent_posts_rel_link'); // Removes the next and previous post links
    remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link

    //all things emoji
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');

    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
}

add_action('init', 'disable_wp_stuff');

/*
* Pull in our favorite KMA add-ons.
*/
function loadModules()
{

    //modules
    //require('modules/leads/leads.php');
    //require('modules/team/team.php');
    //require('modules/testimonials/testimonials.php');
    //require('modules/social/sociallinks.php');
    //require('modules/leads/AdminLeads.php');

    if (is_admin()) {
        $beachyBuckets = new AdminLeads();
        $beachyBuckets->createNavLabel();
        $beachyBuckets->addUserRole('Author', [
            'edit_agent'              => true,
            'publish_agents'          => true,
            'delete_published_agents' => false,
            'edit_agents'             => true,
            'delete_agents'           => false,
            'edit_others_agents'      => false,
            'delete_others_posts'     => false,
        ]);
        $beachyBuckets->addUserRole('Administrator', [
            'read_agents'             => true,
            'edit_agent'              => true,
            'edit_agents'             => true,
            'edit_others_agents'      => true,
            'delete_agents'           => true,
            'publish_agents'          => true,
            'read_offices'            => true,
            'edit_offices'            => true,
            'edit_office'             => true,
            'edit_others_offices'     => true,
            'delete_offices'          => true,
            'publish_offices'         => true,
            'read_communities'        => true,
            'edit_communities'        => true,
            'edit_communitiess'       => true,
            'edit_others_communities' => true,
            'delete_communities'      => true,
            'publish_communities'     => true,
            'read_leads'              => true,
            'edit_leads'              => true,
            'edit_lead'               => true,
            'edit_others_leads'       => true,
            'delete_leads'            => true,
            'publish_leads'           => true,
        ]);
    }

}

add_action('after_setup_theme', 'loadModules');

require wp_normalize_path(get_template_directory() . '/inc/template-tags.php');
require wp_normalize_path(get_template_directory() . '/inc/extras.php');
require wp_normalize_path(get_template_directory() . '/inc/customizer.php');

if ( ! function_exists('kmaidx_inline')) :
    function kmaidx_inline()
    {
        ?>
        <style type="text/css">
            <?php echo file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css' ) ?>
        </style>
        <style type="text/css">
            <?php echo file_get_contents(wp_normalize_path(get_template_directory() . '/modules/modulestyles.php' )) ?>
        </style>
        <style type="text/css">
            <?php echo file_get_contents(wp_normalize_path(get_template_directory() . '/css/jquery-ui.min.css' )) ?>
        </style>
        <style type="text/css">
            <?php echo file_get_contents(wp_normalize_path(get_template_directory() . '/css/inline.css' )) ?>
        </style>
        <style type="text/css">
            <?php echo file_get_contents(wp_normalize_path(get_template_directory() . '/css/ie.css' )) ?>
        </style>
        <?php
    }
endif;
add_action('wp_head', 'kmaidx_inline');

function in_array_r($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (is_array($item)) {
            foreach ($item as $arr) {
                if (is_array($arr)) {
                    if (in_array($needle, $arr, $strict)) {
                        return true;
                    }
                } else {
                    if ($strict ? $arr === $needle : $arr == $needle) {
                        return true;
                    }
                }
            }
        } else {
            if ($strict ? $item === $needle : $item == $needle) {
                return true;
            }
        }

    }

    return false;
}

add_action('wp_ajax_loadCommMapPins', 'loadCommMapPins');
add_action('wp_ajax_nopriv_loadCommMapPins', 'loadCommMapPins');
function loadCommMapPins()
{

    if (isset($_SESSION['communitymap'])) {

        $result = $_SESSION['communitymap'];

    } else {

        $communities   = new Communities();
        $communitylist = $communities->getCommunities();

        foreach ($communitylist as $community) {

            if ($community['latitude'] == '' || $community['longitude'] == '') {

            } else {
                $return[] = array(
                    'name' => $community['title'],
                    'lat'  => $community['latitude'],
                    'lng'  => $community['longitude'],
                    'type' => 'neighborhood', //name of pin (_-pin.png)
                    'link' => get_post_permalink($community['id'])
                );
            }

        }

        $offices      = new Offices();
        $locationlist = $offices->getAllOffices();

        foreach ($locationlist as $location) {
            $return[] = $location;
        }

        $return[] = array(
            'name' => 'Laguna Beach',
            'lat'  => '30.2387797',
            'lng'  => '-85.9252252',
            'type' => 'beach' //name of pin (_-pin.png)30.2119524,-85.8720894
        );

        $return[] = array(
            'name' => 'Edgewater Beach',
            'lat'  => '30.2119524',
            'lng'  => '-85.8720894',
            'type' => 'beach' //name of pin (_-pin.png)
        );

        $return[] = array(
            'name' => 'Grand Lagoon',
            'lat'  => '30.1713572',
            'lng'  => '-85.8000543',
            'type' => 'beach' //name of pin (_-pin.png)
        );

        $return[] = array(
            'name' => 'Thomas Drive',
            'lat'  => '30.1520455',
            'lng'  => '-85.769862',
            'type' => 'beach' //name of pin (_-pin.png)
        );

        $return[] = array(
            'name' => 'West Panama City Beach',
            'lat'  => '30.2584549',
            'lng'  => '-85.9703253',
            'type' => 'beach' //name of pin (_-pin.png)
        );

        $return[] = array(
            'name' => 'Seacrest',
            'lat'  => '30.2895669',
            'lng'  => '-86.0503214',
            'type' => 'beach' //name of pin (_-pin.png)
        );

        $return[] = array(
            'name' => 'Beaches Near Seagrove',
            'lat'  => '30.3098054',
            'lng'  => '-86.1085854',
            'type' => 'beach' //name of pin (_-pin.png)
        );

        $return[] = array(
            'name' => 'Blue Mountain Beaches',
            'lat'  => '30.3375421',
            'lng'  => '-86.2007431',
            'type' => 'beach' //name of pin (_-pin.png)
        );

        $return[] = array(
            'name' => 'Beaches Near Draper Lake',
            'lat'  => '30.3421559',
            'lng'  => '-86.2178834',
            'type' => 'beach' //name of pin (_-pin.png)
        );

        $_SESSION['communitymap'] = json_encode($return);
        $result                   = json_encode($return);

    }

    if ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo $result;
    }

    wp_die();
}

add_action('wp_ajax_loadOfficePins', 'loadOfficePins');
add_action('wp_ajax_nopriv_loadOfficePins', 'loadOfficePins');
function loadOfficePins()
{

    if (isset($_SESSION['officemap'])) {

        $result = $_SESSION['officemap'];

    } else {

        $return = array();

        $offices      = new Offices();
        $locationlist = $offices->getAllOffices();

        foreach ($locationlist as $location) {
            $return[] = $location;
        }

        $_SESSION['officemap'] = json_encode($return);
        $result                = json_encode($return);
    }

    if ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo $result;
    }

    wp_die();
}

include(wp_normalize_path(get_template_directory() . '/inc/members.php'));

add_filter('get_the_archive_title', function ($title) {

    if (is_category()) {

        $title = single_cat_title('Beachy Blog ', false);

    } elseif (is_tag()) {

        $title = single_tag_title('Beachy Tag: ', false);

    } elseif (is_author()) {

        $title = '<span class="vcard">' . get_the_author() . '</span>';

    }

    return $title;

});


add_filter('wpseo_title', 'listing_page_titles', 100);
function listing_page_titles($metaTitle)
{
    global $post;
    $newTitle = $metaTitle;
    if ($post->post_name == 'listing') {
        global $metaTitle;
        if (isset($metaTitle)) {
            $newTitle = $metaTitle;
        }
    } elseif ($post->post_type == 'agent') {
        global $metaTitle;
        if (isset($metaTitle)) {
            $newTitle = $metaTitle;
        }
    }

    return $newTitle;
}

add_filter('wpseo_metadesc', 'listing_page_description', 100, 1);
function listing_page_description($metaDescription)
{
    global $post;
    $newDescription = $metaDescription;
    if ($post->post_name == 'listing') {
        global $metaDescription;
        if (isset($metaDescription)) {
            $newDescription = $metaDescription;
        }
    } elseif ($post->post_type == 'agent') {
        global $metaDescription;
        if (isset($metaDescription)) {
            $newDescription = $metaDescription;
        }
    }

    return $newDescription;
}

add_filter('wpseo_opengraph_image', 'listing_og_image', 100, 1);
function listing_og_image($ogPhoto)
{
    global $post;
    $newImage = $ogPhoto;
    if ($post->post_name == 'listing') {
        global $ogPhoto;
        if (isset($ogPhoto)) {
            $newImage = $ogPhoto;
        }
    } elseif ($post->post_type == 'agent') {
        global $ogPhoto;
        if (isset($ogPhoto)) {
            $newImage = $ogPhoto;
        }
    }

    return $newImage;
}

add_filter('wpseo_canonical', 'listing_og_url', 100, 1);
add_filter('wpseo_opengraph_url', 'listing_og_url', 100, 1);
function listing_og_url($ogUrl)
{
    global $post;
    $newUrl = $ogUrl;
    if ($post->post_name == 'listing') {
        global $ogUrl;
        if (isset($ogUrl)) {
            $newUrl = $ogUrl;
        }
    } elseif ($post->post_type == 'agent') {
        global $ogUrl;
        if (isset($ogUrl)) {
            $newUrl = $ogUrl;
        }
    }

    return $newUrl;
}
