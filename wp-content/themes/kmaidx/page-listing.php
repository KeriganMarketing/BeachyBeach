<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package KMA_DEMO
 */

$mls = new MLS();
$bb  = new BeachyBucket();

if (isset($_POST['user_id']) && isset($_POST['mls_account'])) {
    $bb->handleFavorite($_POST['user_id'], $_POST['mls_account']);
}

$listing     = new Listing($_GET['mls']); //this will be a $_GET variable
$listingInfo = $listing->getInfo();
$user_id     = get_current_user_id();
$buttonText  = $listing->isInBucket($user_id, $listingInfo->mls_account) ? 'REMOVE FROM BUCKET' : 'SAVE TO BUCKET';
$title       = $listingInfo->street_number . ' ' . $listingInfo->street_name;
$isOurs      = $listing->isOurs($listingInfo);
if($isOurs) {
	$agent = $mls->getAgentByMLSId( $listingInfo->listing_member_shortid );
}
if ($listingInfo->unit_number != '') {
    $title = $title . ' ' . $listingInfo->unit_number;
}

add_filter('wp_title', 'filter_listing_title', 100);
function filter_listing_title($title) {
	$title = $title . '|' . get_bloginfo();
	return $title;
}

get_header(); ?>
    <div id="content">
        <article id="post-<?php echo $listingInfo->mls_account; ?>" class="listing">
            <header class="entry-header">
                <div class="container wide">
                    <h1 class="entry-title"><?php echo $title; ?> <span class="subhead small">MLS# <?php echo $listingInfo->mls_account; ?></span></h1>
                </div>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <div class="container wide">
                    <div class="row">
                        <div class="col-lg-5 listing-left">
                            <div class="listing-slider">
                                <?php include(locate_template('template-parts/listing-photos.php')); ?>
                            </div>
                        </div>
                        <div class="col-lg-7 listing-right">
                            <div class="listing-core">
                                <?php include(locate_template('template-parts/listing-core.php')); ?>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <?php if (in_array($listingInfo->property_type, array('G', 'A'), FALSE)) { ?>
                                        <div class="listing-residential">
                                            <?php include(locate_template('template-parts/listing-residential.php')); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (in_array($listingInfo->property_type, array('C'), FALSE)) { ?>
                                        <div class="listing-land">
                                            <?php include(locate_template('template-parts/listing-land.php')); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (in_array($listingInfo->property_type, array('E','J','F'), FALSE)) { ?>
                                        <div class="listing-commercial">
                                            <?php include(locate_template('template-parts/listing-commercial.php')); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if ($isOurs) { ?>
                                    <div class="col-md-5">
                                        <div class="listing-agent-box">
                                            <?php include(locate_template('template-parts/listing-agent.php')); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <hr>
                            <?php include(locate_template('template-parts/listing-features.php')); ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row location-info">

                        <?php include(locate_template('template-parts/listing-location.php')); ?>

                    </div>
                </div>
            </div>
        </article>
    </div>
<?php
wp_enqueue_script('listing-js');
get_footer();
