<?php
/**
 * Find Cards — cream section with 3-up image cards (Farmstand "What You'll
 * Find" style). Markup mirrors the legacy hand-coded rows exactly (see
 * MIGRATION-PLAN.md). Note: the section script line here is a <div>, not a
 * <p>, matching the legacy markup.
 *
 * @package Blue_Raeven
 */

$label  = get_field( 'label' );
$title  = get_field( 'title' );
$script = get_field( 'script' );
$cards  = get_field( 'cards' );

if ( ! $cards ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Find Cards — add cards.</p>';
    }
    return;
}
?>
<section class="section section--cream">
    <div class="container">
        <div class="section__header">
            <div class="section__label"><?php echo esc_html( $label ); ?></div>
            <h2 class="section__title"><?php echo esc_html( $title ); ?></h2>
            <div class="section__script"><?php echo esc_html( $script ); ?></div>
            <div class="section__divider"></div>
        </div>
        <div class="what-youll-find">
<?php foreach ( $cards as $card ) : ?>
            <div class="find-card">
                <div class="find-card__image">
                    <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $card['image']['url'] ) ); ?>" alt="<?php echo esc_attr( $card['image']['alt'] ); ?>" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="find-card__body">
                    <h3 class="find-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
                    <p class="find-card__desc"><?php echo esc_html( $card['desc'] ); ?></p>
                </div>
            </div>
<?php endforeach; ?>
        </div>
    </div>
</section>
