<?php
/**
 * Category List — cream section with intro, categorized item lists, and a
 * CTA button (Other Confections page style). Markup mirrors the legacy
 * hand-coded rows exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$intro      = get_field( 'intro' );
$categories = get_field( 'categories' );
$btn_label  = get_field( 'btn_label' );
$btn_url    = get_field( 'btn_url' );

if ( ! $intro && ! $categories ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Category List — add an intro and categories.</p>';
    }
    return;
}
?>
<section class="section section--cream">
    <div class="container" style="max-width: 900px;">
<?php if ( $intro ) : ?>
        <p style="margin-bottom: 3rem; font-family: var(--font-body); font-size: 1.1rem; color: var(--charcoal); line-height: 1.7;"><?php echo esc_html( $intro ); ?></p>

<?php endif; ?>
        <div class="confections-list">
<?php foreach ( (array) $categories as $cat ) : ?>
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--font-display); font-size: 1.8rem; color: var(--navy); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem;"><?php echo esc_html( $cat['heading'] ); ?></h2>
<?php if ( $cat['note'] ) : ?>
                <p style="font-family: var(--font-body); color: var(--charcoal); line-height: 1.8; margin-bottom: 0.5rem;"><?php echo esc_html( $cat['items'] ); ?></p>
                <p style="font-family: var(--font-body); color: var(--charcoal); font-style: italic;"><?php echo esc_html( $cat['note'] ); ?></p>
<?php else : ?>
                <p style="font-family: var(--font-body); color: var(--charcoal); line-height: 1.8;"><?php echo esc_html( $cat['items'] ); ?></p>
<?php endif; ?>
            </div>

<?php endforeach; ?>
        </div>

<?php if ( $btn_label && $btn_url ) : ?>
        <div style="margin-top: 2rem;">
            <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn--berry" style="font-family: var(--font-display); text-transform: uppercase; padding: 1rem 2.5rem; font-size: 1.1rem;"><?php echo esc_html( $btn_label ); ?></a>
        </div>
<?php endif; ?>
    </div>
</section>
