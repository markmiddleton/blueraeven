<?php
/**
 * Builds the story-rebuild page from component blocks, populating field data
 * with attachment IDs looked up by uploads path. Run: wp @local eval-file <this>
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

// ---------- S1: page hero ----------
$s1 = br_block( 'page-hero', array(
    'title' => 'Our Story', '_title' => 'field_brph_title',
    'script' => "Our Family, Our Farm,\nOur Pie Tradition", '_script' => 'field_brph_script',
    'variant' => 'navy', '_variant' => 'field_brph_variant',
) );

// ---------- S2: photo banner ----------
$s2 = br_block( 'photo-banner', array(
    'image' => br_att_id( '2026/04/farm_banner.jpg' ), '_image' => 'field_brpb_image',
) );

// ---------- S3: story intro ----------
$s3_paras = array(
    'Our story began on a 4th generation family farm in Amity, Oregon, where Ron and Jamie Lewis have been working to build their legacy in the Willamette Valley since 1987, growing the kind of fruit that tastes like sunshine, rain, and hard work all at once. We grow with richer soil, gentler skies, and a level of care that we know will produce the most flavorful, juicy, and abundant fruit that makes Oregon famous.',
    'The Lewis family strives at growing high quality Oregon berries, including blueberries, boysenberries, marionberries (a celebrated regional favorite), blackberries, tayberries (yeah, we’ve linked that one for you to explore), and the heralded Oregon strawberry. If we need a specialty Northwest fruit that we don’t grow, we turn to nearby growers to source locally.',
    'In 2007, we decided that the best use for our family-grown fruit was to create delicious, hand-crafted pies. We believe a great pie starts with great local fruit. What better way to share our craft than hand make fresh pies filled with the berries we’ve nurtured from the ground up.',
);
$s3 = array(
    'heading' => "Our Family, Our Farm,\nOur Pie Tradition", '_heading' => 'field_brstb_heading',
    'image' => br_att_id( '2026/04/farm_photo.jpg' ), '_image' => 'field_brstb_image',
    'reverse' => '0', '_reverse' => 'field_brstb_reverse',
    'paragraphs' => count( $s3_paras ), '_paragraphs' => 'field_brstb_paragraphs',
);
foreach ( $s3_paras as $i => $p ) {
    $s3["paragraphs_{$i}_text"]    = $p;
    $s3["_paragraphs_{$i}_text"]   = 'field_brstb_para_text';
    $s3["paragraphs_{$i}_strong"]  = '0';
    $s3["_paragraphs_{$i}_strong"] = 'field_brstb_para_strong';
}
$s3 = br_block( 'story-block', $s3 );

// ---------- S4: timeline ----------
$tl_items = array(
    array(
        'Raevenbrook Farms Take Root 1928',
        'The farm traces back generations in the Willamette Valley when the Deraeves family started their legacy in Amity, Oregon. From that moment on, each generation was raised on the same principles—hard work, stewardship of the land, and a deep belief in family traditions.',
        array( array( '2024/timeline/planting-roots-family.jpg', 'crop-top' ), array( '2024/timeline/planting-roots-kids.jpg', '' ) ),
    ),
    array(
        'Blueberry Fields Planted 1987',
        'Ronald and Jamie Lewis, third-generation farmers, continued the Raevenbrook Farm legacy, planting the first blueberry field. Since then, the farm has blossomed into more than 130 acres of blueberries, boysenberries, marionberries, blackberries, tayberries, strawberries, apples, and peaches.',
        array( array( '2024/timeline/raevenbrook-sign.png', '' ), array( '2024/timeline/raevenbrook-field.jpg', '' ) ),
    ),
    array(
        'Pies Introduced at Farmstand 2007',
        'Blue Raeven Pie Company was born. Because Ronald and Jamie remain deeply involved in every part of the growing process, they wanted to find the highest and best use for their fruit—building from their family recipes to create hand-crafted pies.',
        array( array( '2024/timeline/farmstand-building.jpg', '' ), array( '2024/timeline/ronald-icecream.jpg', 'crop-top' ) ),
    ),
    array(
        'Pies Expand 2016',
        'As more people fell in love with our pies and a new generation stepped into the business, Blue Raeven moved into a dedicated commercial kitchen. We now bake thousands of pies each week, but every pie is still rolled, filled, and baked with the same care you’d find in our own family kitchen.',
        array( array( '2024/timeline/store-demo.jpg', '' ), array( '2024/timeline/kitchen-workers.jpg', '' ) ),
    ),
    array(
        'Jams and More 2026',
        'We were finally certified to share our old-world jam and fruit spread recipes with wholesale partners. Our jams can now be found beyond our farmstands and in the stores you love.',
        array(),
    ),
    array(
        'Today',
        'With our third and fourth generations working side by side, we’re now welcoming the fifth generation into the joys of family farming. The littles wander the fields, pick berries straight from the vine, and savor the fruits of our labor one pie at a time.',
        array( array( '2024/timeline/child-picking-berries.jpg', '' ), array( '2024/timeline/family-barn.jpg', 'crop-bottom' ) ),
    ),
);
$s4 = array(
    'label' => 'Our Journey', '_label' => 'field_brtl_label',
    'title' => 'A Flavorful History', '_title' => 'field_brtl_title',
    'script' => 'Growing together, season by season', '_script' => 'field_brtl_script',
    'items' => count( $tl_items ), '_items' => 'field_brtl_items',
);
foreach ( $tl_items as $i => $item ) {
    $s4["items_{$i}_year_title"]  = $item[0];
    $s4["_items_{$i}_year_title"] = 'field_brtl_item_year';
    $s4["items_{$i}_text"]        = $item[1];
    $s4["_items_{$i}_text"]       = 'field_brtl_item_text';
    $s4["items_{$i}_images"]      = count( $item[2] );
    $s4["_items_{$i}_images"]     = 'field_brtl_item_images';
    foreach ( $item[2] as $j => $img ) {
        $s4["items_{$i}_images_{$j}_image"]  = br_att_id( $img[0] );
        $s4["_items_{$i}_images_{$j}_image"] = 'field_brtl_img_image';
        $s4["items_{$i}_images_{$j}_crop"]   = $img[1];
        $s4["_items_{$i}_images_{$j}_crop"]  = 'field_brtl_img_crop';
    }
}
$s4 = br_block( 'timeline', $s4 );

// ---------- S5: pies fix everything (reverse story block) ----------
$s5_paras = array(
    array( 'Every pie begins long before it reaches your table. It starts in the fields, where we choose varieties for flavor, not production. We harvest berries between June and September at peak ripeness and freeze the fruit to lock in flavor and juiciness to make pies year-round.', '0' ),
    array( 'The care and passion continue in our pie facility, where we follow family recipes, sharing the family traditions we hold dear. Each crust is rolled and every filling is made with the same care we’d use for our own family.', '0' ),
    array( 'We’ve grown slowly and sustainably to serve our community but more and more of you keep asking for our pies for your table. If you buy a pie at our farmstand or pick one up from a grocery store, we expect each to be equally delightful. That doesn’t happen without a focus on consistency, the right ingredients, and careful delivery.', '0' ),
    array( 'As our team has grown, we still show up early, work hard, and treat everyone as an extension of our own family. We believe in supporting our neighbors, honoring our roots, and sharing the kind of pie goodness that brings people closer.', '0' ),
    array( 'And we hold one truth above all: pies fix everything. Pies mend a tough day, sweeten special moments, and remind us that the best things in life are made with care, shared with love, and enjoyed together.', '0' ),
    array( 'Enjoy our pie and welcome to our family.', '1' ),
    array( '— The Lewis Family', '1' ),
);
$s5 = array(
    'heading' => 'Pies Fix Everything', '_heading' => 'field_brstb_heading',
    'image' => br_att_id( '2026/04/pie-fixes-everything.jpg' ), '_image' => 'field_brstb_image',
    'reverse' => '1', '_reverse' => 'field_brstb_reverse',
    'paragraphs' => count( $s5_paras ), '_paragraphs' => 'field_brstb_paragraphs',
);
foreach ( $s5_paras as $i => $p ) {
    $s5["paragraphs_{$i}_text"]    = $p[0];
    $s5["_paragraphs_{$i}_text"]   = 'field_brstb_para_text';
    $s5["paragraphs_{$i}_strong"]  = $p[1];
    $s5["_paragraphs_{$i}_strong"] = 'field_brstb_para_strong';
}
$s5 = br_block( 'story-block', $s5 );

// ---------- S6: gallery mosaic ----------
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
$s6 = br_block( 'gallery-mosaic', array(
    'label' => 'Life on the Farm', '_label' => 'field_brgm_label',
    'title' => 'Our Fields & Family', '_title' => 'field_brgm_title',
    'tiles' => $tiles, '_tiles' => 'field_brgm_tiles',
    'pool' => $pool, '_pool' => 'field_brgm_pool',
    'swap_ms' => 3500, '_swap_ms' => 'field_brgm_swap_ms',
    'fade_ms' => 900, '_fade_ms' => 'field_brgm_fade_ms',
    'anchor' => 'storyGallery', '_anchor' => 'field_brgm_anchor',
) );

// ---------- S7: feature links ----------
$features = array(
    array( '/pies-more/', '2026/06/our-pies.png', 'Handcrafted Pies', 'Small-batch baked daily with time-honored family recipes.' ),
    array( '/farmstand/', '2026/06/where-to-buy.png', 'Where to Buy', 'Find our pies at the farm stand and select local retailers.' ),
);
$s7 = array(
    'features' => count( $features ), '_features' => 'field_brfl_features',
);
foreach ( $features as $i => $f ) {
    $s7["features_{$i}_url"]    = $f[0];
    $s7["_features_{$i}_url"]   = 'field_brfl_url';
    $s7["features_{$i}_icon"]   = br_att_id( $f[1] );
    $s7["_features_{$i}_icon"]  = 'field_brfl_icon';
    $s7["features_{$i}_title"]  = $f[2];
    $s7["_features_{$i}_title"] = 'field_brfl_title';
    $s7["features_{$i}_desc"]   = $f[3];
    $s7["_features_{$i}_desc"]  = 'field_brfl_desc';
}
$s7 = br_block( 'feature-links', $s7 );

// ---------- S8: testimonial ----------
$s8 = br_block( 'testimonial', array(
    'quote'  => 'The best berry pie I’ve ever tasted. You can tell it’s made with love and the freshest fruit imaginable. A true Oregon treasure.',
    '_quote' => 'field_brts_quote',
    'author' => 'A Happy Customer • Portland, OR',
    '_author' => 'field_brts_author',
) );

// ---------- assemble page ----------
$content = implode( "\n\n", array( $s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8 ) );
$existing = get_page_by_path( 'story-rebuild' );
$postarr = array(
    'post_type'    => 'page',
    'post_status'  => 'publish',
    'post_title'   => 'Our Story (Rebuild)',
    'post_name'    => 'story-rebuild',
    'post_content' => wp_slash( $content ),
);
if ( $existing ) {
    $postarr['ID'] = $existing->ID;
    $page_id = wp_update_post( $postarr );
} else {
    $page_id = wp_insert_post( $postarr );
}
update_post_meta( $page_id, '_wp_page_template', 'page-story' );
WP_CLI::success( "story-rebuild page: $page_id (template: page-story)" );
