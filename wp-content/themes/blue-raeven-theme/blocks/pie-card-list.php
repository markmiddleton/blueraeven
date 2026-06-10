<?php
/**
 * Pie Card List — cream section with hanging sign and pie description cards
 * (Pies page style). Markup mirrors the legacy hand-coded rows exactly
 * (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$sign  = get_field( 'sign' );
$cards = get_field( 'cards' );

if ( ! $cards ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Pie Card List — add pies.</p>';
    }
    return;
}
?>
<section class="section section--cream">
    <div class="container">
        <div class="pies-listing">
            <div class="pies-listing__sign">
                <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $sign['url'] ) ); ?>" alt="<?php echo esc_attr( $sign['alt'] ); ?>">
            </div>
            <div class="pie-cards">
<?php
$card_count = count( $cards );
foreach ( $cards as $i => $card ) :
    ?>
                <div class="pie-card">
                    <h3 class="pie-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
<?php if ( $card['lead'] ) : ?>
                    <p class="pie-card__description"><em><?php echo esc_html( $card['lead'] ); ?></em> — <?php echo esc_html( $card['description'] ); ?></p>
<?php else : ?>
                    <p class="pie-card__description"><?php echo esc_html( $card['description'] ); ?></p>
<?php endif; ?>
                </div>
<?php if ( $i < $card_count - 1 ) : ?>

<?php endif;
endforeach; ?>
            </div>
        </div>
    </div>
</section>
