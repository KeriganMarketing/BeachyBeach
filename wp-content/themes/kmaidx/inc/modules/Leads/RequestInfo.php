<?php

namespace Includes\Modules\Leads;

use Includes\Modules\Agents\Agents;

class RequestInfo extends Leads
{
    public function __construct ()
    {
        parent::__construct ();
        parent::set('ccEmail','lacey@beachybeach.com');
        parent::assembleLeadData(
            [
                'phone_number'       => 'Phone Number',
                'reason_for_contact' => 'Reason for Contact',
                'selected_agent'     => 'Selected Agent',
                'mls_number'         => 'MLS Number',
                'message'            => 'Message',
                'lead_for'           => 'Lead for',
            ]
        );
    }

    public function handleLead ($dataSubmitted = [])
    {
        $fullName = (isset($dataSubmitted['full_name']) ? $dataSubmitted['full_name'] : null);
        $dataSubmitted['full_name'] = (isset($dataSubmitted['first_name']) && isset($dataSubmitted['last_name']) ? $dataSubmitted['first_name'] . ' ' . $dataSubmitted['last_name'] : $fullName);

        if($dataSubmitted['lead_for'] == 'specific'){

            $agent = new Agents();
            $agentInfo = $agent->assembleAgentData($dataSubmitted['selected_agent']);
            parent::set('adminEmail',($agentInfo['email'] != '' ? $agentInfo['email'] : 'info@beachybeach.com'));
            $dataSubmitted['lead_for'] = '';

        }elseif($dataSubmitted['lead_for'] == 'pcb'){

            parent::set('adminEmail','info@beachybeach.com');
            $dataSubmitted['selected_agent'] = '';
            $dataSubmitted['lead_for'] = 'Beachy Beach Real Estate';

        }elseif($dataSubmitted['lead_for'] == '30a'){

            parent::set('adminEmail','30a@beachybeach.com');
            $dataSubmitted['selected_agent'] = '';
            $dataSubmitted['lead_for'] = 'Beachy Beach 30A';

        }

        //parent::set($this->adminEmail,'bbaird85@gmail.com'); //temp
        parent::addToDashboard($dataSubmitted);
        if(parent::validateSubmission($dataSubmitted)){
            echo '<div class="alert alert-success" role="alert">
            <strong>Your request has been received. We will review your submission and get back with you soon.</strong>
            </div>';
        }else{
            echo '<div class="alert alert-danger" role="alert">
            <strong>Errors were found. Please correct the indicated fields below.</strong>
            </div>';
            return;
        }
        parent::sendNotifications($dataSubmitted);
    }

}