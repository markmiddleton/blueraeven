<?php
/**
 * Instruction Cards + FAQs — cream section with image instruction cards and
 * an FAQ list (Baking Instructions page style). Markup mirrors the legacy
 * hand-coded rows exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$cards      = get_field( 'cards' );
$faq_anchor = get_field( 'faq_anchor' );
$faq_title  = get_field( 'faq_title' );
$faqs       = get_field( 'faqs' );

if ( ! $cards && ! $faqs ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Instruction Cards + FAQs — add a card or a question.</p>';
    }
    return;
}
?>
<section class="section section--cream">
    <div class="container container--narrow">

<?php foreach ( (array) $cards as $card ) : ?>
        <div<?php echo $card['anchor'] ? ' id="' . esc_attr( $card['anchor'] ) . '"' : ''; ?> class="instructions-card instructions-card--with-image">
            <div class="instructions-card__image">
                <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $card['image']['url'] ) ); ?>" alt="<?php echo esc_attr( $card['image']['alt'] ); ?>">
            </div>
            <div class="instructions-card__content">
                <h2 class="instructions-card__title"><?php echo esc_html( $card['title'] ); ?></h2>
                <p class="instructions-card__subtitle"><?php echo esc_html( $card['subtitle'] ); ?></p>

                <ul class="instructions-list">
<?php foreach ( (array) $card['steps'] as $step ) : ?>
                    <li><?php echo esc_html( $step['text'] ); ?></li>
<?php endforeach; ?>
                </ul>
            </div>
        </div>

<?php endforeach; ?>
<?php if ( $faqs ) : ?>
        <div<?php echo $faq_anchor ? ' id="' . esc_attr( $faq_anchor ) . '"' : ''; ?> class="faq-section">
            <h2 class="faq-section__title"><?php echo esc_html( $faq_title ); ?></h2>

<?php foreach ( $faqs as $faq ) : ?>
            <div class="faq-item faq-item--open">
                <div class="faq-item__question"><?php echo esc_html( $faq['question'] ); ?></div>
                <div class="faq-answer">
                    <div>
                        <p><?php echo esc_html( $faq['answer'] ); ?></p>
                    </div>
                </div>
            </div>

<?php endforeach; ?>
        </div>
<?php endif; ?>

    </div>
</section>
