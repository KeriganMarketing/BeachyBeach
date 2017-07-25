<?php


/**
 *                    BCAR AND ECAR LIST REFERECNE
 *
 * LIST_3   Searchable Field        List Number Main        Int             11
 * LIST_8   Searchable Field        Property Type           Character        2
 * LIST_9   Searchable Field        Sub-Type                Character      100
 * LIST_15  Searchable Field        Status                  Character      100
 * LIST_22  Searchable Field        List Price              Decimal         15
 * LIST_29  Searchable Field        Area                    Character      100
 * LIST_31  Searchable Field        Street #                Character       10
 * LIST_34  Searchable Field        Street Name             Character       30
 * LIST_35  Searchable Field        Unit #                  Character       30
 * LIST_39  Searchable Field        City                    Character      100
 * LIST_40  Searchable Field        State                   Character      100
 * LIST_43  Searchable Field        Zip Code                Character      100
 * LIST_46  Searchable Field        Latitude                Decimal         11
 * LIST_47  Searchable Field        Longitude               Decimal         11
 * LIST_48  Searchable Field        Apx SqFt(Htd/Cool)      Decimal         10
 * LIST_57  Searchable Field        Acreage                 Decimal         10
 * LIST_66  Searchable Field        Bedrooms                Int              4
 * LIST_67  Searchable Field        Total Baths             Decimal          7
 * LIST_77  Searchable Field        Subdivision             Character       100
 * LIST_87  Searchable Field        Timestamp(modified)        DateTime        25
 * LIST_94  Searchable Field        Sub Area                Character       100
 * LIST_192 Searchable Field        Waterfront              Character       100
 *
 */

require_once("vendor/autoload.php");


/**
 * @property array ecarOptions
 * @property array bcarOptions
 */
class MLS
{

    function __construct()
    {
        $this->getEcarOptions();
        $this->getBcarOptions();
    }

    /**
     *
     */
    public function updateBCAR()
    {
        $loginUrl = 'http://retsgw.flexmls.com:80/rets2_3/Login';
        $username = 'bc.rets.kerigan';
        $password = 'moths-phobe10';

        $this->updateDatabase($loginUrl, $username, $password, 'wp_bcar');
    }

    /**
     *
     */
    public function updateECAR()
    {
        $loginUrl = 'http://retsgw.flexmls.com/rets2_2/Login';
        $username = 'ecn.rets.e9649';
        $password = 'mafic-biotic29';

        $this->updateDatabase($loginUrl, $username, $password, 'wp_ecar');
    }

    /**
     * @param $loginUrl
     * @param $username
     * @param $password
     * @param $table
     */
    private function updateDatabase($loginUrl, $username, $password, $table)
    {
        global $wpdb;
        $wpdb->query("TRUNCATE table " . $table);
        $classArray = [];

        $rets = $this->connectToMLS($loginUrl, $username, $password);

        $rets->Login();

        $classes = $this->getClasses($rets, 'Property');

        foreach ($classes as $class) {
            if ($class['ClassName'] != 'F') {
                array_push($classArray, $class['ClassName']);
            }
        }

        foreach ($classArray as $c) {

            $results = ($table == 'wp_ecar') ?
                $this->get_ECAR_data($c, $rets) :
                $this->get_BCAR_data($c, $rets);

            //echo $results->isMaxRowsReached() ? 'true ' : 'false ';
            //echo $results->getTotalResultsCount();
            foreach ($results as $result) {
                $this->updateTable($table, $wpdb, $result);
            }
        }
    }

    /**
     * @param $loginUrl
     * @param $username
     * @param $password
     * @return \PHRETS\Session
     */
    private function connectToMLS($loginUrl, $username, $password)
    {
        $config = new \PHRETS\Configuration;
        $config->setLoginUrl($loginUrl)
            ->setUsername($username)
            ->setPassword($password)
            ->setRetsVersion('1.7.2')
            ->setOption("compression_enabled", true)
            ->setOption("offset_support", true);


        $rets = new \PHRETS\Session($config);

        return $rets;
    }

    /**
     * @param $rets
     * @param $type
     * @return mixed
     * @internal param $resources
     */
    private function getClasses($rets, $type)
    {
        $letterClasses = $rets->GetClassesMetadata($type);

        return $letterClasses;
    }

