<?php

namespace Includes\Modules\Leads;

class HomeValuation extends Leads
{
    public function __construct ()
    {
        parent::__construct ();
        parent::set('postType','Home Valuation');
        parent::assembleLeadData(
            [
                'phone_number'       => 'Phone Number',
                'selected_agent'     => 'Selected Agent',
                'property_address'   => 'Property Address',
                'property_type'      => 'Property Type',
                'property_details'   => 'Property Details'
            ]
        );
    }

}