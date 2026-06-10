<?php
/**
 * Story Block — framed photo + prose 50/50 (Our Story page style).
 * Normal: photo left. Reverse: text left via the legacy direction:rtl trick.
 * Markup mirrors the legacy hand-coded rows exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$heading    = get_field( 'heading' );
$image      = get_field( 'image' );
$reverse    = get_field( 'reverse' );
$paragraphs = get_field( 'paragraphs' );

if ( ! $heading && ! $paragraphs ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Story Block — add a heading and paragraphs.</p>';
    }
    return;
}

$img_url = $image ? wp_make_link_relative( $image['url'] ) : '';

ob_start(); ?>
                <h3><?php echo nl2br( esc_html( $heading ) ); ?></h3>
<?php foreach ( (array) $paragraphs as $para ) :
    if ( $para['strong'] ) : ?>
                <p><strong><?php echo esc_html( $para['text'] ); ?></strong></p>
<?php else : ?>
                <p>
                    <?php echo esc_html( $para['text'] ); ?>
                </p>
<?php endif;
endforeach;
$text_html = ob_get_clean();

ob_start(); ?>
                <div class="story__image-frame">
                    <img decoding="async" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $image['alt'] ?? '' ); ?>">
                </div>
                <div class="story__frame-accent"></div>
<?php $image_html = ob_get_clean();
?>
<section class="section">
    <div class="container">
<?php if ( $reverse ) : ?>
        <div class="story" style="direction: rtl;">
            <div style="direction: ltr;">
                <div class="story__text">
<?php echo $text_html; ?>
                </div>
            </div>
            <div style="direction: ltr;">
                <div class="story__image-wrap">
<?php echo $image_html; ?>
                </div>
            </div>
        </div>
<?php else : ?>
        <div class="story">
            <div class="story__image-wrap">
<?php echo $image_html; ?>
            </div>
            <div class="story__text">
<?php echo $text_html; ?>
            </div>
        </div>
<?php endif; ?>
    </div>
</section>