    /**
     * @param $class
     * @param $rets
     * @return mixed
     * @internal param $table
     * @internal param $waterfront
     */
    private function get_ECAR_data($class, $rets)
    {


        switch ($class) {
            case 'A':
                $results = $rets->Search('Property', $class, '*', $this->ecarOptions['A']);
                break;
            case 'B':
                $results = $rets->Search('Property', $class, '*', $this->ecarOptions['B']);
                break;
            case 'C':
                $results = $rets->Search('Property', $class, '*', $this->ecarOptions['C']);
                break;
            case 'E':
                $results = $rets->Search('Property', $class, '*', $this->ecarOptions['E']);
                break;
            case 'F':
                $results = $rets->Search('Property', $class, '*', $this->ecarOptions['F']);
                break;
            case 'G':
                $results = $rets->Search('Property', $class, '*', $this->ecarOptions['G']);
                break;
            case 'H':
                $results = $rets->Search('Property', $class, '*', $this->ecarOptions['H']);
                break;
            case 'I':
                $results = $rets->Search('Property', $class, '*', $this->ecarOptions['I']);
                break;
            default:
                $results = $rets->Search('Property', $class, '*', $this->ecarOptions['A']);

                return $results;
        }

        return $results;
    }

    /**
     * @param $class
     * @param $rets
     * @return mixed
     */
    private function get_BCAR_data($class, $rets)
    {


        switch ($class) {
            case 'A':
                $results = $rets->Search('Property', $class, '*', $this->bcarOptions['A']);
                break;
            case 'B':
                $results = $rets->Search('Property', $class, '*', $this->bcarOptions['B']);
                break;
            case 'C':
                $results = $rets->Search('Property', $class, '*', $this->bcarOptions['C']);
                break;
            case 'E':
                $results = $rets->Search('Property', $class, '*', $this->bcarOptions['E']);
                break;
            case 'F':
                $results = $rets->Search('Property', $class, '*', $this->bcarOptions['F']);
                break;
            case 'I':
                $results = $rets->Search('Property', $class, '*', $this->bcarOptions['I']);
                break;
            case 'J':
                $results = $rets->Search('Property', $class, '*', $this->bcarOptions['J']);
                break;
            default:
                $results = $rets->Search('Property', $class, '*', $this->bcarOptions['A']);

        }

        return $results;
    }

    /**
     * @param $table
     * @param $wpdb
     * @param $result
     */
    private function updateTable($table, $wpdb, $result)
    {

        $wpdb->insert($table,
            array(
                'mls_account'   => $result['LIST_3'],
                'property_type' => $result['LIST_8'],
                'class'         => $result['LIST_9'],
                'status'        => $result['LIST_15'],
                'price'         => $result['LIST_22'],
                'area'          => $result['LIST_29'],
                'street_number' => $result['LIST_31'],
                'street_name'   => $result['LIST_34'],
                'unit_number'   => $result['LIST_35'],
                'city'          => $result['LIST_39'],
                'state'         => $result['LIST_40'],
                'zip'           => $result['LIST_43'],
                'latitude'      => $result['LIST_46'],
                'longitude'     => $result['LIST_47'],
                'sq_ft'         => $result['LIST_48'],
                'acreage'       => $result['LIST_57'],
                'bedrooms'      => $result['LIST_66'],
                'bathrooms'     => $result['LIST_67'],
                'subdivision'   => $result['LIST_77'],
                'date_modified' => $result['LIST_87'],
                'sub_area'      => $result['LIST_94'],
                'waterfront'    => $result['LIST_192'],
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%f',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%f',
                '%f',
                '%f',
                '%f',
                '%d',
                '%f',
                '%s',
                '%s',
                '%s',
                '%s',
            )
        );
    }

