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

use Includes\Modules\MLS\FullListing;
use Includes\Modules\MLS\BeachyBucket;

if (isset($_GET['mls'])) {
    $mlsNumber   = $_GET['mls'];
    $fullListing = new FullListing($mlsNumber);
    $listingInfo = $fullListing->create();

    if($listingInfo) {

        $buttonText = $fullListing->isInBucket(get_current_user_id(),
            $listingInfo->mls_account) ? 'REMOVE FROM BUCKET' : 'SAVE TO BUCKET';
        if (isset($_POST['user_id']) && isset($_POST['mls_account'])) {
            $bb = new BeachyBucket();
            $bb->handleFavorite($_POST['user_id'], $_POST['mls_account']);
        }

        $isOurs = $fullListing->isOurs($listingInfo);

        $title = $listingInfo->street_number . ' ' . $listingInfo->street_name;
        if ($listingInfo->unit_number != '') {
            $title = $title . ' ' . $listingInfo->unit_number;
        }

        $metaTitle       = $title . ' | $' . number_format($listingInfo->price) . ' | ' . get_bloginfo('name');
        $metaDescription = $listingInfo->description;
        $ogPhoto         = ($listingInfo->preferred_image != '' ? $listingInfo->preferred_image : get_template_directory_uri() . '/img/beachybeach-placeholder.jpg');
        $ogUrl           = get_the_permalink() . '?mls=' . $listingInfo->mls_account;

    }

}

get_header(); ?>
    <div id="content">
        <article id="post-<?php echo $listingInfo->mls_account; ?>" class="listing">
            <header class="entry-header">
                <div class="container wide">
                    <?php if($listingInfo) { ?>
                    <h1 class="entry-title"><?php echo $title; ?> <span class="subhead small">MLS# <?php echo $listingInfo->mls_account; ?></span></h1>
                    <?php } else{ ?><h1>404</h1><?php } ?>
                </div>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <div class="container wide">
                    <?php if($listingInfo) { ?>
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
                    <p class="footnote disclaimer" style="font-size: .9em; text-align: center; color: #aaa;">Real estate property information provided by Bay County Association of REALTORS® and Emerald Coast Association of REALTORS®. IDX information is provided exclusively for consumers personal, non-commercial use, and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. This data is deemed reliable but is not guaranteed accurate by the MLS.</p>
                    <?php }else{ ?>
                        <p class="center">The requested listing is no longer available.</p>
                    <?php } ?>
                </div>
            </div>
        </article>
    </div>
<?php
wp_enqueue_script('listing-js');
get_footer();
