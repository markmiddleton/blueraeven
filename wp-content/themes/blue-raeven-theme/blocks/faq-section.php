<?php
/**
 * FAQ Section — standalone cream FAQ list (Contact page style). Markup
 * mirrors the legacy hand-coded rows exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$title  = get_field( 'title' );
$anchor = get_field( 'anchor' );
$faqs   = get_field( 'faqs' );

if ( ! $faqs ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">FAQ Section — add questions.</p>';
    }
    return;
}
?>
<section class="section section--cream">
    <div class="container container--narrow">
        <div<?php echo $anchor ? ' id="' . esc_attr( $anchor ) . '"' : ''; ?> class="faq-section">
            <h2 class="faq-section__title"><?php echo esc_html( $title ); ?></h2>

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
    </div>
</section>
