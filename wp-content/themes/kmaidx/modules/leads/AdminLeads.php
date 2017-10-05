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
    }

    public function createNavLabel()
    {
        add_action('admin_menu', function () {
            add_menu_page('Beachy Bucket', 'Beachy Buckets', 'manage_options', 'bb-admin', function () {
                $this->createPageContent();
            }, 'dashicons-palmtree', 6);
        });
    }

    private function createPageContent()
    {
        $user_id    = get_current_user_id();
        $userMeta   = get_user_meta($user_id);
        $agentName  = $userMeta['first_name'][0] . ' ' . $userMeta['last_name'][0];
        $userData   = $this->getBuckets($agentName);
        ?>
        <h1>Clients and Leads assigned to <?php echo $agentName; ?></h1>
        <?php
        echo '<pre>',print_r($userData),'</pre>';
    }

    private function getBuckets($agentName)
    {
        $bb         = new BeachyBucket();
        $userData   = $bb->clientBeachyBuckets($agentName);

        return $userData;
    }
}
