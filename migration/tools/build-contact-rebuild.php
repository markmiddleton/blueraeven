<?php
/**
 * Builds the contact-rebuild page. Run: wp @local eval-file <this>
 */

function br_att_id( $rel ) {
    global $wpdb;
    $id = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value = %s LIMIT 1",
        $rel
    ) );
    if ( ! $id ) {
        WP_CLI::error( "No attachment for $rel" );
    }
    return $id;
}

function br_block( $name, $data ) {
    return '<!-- wp:acf/' . $name . ' ' . json_encode(
        array( 'name' => 'acf/' . $name, 'data' => $data, 'mode' => 'edit' ),
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    ) . ' /-->';
}

// ---------- C1: page hero ----------
$c1 = br_block( 'page-hero', array(
    'title' => 'Get In Touch', '_title' => 'field_brph_title',
    'script' => 'We’d love to hear from you', '_script' => 'field_brph_script',
    'variant' => 'navy', '_variant' => 'field_brph_variant',
) );

// ---------- C2: photo banner ----------
$c2 = br_block( 'photo-banner', array(
    'image' => br_att_id( '2026/04/farm_banner.jpg' ), '_image' => 'field_brpb_image',
) );

// ---------- C3: contact methods ----------
$methods = array(
    array( 'Visit Us', 'Amity Farmstand & McMinnville Pie Shop', 'See hours & locations', 'Get Directions', '/farmstand/' ),
    array( 'Call Us', '(503) 835-0740', 'Mon–Sat, 9am–5:30pm', 'Give Us a Ring', 'tel:5038350740' ),
    array( 'Email Us', 'hello@blueraeven.com', 'We reply within 24 hours', 'Send a Message', 'mailto:hello@blueraeven.com' ),
);
$c3 = array( 'cards' => count( $methods ), '_cards' => 'field_brcm_cards' );
foreach ( $methods as $i => $m ) {
    $c3["cards_{$i}_title"]       = $m[0];
    $c3["_cards_{$i}_title"]      = 'field_brcm_title';
    $c3["cards_{$i}_line1"]       = $m[1];
    $c3["_cards_{$i}_line1"]      = 'field_brcm_line1';
    $c3["cards_{$i}_line2"]       = $m[2];
    $c3["_cards_{$i}_line2"]      = 'field_brcm_line2';
    $c3["cards_{$i}_link_label"]  = $m[3];
    $c3["_cards_{$i}_link_label"] = 'field_brcm_link_label';
    $c3["cards_{$i}_link_url"]    = $m[4];
    $c3["_cards_{$i}_link_url"]   = 'field_brcm_link_url';
}
$c3 = br_block( 'contact-methods', $c3 );

// ---------- C4: contact form ----------
$subjects = array(
    array( 'where-to-find', 'Where to find us' ),
    array( 'feedback', 'Feedback' ),
    array( 'special-orders', 'Special orders' ),
    array( 'wholesale', 'Wholesale inquiry' ),
    array( 'fundraising', 'Fundraising inquiry' ),
    array( 'jobs', 'Job inquiry' ),
    array( 'other', 'Other' ),
);
$c4 = array(
    'heading' => 'Drop Us a Line', '_heading' => 'field_brcf_heading',
    'subtitle' => 'for orders, events, or just to say hi', '_subtitle' => 'field_brcf_subtitle',
    'access_key' => '9508eed0-a2f2-4133-8688-ea9e430b8f41', '_access_key' => 'field_brcf_access_key',
    'sitekey' => '50b2fe65-b00b-4b9e-ad62-3ba471098be2', '_sitekey' => 'field_brcf_sitekey',
    'subjects' => count( $subjects ), '_subjects' => 'field_brcf_subjects',
    'button' => 'Send Message', '_button' => 'field_brcf_button',
    'thanks_title' => 'Thanks! Your message is on its way.', '_thanks_title' => 'field_brcf_thanks_title',
    'thanks_text' => 'We’ll get back to you soon.', '_thanks_text' => 'field_brcf_thanks_text',
    'image' => br_att_id( '2026/04/contact_pie_vertical.jpg' ), '_image' => 'field_brcf_image',
);
foreach ( $subjects as $i => $s ) {
    $c4["subjects_{$i}_value"]  = $s[0];
    $c4["_subjects_{$i}_value"] = 'field_brcf_subj_value';
    $c4["subjects_{$i}_label"]  = $s[1];
    $c4["_subjects_{$i}_label"] = 'field_brcf_subj_label';
}
$c4 = br_block( 'contact-form', $c4 );

