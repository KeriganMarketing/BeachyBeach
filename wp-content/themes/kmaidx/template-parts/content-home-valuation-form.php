<?php

$mlsLead = new kmaLeads();
$mls = new MLS();
$ADMIN_EMAIL = 'bryan@kerigan.com';
$DOMAIN_NAME = 'beachybeach.com';

//CURRENT USER INFO
$currentUser = get_user_meta( get_current_user_id() );
$currentUserInfo = get_userdata( get_current_user_id() );

//FOR AGENT DROPDOWN
$agents = new mlsTeam();
$agentArray = $agents->getAgentNames();
$agentOptions = '';

//DEFAULT FORM VARS
$yourname               = (isset($_GET['your_name']) ? $_GET['your_name'] : '');
$youremail              = (isset($_GET['your_email']) ? $_GET['your_email'] : '');
$phone                  = (isset($_GET['phone']) ? $_GET['phone'] : '');
$listing_address        = (isset($_GET['listing_address']) ? $_GET['listing_address'] : '');
$listing_address_2      = (isset($_GET['listing_address_2']) ? $_GET['listing_address_2'] : '');
$listing_city           = (isset($_GET['listing_city']) ? $_GET['listing_city'] : '');
$listing_state          = (isset($_GET['listing_state']) ? $_GET['listing_state'] : '');
$listing_zip            = (isset($_GET['listing_zip']) ? $_GET['listing_zip'] : '');
$listing_property_type  = (isset($_GET['listing_property_type']) ? $_GET['listing_property_type'] : '');
$emailformattedbadly    = FALSE;
$passCheck              = FALSE;
$message                = '';

//IS USER LOGGED IN?
$yourname               = ($currentUser['first_name'][0] != '' ? $currentUser['first_name'][0] : $yourname);
$yourname               = ($currentUser['last_name'][0] != '' ? $yourname.' '.$currentUser['last_name'][0] : $yourname);
$youremail              = (isset($currentUserInfo->user_email) ? $currentUserInfo->user_email : $youremail);
$phone                  = (isset($currentUser['phone1'][0]) ? $currentUser['phone1'][0] : $phone);

$selectedAgent = (isset($currentUser['selected_agent'][0]) ? $currentUser['selected_agent'][0] : null); //get agent from user data.
$selectedAgent = (isset($_GET['selected_agent']) ? $_GET['selected_agent'] : $selectedAgent ); //IF GET, then override.
//print(strtolower(str_replace(' ','-',$selectedAgent)));

//SELECT OPTIONS
foreach($agentArray as $agent){
    //echo '<pre>',print_r($agent),'</pre>';
	$agentOptions .= '<option value="'.$agent.'" '.($selectedAgent == $agent ? 'selected' : '').' >'.$agent.'</option>';
}

$formID                 = (isset($_POST['formID']) ? $_POST['formID'] : '');
$securityFlag           = (isset($_POST['secu']) ? $_POST['secu'] : '');
$formSubmitted          = ($formID == 'homevaluation' && $securityFlag == '' ? TRUE : FALSE);

