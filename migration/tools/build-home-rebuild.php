<?php
/**
 * Builds the home-rebuild page (full home: carousel, pie features, banners).
 * Run: wp @local eval-file <this>
 */

function br_block( $name, $data ) {
    return '<!-- wp:acf/' . $name . ' ' . json_encode(
        array( 'name' => 'acf/' . $name, 'data' => $data, 'mode' => 'edit' ),
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    ) . ' /-->';
}

// ---------- H1: hero carousel ----------
$h1 = br_block( 'hero-carousel', array(
    'slides' => 2, '_slides' => 'field_brhc_slides',
    'slides_0_type' => 'pan', '_slides_0_type' => 'field_brhc_slide_type',
    'slides_0_image' => 228, '_slides_0_image' => 'field_brhc_slide_image',
    'slides_0_from_left' => '0', '_slides_0_from_left' => 'field_brhc_slide_from_left',
    'slides_0_video' => '', '_slides_0_video' => 'field_brhc_slide_video',
    'slides_1_type' => 'video', '_slides_1_type' => 'field_brhc_slide_type',
    'slides_1_image' => '', '_slides_1_image' => 'field_brhc_slide_image',
    'slides_1_from_left' => '0', '_slides_1_from_left' => 'field_brhc_slide_from_left',
    'slides_1_video' => 318, '_slides_1_video' => 'field_brhc_slide_video',
    'brand' => 315, '_brand' => 'field_brhc_brand',
    'duration' => 12000, '_duration' => 'field_brhc_duration',
) );

// ---------- H2: best fruit ----------
$h2 = br_block( 'pie-feature', array(
    'image' => 316, '_image' => 'field_brpf_image',
    'reverse' => '0', '_reverse' => 'field_brpf_reverse',
    'colored' => '0', '_colored' => 'field_brpf_colored',
    'label' => 'The Blue Raeven Farms Difference', '_label' => 'field_brpf_label',
    'title' => 'The Best Fruit Makes the Best Pies', '_title' => 'field_brpf_title',
    'desc' => 'Our pies are loaded with fruit — not fillers. We use a higher fruit-to-crust ratio than most, so every bite bursts with real berry flavor, grown on our farm or from nearby Northwest neighbors. This is how pie is meant to taste.',
    '_desc' => 'field_brpf_desc',
    'btn_label' => 'View our Handcrafted Pies', '_btn_label' => 'field_brpf_btn_label',
    'btn_url' => '/pies-more/pies/', '_btn_url' => 'field_brpf_btn_url',
) );

// ---------- H3: ready for your table ----------
$h3 = br_block( 'pie-feature', array(
    'image' => 317, '_image' => 'field_brpf_image',
    'reverse' => '1', '_reverse' => 'field_brpf_reverse',
    'colored' => '1', '_colored' => 'field_brpf_colored',
    'label' => 'Take One Home', '_label' => 'field_brpf_label',
    'title' => 'Ready for Your Table', '_title' => 'field_brpf_title',
    'desc' => 'Whether buying from our farmstands or grocery store, every pie is packaged with care in our signature Blue Raeven box. If you’re taking one home for the family, gifting to a friend, or planning for a special occasion, trust that our pies travel beautifully.',
    '_desc' => 'field_brpf_desc',
    'btn_label' => 'Find Us Near You', '_btn_label' => 'field_brpf_btn_label',
    'btn_url' => '/farmstand/', '_btn_url' => 'field_brpf_btn_url',
) );

// ---------- H5/H6: story banners (pilot data) ----------
$h5 = br_block( 'story-banner', array(
    'bg_image' => 226, '_bg_image' => 'field_brsb_bg_image',
    'title' => 'The Story Behind our Handcrafted Pies', '_title' => 'field_brsb_title',
    'subhead' => 'A generational legacy of farming, fruit, and family tradition', '_subhead' => 'field_brsb_subhead',
    'cta_label' => 'Read Our Story', '_cta_label' => 'field_brsb_cta_label',
    'cta_url' => '/story/', '_cta_url' => 'field_brsb_cta_url',
    'open_style' => '1', '_open_style' => 'field_brsb_open_style',
    'show_spacer' => '1', '_show_spacer' => 'field_brsb_show_spacer',
) );
$h6 = br_block( 'story-banner', array(
    'bg_image' => 228, '_bg_image' => 'field_brsb_bg_image',
    'title' => 'Wholesale and Fundraising', '_title' => 'field_brsb_title',
    'subhead' => 'Great Pie is Good Business', '_subhead' => 'field_brsb_subhead',
    'cta_label' => 'Partner With Us', '_cta_label' => 'field_brsb_cta_label',
    'cta_url' => '/wholesale-fundraising/', '_cta_url' => 'field_brsb_cta_url',
    'open_style' => '1', '_open_style' => 'field_brsb_open_style',
    'show_spacer' => '1', '_show_spacer' => 'field_brsb_show_spacer',
) );

// ---------- assemble page ----------
$content = implode( "\n\n", array( $h1, $h2, $h3, $h5, $h6 ) );
$existing = get_page_by_path( 'home-rebuild' );
$postarr = array(
    'post_type'    => 'page',
    'post_status'  => 'publish',
    'post_title'   => 'Home (Rebuild)',
    'post_name'    => 'home-rebuild',
    'post_content' => wp_slash( $content ),
);
if ( $existing ) {
    $postarr['ID'] = $existing->ID;
    $page_id = wp_update_post( $postarr );
} else {
    $page_id = wp_insert_post( $postarr );
}
WP_CLI::success( "home-rebuild page: $page_id" );