// ---------- C5: FAQ section ----------
$faqs = array(
    array( 'Can I order pies for shipping?', 'Currently, our pies are available exclusively at the farm stand and through select local retailers. We’re working on shipping options — sign up for our newsletter to be the first to know!' ),
    array( 'Do you take custom flavor requests?', 'Absolutely! For special orders of 6 or more pies, we can work with you on custom flavors and combinations. Give us a call or use the contact form to get started.' ),
    array( 'When is U-Pick berry season?', 'U-Pick season typically runs from mid-June through August, depending on weather and crop conditions. Follow us on social media for real-time updates on picking availability.' ),
    array( 'Are your products gluten-free or vegan?', 'Our traditional pies use a butter-based crust with wheat flour. We occasionally offer gluten-free options during special events — ask us about current availability.' ),
    array( 'Can I visit the farm with a group?', 'We love hosting groups! For parties of 10 or more, please call ahead so we can make sure we have plenty of pie and a warm welcome ready for you.' ),
);
$c5 = array(
    'title' => 'Common Questions', '_title' => 'field_brfs_title',
    'anchor' => '', '_anchor' => 'field_brfs_anchor',
    'faqs' => count( $faqs ), '_faqs' => 'field_brfs_faqs',
);
foreach ( $faqs as $i => $f ) {
    $c5["faqs_{$i}_question"]  = $f[0];
    $c5["_faqs_{$i}_question"] = 'field_brfs_question';
    $c5["faqs_{$i}_answer"]    = $f[1];
    $c5["_faqs_{$i}_answer"]   = 'field_brfs_answer';
}
$c5 = br_block( 'faq-section', $c5 );

// ---------- C6: social CTA ----------
$c6 = br_block( 'social-cta', array(
    'label' => 'Stay Connected', '_label' => 'field_brsc_label',
    'title' => 'Follow Along', '_title' => 'field_brsc_title',
    'script' => 'for harvest updates, new flavors, and farm life', '_script' => 'field_brsc_script',
    'links' => 2, '_links' => 'field_brsc_links',
    'links_0_platform' => 'facebook', '_links_0_platform' => 'field_brsc_platform',
    'links_0_url' => 'https://www.facebook.com/blueraevenpie', '_links_0_url' => 'field_brsc_url',
    'links_1_platform' => 'instagram', '_links_1_platform' => 'field_brsc_platform',
    'links_1_url' => 'https://www.instagram.com/blueraevenpie', '_links_1_url' => 'field_brsc_url',
) );

// ---------- assemble page ----------
$content = implode( "\n\n", array( $c1, $c2, $c3, $c4, $c5, $c6 ) );
$existing = get_page_by_path( 'contact-rebuild' );
$postarr = array(
    'post_type'    => 'page',
    'post_status'  => 'publish',
    'post_title'   => 'Contact (Rebuild)',
    'post_name'    => 'contact-rebuild',
    'post_content' => wp_slash( $content ),
);
if ( $existing ) {
    $postarr['ID'] = $existing->ID;
    $page_id = wp_update_post( $postarr );
} else {
    $page_id = wp_insert_post( $postarr );
}
update_post_meta( $page_id, '_wp_page_template', 'page-contact' );
WP_CLI::success( "contact-rebuild page: $page_id (template: page-contact)" );