    /**
     * @internal param $waterfront
     */
    private function getEcarOptions()
    {
        $waterfront = 'GF20131203222329624962000000'; //mother of god

        $this->ecarOptions = [
            'A' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_48,LIST_57,LIST_66,LIST_67,LIST_77,LIST_87,LIST_94,' . $waterfront . ',LIST_133'
            ],
            'B' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_48,LIST_66,LIST_67,LIST_77,LIST_87,LIST_94,LIST_133'
            ],
            'C' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_57,LIST_77,LIST_87,LIST_94,LIST_133'
            ],
            'E' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_57,LIST_87,LIST_94,LIST_133'
            ],
            'F' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_48,LIST_57,LIST_87,LIST_94,LIST_133'
            ],
            'G' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_48,LIST_57,LIST_66,LIST_67,LIST_77,LIST_87,LIST_94,LIST_133'
            ],
            'H' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_48,LIST_57,LIST_66,LIST_67,LIST_77,LIST_87,LIST_94,LIST_133'
            ],
            'I' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_87,LIST_94,LIST_133'
            ],
        ];
    }

    /**
     * @internal param $waterfront
     */
    private function getBcarOptions()
    {
        $waterfront = 'LIST_192';

        $this->bcarOptions = [
            'A' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_48,LIST_57,LIST_66,LIST_67,LIST_77,LIST_87,LIST_94,' . $waterfront . ',LIST_133'
            ],
            'B' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_48,LIST_66,LIST_67,LIST_77,LIST_87,LIST_94,' . $waterfront . ',LIST_133'
            ],
            'C' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_57,LIST_77,LIST_87,LIST_94,' . $waterfront . ',LIST_133'
            ],
            'E' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_48,LIST_57,LIST_77,LIST_87,LIST_94,' . $waterfront . ',LIST_133'
            ],
            'F' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_48,LIST_77,LIST_87,LIST_94,' . $waterfront . ',LIST_133'
            ],
            'G' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_48,LIST_57,LIST_66,LIST_67,LIST_77,LIST_87,LIST_94,LIST_133'
            ],
            'H' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_48,LIST_57,LIST_66,LIST_67,LIST_77,LIST_87,LIST_94,LIST_133'
            ],
            'I' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_77,LIST_87,LIST_94,' . $waterfront . ',LIST_133'
            ],
            'J' => [
                'Limit'  => -1,
                'Select' =>
                    'LIST_3,LIST_8,LIST_9,LIST_15,LIST_22,LIST_29,LIST_31,LIST_34,LIST_35,LIST_39,LIST_40,LIST_43,LIST_46,LIST_47,LIST_57,LIST_77,LIST_87,LIST_94,' . $waterfront . ',LIST_133'
            ],
        ];
    }

    /**
     * @param $searchTerm
     * @return string
     */
    public function buildQuery($searchTerm)
    {

        $query = "SELECT b.id, b.status, b.state, b.preferred_image, b.mls_account, b.price, b.area, b.sub_area, b.subdivision, b.city, b.street_number, b.street_name, b.unit_number, b.zip, b.bedrooms, b.bathrooms, b.sq_ft, b.acreage, b.class, b.waterfront, b.date_modified FROM wp_bcar b WHERE b.status like 'Active' ";
        foreach($searchTerm['city'] as $city){
            if ($city) {
                $query .= ' AND b.city LIKE "' . $city . '" OR b.zip LIKE "' . $city . '" OR b.subdivision LIKE "' . $city . '" OR b.area LIKE "' . $city . '"';
                //$_SESSION['city'] = $searchTerm['city'];
            }
        }
//        if ($searchTerm['price']) {
//            $query .= ' AND b.price > ' . $searchTerm['price'];
//            //$_SESSION['price'] = $searchTerm['price'];
//        }
        if ($searchTerm['price']) {
            $query .= ' AND b.price < ' . $searchTerm['price'];
            //$_SESSION['price'] = $searchTerm['price'];
        }
        if ($searchTerm['bedrooms']) {
            $query .= ' AND b.bedrooms > ' . $searchTerm['bedrooms'];
            //$_SESSION['bedrooms'] = $searchTerm['bedrooms'];
        }
        if ($searchTerm['class']) {
            foreach($searchTerm['class'] as $class){

                $query .= ' AND b.class LIKE "' . $class . '"';
                //$_SESSION['class'] = $searchTerm['class'];
            }
        }

        $query .= " UNION ";
        $query .= "SELECT e.id, e.status, e.state, e.preferred_image, e.mls_account, e.price, e.area, e.sub_area, e.subdivision, e.city, e.street_number, e.street_name, e.unit_number, e.zip, e.bedrooms, e.bathrooms, e.sq_ft, e.acreage, e.class, e.waterfront, e.date_modified FROM wp_ecar e WHERE e.status like 'Active' ";
        foreach($searchTerm['city'] as $city) {
            if ($city) {
                $query .= ' AND e.city LIKE "' . $city . '" OR e.zip LIKE "' . $city . '" OR e.subdivision LIKE "' . $city . '" OR e.area LIKE "' . $city . '"';
                //$_SESSION['city'] = $searchTerm['city'];
            }
        }
//        if ($searchTerm['price']) {
//            $query .= ' AND e.price > ' . $searchTerm['price'];
//            //$_SESSION['price'] = $searchTerm['price'];
//        }
        if ($searchTerm['price']) {
            $query .= ' AND e.price < ' . $searchTerm['price'];
            //$_SESSION['price'] = $searchTerm['price'];
        }
        if ($searchTerm['bedrooms']) {
            $query .= ' AND e.bedrooms > ' . $searchTerm['bedrooms'];
            //$_SESSION['bedrooms'] = $searchTerm['bedrooms'];
        }
        if ($searchTerm['class']) {
            $query .= ' AND e.class LIKE "' . $searchTerm['class'] . '"';
            //$_SESSION['class'] = $searchTerm['class'];
        }


        return $query;
    }


    /**
     * @param $column
     * @return array|null|object
     */
    public function getDistinctColumn($column)
    {
        global $wpdb;

        $results = $wpdb->get_results("Select * FROM ((SELECT DISTINCT $column from wp_bcar as b) UNION (SELECT DISTINCT $column from wp_ecar as e)) as Q WHERE Q.$column IS NOT NULL AND Q.$column <> '' ORDER BY Q.$column;");

        return $results;
    }

    /**
     * @param $postVars
     */
    public function setSession($postVars)
    {
	    $_SESSION             = null;
        $_SESSION['city']     = isset($postVars['city']) ? $postVars['city'] : null;
        $_SESSION['price']    = isset($postVars['price']) ? $postVars['price'] : null;
        $_SESSION['bedrooms'] = isset($postVars['bedrooms']) ? $postVars['bedrooms'] : null;
        $_SESSION['class']    = isset($postVars['class']) ? $postVars['class'] : null;

    }

    /**
     * @param $query
     * @return string
     */
    public function getTotalQuery($query)
    {
        $total_query = "SELECT COUNT(preferred_image) FROM (" . $query . ") as Q ";

        return $total_query;
    }

    /**
     * @return int|number
     */
    function determinePagination()
    {
        $page = isset($_GET['pg']) ? abs((int)$_GET['pg']) : 1;

        return $page;
    }

    /**
     * @param $page
     * @param $listingsPerPage
     * @return mixed
     */
    function determineOffset($page, $listingsPerPage)
    {
        if ($page > 1) {
            $offset = $page * $listingsPerPage - $listingsPerPage +1;
        } else {
            $offset = $page;
        }

        return $offset;
    }

    public function updateBCARPhotos()
    {
        global $wpdb;
        $listings = $wpdb->get_results("SELECT DISTINCT mls_account FROM wp_bcar");
        $loginUrl = 'http://retsgw.flexmls.com:80/rets2_3/Login';
        $username = 'bc.rets.kerigan';
        $password = 'moths-phobe10';

        foreach ($listings as $listing) {
            $listingsArray[] = $listing->mls_account;
        }

        $chunkedArray = array_chunk($listingsArray, 250);

        foreach ($chunkedArray as $chunk => $mls) {
            $newArray[ $chunk ] = implode(",", $mls);
        }

        $rets = $this->connectToMLS($loginUrl, $username, $password);
        $rets->Login();

        foreach ($newArray as $mls_batch) {
            $photos = $rets->GetObject('Property', 'Photo', urldecode($mls_batch), '1', 1);

            $this->updatePhotosTable('wp_bcar', $photos, $wpdb);

        }

    }

    public function updateECARPhotos()
    {
        global $wpdb;
        $listings = $wpdb->get_results("SELECT DISTINCT mls_account FROM wp_ecar");
        $loginUrl = 'http://retsgw.flexmls.com/rets2_2/Login';
        $username = 'ecn.rets.e9649';
        $password = 'mafic-biotic29';

        foreach ($listings as $listing) {
            $listingsArray[] = $listing->mls_account;
        }

        $chunkedArray = array_chunk($listingsArray, 250);

        foreach ($chunkedArray as $chunk => $mls) {
            $newArray[ $chunk ] = implode(",", $mls);
        }

        $rets = $this->connectToMLS($loginUrl, $username, $password);
        $rets->Login();
        foreach ($newArray as $mls_batch) {
            $photos = $rets->GetObject('Property', 'Photo', urldecode($mls_batch), '1', 1);

            $this->updatePhotosTable('wp_ecar', $photos, $wpdb);

        }

    }

    private function updatePhotosTable($table, $photos, $wpdb)
    {
        foreach ($photos as $photo) {
            $mls_account = $photo->getContentId();
            $photo_url   = $photo->getLocation();
            echo '.';
            $wpdb->query("UPDATE " . $table . " SET preferred_image='" . $photo_url . "' WHERE mls_account='" . $mls_account ."'");
        }
    }

    public function getSvg($file = ''){

	    if($file!=''){

		    $activeTemplateDir = get_template_directory_uri().'/helpers/assets/';
		    $templatefileRequested = $file.'.svg';

		    return $activeTemplateDir.$templatefileRequested;

	    }

    }

}
