<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package KMA_DEMO
 */

$mls = new MLS();

get_header(); ?>
    <div id="content">

        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'template-parts/content', 'page' );

	                $propTypeArray    = $mls->getDistinctColumn('property_type');
	                $classArray       = $mls->getDistinctColumn('class');

	                foreach($propTypeArray as $type){
		                //echo '<pre>',print_r($type),'</pre>';
	                }

	                foreach($classArray as $class){
		                //echo '<pre>',print_r($class),'</pre>';
	                }

	                $typeArray = array(
	                    'Single Family Home' => array('Detached Single Family'),
	                    'Condo / Townhome' => array('Condominium','Townhouse','Townhomes'),
	                    'Commercial' => array('Office','Retail','Industrial','Income Producing','Unimproved Commercial','Business Only','Auto Repair','Improved Commercial','Hotel/Motel'),
	                    'Lots / Land' => array('Vacant Land','Residential Lots','Land','Land/Acres','Lots/Land'),
	                    'Multi-Family Home' => array('Duplex Multi-Units','Triplex Multi-Units'),
	                    'Rental' => array('Apartment','House','Duplex','Triplex','Quadruplex','Apartments/Multi-family'),
	                    'Manufactured' => array('Mobile Home','Mobile/Manufactured'),
	                    'Farms / Agricultural' => array('Farm','Agricultural','Farm/Ranch','Farm/Timberland'),
	                    'Other' => array('Attached Single Unit','Attached Single Family','Dock/Wet Slip','Dry Storage','Mobile/Trailer Park','Mobile Home Park','Residential Income','Parking Space','RV/Mobile Park')
                    );

                    foreach($typeArray as $parent => $type){
	                    echo '<pre>',$parent.": ",print_r($type),'</pre>';
                    }

                    ?>

                    <div class="comments-section">
                        <div class="container">
                            <?php // If comments are open or we have at least one comment, load up the comment template.
                            if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif; ?>
                        </div>
                    </div>

                <?php endwhile; ?>

            </main><!-- #main -->
        </div><!-- #primary -->

    </div>
<?php get_footer();

