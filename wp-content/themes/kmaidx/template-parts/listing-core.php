<div class="row">
    <div class="col-md-6 flex-order-md-second">
        <div id="req-info-btn" class="text-center text-md-right">
            <form class="form form-inline" action="/contact/" method="get" style="display:inline-block;" >
                <input type="hidden" name="reason" value="Property inquiry" />
                <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>" />
                <input type="hidden" name="mls_number" value="<?php echo $listingInfo->mls_account; ?>" />
                <input type="hidden" name="selected_agent" value="<?php echo ($isOurs ? $agentData['full_name'] : ''); ?>" />
                <button type="submit" class="btn btn-primary mb-2" >Request Info</button>
            </form>
			<?php if(is_user_logged_in()){?>
                <form class="form form-inline" method="post" style="display:inline-block;" >
                    <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>" />
                    <input type="hidden" name="mls_account" value="<?php echo $listingInfo->mls_account; ?>" />
                    <button type="submit" class="btn btn-primary mb-2" ><img src="<?php echo getSvg( 'star' ); ?>" alt="save to favorites" style="width: 16px; vertical-align: sub; margin: 0 3px 0 0;"> <?php echo $buttonText; ?></button>
                </form>
			<?php } ?>
            <button type="button" class="btn btn-primary hidden-md-up mb-2" data-toggle="modal" data-target="#lightbox" >View more photos</button>
        </div>
    </div>
    <div class="col-md-6 flex-order-md-first text-center text-md-left">
        <h1 class="listing-page-location mt-2 mt-md-0"><?php echo $listingInfo->street_number.' '.$listingInfo->street_name; ?></h1>
		<h2 class="listing-page-area"><?php echo $listingInfo->city; ?>, FL</h2>
		<h3 class="listing-page-price">$<?php echo number_format($listingInfo->price); ?></h3>
	</div>
</div>
<div class="listing-details">
	<p><?php echo $listingInfo->description; ?></p>
</div>