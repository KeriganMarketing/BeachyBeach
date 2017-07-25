<?php
/**
 * KMA IDX functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package KMA_DEMO
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
if ( ! function_exists( 'kmaidx_setup' ) ) :

function kmaidx_setup() {

	add_action('init', 'startSession', 1);
	add_action('wp_logout', 'endSession');
	add_action('wp_login', 'endSession');

	ini_set('session.bug_compat_warn', 0);
	ini_set('session.bug_compat_42', 0);

	function startSession() {
		if(!session_id()) {
			session_start();
		}
	}

	function endSession() {
		session_destroy ();
	}

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on KMA IDX, use a find and replace
	 * to change 'kmaidx' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'kmaidx', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in these locations.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'kmaidx' ),
		'menu-2' => esc_html__( 'Footer', 'kmaidx' ),
		'menu-3' => esc_html__( 'Mobile', 'kmaidx' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

    //require('inc/vendor/autoload.php');
    require('inc/bootstrap-wp-navwalker.php');
    require('inc/cpt.php');
    require('inc/editor.php');
	require("helpers/MLS.php");
}
endif;
add_action( 'after_setup_theme', 'kmaidx_setup' );

function kmaidx_scripts() {

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js', false, false, true );

	//styles
	wp_register_style( 'fullcalendar-style', '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/fullcalendar.min.css', null,'0.0.1');
	wp_register_style( 'lightbox-styles', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/css/lightbox.min.css', false, '0.0.2' );
	wp_register_style( 'select2-styles', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css', false, '0.0.2' );

    //scripts
    wp_register_script( 'tether', 'https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js', array('jquery'), '0.0.1', true );
    wp_register_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js', array('jquery'), '0.0.1', true );
	wp_register_script( 'images-loaded', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.1/imagesloaded.min.js', array('jquery'), '0.0.1', true );
    wp_register_script( 'custom-scripts', get_template_directory_uri() . '/js/scripts.js', array(), '0.0.2', true );
	wp_register_script( 'lightbox', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/js/lightbox.min.js', array('jquery'), '0.0.1', true );
	wp_register_script( 'lazy-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.4/jquery.lazy.min.js', array('jquery'), '0.0.1', true );
	wp_register_script( 'select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery'), '0.0.1', true );

	//wp ajax scripts
	wp_register_script( "ajax-scripts", get_template_directory_uri() . '/js/ajax.js', array('jquery'), '0.0.2' , true );
	wp_localize_script( 'ajax-scripts', 'wpAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

	//enqeue
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'tether' );
	wp_enqueue_script( 'bootstrap-js' );
	wp_enqueue_script( 'custom-scripts' );
	wp_enqueue_script( 'lazy-js' );
	wp_enqueue_style( 'select2-styles' );
	wp_enqueue_script( 'select2-js' );
	wp_enqueue_script( 'ajax-scripts' );
}
add_action( 'wp_enqueue_scripts', 'kmaidx_scripts' );

function prefix_add_footer_styles() {
	wp_enqueue_style( 'kmaidx-footer-styles', get_template_directory_uri() . '/style.css', false, '0.0.2' );
};
add_action( 'get_footer', 'prefix_add_footer_styles' );

function disable_wp_stuff() {
	remove_action('wp_head', 'rsd_link'); // Removes the Really Simple Discovery link
	remove_action('wp_head', 'wlwmanifest_link'); // Removes the Windows Live Writer link
	remove_action('wp_head', 'wp_generator'); // Removes the WordPress version
	remove_action('wp_head', 'start_post_rel_link'); // Removes the random post link
	remove_action('wp_head', 'index_rel_link'); // Removes the index page link
	remove_action('wp_head', 'adjacent_posts_rel_link'); // Removes the next and previous post links
	remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link

	//all things emoji
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	// Remove oEmbed discovery links.
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
}
add_action( 'init', 'disable_wp_stuff' );

/*
* Pull in our favorite KMA add-ons.
* uncomment to enable. :)
*/

