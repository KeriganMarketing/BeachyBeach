<?php
/**
 * Created by PhpStorm.
 * User: Bryan
 * Date: 10/5/2017
 * Time: 10:15 AM
 */

class AdminLeads
{
    public function __construct()
    {
        //listen for data save
        $this->save();
    }

    public function createNavLabel()
    {

        $userId      = get_current_user_id();
        $accessLevel = $this->getAccessLevel($userId);

        add_action('admin_menu', function () {
            add_menu_page('My Beachy Buckets', 'My Beachy Buckets', 'manage_options', 'bb-buckets', function () {
                $this->createMyBeachyBuckets();
            }, 'dashicons-palmtree', 6);
        });

        if (in_array('administrator', $accessLevel) || in_array_r('editor', $accessLevel)) {
            add_action('admin_menu', function () {
                add_menu_page('All Beachy Buckets', 'All Beachy Buckets', 'manage_options', 'bb-admin', function () {
                    $this->createAllBeachyBuckets();
                }, 'dashicons-palmtree', 5);
            });
        }
    }

    private function getAccessLevel($userId)
    {

        $userMeta     = get_user_meta($userId);
        $accessLevels = unserialize($userMeta['wp_capabilities'][0]);

        $output = [];
        foreach ($accessLevels as $level => $code) {
            array_push($output, $level);
        }

        return $output;
    }

    private function getBuckets($agentName, $accessLevel = false)
    {
        $bb = new BeachyBucket();

        if ($accessLevel) {
            $userData = $bb->allBuckets($agentName);
        } else {
            $userData = $bb->clientBeachyBuckets($agentName);
        }

        return $userData;
    }

