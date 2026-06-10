<?php
/**
 * Contact Methods — torn-paper cards for visit/call/email (Contact page
 * style). Markup mirrors the legacy hand-coded rows exactly (see
 * MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$cards = get_field( 'cards' );

if ( ! $cards ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Contact Methods — add method cards.</p>';
    }
    return;
}
?>
<section class="section">
    <div class="container">
        <div class="contact-methods">
<?php foreach ( $cards as $card ) : ?>
            <div class="contact-method">
                <div class="contact-method__title"><?php echo esc_html( $card['title'] ); ?></div>
                <div class="contact-method__text">
                    <?php echo esc_html( $card['line1'] ); ?><br>
                    <?php echo esc_html( $card['line2'] ); ?><br>
                    <a href="<?php echo esc_url( $card['link_url'] ); ?>"><?php echo esc_html( $card['link_label'] ); ?></a>
                </div>
            </div>
<?php endforeach; ?>
        </div>
    </div>
</section>