if( $formSubmitted ){ //FORM WAS SUBMITTED

    //OVERRIDE DEFAULTS IF FORM POSTED
	$yourname               = (isset($_POST['your_name']) ? $_POST['your_name'] : $yourname);
	$youremail              = (isset($_POST['your_email']) ? $_POST['your_email'] : $youremail);
	$phone                  = (isset($_POST['phone']) ? $_POST['phone'] : $phone);
	$selectedAgent          = (isset($_POST['selected_agent']) ? $_POST['selected_agent'] : $selectedAgent );
	$listing_address        = (isset($_POST['listing_address']) ? $_POST['listing_address'] : $listing_address);
	$listing_address_2      = (isset($_POST['listing_address_2']) ? $_POST['listing_address_2'] : $listing_address_2);
	$listing_city           = (isset($_POST['listing_city']) ? $_POST['listing_city'] : $listing_city);
	$listing_state          = (isset($_POST['listing_state']) ? $_POST['listing_state'] : $listing_state);
	$listing_zip            = (isset($_POST['listing_zip']) ? $_POST['listing_zip'] : $listing_zip);
	$listing_property_type  = (isset($_POST['listing_property_type']) ? $_POST['listing_property_type'] : $listing_property_type);
	$message                = (isset($_POST['property_details']) ? $_POST['property_details'] : $message);
	$who                = (isset($_POST['who']) ? $_POST['who'] : '');

	if($who == 'specific'){

		$agent = new mlsTeam();
		$agentInfo = $agent->getSingleAgent($selectedAgent);
		//echo '<pre>',print_r($_POST),'</pre>';
		//echo '<pre>',print_r($agentInfo),'</pre>';
		$agentMLSInfo = $mls->getAgentByName($agentInfo['name']);
		$ADMIN_EMAIL    = ($agentMLSInfo != false ? $agentMLSInfo->email : '');
		if($agentInfo['email'] != '' ){ $ADMIN_EMAIL = $agentInfo['email']; }
		$leadFor = $selectedAgent;

	}elseif($who == 'pcb'){

		$ADMIN_EMAIL = 'info@beachybeach.com';
		$leadFor = 'Beachy Beach Real Estate';

	}elseif($who == '30a'){

		$ADMIN_EMAIL = '30a@beachybeach.com';
		$leadFor = 'Beachy Beach 30A';

	}

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
	);

	if($selectedAgent!=''){         $emailvars['Selected Agent']    = $selectedAgent; }
	if($listing_address!=''){       $emailvars['Property Address']  = $listing_address.' '.$listing_address_2.'<br>'.$listing_city.' '.$listing_state.', '.$listing_zip; }
	if($listing_property_type!=''){ $emailvars['Property Type']     = $listing_property_type; }
	if($message!=''){               $emailvars['Additional Info']   = htmlentities(stripslashes($message)); }

	$successmessage     = '<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span><span class="sr-only">Success:</span> <strong>Your home valuation request has been received. Your selected agent/staff will review your submission and get back with you soon.</strong>';
	$errormessage       = '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span> Errors were found. Please correct the indicated fields below.';

	$fontstyle          = 'font-family: sans-serif;';
	$headlinestyle      = 'style="font-size:20px; '.$fontstyle.' color:#42BC7B;"';
	$copystyle          = 'style="font-size:16px; '.$fontstyle.' color:#333;"';
	$labelstyle         = 'style="padding:4px 8px; background:#F7F6F3; border:1px solid #FFFFFF; font-weight:bold; '.$fontstyle.' font-size:14px; color:#4D4B47; width:150px;"';
	$datastyle          = 'style="padding:4px 8px; background:#F7F6F3; border:1px solid #FFFFFF; '.$fontstyle.' font-size:14px;"';

	$headline           = '<h2 '.$headlinestyle.'>Home Valuation Request</h2>';
	$receiptheadline    = '<h2 '.$headlinestyle.'>Your home valuation request</h2>';
	$adminintrocopy     = '<p '.$copystyle.'>You have received a home valuation lead from the website. Details are below:</p>';
	$receiptintrocopy   = '<p '.$copystyle.'>Your request has been received and we will get back with you as soon as we can. What you submitted is below:</p>';
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

			$emailTemplate  = file_get_contents(wp_normalize_path(get_template_directory().'/modules/leads/emailtemplate.php'));
			$split          = strrpos($emailTemplate, '<!--[content]-->');
			$templatebot    = substr($emailTemplate, $split);
			$templatetop    = substr($emailTemplate, 0, $split);

			// store the comment normally
			$emailMessage = $templatetop.$emaildata['headline'].$emaildata['introcopy'].$templatebot;
			$leadId = wp_insert_post(
				array( //POST INFO
					'post_content' => '',
					'post_status' => 'publish',
					'post_type' => 'Lead',
					'post_title' => $yourname,
					'comment_status' => 'closed',
					'ping_status' => 'closed',
					'meta_input' => array( //POST META
						'lead_info_name' => $yourname,
						'lead_info_date' => date('M j, Y').' @ '.date('g:i a e'),
						'lead_info_phone_number' => $phone,
						'lead_info_email_address' => $youremail,
						'lead_info_message' => $message,
						'lead_info_selected_agent' => $selectedAgent,
						'lead_info_notification_preview' => $emailMessage,
						'lead_info_property_type' => $listing_property_type,
						'lead_info_address' => $listing_address.' '.$listing_address_2.'<br>'.$listing_city.' '.$listing_state.', '.$listing_zip,
					)
				), true
			);
			wp_set_object_terms( $leadId, 1413, 'type' ); //Home Valuation

		}

    }else{ //ERRORS
        echo '<div class="alert alert-danger" role="alert">'.$errormessage;
        if($adderror != '') { echo '<ul>'.$adderror.'</ul>'; }
        echo '</div>';

		foreach($agentArray as $agent){
			$agentOptions .= '<option value="'.$agent.'" '.($selectedAgent == $agent ? 'selected' : '').' >'.$agent.'</option>';
		}

    }

}

