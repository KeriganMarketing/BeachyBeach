<?php
namespace Includes\Modules\MLS;

use GuzzleHttp\Client;
use Includes\Modules\Agents\Agents;
use Includes\Modules\MLS\BeachyBucket;

/**
* MLS Listing - Made by Daron Adkins
*/
class FullListing
{
    private $mlsNumber;

    /**
     * Search Constructor
     * @param string $mlsNumber - Basically just the $_GET variables
     */
    public function __construct($mlsNumber)
    {
        $this->mlsNumber   = $mlsNumber;
    }

    public function create()
    {
        $client = new Client(['base_uri' => 'https://mothership.kerigan.com/api/v1/listing/','http_errors' => false]);

        // make the API call
        $raw = $client->request(
            'GET',
            $this->mlsNumber
        );

        $results = json_decode($raw->getBody());

        return $results;
    }

    public function isOurs($listingInfo)
    {
        $agents = new Agents();
        $agentArray = $agents->getTeam();

        $mlsArray = array();
        foreach ($agentArray as $agent) {

            $agentIds = explode(',',$agent['short_ids']);
            foreach($agentIds as $agentId){
                $mlsArray[] = $agentId;
            }

        }

        if (in_array($listingInfo->listing_member_shortid, $mlsArray) ||
            in_array($listingInfo->colisting_member_shortid, $mlsArray)
        ) {
            return true;
        }

        return false;
    }

    public function isInBucket($user_id, $mls_number)
    {
        $bb = new BeachyBucket();

        $results = $bb->findBucketItem($user_id, $mls_number);

        if (empty($results)) {
            return false;
        }

        return true;
    }

    public function setListingSeo( $listingInfo )
    {

        global $metaTitle;
        $title = $listingInfo->street_number . ' ' . $listingInfo->street_name;
        $title = ($listingInfo->unit_number != '' ? $title . ' ' . $listingInfo->unit_number : $title);
        $metaTitle = $title . ' | $' . number_format($listingInfo->price) . ' | ' . $listingInfo->city . ' | ' . get_bloginfo('name');
        add_filter('wpseo_title', function ($metaTitle) {
            return $metaTitle;
        }, 100, 1);

        global $metaDescription;
        $metaDescription = strip_tags($listingInfo->description);
        add_filter('wpseo_metadesc', function ($metaDescription) {
            return $metaDescription;
        }, 100, 1);

        global $ogPhoto;
        $ogPhoto = ($listingInfo->preferred_image != '' ? $listingInfo->preferred_image : get_template_directory_uri() . '/img/beachybeach-placeholder.jpg');
        add_filter('wpseo_opengraph_image', function ($ogPhoto) {
            return $ogPhoto;
        }, 100, 1);

        global $ogUrl;
        $ogUrl = get_the_permalink() . '?mls=' . $listingInfo->mls_account;
        add_filter('wpseo_canonical',  function ($ogUrl) {
            return $ogUrl;
        }, 100, 1);
        add_filter('wpseo_opengraph_url', function ($ogUrl) {
            return $ogUrl;
        }, 100, 1);

    }
}
