<?php
/**
 * Page Hero block — wood-texture headline banner used at the top of inner
 * pages. Markup mirrors the legacy hand-coded rows (see MIGRATION-PLAN.md).
 * The old navy/wood toggle was removed: both variants rendered identically
 * in the CSS, so the hero always uses the wood-texture background.
 *
 * @package Blue_Raeven
 */

$title  = get_field( 'title' );
$script = get_field( 'script' );

if ( ! $title ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Page Hero — add a page title.</p>';
    }
    return;
}
?>
<div class="page-hero page-hero--wood">
    <div class="container">
        <h1 class="page-hero__title"><?php echo esc_html( $title ); ?></h1>
<?php if ( $script ) : ?>
        <p class="page-hero__script"><?php echo nl2br( esc_html( $script ) ); ?></p>
<?php endif; ?>
        <div class="page-hero__divider"></div>
    </div>
</div>
