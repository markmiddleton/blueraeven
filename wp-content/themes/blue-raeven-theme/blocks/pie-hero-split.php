<?php
/**
 * Pie Hero Split — photo beside navy text panel (Pies page style). Markup
 * mirrors the legacy hand-coded rows exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$image   = get_field( 'image' );
$heading = get_field( 'heading' );
$script  = get_field( 'script' );
$text    = get_field( 'text' );

if ( ! $heading && ! $image ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Pie Hero Split — add a photo and heading.</p>';
    }
    return;
}
?>
<div class="pie-hero-split">
    <div class="pie-hero-split__image">
        <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $image['url'] ) ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" style="width:100%;height:100%;object-fit:cover;">
    </div>
    <div class="pie-hero-split__text">
        <h2><?php echo esc_html( $heading ); ?></h2>
        <div class="script"><?php echo esc_html( $script ); ?></div>
        <p>
            <?php echo esc_html( $text ); ?>
        </p>
    </div>
</div>