    private function createMyBeachyBuckets()
    {
        $userId    = get_current_user_id();
        $userMeta  = get_user_meta($userId);
        $agentName = $userMeta['first_name'][0] . ' ' . $userMeta['last_name'][0];
        $userData  = $this->getBuckets($agentName);

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline" style="margin-bottom: 1rem;">Clients and Leads assigned
                to <?php echo $agentName; ?></h1>

            <table class="wp-list-table widefat fixed striped pages">
                <thead>
                <tr>
                    <th scope="col" id="title" class="manage-column column-name column-primary sortable desc"><a
                                href="?page=bb-admin&amp;orderby=name&amp;order=asc"><span>Name</span><span
                                    class="sorting-indicator"></span></a></th>
                    <th scope="col" id="phone" class="manage-column column-phone"><span>Phone Number</span></th>
                    <th scope="col" id="email" class="manage-column column-email"><span>Email Address</span></th>
                    <th scope="col" id="email" class="manage-column column-address"><span>Physical Address</span></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($userData as $user) {
                    $user['zip'][0]            = isset($user['zip'][0]) ? $user['zip'][0] : '';
                    $user['city'][0]           = isset($user['city'][0]) ? $user['city'][0] : '';
                    $user['addr1'][0]          = isset($user['addr1'][0]) ? $user['addr1'][0] : '';
                    $user['addr2'][0]          = isset($user['addr2'][0]) ? $user['addr2'][0] : '';
                    $user['phone1'][0]         = isset($user['phone1'][0]) ? $user['phone1'][0] : '';
                    $user['thestate'][0]       = isset($user['thestate'][0]) ? $user['thestate'][0] : '';
                    $user['last_name'][0]      = isset($user['last_name'][0]) ? $user['last_name'][0] : '';
                    $user['first_name'][0]     = isset($user['first_name'][0]) ? $user['first_name'][0] : '';

                    ?>
                    <tr>
                        <td><strong><?php echo $user['first_name'][0] . ' ' . $user['last_name'][0]; ?></strong></td>
                        <td>
                            <strong><a href="tel:<?php echo $user['phone1'][0]; ?>"><?php echo $user['phone1'][0]; ?></a></strong>
                        </td>
                        <td>
                            <strong><a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a></strong>
                        </td>
                        <td><strong><?php echo $user['addr1'][0];
                                echo $user['addr2'][0] != '' ? ', ' . $user['addr2'][0] : ''; ?><br>
                                <?php echo $user['city'][0] . ', ' . $user['thestate'][0] . $user['zip'][0]; ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <a target="_blank" href="https://beachybeach.com/beachy-bucket/?users_bucket=<?php echo $user['id']; ?>" role="button" class="button button-primary" style="float: right" >View All <?php echo count($user['buckets']); ?> Properties</a>
                            <p>Saved Properties: &nbsp;
                                <?php
                                foreach ($user['buckets'] as $mlsNumber) {
                                    echo '<a href="/listing/?mls=' . $mlsNumber . '" target="_blank">' . $mlsNumber . '</a>, ';
                                }
                                ?>
                            </p>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>

        <?php


    }


    private function createAllBeachyBuckets()
    {

        $userId    = get_current_user_id();
        $userMeta  = get_user_meta($userId);
        $agentName = $userMeta['first_name'][0] . ' ' . $userMeta['last_name'][0];
        $userData  = $this->getBuckets($agentName, true);

//        echo '<pre>',print_r($userData),'</pre>';

        //FOR AGENT DROPDOWN
        $agents     = new mlsTeam();
        $agentArray = $agents->getAgentNames();

        add_thickbox();
        $thickboxes ='';

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline" style="margin-bottom: 1rem;">All Clients and Leads</h1>

            <table class="wp-list-table widefat fixed striped pages">
                <thead>
                <tr>
                    <th scope="col" id="title" class="manage-column column-name column-primary sortable desc"><a
                                href="?page=bb-admin&amp;orderby=name&amp;order=asc"><span>Name</span><span
                                    class="sorting-indicator"></span></a></th>
                    <th scope="col" id="phone" class="manage-column column-phone"><span>Phone Number</span></th>
                    <th scope="col" id="email" class="manage-column column-email"><span>Email Address</span></th>
                    <th scope="col" id="address" class="manage-column column-address"><span>Physical Address</span></th>
                    <th scope="col" id="agent" class="manage-column column-agent"><span>Assigned Agent</span></th>
                    <th scope="col" id="properties" class="manage-column column-properties"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($userData as $user) {
                    $user['zip'][0]            = isset($user['zip'][0]) ? $user['zip'][0] : '';
                    $user['city'][0]           = isset($user['city'][0]) ? $user['city'][0] : '';
                    $user['addr1'][0]          = isset($user['addr1'][0]) ? $user['addr1'][0] : '';
                    $user['addr2'][0]          = isset($user['addr2'][0]) ? $user['addr2'][0] : '';
                    $user['phone1'][0]         = isset($user['phone1'][0]) ? $user['phone1'][0] : '';
                    $user['thestate'][0]       = isset($user['thestate'][0]) ? $user['thestate'][0] : '';
                    $user['last_name'][0]      = isset($user['last_name'][0]) ? $user['last_name'][0] : '';
                    $user['first_name'][0]     = isset($user['first_name'][0]) ? $user['first_name'][0] : '';
                    $user['selected_agent'][0] = isset($user['selected_agent'][0]) ? $user['selected_agent'][0] : '';

                    //SELECT OPTIONS
                    $agentOptions = '';
                    foreach ($agentArray as $agent) {
                        $agentOptions .= '<label style="padding: .5rem 1rem; display: block;"><input type="radio" name="agentassignment" value="' . $agent . '" ' . ($user['selected_agent'][0] == $agent ? 'checked' : '') . ' /> ' . $agent . '</label>';
                    }

                    if($user['selected_agent'][0] == 'First Available'){
                        $changeButton = '<a title="Select an Agent for ' . $user['first_name'][0] . ' ' . $user['last_name'][0] . '" href="#TB_inline?width=300&height=500&inlineId=assignagent'.$user['first_name'][0] . $user['last_name'][0].'" role="button" data-toggle="modal" class="button button-secondary thickbox" style="float: right; color: #FFF; background-color: darkred; box-shadow: inset 0 -2px 0 rgba(0,0,0,.3); border-color: rgba(0,0,0,.3);" >Assign Agent</a>';
                    }else{
                        $changeButton = '<a title="Select an Agent for ' . $user['first_name'][0] . ' ' . $user['last_name'][0] . '" href="#TB_inline?width=300&height=500&inlineId=assignagent'.$user['first_name'][0] . $user['last_name'][0].'" role="button" data-toggle="modal" class="button button-info thickbox" style="float: right" >Change Agent</a>';
                    }

                    $thickboxes .= '<div id="assignagent'.$user['first_name'][0] . $user['last_name'][0].'" class="modal hide fade" style="display:none; ">
                        <div>
                            <form class="form" id="agentselect" method="post" action="'.$_SERVER['REQUEST_URI'].'" >
                                <input type="hidden" name="formID" value="agentselect" >
                                <input type="hidden" name="cid" value="'.$user['id'].'" >
                                '.$agentOptions.'
                                <div class="stuck" style="position: absolute; top: 50px; right: 30px;">
                                <button style="padding: .5rem 1rem; height: auto; font-size: 1.2em;" class="button button-primary" >SAVE</button>
                                </div>
                            </form>
                            </div>
                        </div>';
                    ?>

                    <tr id="<?php echo $user['first_name'][0] . $user['last_name'][0]; ?>-form">
                        <td><strong><?php echo $user['first_name'][0] . ' ' . $user['last_name'][0]; ?></strong></td>
                        <td>
                            <strong><a href="tel:<?php echo $user['phone1'][0]; ?>"><?php echo $user['phone1'][0]; ?></a></strong>
                        </td>
                        <td>
                            <strong><a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a></strong>
                        </td>
                        <td><strong><?php echo $user['addr1'][0];
                                echo $user['addr2'][0] != '' ? ', ' . $user['addr2'][0] : ''; ?><br>
                                <?php echo $user['city'][0] . ', ' . $user['thestate'][0] . $user['zip'][0]; ?></strong>
                        </td>
                        <td><strong><?php echo $user['selected_agent'][0]; ?></strong>  <?php echo $changeButton; ?></td>
                        <td align="center"><a href="https://beachybeach.com/beachy-bucket/?users_bucket=<?php echo $user['id']; ?>" role="button" class="button button-primary" style="float: right" target="_blank" ><?php echo count($user['buckets']); ?> Properties</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
        <?php

        echo $thickboxes;

    }

    private function save(){

        $formSubmitted = isset($_POST['formID']) ? $_POST['formID'] : null;
        if($formSubmitted == 'agentselect'){
            update_user_meta( $_POST['cid'], 'selected_agent', $_POST['agentassignment'] );
        }

    }

}
