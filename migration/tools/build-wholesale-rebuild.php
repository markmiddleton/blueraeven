<?php
/**
 * Builds the wholesale-rebuild page: copies the original page's native
 * blocks verbatim and replaces its two raw wp:html islands (page hero,
 * download grid) with ACF component blocks. Run: wp @local eval-file <this>
 */

function br_block( $name, $data ) {
    return '<!-- wp:acf/' . $name . ' ' . json_encode(
        array( 'name' => 'acf/' . $name, 'data' => $data, 'mode' => 'edit' ),
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    ) . ' /-->';
}

$hero = br_block( 'page-hero', array(
    'title' => 'Wholesale & Fundraising', '_title' => 'field_brph_title',
    'script' => 'Crafted With Care. Ready for Your Stores.', '_script' => 'field_brph_script',
    'variant' => 'wood', '_variant' => 'field_brph_variant',
) );

$downloads = array(
    array( 311, 'pdf', 'Individual Order Form', 'Printable form for collecting individual pie orders.' ),
    array( 312, 'excel', 'Online Order Template', 'Excel spreadsheet for collecting orders digitally.' ),
    array( 313, 'excel', 'Order Tally Sheet', 'Template to compile orders and calculate totals.' ),
);
$grid = array( 'cards' => count( $downloads ), '_cards' => 'field_brdg_cards' );
foreach ( $downloads as $i => $d ) {
    $grid["cards_{$i}_file"]   = $d[0];
    $grid["_cards_{$i}_file"]  = 'field_brdg_file';
    $grid["cards_{$i}_icon"]   = $d[1];
    $grid["_cards_{$i}_icon"]  = 'field_brdg_icon';
    $grid["cards_{$i}_title"]  = $d[2];
    $grid["_cards_{$i}_title"] = 'field_brdg_title';
    $grid["cards_{$i}_desc"]   = $d[3];
    $grid["_cards_{$i}_desc"]  = 'field_brdg_desc';
}
$grid = br_block( 'download-grid', $grid );

$orig = get_post( 53 )->post_content;

// Replace the two wp:html islands in order: 1st = hero, 2nd = download grid.
$replacements = array( $hero, $grid );
$n = 0;
$content = preg_replace_callback(
    '/<!-- wp:html -->.*?<!-- \/wp:html -->/s',
    function () use ( &$n, $replacements ) {
        return $replacements[ $n++ ] ?? '';
    },
    $orig
);

if ( 2 !== $n ) {
    WP_CLI::error( "Expected 2 wp:html islands, replaced $n" );
}

$existing = get_page_by_path( 'wholesale-rebuild' );
$postarr = array(
    'post_type'    => 'page',
    'post_status'  => 'publish',
    'post_title'   => 'Wholesale & Fundraising (Rebuild)',
    'post_name'    => 'wholesale-rebuild',
    'post_content' => wp_slash( $content ),
);
if ( $existing ) {
    $postarr['ID'] = $existing->ID;
    $page_id = wp_update_post( $postarr );
} else {
    $page_id = wp_insert_post( $postarr );
}
WP_CLI::success( "wholesale-rebuild page: $page_id (replaced $n islands)" );
