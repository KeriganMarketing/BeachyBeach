<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package KMA_DEMO
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
        <div class="container wide">
		<?php the_title( '<h1 class="entry-title">', ($agent['aka'] != '' ? ' <span class="subhead small">A.K.A. '.$agent['aka'].'</span>' : '').'</h1>' ); ?>
        </div>
	</header><!-- .entry-header -->

	<div class="entry-content">
        <div class="container wide">
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <img class="card-img-top" src="<?php echo ($agent['thumbnail'] != '' ? $agent['thumbnail'] : get_template_directory_uri().'/img/beachybeach-placeholder.jpg' ); ?>" alt="<?php echo $agent['name']; ?>" style="width:500px;">
                    <div class="contact-info bio">
                        <h4><?php echo ($agent['title'] != '' ? $agent['title'] : 'Realtor' ); ?></h4>
                        <ul class="contact-info">
	                        <?php if($agentCellPhone != ''){?><li class="phone"><img src="<?php echo $mls->getSvg('phone'); ?>" alt="Call <?php echo $agent['name']; ?>" ><a href="tel:<?php echo $agentCellPhone; ?>" ><?php echo $agentCellPhone; ?></a> <span class="label">Cell</span></li><?php } ?>
	                        <?php if($agentOfficePhone != ''){?><li class="phone"><img src="<?php echo $mls->getSvg('phone'); ?>" alt="Call <?php echo $agent['name']; ?>" ><a href="tel:<?php echo $agentOfficePhone; ?>" ><?php echo $agentOfficePhone; ?></a> <span class="label">Office</span></li><?php } ?>
	                        <?php if($agentEmail != ''){?><li class="email"><img src="<?php echo $mls->getSvg('email'); ?>" alt="Email <?php echo $agent['name']; ?>" ><a href="mailto:<?php echo $agentEmail; ?>" ><?php echo $agentEmail; ?></a></li><?php } ?>
	                        <?php if($agentWebsite != ''){?><li class="web"><img src="<?php echo $mls->getSvg('url'); ?>" alt="View <?php echo $agent['name']; ?>'s Website" ><a target="_blank" href="<?php echo $agentWebsite; ?>" ><?php echo $agentWebsite; ?></a></li><?php } ?>
                            <?php foreach($agent['social'] as $social => $link){
                                echo ( $link != '' ? '<li class="phone"><img src="'.$mls->getSvg($social).'" alt="Follow '.$agent['name'].' on '.$social.'" ><a href="'.$link.'" target="_blank">'.$link.'</a></li>' : '');
                            } ?>
                        </ul>
                    </div>
                    <?php echo '<!--<pre>',print_r($agentMLSInfo),'</pre>-->'; ?>
                </div>
                <div class="col-sm-6 col-lg-8">
                    <div class="text-md-right">
                    <form class="form form-inline" action="/contact/" method="get" style="display:inline-block;" >
                        <input type="hidden" name="reason" value="Just reaching out" />
                        <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>" />
                        <input type="hidden" name="selected_agent" value="<?php echo $agent['name']; ?>" />
                        <button type="submit" class="btn btn-primary" >Contact Me</button>
                    </form>
                    <a href="#mylistings" class="btn btn-primary">See My Listings</a>
                    </div>
                    <hr>

                    <?php the_content(); ?>

                </div>
            </div>
            <div id="mylistings">
                <div class="row">
                    <div class="col">
                        <h2>My Listings</h2>
			            <?php get_template_part( 'template-parts/mls', 'sortbar' ); ?>
                    </div>
                </div>
                <div class="row">

                    <?php foreach ($agentListings as $result) { ?>
                        <div class="listing-tile agent col-sm-6 col-lg-3 text-center">
                            <?php include( locate_template( 'template-parts/mls-search-listing.php' ) ); ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
