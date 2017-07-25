<?php

$mlsLead = new kmaLeads();
$ADMIN_EMAIL = 'bryan@kerigan.com';
$DOMAIN_NAME = 'beachybeach.com';

//CURRENT USER INFO
$currentUser = get_user_meta( get_current_user_id() );
$currentUserInfo = get_userdata( get_current_user_id() );

//FOR AGENT DROPDOWN
$agents = new mlsTeam();
$agentArray = $agents->getAgentNames();
$agentOptions = '<option value="First Available">First Available</option>';

//DEFAULT FORM VARS
$yourname               = (isset($_GET['your_name']) ? $_GET['your_name'] : '');
$youremail              = (isset($_GET['your_email']) ? $_GET['your_email'] : '');
$phone                  = (isset($_GET['phone']) ? $_GET['phone'] : '');
$reason                 = (isset($_GET['reason']) ? $_GET['reason'] : '');
$mlsnumber              = (isset($_GET['mls_number']) ? $_GET['mls_number'] : '');
$emailformattedbadly    = FALSE;
$passCheck              = FALSE;
$message                = '';

$selectedAgent = (isset($currentUser['selected_agent'][0]) ? $currentUser['selected_agent'][0] : null); //get agent from user data.
$selectedAgent = (isset($_GET['selected_agent']) ? $_GET['selected_agent'] : $selectedAgent ); //IF GET, then override.

//SELECT OPTIONS
foreach($agentArray as $agent){
	$agentOptions .= '<option value="'.$agent.'" '.(strtolower(str_replace(' ','-',$selectedAgent)) == $agent ? 'selected' : '').' >'.$agent.'</option>';
}

$reasonArray = array(
    'reachingout'   => 'Just reaching out',
    'selling'       => 'Thinking about selling',
    'inquiry'       => 'Property inquiry'
);

$reasonOptions = '';

foreach($reasonArray as $reasonValue => $reasonText){
	$reasonOptions .= '<option value="'.$reasonText.'" '.($reason == $reasonText ? 'selected' : '').' >'.$reasonText.'</option>';
}

$formID                 = (isset($_POST['formID']) ? $_POST['formID'] : '');
$securityFlag           = (isset($_POST['secu']) ? $_POST['secu'] : '');
$formSubmitted          = ($formID == 'requestinfo' && $securityFlag == '' ? TRUE : FALSE);

