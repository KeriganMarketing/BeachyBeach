<?php
/**
 * Created by PhpStorm.
 * User: Bryan
 * Date: 3/24/2017
 * Time: 4:56 PM
 */
///CREATE TEAM CPT
$team = new Custom_Post_Type(
	'Team Member',
	array(
		'supports'			 => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'menu_icon'			 => 'dashicons-groups',
		'hierarchical'       => true,
		'has_archive' 		 => false,
		'menu_position'      => null,
		'public'             => true,
		'publicly_queryable' => true,
		'rewrite'            => array( 'slug' => 'team', 'with_front' => FALSE ),
	)
);

$team->add_meta_box(
	'Member Info',
	array(
		'Title' 			=> 'text',
		'Email Address' 		=> 'text',
		'LinkedIn Link' => 'longtext',
	)
);

function getteam_func( $atts, $content = null ) {
	$debugteam = FALSE;

	$a = shortcode_atts( array(
		'category' => '',
		'truncate' => 0,
	), $atts );

	if($debugteam){
		$output = '<p>category = '.$a['category'].'</p>';
	}else{
		$output = '';
	}

	$request = array(
		'posts_per_page'   => -1,
		'offset'           => 0,
		'order'            => 'ASC',
		'orderby'   		 => 'menu_order',
		'post_type'        => 'team_member',
		'post_status'      => 'publish',
	);

	if($a['category']!= ''){
		$categoryarray = array(
			array(
				'taxonomy' => 'team_category',
				'field' => 'slug',
				'terms' => $a['category'],
				'include_children' => false,
			),
		);
		$request['tax_query'] = $categoryarray;
	}

	if($debugteam){
		print_r($request);
	}

	$memberlist = get_posts( $request );

	$output = '<div class="team-gallery row justify-content-center align-items-middle">';
	foreach($memberlist as $member){
		$member_id = $member->ID;
		$name = $member->post_title;
        $thumb_id = get_post_thumbnail_id( $member_id );
        $thumb = wp_get_attachment_image_src( $thumb_id, 'large');
        $thumb_url = $thumb[0];
		$title = get_post_meta($member_id,'member_info_title', true);
		$linkedinlink = get_post_meta($member_id,'member_info_linkedin_link', true);
		$emailaddress = get_post_meta($member_id,'member_info_email_address', true);

        $output .='<div class="team-member col-sm-6 col-md-4 col-lg-3">
                        <div class="image-container">
                            <div class="image"><a href="'.get_permalink($member_id).'" ><img src="' . $thumb_url . '" alt="' . $name . '" class="img-fluid" ></a></div>
                        </div>
                        <div class="info">
                            <h3>'.$name.'</h3>
                            <h4>'.$title.'</h4>
                            <a href="'.get_permalink($member_id).'" >View Bio</a>
                        </div>
                    </div>';

	}
	$output .= '</div>';

	return $output;

}
add_shortcode( 'getteam', 'getteam_func' );