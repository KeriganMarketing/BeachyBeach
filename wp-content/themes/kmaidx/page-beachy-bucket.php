<?php
use Includes\Modules\MLS\BeachyBucket;
use Includes\Modules\MLS\FullListing;

get_header();
global $paged;
global $wpdb;

$paged   = (get_query_var('paged')) ? abs((int)get_query_var('paged')) : 1;
$bb      = new BeachyBucket();
$user_id = (isset($_GET['users_bucket']) ? $_GET['users_bucket'] : get_current_user_id());

$mlsNumbers = $bb->listingsSavedByUser($user_id);
?>

    <div id="content">


    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php while (have_posts()) : the_post();

                get_template_part('template-parts/content', 'page');

            endwhile; ?>
            <div class="container wide">
                <div class="account-actions text-right">
                    <a class="btn btn-sm btn-primary mr-1" href="/beachy-bucket/edit-account/">Edit my account information</a>
                    <a class="btn btn-sm btn-primary" href="/beachy-bucket/change-password/">Change my password</a>
                </div>
                <hr>
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

    <div class="container wide">

        <div class="row justify-content-center">
            <?php foreach ($mlsNumbers as $result) {
                $fullListing = new FullListing($result);
                $result      = $fullListing->create();
                ?>
                <div class="listing-tile property-search col-sm-6 col-lg-3 text-center">
		            <?php include( locate_template( 'template-parts/mls-search-listing.php' ) ); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php get_footer();
