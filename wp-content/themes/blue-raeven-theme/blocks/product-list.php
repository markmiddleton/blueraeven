<?php
/**
 * Product List — cream section with a wide product photo, intro paragraphs,
 * and product cards (Jams & Spreads page style). Markup mirrors the legacy
 * hand-coded rows exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$image      = get_field( 'image' );
$paragraphs = get_field( 'paragraphs' );
$cards      = get_field( 'cards' );

if ( ! $image && ! $paragraphs && ! $cards ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Product List — add a photo, intro paragraphs, and product cards.</p>';
    }
    return;
}

$para_count = is_array( $paragraphs ) ? count( $paragraphs ) : 0;
?>
<section class="section section--cream">
    <div class="container">
<?php if ( $image ) : ?>
        <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $image['url'] ) ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="pies-hero-image">

<?php endif; ?>
<?php foreach ( (array) $paragraphs as $i => $para ) :
    // Last intro paragraph carries extra space before the cards.
    $mb = ( $i === $para_count - 1 ) ? '3rem' : '1.5rem';
    ?>
        <p style="max-width: 900px; margin: 0 auto <?php echo $mb; ?>; font-family: var(--font-body); font-size: 1.1rem; color: var(--charcoal); line-height: 1.8;"><?php echo esc_html( $para['text'] ); ?></p>

<?php endforeach; ?>
<?php if ( $cards ) : ?>
        <div class="pie-cards">
<?php foreach ( $cards as $card ) : ?>
            <div class="pie-card">
                <h3 class="pie-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
                <p class="pie-card__description"><?php echo esc_html( $card['description'] ); ?></p>
            </div>
<?php endforeach; ?>
        </div>
<?php endif; ?>
    </div>
</section>
