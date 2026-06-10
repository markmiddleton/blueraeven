<?php
/**
 * Testimonial — wood-background centered quote. Markup mirrors the legacy
 * hand-coded rows exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$quote  = get_field( 'quote' );
$author = get_field( 'author' );

if ( ! $quote ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Testimonial — add a quote.</p>';
    }
    return;
}
?>
<section class="section--wood" style="padding: 4rem 0; width: 100%;">
    <div class="container" style="display: flex; justify-content: center; padding: 0 2rem;">
        <div class="testimonial" style="max-width: 700px; text-align: center;">
            <p class="testimonial__quote">
                <?php echo esc_html( $quote ); ?>
            </p>
            <div class="testimonial__author"><?php echo esc_html( $author ); ?></div>
        </div>
    </div>
</section>
