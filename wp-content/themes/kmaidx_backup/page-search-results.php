<?php
/**
 * @package idx
 */

get_header(); ?>
<div class="container-fluid" >
	<div class="row">
		<div class="col">
		<?php get_template_part( 'template-parts/mls', 'searchbar' ); ?>
		</div>
	</div>
	<div class="row">
		<?php get_template_part( 'template-parts/mls', 'searchlisting' ); ?>
	</div>
</div>

<?php get_footer();
