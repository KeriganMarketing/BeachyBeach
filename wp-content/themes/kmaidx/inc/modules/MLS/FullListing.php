<?php
namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

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
        $client = new Client(['base_uri' => 'http://mothership.kerigan.com/api/v1/listing/']);

        // make the API call
        $raw = $client->request(
            'GET',
            $this->mlsNumber
        );

        $results = json_decode($raw->getBody());

        return $results;
    }
}
