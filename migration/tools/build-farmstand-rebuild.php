<?php
/**
 * Builds the farmstand-rebuild page. Run: wp @local eval-file <this>
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

// ---------- F1: page hero ----------
$f1 = br_block( 'page-hero', array(
    'title' => 'Easy to Find Us', '_title' => 'field_brph_title',
    'script' => 'Visit our farmstand, pie shop, or local grocery', '_script' => 'field_brph_script',
    'variant' => 'navy', '_variant' => 'field_brph_variant',
) );

// ---------- F2: visit photo collage ----------
$f2 = br_block( 'photo-collage', array(
    'main' => br_att_id( '2026/04/visit_hero.jpg' ), '_main' => 'field_brpc_main',
    'sides' => 2, '_sides' => 'field_brpc_sides',
    'sides_0_image' => br_att_id( '2026/04/visit_scene1.jpg' ), '_sides_0_image' => 'field_brpc_side_image',
    'sides_0_position' => '', '_sides_0_position' => 'field_brpc_side_pos',
    'sides_1_image' => br_att_id( '2026/04/visit_scene2.jpg' ), '_sides_1_image' => 'field_brpc_side_image',
    'sides_1_position' => 'center calc(50% + 100px)', '_sides_1_position' => 'field_brpc_side_pos',
) );

// ---------- F3: retailer section ----------
$retailers = array(
    array( 'Harvest Fresh Grocery', 'https://harvestfresh.com/' ),
    array( 'Market of Choice', 'https://marketofchoice.com/locations/' ),
    array( 'New Seasons Market', 'https://www.newseasonsmarket.com/find-a-store' ),
    array( 'Newport Avenue Market', 'https://newportavemarket.com/' ),
    array( 'Oliver Lemon’s', 'https://oliverlemons.com/' ),
    array( 'Otto’s Sausage Kitchen', 'https://www.ottossausage.com/' ),
    array( 'Roth’s IGA', 'https://www.roths.com/contact.php' ),
    array( 'Zupan’s', 'https://www.zupans.com/' ),
);
$farmstands = array(
    'Aspinwall’s Produce', 'Boones Ferry Farm', 'Dave Heikes Farms', 'Detering Orchards',
    'EZ Orchards', 'Farmington Gardens', 'Green Bridge Gardens', 'Jones Farm',
    'Justy’s Produce', 'Lehne Farms', 'Northwest Fresh Seafood Company',
    'Nottinghamshire Farms', 'Phil’s Market', 'Richard’s Farmstand',
);
$f3 = array(
    'title' => 'Available At Select Grocers', '_title' => 'field_brrs_title',
    'script' => 'Find us near you', '_script' => 'field_brrs_script',
    'intro' => 'Over the years, our pies have become part of holiday tables, weekend adventures, and celebrations big and small whether purchased at farm stores, regional grocers, bakeries, or brought to you from a local community <a href="/wholesale-fundraising/" style="color:var(--berry); text-decoration:underline;">fundraising</a> event.',
    '_intro' => 'field_brrs_intro',
    'retailers' => count( $retailers ), '_retailers' => 'field_brrs_retailers',
    'sub_title' => 'Also at area farmstands', '_sub_title' => 'field_brrs_sub_title',
    'farmstands' => count( $farmstands ), '_farmstands' => 'field_brrs_farmstands',
);
foreach ( $retailers as $i => $r ) {
    $f3["retailers_{$i}_name"]  = $r[0];
    $f3["_retailers_{$i}_name"] = 'field_brrs_ret_name';
    $f3["retailers_{$i}_url"]   = $r[1];
    $f3["_retailers_{$i}_url"]  = 'field_brrs_ret_url';
}
foreach ( $farmstands as $i => $name ) {
    $f3["farmstands_{$i}_name"]  = $name;
    $f3["_farmstands_{$i}_name"] = 'field_brrs_fs_name';
}
$f3 = br_block( 'retailer-section', $f3 );

// ---------- F4: location info cards ----------
$f4 = array(
    'title' => 'Come Visit Us', '_title' => 'field_bric_title',
    'script' => 'at our farmstand and pie shop', '_script' => 'field_bric_script',
    'intro' => 'Our Amity Farmstand has been welcoming visitors since 2007, offering a wide selection of our handcrafted pies, jams, and jellies—along with gourmet treats, snacks, and fresh seasonal berries. You can also stop by our pie shop in McMinnville to enjoy the same delicious favorites made right at the source—our pie kitchen. And stop by our grocery partners listed below to pick up a delicious pie near you.',
    '_intro' => 'field_bric_intro',
    'cards' => 2, '_cards' => 'field_bric_cards',
    'cards_0_title' => "Blue Raeven Farmstand\nAmity", '_cards_0_title' => 'field_bric_card_title',
    'cards_0_address' => "20650 S Hwy 99W\nAmity, OR 97101", '_cards_0_address' => 'field_bric_card_address',
    'cards_0_hours' => "Monday – Saturday: 9 AM to 5:30 PM\nSunday: 10 AM to 5 PM", '_cards_0_hours' => 'field_bric_card_hours',
    'cards_0_phone' => '(503) 835-0740', '_cards_0_phone' => 'field_bric_card_phone',
    'cards_0_tel' => '5038350740', '_cards_0_tel' => 'field_bric_card_tel',
    'cards_1_title' => "Blue Raeven Pie Company\nMcMinnville", '_cards_1_title' => 'field_bric_card_title',
    'cards_1_address' => "1101 NE Alpine Ave\nMcMinnville, OR 97128", '_cards_1_address' => 'field_bric_card_address',
    'cards_1_hours' => "Tuesday – Saturday: 10 AM to 5:30 PM\nSunday – Monday: Closed", '_cards_1_hours' => 'field_bric_card_hours',
    'cards_1_phone' => '(503) 474-2856', '_cards_1_phone' => 'field_bric_card_phone',
    'cards_1_tel' => '5034742856', '_cards_1_tel' => 'field_bric_card_tel',
);
$f4 = br_block( 'info-cards', $f4 );

// ---------- F5: find cards ----------
$find_cards = array(
    array( '2026/04/handcrafted-pies.jpg', 'Handcrafted Pies', 'Baked fresh daily using our own berries and family recipes.' ),
    array( '2026/04/jams-and-jellies.jpg', 'Jams & Confections', 'Small-batch jams made with the same fruit we put in our pies.' ),
    array( '2026/04/fresh-berries.jpg', 'Fresh Berries', 'Hand-picked blueberries, marionberries, blackberries.' ),
);
$f5 = array(
    'label' => 'At the Stand', '_label' => 'field_brfc_label',
    'title' => 'What You’ll Find', '_title' => 'field_brfc_title',
    'script' => 'Fresh from the farm, every day', '_script' => 'field_brfc_script',
    'cards' => count( $find_cards ), '_cards' => 'field_brfc_cards',
);
foreach ( $find_cards as $i => $c ) {
    $f5["cards_{$i}_image"]  = br_att_id( $c[0] );
    $f5["_cards_{$i}_image"] = 'field_brfc_card_image';
    $f5["cards_{$i}_title"]  = $c[1];
    $f5["_cards_{$i}_title"] = 'field_brfc_card_title';
    $f5["cards_{$i}_desc"]   = $c[2];
    $f5["_cards_{$i}_desc"]  = 'field_brfc_card_desc';
}
$f5 = br_block( 'find-cards', $f5 );

// ---------- F6: directions split ----------
$f6 = array(
    'map_src' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2815.8422667894074!2d-123.21031258735016!3d45.11038147094982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54954d85ed1b2141%3A0x75e44eea1857c45e!2sBlue%20Raeven%20Farmstand!5e0!3m2!1sen!2sus!4v1778278843790!5m2!1sen!2sus',
    '_map_src' => 'field_brds_map_src',
    'heading' => 'Find Us on 99W', '_heading' => 'field_brds_heading',
    'paragraphs' => 2, '_paragraphs' => 'field_brds_paragraphs',
    'paragraphs_0_text' => 'We’re located on the scenic Highway 99W corridor, in the heart of Oregon wine country. Whether you’re visiting the Willamette Valley wineries or making a special trip just for pie, we’re easy to find.',
    '_paragraphs_0_text' => 'field_brds_para_text',
    'paragraphs_1_text' => 'Look for our blue farmstand sign on the west side of the highway, just south of Amity. Plenty of free parking available.',
    '_paragraphs_1_text' => 'field_brds_para_text',
    'address' => "20650 S. Hwy 99W\nAmity, Oregon 97101", '_address' => 'field_brds_address',
);
$f6 = br_block( 'directions-split', $f6 );

// ---------- F7: gallery mosaic (same config as story) ----------
$tiles = array();
foreach ( array( '01', '04', '07', '10', '13' ) as $n ) {
    $tiles[] = br_att_id( "2026/05/story-grid/family-$n.jpg" );
}
$pool = array();
for ( $i = 1; $i <= 24; $i++ ) { $pool[] = br_att_id( sprintf( '2026/05/story-grid/family-%02d.jpg', $i ) ); }
for ( $i = 1; $i <= 16; $i++ ) { $pool[] = br_att_id( sprintf( '2026/05/story-grid/farm-%02d.jpg', $i ) ); }
foreach ( array( 'gallery_tall1.jpg', 'gallery1.jpg', 'gallery3.jpg', 'gallery4.jpg' ) as $g ) {
    $pool[] = br_att_id( "2026/04/$g" );
}
$f7 = br_block( 'gallery-mosaic', array(
    'label' => 'Life on the Farm', '_label' => 'field_brgm_label',
    'title' => 'Our Fields & Family', '_title' => 'field_brgm_title',
    'tiles' => $tiles, '_tiles' => 'field_brgm_tiles',
    'pool' => $pool, '_pool' => 'field_brgm_pool',
    'swap_ms' => 3500, '_swap_ms' => 'field_brgm_swap_ms',
    'fade_ms' => 900, '_fade_ms' => 'field_brgm_fade_ms',
    'anchor' => 'storyGallery', '_anchor' => 'field_brgm_anchor',
) );

// ---------- assemble page ----------
$content = implode( "\n\n", array( $f1, $f2, $f3, $f4, $f5, $f6, $f7 ) );
$existing = get_page_by_path( 'farmstand-rebuild' );
$postarr = array(
    'post_type'    => 'page',
    'post_status'  => 'publish',
    'post_title'   => 'Farmstand (Rebuild)',
    'post_name'    => 'farmstand-rebuild',
    'post_content' => wp_slash( $content ),
);
if ( $existing ) {
    $postarr['ID'] = $existing->ID;
    $page_id = wp_update_post( $postarr );
} else {
    $page_id = wp_insert_post( $postarr );
}
update_post_meta( $page_id, '_wp_page_template', 'page-visit' );
WP_CLI::success( "farmstand-rebuild page: $page_id (template: page-visit)" );
