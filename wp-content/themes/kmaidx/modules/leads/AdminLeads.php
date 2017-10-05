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

        $userId    = get_current_user_id();
        $accessLevel = $this->getAccessLevel($userId);

        add_action('admin_menu', function () {
            add_menu_page('My Beachy Buckets', 'My Beachy Buckets', 'manage_options', 'bb-buckets', function () {
                $this->createMyBeachyBuckets();
            }, 'dashicons-palmtree', 6);
        });

        if(in_array('administrator', $accessLevel) || in_array_r('editor', $accessLevel)){
            add_action('admin_menu', function () {
                add_menu_page('All Beachy Buckets', 'All Beachy Buckets', 'manage_options', 'bb-admin', function () {
                    $this->createAllBeachyBuckets();
                }, 'dashicons-palmtree', 5);
            });
        }

    }

    private function getAccessLevel( $userId ){

        $userMeta     = get_user_meta($userId);
        $accessLevels = unserialize($userMeta['wp_capabilities'][0]);

        $output = [];
        foreach ($accessLevels as $level => $code){
            array_push($output, $level);
        }
        return $output;

    }

    private function createMyBeachyBuckets()
    {
        $userId    = get_current_user_id();
        $userMeta   = get_user_meta($userId);
        $agentName  = $userMeta['first_name'][0] . ' ' . $userMeta['last_name'][0];
        $userData   = $this->getBuckets($agentName);

        echo '<pre>',print_r($userMeta),'</pre>';

        echo '<!--<pre>',print_r($userData),'</pre>-->';
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline" style="margin-bottom: 1rem;">Clients and Leads assigned to <?php echo $agentName; ?></h1>

            <table class="wp-list-table widefat fixed striped pages">
                <thead>
                    <tr>
                        <th scope="col" id="title" class="manage-column column-name column-primary sortable desc"><a href="?page=bb-admin&amp;orderby=name&amp;order=asc"><span>Name</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="phone" class="manage-column column-phone"><span>Phone Number</span></th>
                        <th scope="col" id="email" class="manage-column column-email"><span>Email Address</span></th>
                        <th scope="col" id="email" class="manage-column column-address"><span>Physical Address</span></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($userData as $user) { ?>
                    <tr>
                        <td><strong><?php echo $user['first_name'][0] . ' ' . $user['last_name'][0]; ?></strong></td>
                        <td><strong><a href="tel:<?php echo $user['phone1'][0]; ?>" ><?php echo $user['phone1'][0]; ?></a></strong></td>
                        <td><strong><a href="mailto:<?php echo $user['email']; ?>" ><?php echo $user['email']; ?></a></strong></td>
                        <td><strong><?php echo $user['addr1'][0]; echo $user['addr2'][0] != '' ? ', ' . $user['addr2'][0] : ''; ?><br>
                                <?php echo $user['city'][0] . ', ' . $user['thestate'][0] . $user['zip'][0]; ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <p>Saved Properties ( <?php echo count($user['buckets']); ?> ):</p>
                            <ul style="margin-left: 2rem;">
                                <?php
                                foreach ($user['buckets'] as $mlsNumber) {
                                    echo '<li><a href="/listing/?mls=' . $mlsNumber . '" target="_blank">' . $mlsNumber . '</a></li>';
                                }
                                ?>
                            </ul>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>

        <?php
    }

    private function getBuckets($agentName)
    {
        $bb         = new BeachyBucket();
        $userData   = $bb->clientBeachyBuckets($agentName);

        return $userData;
    }

    private function createAllBeachyBuckets() {

        $bb         = new BeachyBucket();
        $userData   = $bb->allBuckets();

        return $userData;

    }

    private function buildPage(){

    }

}
