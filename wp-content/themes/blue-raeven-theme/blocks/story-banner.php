<?php
/**
 * Story Banner block.
 *
 * Full-width photo banner with title, script subhead, and optional CTA.
 * Markup intentionally mirrors the legacy hand-coded rows character for
 * character (see MIGRATION-PLAN.md) — do not "tidy" the HTML.
 *
 * @package Blue_Raeven
 */

$bg_image    = get_field( 'bg_image' );
$title       = get_field( 'title' );
$subhead     = get_field( 'subhead' );
$cta_label   = get_field( 'cta_label' );
$cta_url     = get_field( 'cta_url' );
$open_style  = get_field( 'open_style' );
$show_spacer = get_field( 'show_spacer' );

// Editor placeholder when nothing is configured yet.
if ( ! $bg_image && ! $title ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Story Banner — choose a background photo and add a title.</p>';
    }
    return;
}

// Path-relative URL to stay environment-portable (matches legacy markup style).
$bg_url  = $bg_image ? wp_make_link_relative( $bg_image ) : '';
$classes = 'story-banner' . ( $open_style ? ' story-banner--open' : '' );

if ( $show_spacer ) : ?>
<div class="story-banner-spacer" aria-hidden="true"></div>
<?php endif; ?>
<section class="<?php echo esc_attr( $classes ); ?>" style="background-image: url('<?php echo esc_url( $bg_url ); ?>');">
    <div class="story-banner__box">
        <h2 class="story-banner__title"><?php echo esc_html( $title ); ?></h2>
<?php if ( $subhead ) : ?>
        <p class="story-banner__subhead"><?php echo esc_html( $subhead ); ?></p>
<?php endif; ?>
<?php if ( $cta_label && $cta_url ) : ?>
        <a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn--primary"><?php echo esc_html( $cta_label ); ?></a>
<?php endif; ?>
    </div>
</section>