?>
<a id="homeval" class="pad-anchor"></a>
<form class="form homevalform" enctype="multipart/form-data" method="post" action="#homeval" id="homeval">
	<input type="hidden" name="formID" value="homevaluation" >
    <h3>Contact Information</h3>
    <div class="row" style="width:100%">
        <div class="col-md-6 col-lg-4">
            <label for="your_name" class="sr-only">Name *</label>
            <div class="input-group mb-2">
                <input name="your_name" type="text" id="your_name" class="textbox form-control <?php echo ( $yourname && $formSubmitted ? 'has-error' : ''); ?>" value="<?php echo ($yourname != '' ? $yourname : ''); ?>" required placeholder="Name *">
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <label for="your_email" class="sr-only">Email Address *</label>
            <div class="input-group mb-2">
                <input name="your_email" type="text" id="your_email" class="textbox form-control <?php echo( $youremail=='' && $formSubmitted || $emailformattedbadly ? 'has-error' : ''); ?>" value="<?php echo (!$passCheck ? $youremail : ''); ?>" required placeholder="Email Address *">
            </div>
        </div>
        <div class="col-lg-4">
            <label for="phone" class="sr-only">Phone Number *</label>
            <div class="input-group mb-2">
                <input name="phone" type="text" id="phone" class="textbox form-control <?php echo ( $phone && $formSubmitted ? 'has-error' : ''); ?>" value="<?php echo ($phone != '' ? $phone : ''); ?>" placeholder="Phone Number *">
            </div>
        </div>
        <div class="col-12 mt-4">
            <label for="who" >Select an area office or specific agent.</label>
        </div>
        <div class="custom-controls-inline col-12">

            <label class="custom-control custom-radio mt-2 mb-2">
                <input id="radioStacked1" name="who" type="radio" class="custom-control-input" onclick="toggleSelect();" value="pcb">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Beachy Beach Real Estate</span>
            </label>
            <label class="custom-control custom-radio">
                <input id="radioStacked2" name="who" type="radio" class="custom-control-input" onclick="toggleSelect();" value="30a">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Beachy Beach 30A Real Estate</span>
            </label>
            <label class="custom-control custom-radio">
                <input id="select-an-agent" name="who" type="radio" class="custom-control-input" onclick="toggleSelect();" value="specific" <?php echo ($selectedAgent!='' ? 'checked' : ''); ?> >
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Select an agent</span>
            </label>

            <div class="form-group <?php echo ( $selectedAgent=='' && $formSubmitted ? 'has-error' : ''); ?>" id="agent-select-dd" style="display: none; margin:0;">
                <label for="your_agent" class="sr-only">Your Agent</label>
                <select class="form-control" name="your_agent" required>
			        <?php echo $agentOptions; ?>
                </select>
            </div>

        </div>

    </div>
    <div class="spacer"></div>
    <h3>Property Information</h3>
    <div class="row" style="width:100%">
        <div class="col-md-8">
            <label for="listing_address" class="sr-only">Listing Address *</label>
            <div class="input-group mb-2">
                <input name="listing_address" type="text" id="listing_address <?php echo ( $listing_address && $formSubmitted ? 'has-error' : ''); ?>" value="<?php echo ($listing_address != '' ? $listing_address : ''); ?>" class="textbox form-control" required placeholder="Listing Address *">
            </div>
        </div>
        <div class="col-md-4">
            <label for="listing_address_2" class="sr-only">Apt/Suite *</label>
            <div class="input-group mb-2">
                <input name="listing_address_2" type="text" id="listing_address_2" class="textbox form-control" value="<?php echo ($listing_address_2 != '' ? $listing_address_2 : ''); ?>" placeholder="Apt/Suite">
            </div>
        </div>
        <div class="col-md-5">
            <label for="listing_city" class="sr-only">City *</label>
            <div class="input-group mb-2">
                <input name="listing_city" type="text" id="listing_city" class="textbox form-control <?php echo ( $listing_city && $formSubmitted ? 'has-error' : ''); ?>" value="<?php echo ($listing_city != '' ? $listing_city : ''); ?>" required placeholder="City *">
            </div>
        </div>
        <div class="col-md-4">
            <label for="listing_state" class="sr-only">State *</label>
            <div class="input-group mb-2">
                <select class="form-control <?php echo ( $listing_state=='' && $formSubmitted ? 'has-error' : ''); ?>" required name="listing_state">
                    <option value="AL" <?php if($listing_state == 'AL'){ echo 'selected'; } ?> >Alabama</option>
                    <option value="AK" <?php if($listing_state == 'AK'){ echo 'selected'; } ?> >Alaska</option>
                    <option value="AZ" <?php if($listing_state == 'AZ'){ echo 'selected'; } ?> >Arizona</option>
                    <option value="AR" <?php if($listing_state == 'AR'){ echo 'selected'; } ?> >Arkansas</option>
                    <option value="CA" <?php if($listing_state == 'CA'){ echo 'selected'; } ?> >California</option>
                    <option value="CO" <?php if($listing_state == 'CO'){ echo 'selected'; } ?> >Colorado</option>
                    <option value="CT" <?php if($listing_state == 'CT'){ echo 'selected'; } ?> >Connecticut</option>
                    <option value="DE" <?php if($listing_state == 'DE'){ echo 'selected'; } ?> >Delaware</option>
                    <option value="FL" <?php if($listing_state == 'FL' || $listing_state == ''){ echo 'selected'; } ?> >Florida</option>
                    <option value="GA" <?php if($listing_state == 'GA'){ echo 'selected'; } ?> >Georgia</option>
                    <option value="HI" <?php if($listing_state == 'HI'){ echo 'selected'; } ?> >Hawaii</option>
                    <option value="ID" <?php if($listing_state == 'ID'){ echo 'selected'; } ?> >Idaho</option>
                    <option value="IL" <?php if($listing_state == 'IL'){ echo 'selected'; } ?> >Illinois</option>
                    <option value="IN" <?php if($listing_state == 'IN'){ echo 'selected'; } ?> >Indiana</option>
                    <option value="IA" <?php if($listing_state == 'IA'){ echo 'selected'; } ?> >Iowa</option>
                    <option value="KS" <?php if($listing_state == 'KS'){ echo 'selected'; } ?> >Kansas</option>
                    <option value="KY" <?php if($listing_state == 'KY'){ echo 'selected'; } ?> >Kentucky</option>
                    <option value="LA" <?php if($listing_state == 'LA'){ echo 'selected'; } ?> >Louisiana</option>
                    <option value="ME" <?php if($listing_state == 'ME'){ echo 'selected'; } ?> >Maine</option>
                    <option value="MD" <?php if($listing_state == 'MD'){ echo 'selected'; } ?> >Maryland</option>
                    <option value="MA" <?php if($listing_state == 'MA'){ echo 'selected'; } ?> >Massachusetts</option>
                    <option value="MI" <?php if($listing_state == 'MI'){ echo 'selected'; } ?> >Michigan</option>
                    <option value="MN" <?php if($listing_state == 'MN'){ echo 'selected'; } ?> >Minnesota</option>
                    <option value="MS" <?php if($listing_state == 'MS'){ echo 'selected'; } ?> >Mississippi</option>
                    <option value="MO" <?php if($listing_state == 'MO'){ echo 'selected'; } ?> >Missouri</option>
                    <option value="MT" <?php if($listing_state == 'MT'){ echo 'selected'; } ?> >Montana</option>
                    <option value="NE" <?php if($listing_state == 'NE'){ echo 'selected'; } ?> >Nebraska</option>
                    <option value="NV" <?php if($listing_state == 'NV'){ echo 'selected'; } ?> >Nevada</option>
                    <option value="NH" <?php if($listing_state == 'NH'){ echo 'selected'; } ?> >New Hampshire</option>
                    <option value="NJ" <?php if($listing_state == 'NJ'){ echo 'selected'; } ?> >New Jersey</option>
                    <option value="NM" <?php if($listing_state == 'NM'){ echo 'selected'; } ?> >New Mexico</option>
                    <option value="NY" <?php if($listing_state == 'NY'){ echo 'selected'; } ?> >New York</option>
                    <option value="NC" <?php if($listing_state == 'NC'){ echo 'selected'; } ?> >North Carolina</option>
                    <option value="ND" <?php if($listing_state == 'ND'){ echo 'selected'; } ?> >North Dakota</option>
                    <option value="OH" <?php if($listing_state == 'OH'){ echo 'selected'; } ?> >Ohio</option>
                    <option value="OK" <?php if($listing_state == 'OK'){ echo 'selected'; } ?> >Oklahoma</option>
                    <option value="OR" <?php if($listing_state == 'OR'){ echo 'selected'; } ?> >Oregon</option>
                    <option value="PA" <?php if($listing_state == 'PA'){ echo 'selected'; } ?> >Pennsylvania</option>
                    <option value="RI" <?php if($listing_state == 'RI'){ echo 'selected'; } ?> >Rhode Island</option>
                    <option value="SC" <?php if($listing_state == 'SC'){ echo 'selected'; } ?> >South Carolina</option>
                    <option value="SD" <?php if($listing_state == 'SD'){ echo 'selected'; } ?> >South Dakota</option>
                    <option value="TN" <?php if($listing_state == 'TN'){ echo 'selected'; } ?> >Tennessee</option>
                    <option value="TX" <?php if($listing_state == 'TX'){ echo 'selected'; } ?> >Texas</option>
                    <option value="UT" <?php if($listing_state == 'UT'){ echo 'selected'; } ?> >Utah</option>
                    <option value="VT" <?php if($listing_state == 'VT'){ echo 'selected'; } ?> >Vermont</option>
                    <option value="VA" <?php if($listing_state == 'VA'){ echo 'selected'; } ?> >Virginia</option>
                    <option value="WA" <?php if($listing_state == 'WA'){ echo 'selected'; } ?> >Washington</option>
                    <option value="WV" <?php if($listing_state == 'WV'){ echo 'selected'; } ?> >West Virginia</option>
                    <option value="WI" <?php if($listing_state == 'WI'){ echo 'selected'; } ?> >Wisconsin</option>
                    <option value="WY" <?php if($listing_state == 'WY'){ echo 'selected'; } ?> >Wyoming</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <label for="listing_zip" class="sr-only">Zip *</label>
            <div class="input-group mb-2">
                <input name="listing_zip" type="text" id="listing_zip" class="textbox form-control <?php echo ( $listing_zip && $formSubmitted ? 'has-error' : ''); ?>" value="<?php echo ($listing_zip != '' ? $listing_zip : ''); ?>" required placeholder="Zip *">
            </div>
        </div>
        <div class="col-12">
            <label for="listing_property_type" class="sr-only">Property Type *</label>
            <div class="input-group form-check form-check-inline mt-2 mb-2">
                <label class="custom-control custom-radio">
                    <input type="radio" name="listing_property_type" value="Single Family Home" <?php echo ( $listing_property_type == 'Single Family Home' && $formSubmitted ? 'selected' : ''); ?> class="custom-control-input" >
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Single Family Home</span>
                </label>
                <label class="custom-control custom-radio">
                    <input type="radio" name="listing_property_type" value="Commercial" <?php echo ( $listing_property_type == 'Commercial' && $formSubmitted ? 'selected' : ''); ?> class="custom-control-input" >
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Commercial</span>
                </label>
                <label class="custom-control custom-radio">
                    <input type="radio" name="listing_property_type" value="Condo/Townhome" <?php echo ( $listing_property_type == 'Condo/Townhome' && $formSubmitted ? 'selected' : ''); ?> class="custom-control-input" >
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Condo/Townhome</span>
                </label>
                <label class="custom-control custom-radio">
                    <input type="radio" name="listing_property_type" value="Lot/Land" <?php echo ( $listing_property_type == 'Lot/Land' && $formSubmitted ? 'selected' : ''); ?> class="custom-control-input" >
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Lot/Land</span>
                </label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="property_details" class="sr-only">Property Details</label>
                <textarea name="property_details" rows="4" class="form-control" placeholder="Property Details" style="height: 130px;"><?php echo ($message != '' ? stripslashes($message) : ''); ?></textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <input type="text" name="secu" style="position: absolute; height: 1px; top: -50px; left: -50px; width: 1px; padding: 0; margin: 0; visibility: hidden;" >
                <button type="submit" class="btn btn-primary btn-md mb-2" >Submit Valuation Request</button>
            </div>
        </div>
    </div>
</form>