function loadModules (){

    //modules
    require('modules/leads/leads.php');
    require('modules/team/team.php');
    require('modules/testimonials/testimonials.php');
    require('modules/social/sociallinks.php');

    /*CUSTOM POST TYPES HERE*/
    $communities = new Custom_Post_Type(
        'Communities',
        array(
            'supports'			 => array( 'title', 'editor', 'thumbnail', 'revisions' ),
            'menu_icon'			 => 'dashicons-location',
            'has_archive' 		 => true,
            'menu_position'      => null,
            'public'             => true,
            'publicly_queryable' => true,
        )
    );

	$communities->add_meta_box(
        'Community Info',
        array(
            'Database Name' 			=> 'text'
        )
    );

}
add_action( 'after_setup_theme', 'loadModules' );


require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/customizer.php';

if ( ! function_exists( 'kmaidx_inline' ) ) :
	function kmaidx_inline() {
		?>
        <style type="text/css">
            <?php echo file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css' ) ?>
        </style>
        <style type="text/css">
            <?php echo file_get_contents(get_template_directory_uri() . '/modules/modulestyles.php?ver=0.0.1') ?>
        </style>
        <style type="text/css">
            <?php echo file_get_contents(get_template_directory_uri() . '/css/inline.css?ver=0.0.3' ) ?>
        </style>
		<?php
	}
endif;
add_action( 'wp_head', 'kmaidx_inline' );

add_action('wp_ajax_loadMlsIdx', 'loadMlsIdx');
add_action('wp_ajax_nopriv_loadMlsIdx', 'loadMlsIdx');
function loadMlsIdx() {

//	if(isset($_SESSION['smartselect'])){

//		$result = $_SESSION['smartselect'];

//	} else {

		$mls  = new MLS();

		$result['typeArray'] = array();
		foreach ( $mls->getDistinctColumn('class') as $type ) {
			$result['typeArray'][] = array(
				'id'        => $type->class,
				'text'      => $type->class,
				'class'     => 'option',
			);
		}

		$result['areaArray'] = array();
		$result['areaArray'][0] = array(
			'text'          => 'AREAS',
			'children'      => array()
		);
		foreach ( $mls->getDistinctColumn('area') as $value ) {
			$result['areaArray'][0]['children'][] = array(
				'id'        => $value->area,
				'text'      => $value->area,
				'class'     => 'option',
			);
		}
		foreach ( $mls->getDistinctColumn('sub_area') as $value ) {
			$result['areaArray'][0]['children'][] = array(
				'id'        => $value->sub_area,
				'text'      => $value->sub_area,
				'class'     => 'option',
			);
		}

		$result['areaArray'][1] = array(
			'text'          => 'CITIES',
			'children'      => array()
		);
		foreach ( $mls->getDistinctColumn('city') as $value ) {
			$result['areaArray'][1]['children'][] = array(
				'id'        => $value->city,
				'text'      => $value->city,
				'class'     => 'option',
			);
		}

		$result['areaArray'][2] = array(
			'text'          => 'SUBDIVISIONS',
			'children'      => array()
		);
		foreach ( $mls->getDistinctColumn('subdivision') as $value ) {
			$result['areaArray'][2]['children'][] = array(
				'id'        => $value->subdivision,
				'text'      => $value->subdivision,
				'class'     => 'option',
			);
		}

		$result['areaArray'][3] = array(
			'text'          => 'Zip Code',
			'children'      => array()
		);
		foreach ( $mls->getDistinctColumn('zip') as $value ) {
			$result['areaArray'][3]['children'][] = array(
				'id'        => $value->zip,
				'text'      => $value->zip,
				'class'     => 'option',
			);
		}

		$_SESSION['smartselect']        = json_encode( $result );
		$result                         = json_encode( $result );

//	}

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		echo $result;
	}

	wp_die();

}