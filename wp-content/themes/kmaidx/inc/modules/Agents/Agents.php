<?php

namespace Includes\Modules\Agents;

use GuzzleHttp\Client;
use Includes\Modules\CPT\CustomPostType;

class Agents {

	public $queryvar;
	public $agentArray;

	public function __construct() {
	}

	public function createPostType() {

		$team = new CustomPostType( 'agent',
			[
				'supports'           => [ 'title', 'editor', 'thumbnail', 'author' ],
				'menu_icon'          => 'dashicons-businessman',
				'has_archive'        => false,
				'menu_position'      => null,
				'public'             => true,
				'publicly_queryable' => true,
				'hierarchical'       => true,
				'show_ui'            => true,
				'show_in_nav_menus'  => true,
				'_builtin'           => false,
				'rewrite'            => [
					'slug'       => 'team',
					//string Customize the permalink structure slug. Defaults to the $post_type value. Should be translatable.
					'with_front' => true,
					//bool Should the permalink structure be prepended with the front base. <br>
					//(example: if your permalink structure is /blog/, then your links will be: false-> /news/, true->/blog/news/). Defaults to true
					'feeds'      => true,
					//bool Should a feed permalink structure be built for this post type. Defaults to has_archive value
					'pages'      => false
					//bool Should the permalink structure provide for pagination. Defaults to true
				],
				/*'capability_type'    => array('agent','agents'),
				'capabilities' => array(
					'edit_post'          => 'edit_agents',
					'read_post'          => 'read_agents',
					'publish_posts'      => 'publish_agents',
					'edit_others_posts'  => 'edit_others_agents'
				),*/
			]
		);
		$team->addTaxonomy( 'office' );
		$team->createTaxonomyMeta( 'office', [ 'label' => 'Address', 'type' => 'textarea' ] );
		$team->createTaxonomyMeta( 'office', [ 'label' => 'Phone Number', 'type' => 'text' ] );
		$team->createTaxonomyMeta( 'office', [ 'label' => 'Fax Number', 'type' => 'text' ] );
		$team->createTaxonomyMeta( 'office', [ 'label' => 'GPS Coordinates', 'type' => 'text' ] );

		$team->addMetaBox(
			'Contact Info',
			[
				'Display Name' => 'text',
				'MLS IDs'      => 'text',
				'AKA'          => 'text',
				'Title'        => 'text',
				'Photo'        => 'image',
				'Email'        => 'text',
				'Website'      => 'text',
				'Office Phone' => 'text',
                'Cell Phone'   => 'text',
			]
		);

		$team->addMetaBox(
			'Social Media Info',
			[
				'Facebook'    => 'text',
				'Twitter'     => 'text',
				'LinkedIn'    => 'text',
				'Instagram'   => 'text',
				'YouTube'     => 'text',
				'Google Plus' => 'text'
			]
		);

	}

	public function getAgentNames() {
		$request = get_posts( [
			'post_type'      => 'agent',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'offset'         => 0,
			'post_status'    => 'publish',
		] );

		$output = [];
		foreach ( $request as $item ) {
			array_push( $output, ( isset( $item->post_title ) ? $item->post_title : null ) );
		}

		return $output;
	}

