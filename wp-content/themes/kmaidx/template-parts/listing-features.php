<?php
/**
 * Created by PhpStorm.
 * User: Bryan
 * Date: 5/22/2017
 * Time: 2:08 PM
 */
$extfeatures = explode(',',$listingInfo->exterior);
$amenities = explode(',',$listingInfo->amenities);
$intfeatures = explode(',',$listingInfo->interior);
$appliances = explode(',',$listingInfo->appliances);
$energy = explode(',',$listingInfo->energy_features);
$construction = explode(',',$listingInfo->construction);
$utilities = explode(',',$listingInfo->utilities);
?>
<div class="row justify-content-center">
	<?php if(count($intfeatures) > 1){ ?>
        <div class="col-sm-4">
            <h3>Interior</h3>
            <ul>
				<?php foreach($intfeatures as $feat){ ?>
                    <li><?php echo $feat; ?></li>
				<?php } ?>
            </ul>
        </div>
	<?php } ?>
	<?php if(count($appliances) > 1){ ?>
        <div class="col-sm-4">
            <h3>Appliances</h3>
            <ul>
				<?php foreach($appliances as $feat){ ?>
                    <li><?php echo $feat; ?></li>
				<?php } ?>
            </ul>
        </div>
	<?php } ?>
    <?php if(count($extfeatures) > 1){ ?>
    <div class="col-sm-4">
        <h3>Exterior</h3>
        <ul>
            <?php foreach($extfeatures as $feat){ ?>
                <li><?php echo $feat; ?></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
    <?php if(count($amenities) > 1){ ?>
    <div class="col-sm-4">
        <h3>Amenities</h3>
        <ul>
            <?php foreach($amenities as $feat){ ?>
                <li><?php echo $feat; ?></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
    <?php if(count($energy) > 1){ ?>
    <div class="col-sm-4">
        <h3>Energy</h3>
        <ul>
            <?php foreach($energy as $feat){ ?>
                <li><?php echo $feat; ?></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
	<?php if(count($construction) > 1){ ?>
        <div class="col-sm-4">
            <h3>Construction</h3>
            <ul>
				<?php foreach($construction as $feat){ ?>
                    <li><?php echo $feat; ?></li>
				<?php } ?>
            </ul>
        </div>
	<?php } ?>
	<?php if(count($utilities) > 1){ ?>
        <div class="col-sm-4">
            <h3>Utilities</h3>
            <ul>
				<?php foreach($utilities as $feat){ ?>
                    <li><?php echo $feat; ?></li>
				<?php } ?>
            </ul>
        </div>
	<?php } ?>
</div>