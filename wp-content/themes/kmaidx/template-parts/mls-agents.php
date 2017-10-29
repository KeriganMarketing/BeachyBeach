<?php

foreach($team as $agent){

    $agentData = $wpTeam->assembleAgentData( $agent['mls_name'] );
    $agentCategories = '';
	$is30a = false;
    foreach($agentData['categories'] as $category){
        if($category['category-slug'] == '30a-office' || $category['category-slug'] == 'seacrest-office' || $category['category-slug'] == 'destin-office'){
            $is30a = true;
        }
        $agentCategories .= ' '.$category['category-slug'].'-filter';
    }


    $company = ( $is30a ? 'Beachy Beach 30a Real Estate' : 'Beachy Beach Real Estate' );

    if($agentData['name'] == 'Karen Smith'){
	    $company = 'Beachy Beach Real Estate <br> Beachy Beach 30a Real Estate';
    }

    ?>
    <div class="agent-card col-sm-6 col-lg-4 col-xl-3<?php echo $agentCategories; ?> all-filter" >
        <div class="card" >
            <div class="card-image">
                <img class="card-img-top" src="<?php echo $agentData['thumbnail']; ?>" alt="<?php echo $agentData['name']; ?>" >
            </div>
            <div class="card-block">
                <h4 class="card-title"><?php echo $agentData['name']; ?></h4>
                <h5 class="card-subtitle"><?php echo ($agentData['title'] != '' ? $agentData['title'] : 'Realtor' ); ?></h5>
                <h5 class="card-subtitle company"><?php echo $company; ?></h5>
                <ul class="contact-info">
                    <?php if($agentData['email_address'] != ''){?><li class="email"><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:<?php echo $agentData['email_address']; ?>" ><?php echo $agentData['email_address']; ?></a></li><?php } ?>
                    <?php if($agentData['cell_phone'] != ''){?><li class="phone"><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:<?php echo $agentData['cell_phone']; ?>" ><?php echo $agentData['cell_phone']; ?></a></li><?php } ?>
                </ul>
                <form class="form form-inline" action="/contact/" method="get" style="display:inline-block;" >
                    <input type="hidden" name="reason" value="Just reaching out" />
                    <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>" />
                    <input type="hidden" name="selected_agent" value="<?php echo $agentData['name']; ?>" />
                    <button type="submit" class="btn btn-primary" >Contact Me</button>
                </form>
                <a href="<?php echo $agentData['link']; ?>" class="btn btn-primary">view profile</a>
            </div>
        </div>
    </div>
<?php } ?>