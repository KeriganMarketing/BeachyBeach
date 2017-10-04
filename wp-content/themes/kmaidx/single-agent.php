<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package KMA_DEMO
 */

$agentTerms                     = wp_get_object_terms( $post->ID, 'office' );
$agentCategories = array();
foreach($agentTerms as $term){
    array_push($agentCategories, array(
                    'category-id'       => (isset($term->term_id)   ? $term->term_id : null),
                    'category-name'     => (isset($term->name)      ? $term->name : null),
                    'category-slug'     => (isset($term->slug)      ? $term->slug : null),
            )
    );
}

$agent = array(
        'id'            => (isset($post->ID)                  ? $post->ID : null),
        'name'          => (isset($post->post_title)          ? $post->post_title : null),
        'aka'           => (isset($post->contact_info_aka)    ? $post->contact_info_aka : null),
        'title'         => (isset($post->contact_info_title)  ? $post->contact_info_title : null),
        'phone'         => (isset($post->contact_info_phone)  ? $post->contact_info_phone : null),
        'email'         => (isset($post->contact_info_email)  ? $post->contact_info_email : null),
        'website'       => (isset($post->contact_info_website)? $post->contact_info_website : null),
        'slug'          => (isset($post->post_name)           ? $post->post_name : null),
        'thumbnail'     => (isset($post->contact_info_photo)  ? $post->contact_info_photo : null),
        'link'          => get_permalink($post->ID),
        'social'        => array(
                'facebook'      => ($post->social_media_info_facebook   != '' ? $post->social_media_info_facebook : ''),
                'twitter'       => ($post->social_media_info_twitter    != '' ? $post->social_media_info_twitter : ''),
                'linkedin'      => ($post->social_media_info_linkedin   != '' ? $post->social_media_info_linkedin : ''),
                'instagram'     => ($post->social_media_info_instagram  != '' ? $post->social_media_info_instagram : ''),
                'youtube'       => ($post->social_media_info_youtube    != '' ? $post->social_media_info_youtube : ''),
                'google_plus'   => ($post->social_media_info_google     != '' ? $post->social_media_info_google : ''),
        ),
        'categories'    => $agentCategories,
        'mls_names'     => ($post->contact_info_additional_mls_names != ''  ? $post->contact_info_additional_mls_names : null)
);

$socialLinks = [
    'facebook'      => ($post->social_media_info_facebook   != '' ? 'https://facebook.com'.$post->social_media_info_facebook : ''),
    'twitter'       => ($post->social_media_info_twitter    != '' ? 'https://twitter.com'.$post->social_media_info_twitter : ''),
    'linkedin'      => ($post->social_media_info_linkedin   != '' ? 'https://www.linkedin.com/in'.$post->social_media_info_linkedin : ''),
    'instagram'     => ($post->social_media_info_instagram  != '' ? 'https://instagram.com'.$post->social_media_info_instagram : ''),
    'youtube'       => ($post->social_media_info_youtube    != '' ? 'https://www.youtube.com/user'.$post->social_media_info_youtube : ''),
    'google_plus'   => ($post->social_media_info_google     != '' ? 'https://plus.google.com'.$post->social_media_info_google : '')
];

$mls = new MLS();
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'price';
$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'DESC';

if($agent['name'] != '') {

    $agentIds = [];
    $agentMLSInfo = $mls->getAgentByName($agent['name']);
    array_push($agentIds, $agentMLSInfo->short_ids);

    if($agent['mls_names'] != '') {
        $additionalNames = explode(',',$agent['mls_names']);
        foreach($additionalNames as $additionalName){
            array_push($agentIds,$additionalName);
        }
    }

    $agentListings = $mls->getAgentListings($agentIds, $sortBy, $orderBy);

}

$agentEmail         = '';
$agentCellPhone     = '';
$agentOfficePhone   = '';
$agentWebsite       = '';

$agentEmail    = ($agentMLSInfo != false ? $agentMLSInfo->email : '');
if($agent['email'] != '' ){ $agentEmail = $agent['email']; }

$agentCellPhone    = ($agentMLSInfo != false ? $agentMLSInfo->cell_phone : '');
$agentOfficePhone    = ($agentMLSInfo != false ? $agentMLSInfo->office_phone : '');

if($agent['phone'] != '' ){ $agentCellPhone = $agent['phone']; }

$agentWebsite  = ($agentMLSInfo != false ? $agentMLSInfo->url : '');
if($agent['website'] != '' ){ $agentWebsite = $agent['website']; }

$metaTitle = $agent['name'] . ' | ' . $agent['title'] . ' | ' . get_bloginfo('name');
$metaDescription = strip_tags($post->post_content);
$ogPhoto = ($agent['thumbnail'] != '' ? $agent['thumbnail'] : get_template_directory_uri().'/img/beachybeach-placeholder.jpg' );
$ogUrl = get_the_permalink();

get_header(); ?>
    <!-- <?php print_r($agentIds); ?> -->
<div id="content">

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php include(locate_template('template-parts/content-realtor.php')); ?>

        <?php endwhile; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

</div>
<?php get_footer();
