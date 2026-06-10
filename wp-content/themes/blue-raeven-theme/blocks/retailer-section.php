<?php
/**
 * Retailer Section — gold section listing grocery retailers and area
 * farmstands (Farmstand page style). Markup mirrors the legacy hand-coded
 * rows exactly (see MIGRATION-PLAN.md).
 *
 * The intro paragraph is a WYSIWYG field (basic toolbar) — wpautop wraps it
 * in <p> so existing plain values and editor-saved values render the same.
 * Its styling lives in .retailer-section__intro CSS, so editor-added links
 * inherit the brand berry colour. Everything else is escaped.
 *
 * @package Blue_Raeven
 */

$title      = get_field( 'title' );
$script     = get_field( 'script' );
$intro      = get_field( 'intro' );
$retailers  = get_field( 'retailers' );
$sub_title  = get_field( 'sub_title' );
$farmstands = get_field( 'farmstands' );

if ( ! $retailers ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Retailer Section — add retailers.</p>';
    }
    return;
}

$fs_names = array();
foreach ( (array) $farmstands as $fs ) {
    $fs_names[] = esc_html( $fs['name'] );
}
?>
<section class="section section--gold-light">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title"><?php echo esc_html( $title ); ?></h2>
            <p class="section__script"><?php echo esc_html( $script ); ?></p>
            <div class="section__divider"></div>
        </div>
        <div class="retailer-section__intro">
            <?php echo wpautop( $intro ); // phpcs:ignore WordPress.Security.EscapeOutput — WYSIWYG content ?>
        </div>
        <div class="retailer-list">
<?php foreach ( $retailers as $r ) : ?>
            <a href="<?php echo esc_url( $r['url'] ); ?>" target="_blank" rel="noopener" class="retailer-link"><?php echo esc_html( $r['name'] ); ?></a>
<?php endforeach; ?>
        </div>
<?php if ( $sub_title && $fs_names ) : ?>
        <p style="text-align:center; margin:4rem 0 0.75rem; font-family:var(--font-script); color:var(--berry); font-size:clamp(2.8rem, 5vw, 3.6rem);"><?php echo esc_html( $sub_title ); ?></p>
        <p style="text-align:center; max-width:900px; margin:0 auto; color:var(--charcoal); font-size:1rem; line-height:1.9;"><?php echo implode( ' · ', $fs_names ); ?></p>
<?php endif; ?>
    </div>
</section>