if( $formSubmitted ){ //FORM WAS SUBMITTED

    //OVERRIDE DEFAULTS IF FORM POSTED
	$yourname           = (isset($_POST['your_name']) ? $_POST['your_name'] : $yourname);
	$youremail          = (isset($_POST['your_email']) ? $_POST['your_email'] : $youremail);
	$phone              = (isset($_POST['phone']) ? $_POST['phone'] : $phone);
	$selectedAgent      = (isset($_POST['selected_agent']) ? $_POST['selected_agent'] : $selectedAgent );
	$reason             = (isset($_POST['reason']) ? $_POST['reason'] : $reason);
	$mlsnumber          = (isset($_POST['mls_number']) ? $_POST['mls_number'] : $mlsnumber);
	$message            = (isset($_POST['additional_info']) ? $_POST['additional_info'] : $message);


	//BEGIN CHECKS
	$passCheck = TRUE;
	$adderror = '';

	if($youremail == ''){
		$passCheck = FALSE;
		$adderror .= '<li>Email address is required.</li>';
	}elseif(!filter_var($youremail, FILTER_VALIDATE_EMAIL) && !preg_match('/@.+\./', $youremail)) {
		$passCheck = FALSE;
		$emailformattedbadly = TRUE;
		$adderror .= '<li>Email is formatted incorrectly.</li>';
	}
	if($yourname == ''){
		$passCheck = FALSE;
		$adderror .= '<li>Name is required.</li>';
	}

	//TODO: Override "To" for agent routing...

	//BEGIN EMAIL
	$sendadmin = array(
		'to'		=> $ADMIN_EMAIL,
		'from'		=> get_bloginfo().' <noreply@'.$DOMAIN_NAME.'>',
		'subject'	=> 'Property info request from website',
		'bcc'		=> 'support@kerigan.com',
		'replyto'   => $youremail
	);

	$sendreceipt = array(
		'to'		=> $youremail,
		'from'		=> get_bloginfo().' <noreply@'.$DOMAIN_NAME.'>',
		'subject'	=> 'Your property info request',
		'bcc'		=> 'support@kerigan.com'
	);

	$emailvars = array(
		'Name'              => $yourname,
		'Email Address'     => $youremail,
		'Phone Number'      => $phone,
		'Additional Info'   => htmlentities(stripslashes($message)),
	);

	if($reason!=''){        $postvars['Reason for Reaching Out'] = $reason; }
	if($mlsnumber!=''){     $postvars['MLS#'] = $mlsnumber; }
	if($selectedAgent!=''){ $postvars['Selected Agent'] = $selectedAgent; }

	$successmessage     = '<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span><span class="sr-only">Success:</span> <strong>Your request has been received. Our staff will review your submission and get back with you soon.</strong>';
	$errormessage       = '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span> Errors were found. Please correct the indicated fields below.';

	$fontstyle          = 'font-family: sans-serif;';
	$headlinestyle      = 'style="font-size:20px; '.$fontstyle.' color:#42BC7B;"';
	$copystyle          = 'style="font-size:16px; '.$fontstyle.' color:#333;"';
	$labelstyle         = 'style="padding:4px 8px; background:#F7F6F3; border:1px solid #FFFFFF; font-weight:bold; '.$fontstyle.' font-size:14px; color:#4D4B47; width:150px;"';
	$datastyle          = 'style="padding:4px 8px; background:#F7F6F3; border:1px solid #FFFFFF; '.$fontstyle.' font-size:14px;"';

	$headline           = '<h2 '.$headlinestyle.'>Info Request</h2>';
	$receiptheadline    = '<h2 '.$headlinestyle.'>Your contact request</h2>';
	$adminintrocopy     = '<p '.$copystyle.'>You have received a lead from the website. Details are below:</p>';
	$receiptintrocopy   = '<p '.$copystyle.'>Your message has been received and we will get back with you as soon as we can. What you submitted is below:</p>';
	$dateofemail        = '<p '.$copystyle.'>Date Submitted: '.date('M j, Y').' @ '.date('g:i a').'</p>';

	$submittedData = '<table cellpadding="0" cellspacing="0" border="0" style="width:100%" ><tbody>';
	foreach($emailvars as $key => $var ){
		if(!is_array($var)){
			$submittedData .= '<tr><td '.$labelstyle.' >'.$key.'</td><td '.$datastyle.'>'.$var.'</td></tr>';
		}else{
			$submittedData .= '<tr><td '.$labelstyle.' >'.$key.'</td><td '.$datastyle.'>';
			foreach($var as $k => $v){
				$submittedData .= '<span style="display:block;width:100%;">'.$v.'</span><br>';
			}
			$submittedData .= '</ul></td></tr>';
		}
	}
	$submittedData .= '</tbody></table>';

	$adminContent = $adminintrocopy.$submittedData.$dateofemail;
	$receiptContent = $receiptintrocopy.$submittedData.$dateofemail;

	$emaildata = array(
		'headline'	=> $headline,
		'introcopy'	=> $adminContent,
	);
	$receiptdata = array(
		'headline'	=> $receiptheadline,
		'introcopy'	=> $receiptContent,
	);


	if($passCheck){

		echo '<div class="alert alert-success" role="alert">'.$successmessage.'</div>';
		//TODO: Check if Spam

        $isSpam = FALSE;

		if( $isSpam ){


		}else {

			$mlsLead->sendEmail( $sendadmin, $emaildata );
			$mlsLead->sendEmail( $sendreceipt, $receiptdata );

		}

    }else{ //ERRORS
        echo '<div class="alert alert-danger" role="alert">'.$errormessage;
        if($adderror != '') { echo '<ul>'.$adderror.'</ul>'; }
        echo '</div>';

		foreach($agentArray as $agent){
			$agentOptions .= '<option value="'.$agent.'" '.(strtolower(str_replace(' ','-',$selectedAgent)) == $agent ? 'selected' : '').' >'.$agent.'</option>';
		}

		foreach($reasonArray as $reasonValue => $reasonText){
			$reasonOptions .= '<option value="'.$reasonText.'" '.($reason == $reasonText ? 'selected' : '').' >'.$reasonText.'</option>';
		}

    }

}

