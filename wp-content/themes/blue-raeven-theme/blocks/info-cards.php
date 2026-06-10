<?php
/**
 * Location Info Cards — torn-paper location cards with address, hours, and
 * phone (Farmstand "Come Visit Us" style). Markup mirrors the legacy
 * hand-coded rows exactly (see MIGRATION-PLAN.md) — including the precise
 * <br> structure inside each card.
 *
 * @package Blue_Raeven
 */

$title  = get_field( 'title' );
$script = get_field( 'script' );
$intro  = get_field( 'intro' );
$cards  = get_field( 'cards' );

if ( ! $cards ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Location Info Cards — add a location.</p>';
    }
    return;
}
?>
<section class="section">
    <div class="container">
        <div class="section__header" style="margin-bottom: 1.5rem;">
            <h2 class="section__title"><?php echo esc_html( $title ); ?></h2>
            <p class="section__script"><?php echo esc_html( $script ); ?></p>
        </div>
        <p style="color:var(--text-secondary); font-size:1.05rem; line-height:1.8; margin-bottom:2.5rem; max-width:800px; margin-left:auto; margin-right:auto;">
            <?php echo esc_html( $intro ); ?>
        </p>
        <div class="farmstand-grid">
<?php foreach ( $cards as $card ) :
    $hours_lines = array_values( array_filter( array_map( 'trim', explode( "\n", (string) $card['hours'] ) ), 'strlen' ) );
    $hours_count = count( $hours_lines );
    ?>
            <div class="info-block">
                <div class="info-block__title"><?php echo nl2br( esc_html( $card['title'] ) ); ?></div>
                <div class="info-block__text">
                    <strong><?php echo nl2br( esc_html( $card['address'] ) ); ?></strong><br><br>
<?php foreach ( $hours_lines as $i => $line ) :
    $tail = ( $i === $hours_count - 1 ) ? '<br><br>' : '<br>';
    ?>
                    <?php echo esc_html( $line ) . $tail . "\n"; ?>
<?php endforeach; ?>
                    <a href="tel:<?php echo esc_attr( $card['tel'] ); ?>"><?php echo esc_html( $card['phone'] ); ?></a>
                </div>
            </div>
<?php endforeach; ?>
        </div>
    </div>
</section>
