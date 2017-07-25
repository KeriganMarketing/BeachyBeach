<?php
/**
 * Created by PhpStorm.
 * User: Bryan
 * Date: 5/23/2017
 * Time: 2:44 PM
 */
$wpTeam = new mlsTeam();
//$agent = $mls->getAgentByMLSId($listingInfo->listing_member_shortid);
$wpAgent = $wpTeam->getSingleAgent($agent->full_name);

$agentEmail    = '';
$agentPhone    = '';
$agentWebsite  = '';

$agentEmail    = (isset($agent->email) ? $agent->email : '');
if($wpAgent['email'] != '' ){ $agentEmail = $wpAgent['email']; }

$agentPhone    = (isset($agent->cell_phone) ? $agent->cell_phone : '');
if($agentPhone == ''){ $agentPhone = (isset($agent->office_phone) ? $agent->office_phone : $agentPhone); }
if($wpAgent['phone'] != '' ){ $agentPhone = $wpAgent['phone']; }

//echo '<pre>',print_r($agent),'</pre>';
?>
<div class="card" >
  <img class="card-img-top" src="<?php echo ($wpAgent['thumbnail'] != '' ? $wpAgent['thumbnail'] : get_template_directory_uri().'/img/beachybeach-placeholder.jpg' ); ?>" alt="<?php echo $wpAgent['name']; ?>">
  <div class="card-block">
    <h4 class="card-title"><?php echo $agent->full_name; ?></h4>
      <ul class="contact-info">
		  <?php if($agentEmail != ''){?><li class="email"><img src="<?php echo $mls->getSvg('email'); ?>" alt="Email <?php echo $wpAgent['name']; ?>" ><a href="mailto:<?php echo $agentEmail; ?>" ><?php echo $agentEmail; ?></a></li><?php }else{ ?><li class="blank"></li><?php } ?>
		  <?php if($agentPhone != ''){?><li class="phone"><img src="<?php echo $mls->getSvg('phone'); ?>" alt="Call <?php echo $wpAgent['name']; ?>" ><a href="tel:<?php echo $agentPhone; ?>" ><?php echo $agentPhone; ?></a></li><?php }else{ ?><li class="blank"></li><?php } ?>
      </ul>
    <a href="<?php echo $wpAgent['link']; ?>" class="btn btn-primary">view profile</a>
  </div>
</div>