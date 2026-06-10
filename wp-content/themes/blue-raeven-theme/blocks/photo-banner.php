<?php
/**
 * Photo Banner — full-width image strip. Markup mirrors the legacy
 * hand-coded rows exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$image = get_field( 'image' );

if ( ! $image ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Photo Banner — choose a photo.</p>';
    }
    return;
}
?>
<div class="photo-banner">
    <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $image['url'] ) ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
</div>
