<?php
/**
 * CUTOVER (local): copy each validated rebuild page's block content into the
 * original page (preserving IDs, slugs, templates, menus, front-page setting).
 * Run: wp @local eval-file <this>
 */

$map = array(
    // rebuild slug            => original page ID
    'home-rebuild'              => 4,
    'story-rebuild'             => 5,
    'our-berries-rebuild'       => 82,
    'farmstand-rebuild'         => 7,
    'contact-rebuild'           => 8,
    'pies-rebuild'              => 49,
    'jams-spreads-rebuild'      => 50,
    'other-confections-rebuild' => 51,
    'baking-rebuild'            => 52,
    'wholesale-rebuild'         => 53,
);

foreach ( $map as $rebuild_slug => $orig_id ) {
    $rebuild = get_page_by_path( $rebuild_slug );
    if ( ! $rebuild ) {
        WP_CLI::error( "Missing rebuild page: $rebuild_slug" );
    }
    $orig = get_post( $orig_id );
    if ( ! $orig ) {
        WP_CLI::error( "Missing original page: $orig_id" );
    }
    $result = wp_update_post( array(
        'ID'           => $orig_id,
        'post_content' => wp_slash( $rebuild->post_content ),
    ), true );
    if ( is_wp_error( $result ) ) {
        WP_CLI::error( "Update failed for $orig_id: " . $result->get_error_message() );
    }
    WP_CLI::log( sprintf( '%-28s -> #%d %s', $rebuild_slug, $orig_id, $orig->post_name ) );
}

WP_CLI::success( 'All 10 original pages now use block-component content.' );
