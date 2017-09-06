<?php
/**
 * Created by PhpStorm.
 * User: Bryan
 * Date: 5/19/2017
 * Time: 10:23 AM
 */

foreach($team as $agent){

	$agentEmail    = '';
	$agentPhone    = '';
	$agentWebsite  = '';

    if( $agent['name'] != '' ) {
        $mlsAgent = new MLS();
        $agentMLSInfo = $mlsAgent->getAgentByName($agent['name']);
    }
	$agentEmail    = ($agentMLSInfo != false ? $agentMLSInfo->email : '');
	if($agent['email'] != '' ){ $agentEmail = $agent['email']; }

	$agentPhone    = ($agentMLSInfo != false ? $agentMLSInfo->cell_phone : '');
	if($agentPhone == ''){ $agentPhone = ($agentMLSInfo != false ? $agentMLSInfo->office_phone : $agentPhone); }
	if($agent['phone'] != '' ){ $agentPhone = $agent['phone']; }

	$agentWebsite  = ($agentMLSInfo != false ? $agentMLSInfo->url : '');
	if($agent['website'] != '' ){ $agentWebsite = $agent['website']; }

    //echo '<pre>',print_r($agent),'</pre>';

    $agentCategories = '';
	$is30a = false;
    foreach($agent['categories'] as $category){
        if($category['category-slug'] == '30a-office' || $category['category-slug'] == 'seacrest-office' || $category['category-slug'] == 'destin-office'){
            $is30a = true;
        }
        $agentCategories .= ' '.$category['category-slug'].'-filter';
    }


    $company = ( $is30a ? 'Beachy Beach 30a Real Estate' : 'Beachy Beach Real Estate' );

    if($agent['name'] == 'Karen Smith'){
	    $company = 'Beachy Beach Real Estate <br> Beachy Beach 30a Real Estate';
    }

    ?>
    <div class="agent-card col-sm-6 col-lg-4 col-xl-3<?php echo $agentCategories; ?> all-filter" >
        <div class="card" >
            <div class="card-image">
                <img class="card-img-top" src="<?php echo ($agent['thumbnail'] != '' ? $agent['thumbnail'] : get_template_directory_uri().'/img/beachybeach-placeholder.jpg' ); ?>" alt="<?php echo $agent['name']; ?>" style="width:500px;">
            </div>
            <div class="card-block">
                <h4 class="card-title"><?php echo $agent['name']; ?></h4>
                <h5 class="card-subtitle"><?php echo ($agent['title'] != '' ? $agent['title'] : 'Realtor' ); ?></h5>
                <h5 class="card-subtitle company"><?php echo $company; ?></h5>
                <ul class="contact-info">
	                <?php if($agentEmail != ''){?><li class="email"><img src="<?php echo $mlsAgent->getSvg('email'); ?>" alt="Email <?php echo $agent['name']; ?>" ><a href="mailto:<?php echo $agentEmail; ?>" ><?php echo $agentEmail; ?></a></li><?php }else{ ?><li class="blank"></li><?php } ?>
                    <?php if($agentPhone != ''){?><li class="phone"><img src="<?php echo $mlsAgent->getSvg('phone'); ?>" alt="Call <?php echo $agent['name']; ?>" ><a href="tel:<?php echo $agentPhone; ?>" ><?php echo $agentPhone; ?></a></li><?php }else{ ?><li class="blank"></li><?php } ?>
                </ul>
                <form class="form form-inline" action="/contact/" method="get" style="display:inline-block;" >
                    <input type="hidden" name="reason" value="Just reaching out" />
                    <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>" />
                    <input type="hidden" name="selected_agent" value="<?php echo $agent['name']; ?>" />
                    <button type="submit" class="btn btn-primary" >Contact Me</button>
                </form>
                <a href="<?php echo $agent['link']; ?>" class="btn btn-primary">view profile</a>
            </div>
        </div>
    </div>
<?php } ?>