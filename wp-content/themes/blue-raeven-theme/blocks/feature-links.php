<?php
/**
 * Feature Links — icon cards linking to other pages (Our Story page style).
 * Markup mirrors the legacy hand-coded rows exactly (see MIGRATION-PLAN.md).
 * The icon's alt text intentionally repeats the card title, as the legacy
 * markup did.
 *
 * @package Blue_Raeven
 */

$features = get_field( 'features' );

if ( ! $features ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Feature Links — add feature cards.</p>';
    }
    return;
}
?>
<section class="section" style="padding: 2rem 0 3rem;">
    <div class="container">
        <div class="features">
<?php foreach ( $features as $f ) : ?>
            <a href="<?php echo esc_url( $f['url'] ); ?>" class="feature">
                <div class="feature__icon">
                    <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $f['icon']['url'] ) ); ?>" alt="<?php echo esc_attr( $f['title'] ); ?>">
                </div>
                <div class="feature__title"><?php echo esc_html( $f['title'] ); ?></div>
                <div class="feature__desc"><?php echo esc_html( $f['desc'] ); ?></div>
            </a>
<?php endforeach; ?>
        </div>
    </div>
</section>