	public function getTeam( $args = [] ) {

		$request = [
			'post_type'      => 'agent',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'offset'         => 0,
			'post_status'    => 'publish',
		];

		$request = get_posts( array_merge( $request, $args ) );

		$output = [];
		foreach ( $request as $item ) {

			$terms      = wp_get_object_terms( $item->ID, 'office' );
			$categories = [];
			foreach ( $terms as $term ) {
				array_push( $categories, [
						'category-id'   => ( isset( $term->term_id ) ? $term->term_id : null ),
						'category-name' => ( isset( $term->name ) ? $term->name : null ),
						'category-slug' => ( isset( $term->slug ) ? $term->slug : null ),
					]
				);
			}

			array_push( $output, [
                'id'           => (isset($itemID) ? $item->ID : null),
                'mls_name'     => (isset($item->post_title) ? $item->post_title : null),
                'name'         => (isset($item->contact_info_display_name) ? $item->contact_info_display_name : $item->post_title),
                'aka'          => (isset($item->contact_info_aka) ? $item->contact_info_aka : null),
                'title'        => (isset($item->contact_info_title) ? $item->contact_info_title : null),
                'email_address'=> (isset($item->contact_info_email) ? $item->contact_info_email : null),
                'website'      => (isset($item->contact_info_website) ? $item->contact_info_website : null),
                'office_phone' => (isset($item->contact_info_office_phone) ? $item->contact_info_office_phone : null),
                'cell_phone'   => (isset($item->contact_info_cell_phone) ? $item->contact_info_cell_phone : null),
                'slug'         => (isset($item->post_name) ? $item->post_name : null),
                'thumbnail'    => (isset($item->contact_info_photo) ? $item->contact_info_photo : get_template_directory_uri() . '/img/beachybeach-placeholder.jpg'),
                'short_ids'    => (isset($item->contact_info_mls_ids) ? $item->contact_info_mls_ids : null),
                'link'         => get_permalink($item->ID),
                'bio'          => (isset($item->post_content) ? $item->post_content : null),
                'social'       => [
                    'facebook'    => (isset($item->social_media_info_facebook) ? $item->social_media_info_facebook : null),
                    'twitter'     => (isset($item->social_media_info_twitter) ? $item->social_media_info_twitter : null),
                    'linkedin'    => (isset($item->social_media_info_linkedin) ? $item->social_media_info_linkedin : null),
                    'instagram'   => (isset($item->social_media_info_instagram) ? $item->social_media_info_instagram : null),
                    'youtube'     => (isset($item->social_media_info_youtube) ? $item->social_media_info_youtube : null),
                    'google_plus' => (isset($item->social_media_info_google) ? $item->social_media_info_google : null),
                ],
                'categories'   => $categories
            ]);

		}

		return $output;
	}

	public function getSingleAgent( $name ) {

		$output = $this->getTeam( [
			'title'          => $name,
			'posts_per_page' => 1,
		] );

		return $output[0];
	}

	public function getOffices( $args = [], $limit = 0 ) {

		$request = [
			'taxonomy'   => 'office',
			'hide_empty' => false,
		];

		$request = get_terms( array_merge( $request, $args ) );

		//chop to limit manually since SCP Order is ganked.
		if ( $limit != 0 ) {
			$request = array_slice( $request, 0, $limit );
		}

		$output = [];
		foreach ( $request as $item ) {
			$coordinates = explode( ',', get_term_meta( $item->term_id, 'office_gps_coordinates', true ) );
			$output[]    = [
				'id'        => $item->term_id,
				'name'      => $item->name,
                'bio'       => $item->post_content,
				'slug'      => $item->slug,
				'address'   => get_term_meta( $item->term_id, 'office_address', true ),
				'phone'     => get_term_meta( $item->term_id, 'office_phone_number', true ),
				'fax'       => get_term_meta( $item->term_id, 'office_fax_number', true ),
				'latitude'  => $coordinates[0],
				'longitude' => $coordinates[1]
			];
		}

		return $output;

	}

	public function getAgentListings( $agentIds ){

        $client   = new Client(['base_uri' => 'http://mothership.kerigan.com/api/v1/']);

        // make the API call
        $apiCall = $client->request(
            'GET',
            'agentlistings?agentId=' . $agentIds
        );

        return json_decode($apiCall->getBody());

    }

    protected function setAgentSeo( $agentData ){

	    global $metaTitle;
        $metaTitle = $agentData['meta_title'];

        add_filter('wpseo_title', function ($metaTitle) {
            global $post;
            $newTitle = $metaTitle;
            return $newTitle;
        }, 100, 1);


    }

    public function assembleAgentData( $agentName ){

        $agent    = $this->getSingleAgent( $agentName );
        $agentIds = trim(implode('|', explode(',', $agent['short_ids'])));

        $agentMLSInfo = false; //TODO: Get data from MLS

        $agentData['meta_title']       = $agent['name'] . ' | ' . $agent['title'] . ' | ' . get_bloginfo('name');
        $agentData['meta_description'] = strip_tags($agent['bio']);
        $agentData['listings']         = ($agent['short_ids'] != '' ? $this->getAgentListings($agentIds) : [] );

        if(is_array($agent)) {
            $agentData = array_merge($agent, $agentData);
        }
        $this->setAgentSeo($agentData);
        return $agentData;

    }

}