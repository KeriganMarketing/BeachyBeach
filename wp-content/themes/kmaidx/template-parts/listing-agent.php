<?php
use Includes\Modules\Agents\Agents;

$wpTeam = new Agents();
//$agent = $mls->getAgentByMLSId($listingInfo->listing_member_shortid);
$wpAgent = $wpTeam->assembleAgentData($agent->full_name);

?>
<div class="card">
    <img class="card-img-top" src="<?php echo $agentData['thumbnail']; ?>" alt="<?php echo $agentData['name']; ?>">
    <div class="card-block">
        <h4 class="card-title"><?php echo $agent->full_name; ?></h4>
        <ul class="contact-info">
            <?php if ($agentData['email_address'] != '') { ?>
                <li class="email"><i class="fa fa-envelope" aria-hidden="true"></i> <a
                        href="mailto:<?php echo $agentData['email_address']; ?>"><?php echo $agentData['email_address']; ?></a>
                </li><?php } ?>
            <?php if ($agentData['cell_phone'] != '') { ?>
                <li class="phone"><i class="fa fa-phone" aria-hidden="true"></i> <a
                        href="tel:<?php echo $agentData['cell_phone']; ?>"><?php echo $agentData['cell_phone']; ?></a>
                </li><?php } ?>
        </ul>
        <a href="<?php echo $wpAgent['link']; ?>" class="btn btn-primary">view profile</a>
    </div>
</div>