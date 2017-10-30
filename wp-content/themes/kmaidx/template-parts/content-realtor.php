<?php

use Includes\Modules\Social\SocialSettingsPage;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
        <div class="container wide">
		<?php the_title( '<h1 class="entry-title">', ($agentData['aka'] != '' ? ' <span class="subhead small">A.K.A. '.$agentData['aka'].'</span>' : '').'</h1>' ); ?>
        </div>
	</header><!-- .entry-header -->

	<div class="entry-content">
        <div class="container wide">
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <img class="img-fluid" src="<?php echo ($agentData['thumbnail'] != '' ? $agentData['thumbnail'] : get_template_directory_uri().'/img/beachybeach-placeholder.jpg' ); ?>" alt="<?php echo $agentData['name']; ?>" style="width:500px;">
                    <div class="contact-info bio">
                        <h4><?php echo ($agentData['title'] != '' ? $agentData['title'] : 'Realtor' ); ?></h4>
                        <ul class="contact-info">
                            <?php if($agentData['cell_phone'] != ''){?><li class="phone"><img src="<?php echo getSvg('phone'); ?>" alt="Call <?php echo $agentData['name'];?>" > <a href="tel:<?php echo $agentData['cell_phone']; ?>" ><?php echo $agentData['cell_phone']; ?></a> <span class="label">Cell</span></li><?php } ?>
                            <?php if($agentData['office_phone'] != ''){?><li class="phone"><img src="<?php echo getSvg('phone'); ?>" alt="Call <?php echo $agentData['name'];?>" > <a href="tel:<?php echo $agentData['office_phone']; ?>" ><?php echo $agentData['office_phone']; ?></a> <span class="label">Office</span></li><?php } ?>
                            <?php if($agentData['email_address'] != ''){?><li class="email"><img src="<?php echo getSvg('email'); ?>" alt="Email <?php echo $agentData['name'];?>" > <a href="mailto:<?php echo $agentData['email_address']; ?>" ><?php echo $agentData['email_address']; ?></a></li><?php } ?>
                            <?php if($agentData['website'] != ''){?><li class="web"><img src="<?php echo getSvg('url'); ?>" alt="Visit <?php echo $agentData['name'];?>'s website" > <a target="_blank" href="<?php echo $agentData['website']; ?>" ><?php echo str_replace('http://','',$agentData['website']); ?></a></li><?php } ?>
                        </ul>
                        <div class="social agent">
                            <?php
                            $socialLinks = new SocialSettingsPage();
                            $socialIcons = $socialLinks->getSocialLinks('svg', 'circle', $agentData['social']);
                            if (is_array($socialIcons)) {
                                foreach ($socialIcons as $socialId => $socialLink) {
                                    echo '<a class="' . $socialId . '" href="' . $socialLink[0] . '" target="_blank" >' . $socialLink[1] . '</a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-8">
                    <div class="text-md-right">
                    <form class="form form-inline" action="/contact/" method="get" style="display:inline-block;" >
                        <input type="hidden" name="reason" value="Just reaching out" />
                        <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>" />
                        <input type="hidden" name="selected_agent" value="<?php echo $agentData['name']; ?>" />
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

                    <?php foreach ($agentData['listings'] as $result) { ?>
                        <div class="listing-tile agent col-sm-6 col-lg-3 text-center">
                            <?php include( locate_template( 'template-parts/mls-search-listing.php' ) ); ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <p class="footnote disclaimer" style="font-size: .9em; text-align: center; color: #aaa;">Real estate property information provided by Bay County Association of REALTORS® and Emerald Coast Association of REALTORS®. IDX information is provided exclusively for consumers personal, non-commercial use, and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. This data is deemed reliable but is not guaranteed accurate by the MLS.</p>

        </div>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
