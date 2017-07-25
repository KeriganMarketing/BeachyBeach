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
				<?php //get_template_part( 'template-parts/mls', 'searchbar' ); ?>
            </div>
        </div>
        <div class="row">
			<?php get_template_part( 'template-parts/mls', 'commerciallisting' ); ?>
        </div>
    </div>
</div>
<?php get_template_part( 'template-parts/mls', 'mortgage-calulator' ); ?>
<?php
wp_enqueue_script( 'search-ajax' );
get_footer();
