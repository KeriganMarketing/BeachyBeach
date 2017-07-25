<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package KMA_DEMO
 */

global $paged;
global $wpdb;

$paged  = (get_query_var('paged')) ? abs((int)get_query_var('paged')) : 1;
$mls    = new MLS();

$query = $mls->buildQuery(array(
	'city' => array( get_post_meta( $post->ID, 'community_info_database_name', true ) )
));

$sortBy          = isset($_GET['sortBy']) ? ' ORDER BY ' . $_GET['sortBy'] : '';
$orderBy         = isset($_GET['orderBy']) ? ' ' . $_GET['orderBy'] : '';
$total_query     = $mls->getTotalQuery($query);
$total           = $wpdb->get_var($total_query);
$listingsPerPage = 36;
$page            = $mls->determinePagination();
$offset          = $mls->determineOffset($page, $listingsPerPage);
$finalQuery      = $query . $sortBy . $orderBy . " LIMIT " . $offset . ", " . $listingsPerPage;
$results         = $wpdb->get_results($finalQuery);

get_header(); ?>
<div id="content">

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'template-parts/content', 'page' ); ?>

        <?php endwhile; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

    <div class="container wide" >
        <div class="row">
            <div class="col">
			    <?php if(count($results)> 0) {
				    include( locate_template( 'template-parts/mls-mini-map.php' ) );
			    } ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
				<?php if(count($results)> 0) {
					include( locate_template( 'template-parts/mls-sortbar.php' ) );
				} ?>
            </div>
        </div>
        <div class="row">
			<?php
                if(count($results)> 0) {
                    foreach ( $results as $result ) { ?>
                        <div class="listing-tile community col-sm-6 col-lg-3 text-center">
                            <?php include( locate_template( 'template-parts/mls-search-listing.php' ) ); ?>
                        </div>
                    <?php }
                }else{
                    echo '<div class="col" ><p class="text-center">There are currently no properties available for this community.</p></div>';
                }
			?>
        </div>
        <nav aria-label="Search results navigation" class="text-center mx-auto">
            <ul class="pagination">
				<?php
				echo paginate_links(array(
					'base'      => add_query_arg('pg', '%#%'),
					'format'    => '',
					'prev_text' => __('&laquo;'),
					'next_text' => __('&raquo;'),
					'total'     => ceil($total / $listingsPerPage),
					'current'   => $page,
				));
				?>
            </ul>
        </nav>
    </div>

</div>
<?php get_footer();
