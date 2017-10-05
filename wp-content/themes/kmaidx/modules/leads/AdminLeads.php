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

    public function createNavLabel(){

        add_action('admin_menu', function (){
            add_menu_page('Beachy Bucket', 'Beachy Buckets', 'manage_options', 'bb-admin', function(){
                $this->createPageContent();
            }, 'dashicons-palmtree', 6);
        });

    }

    private function createPageContent()
    {

        $user_id    = get_current_user_id();
        $userMeta   = get_user_meta($user_id);
        $agentName  = $userMeta['first_name'][0] . ' ' . $userMeta['last_name'][0];
        $mlsNumbers = $this->getBuckets( $agentName );

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Clients and Leads assigned to <?php echo $agentName; ?></h1>

            <table class="wp-list-table widefat fixed striped pages">
                <thead>
                <tr>
                    <th scope="col" id="title" class="manage-column column-name column-primary sortable desc"><a href="?page=bb-admin&amp;orderby=name&amp;order=asc"><span>Name</span><span class="sorting-indicator"></span></a></th>
                    <th scope="col" id="phone" class="manage-column column-phone"><span>Phone Number</span></th>
                    <th scope="col" id="email" class="manage-column column-email"><span>Email Address</span></th>
                    <th scope="col" id="properties" class="manage-column column-properties"><span>Saved Properties</span></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><strong>Ted</strong></td>
                    <td><strong>123-123-1234</strong></td>
                    <td><strong>user@domain.com</strong></td>
                    <td><strong><?php echo count($mlsNumbers); ?></strong></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <p>Saved Properties:</p>
                        <ul>
                            <?php
                            foreach ($mlsNumbers as $mlsNumber) {
                                echo '<li><a href="/listing/?mls=' . $mlsNumber . '" target="_blank">' . $mlsNumber . '</a></li>';
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
        <?php
    }

    private function getBuckets( $agentName ){

        $bb         = new BeachyBucket();
        $mlsNumbers = $bb->clientBeachyBuckets($agentName);

        return $mlsNumbers;
    }


}