?>
<a id="request-info-form" class="pad-anchor"></a>
<form class="form leadform" enctype="multipart/form-data" method="post" action="#request-info-form" id="requestinfo">
	<input type="hidden" name="formID" value="requestinfo" >
	<div class="row">
		<div class="col-sm-6">

			<div class="form-group">
				<label for="your_name" class="sr-only">Name<span class="req">*</span></label>
				<input name="your_name" type="text" class="form-control <?php echo ( $_POST['fullname']=='' && $formSubmitted ? 'has-error' : ''); ?>" value="<?php echo ($yourname != '' ? $yourname : ''); ?>" required placeholder="Name *">
			</div>
			<div class="form-group">
				<label for="your_email" class="sr-only">Email address<span class="req">*</span></label>
				<input name="your_email" type="email" class="form-control <?php echo( $youremail=='' && $formSubmitted || $emailformattedbadly ? 'has-error' : ''); ?>" value="<?php echo (!$passCheck ? $youremail : ''); ?>" required placeholder="Email address *">
			</div>
			<div class="form-group">
                <label for="phone" class="sr-only">Phone Number</label>
				<div class="phone-group">
					<input type="tel" name="phone" class="form-control ph" value="<?php echo (!$passCheck ? $phone : ''); ?>" placeholder="Phone Number" >
				</div>
			</div>
			<div class="form-group <?php echo ( $reason=='' && $formSubmitted ? 'has-error' : ''); ?>">
				<label for="reason" class="sr-only">Reason for contact<span class="req">*</span></label>
				<select class="form-control" name="reason" id="reason" required >
					<option value="">Reason for contact *</option>
					<?php echo $reasonOptions; ?>
				</select>
			</div>
            <div class="form-group q-mls <?php echo ($mlsnumber == '' ? 'hidden-xs-up' : ''); ?>">
                <label for="mls_number" class="sr-only">MLS#</label>
                <input type="text" class="form-control" value="<?php echo ($mlsnumber != '' ? $mlsnumber : ''); ?>" name="mls_number" placeholder="MLS number" />
            </div>

		</div>
		<div class="col-sm-6">

			<div class="form-group <?php echo ( $selectedAgent=='' && $formSubmitted ? 'has-error' : ''); ?>">
				<label for="your_agent" class="sr-only">Your Agent<span class="req">*</span></label>
				<select class="form-control" name="your_agent" required>
                    <option value="">Select an agent *</option>
					<?php echo $agentOptions; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="additional_info" class="sr-only">Additional Info</label>
				<textarea name="additional_info" rows="4" class="form-control" placeholder="Message" style="height: 93px;"><?php echo ($message != '' ? stripslashes($message) : ''); ?></textarea>
			</div>
			<div class="form-group">
				<input type="text" name="secu" style="position: absolute; height: 1px; top: -50px; left: -50px; width: 1px; padding: 0; margin: 0; visibility: hidden;" >
				<button type="submit" class="btn btn-primary btn-md pull-md-right" >SEND</button>
			</div>

		</div>
	</div>
</form>