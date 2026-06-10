<?php
/**
 * Directions Split — Google Maps embed beside directions text (Farmstand
 * style). Markup mirrors the legacy hand-coded rows exactly (see
 * MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$map_src    = get_field( 'map_src' );
$heading    = get_field( 'heading' );
$paragraphs = get_field( 'paragraphs' );
$address    = get_field( 'address' );

if ( ! $map_src && ! $heading ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Directions Split — add a map embed URL and heading.</p>';
    }
    return;
}
?>
<div class="directions-split">
    <div class="directions-split__map">
        <iframe src="<?php echo esc_url( $map_src ); ?>" width="100%" height="100%" style="border:0;min-height:400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="directions-split__text">
        <h3><?php echo esc_html( $heading ); ?></h3>
<?php foreach ( (array) $paragraphs as $para ) : ?>
        <p>
            <?php echo esc_html( $para['text'] ); ?>
        </p>
<?php endforeach; ?>
        <address>
            <?php echo nl2br( esc_html( $address ) ); ?>
        </address>
    </div>
</div>
