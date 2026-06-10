<?php
/**
 * Builds the pies-rebuild page. Run: wp @local eval-file <this>
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

// ---------- P1: page hero ----------
$p1 = br_block( 'page-hero', array(
    'title' => 'Fruit Pies', '_title' => 'field_brph_title',
    'script' => 'Handcrafted With Our Own Oregon Berries', '_script' => 'field_brph_script',
    'variant' => 'wood', '_variant' => 'field_brph_variant',
) );

// ---------- P2: pie hero split ----------
$p2 = br_block( 'pie-hero-split', array(
    'image' => br_att_id( '2026/05/pie-a-la-mode.jpg' ), '_image' => 'field_brph2_image',
    'heading' => 'Blue Raeven Farms', '_heading' => 'field_brph2_heading',
    'script' => 'Fruit-Forward Flavor', '_script' => 'field_brph2_script',
    'text' => 'You can find our pies in the finest local grocery stores, with even more Blue Raeven products on the way. As long as we continue to put quality, character, and family tradition at the heart of everything we make, we know we’ll keep sharing something truly special: farm-raised, handcrafted recipes passed down through generations and, as always, made with a love for what we do.',
    '_text' => 'field_brph2_text',
) );

// ---------- P3: pie card list ----------
$pies = array(
    array( 'Apple', '', 'There’s nothing more traditional than a Blue Raeven apple pie. Blue Raeven’s twist to this American classic uses Washington State grown granny smith apples with a hint of cinnamon and gourmet caramel.' ),
    array( 'Apple Crumb', '', 'Like all our pies, this specialty starts with our famous apple pie recipe and topped with a crumble to remember. The apple base is piled high with our crumb topping, blending oats, brown sugar, flour, and butter.' ),
    array( 'Blue Raeven Berry', 'Blueberry, Boysenberry & Marionberry', 'Our signature pie is a combination of blueberry, boysenberry, and marionberry, all grown on the Blue Raeven family farm. The flavors are rich, complex, and sweet with a perfect hint of tartness.' ),
    array( 'Boysenberry', '', 'A memorable cross between the raspberry, blackberry, dewberry, and loganberry, the boysenberry is a large dark purple berry packed full of juicy flavor. A great pie for those looking for a sweeter profile than marionberry or blackberry.' ),
    array( 'Bumble Berry', 'Blackberry, Blueberry, Raspberry & Rhubarb', 'Originating in Western Massachusetts, this pie combines local, farm-fresh Pacific Northwest blackberries, blueberries, raspberries, and rhubarb. An overwhelming amount of flavor can only be described when enjoying it by the mouthful.' ),
    array( 'Cherry', '', 'Another long time American classic. Our cherry pie uses whole Montmorency cherries with a hint of almond flavor using all-natural almond extract. Locally grown tart cherries, sweetened to perfection.' ),
    array( 'Marionberry', '', 'Considered the “cabernet of blackberries” for their rich, earthy flavor. We grow them here in the heart of Marionberry country, where they thrive in our Willamette Valley soils. Picked at peak ripeness and paired with our famous crust.' ),
    array( 'Oregon Berry', 'Blueberry, Boysenberry, Marionberry, Strawberry & Raspberry', 'Encompassing the famous berries grown in Oregon, this pie offers an explosion of flavor. Tart notes from blackberries and marionberries pair perfectly with sweeter blueberries and strawberries.' ),
    array( 'Peach Raspberry', '', 'This rare gem brings the bright orange of locally grown peaches and deep red whole raspberries, a combination that has quickly become a Blue Raeven customer favorite. Perfect sweetness and unique texture of peaches complement the floral flavor of farm-fresh raspberry.' ),
    array( 'Strawberry Rhubarb', '', 'Northwest strawberries are world-renowned for their unmatched flavor and juiciness. Harvested in June on our farm, we promise a sweeter, juicier strawberry which harmoniously pairs with fresh Washington grown rhubarb.' ),
    array( 'Razzle Dazzle', 'Blueberry, Marionberry & Raspberry', 'Get ready for a slice that truly lives up to its name. Sweet, juicy blueberries mingle with the deep, wine-like richness of marionberries and the bright, tangy pop of raspberries, creating a perfectly balanced blend.' ),
    array( 'Rhubarb', '', 'This classic dessert balances bold tartness with comforting sweetness. Its vibrant filling, made from ruby-red stalks of fresh rhubarb, softens as it bakes into a luscious, slightly tangy compote.' ),
    array( 'Rhubarb Peach', '', 'Meet the pie that tastes like summer in every slice. Sun-ripened sweetness of juicy peaches with the bright, tangy kick of fresh rhubarb. As it bakes, the fruits melt into a perfectly balanced filling—lush, vibrant, and just tart enough.' ),
    array( 'Valleyberry', 'Blackberry, Marionberry & Raspberry', 'Taste the richness of the valley in every bite. A handpicked blend of blackberries, marionberries, and raspberries—each bringing its own bold character to create a perfectly balanced, jammy filling.' ),
);
$p3 = array(
    'sign' => br_att_id( '2026/05/fresh-baked-pies.png' ), '_sign' => 'field_brpcl_sign',
    'cards' => count( $pies ), '_cards' => 'field_brpcl_cards',
);
foreach ( $pies as $i => $pie ) {
    $p3["cards_{$i}_title"]        = $pie[0];
    $p3["_cards_{$i}_title"]       = 'field_brpcl_card_title';
    $p3["cards_{$i}_lead"]         = $pie[1];
    $p3["_cards_{$i}_lead"]        = 'field_brpcl_card_lead';
    $p3["cards_{$i}_description"]  = $pie[2];
    $p3["_cards_{$i}_description"] = 'field_brpcl_card_desc';
}
$p3 = br_block( 'pie-card-list', $p3 );

// ---------- P4: pre-order section ----------
$cats = array(
    array( 'Seasonal', 'Mincemeat • Pecan • Pumpkin • Key Lime' ),
    array( 'Cream Pies', 'Banana Cream • Chocolate Cream • Chocolate Peanut Butter • Coconut Cream • Lemon Meringue • Peanut Butter Cream • Blackberry Cream • Blueberry Cream • Marionberry Cream • Peach Cream • Raspberry Cream' ),
    array( 'Savory Pies', 'Chicken Pot Pie • Beef Pot Pie • Turkey Pot Pie • Veggie Quiche • Crab Pot Pie' ),
);
$p4 = array(
    'heading' => 'Available at Farmstand Only', '_heading' => 'field_brpo_heading',
    'script' => 'Pre-Order & Pick Up', '_script' => 'field_brpo_script',
    'categories' => count( $cats ), '_categories' => 'field_brpo_categories',
    'btn_label' => 'Visit the Farmstand', '_btn_label' => 'field_brpo_btn_label',
    'btn_url' => '/farmstand/', '_btn_url' => 'field_brpo_btn_url',
);
foreach ( $cats as $i => $c ) {
    $p4["categories_{$i}_label"]  = $c[0];
    $p4["_categories_{$i}_label"] = 'field_brpo_cat_label';
    $p4["categories_{$i}_items"]  = $c[1];
    $p4["_categories_{$i}_items"] = 'field_brpo_cat_items';
}
$p4 = br_block( 'preorder-section', $p4 );

// ---------- assemble page ----------
$content = implode( "\n\n", array( $p1, $p2, $p3, $p4 ) );
$existing = get_page_by_path( 'pies-rebuild' );
$postarr = array(
    'post_type'    => 'page',
    'post_status'  => 'publish',
    'post_title'   => 'Pies (Rebuild)',
    'post_name'    => 'pies-rebuild',
    'post_content' => wp_slash( $content ),
);
if ( $existing ) {
    $postarr['ID'] = $existing->ID;
    $page_id = wp_update_post( $postarr );
} else {
    $page_id = wp_insert_post( $postarr );
}
WP_CLI::success( "pies-rebuild page: $page_id" );
