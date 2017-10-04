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

global $paged;
global $wpdb;

$paged = (get_query_var('paged')) ? abs((int)get_query_var('paged')) : 1;
$mls   = new MLS();

if (isset($_GET['q'])) {
    $query = $mls->buildQuery($_GET);
} else {
    $query = $mls->buildQuery(array());
}
$sortBy          = isset($_GET['sortBy']) ? ' ORDER BY ' . $_GET['sortBy'] : ' ORDER BY date_modified';
$orderBy         = isset($_GET['orderBy']) ? ' ' . $_GET['orderBy'] : ' DESC';
$total_query     = $mls->getTotalQuery($query);
$total           = $wpdb->get_var($total_query);
$listingsPerPage = 36;
$pagenumber      = $mls->determinePagination();
$offset          = $mls->determineOffset($pagenumber, $listingsPerPage);
$finalQuery      = $query . $sortBy . $orderBy . " LIMIT " . $offset . ", " . $listingsPerPage;
$results         = $wpdb->get_results($finalQuery);

get_header(); ?>
<div id="content">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" >

            <?php while ( have_posts() ) : the_post();

                get_template_part( 'template-parts/content', 'page' );

            endwhile; ?>

        </main><!-- #main -->
    </div><!-- #primary -->
    <div class="container wide" >
        <div class="row">
            <div class="col">
				<?php get_template_part( 'template-parts/mls', 'searchbar' ); ?>
            </div>
        </div>
        <div class="row">

            <?php foreach ($results as $result) { ?>
            <div class="listing-tile property-search col-sm-6 col-lg-3 text-center">
                <?php include( locate_template( 'template-parts/mls-search-listing.php' ) ); ?>
            </div>
            <?php } ?>

        </div>
        <nav aria-label="Search results navigation" class="text-center mx-auto">
            <ul class="pagination">
                <?php
                echo paginate_links(array(
                    'base'      => add_query_arg('pg', '%#%'),
                    'format'    => 'li',
                    'prev_text' => __('&laquo;'),
                    'next_text' => __('&raquo;'),
                    'total'     => ceil($total / $listingsPerPage),
                    'current'   => $pagenumber,
                ));
                ?>
            </ul>
        </nav>
        <p class="footnote disclaimer" style="font-size: .9em; text-align: center; color: #aaa;">Real estate property information provided by Bay County Association of REALTORS® and Emerald Coast Association of REALTORS®. IDX information is provided exclusively for consumers personal, non-commercial use, and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. This data is deemed reliable but is not guaranteed accurate by the MLS.</p>

    </div>
</div>
<?php get_template_part( 'template-parts/mls', 'mortgage-calulator' ); ?>
<?php
wp_enqueue_script( 'search-ajax' );
wp_enqueue_script( 'chart-js' );
wp_enqueue_script( 'mortgage-calc' );
get_footer();
