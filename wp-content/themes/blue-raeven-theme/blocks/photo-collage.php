<?php
/**
 * Photo Collage — large main photo with stacked side photos (Farmstand
 * visit mosaic style). Markup mirrors the legacy hand-coded rows exactly
 * (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$main  = get_field( 'main' );
$sides = get_field( 'sides' );

if ( ! $main ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Photo Collage — choose a main photo.</p>';
    }
    return;
}
?>
<div class="visit-hero-mosaic">
    <div class="visit-hero-mosaic__main">
        <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $main['url'] ) ); ?>" alt="<?php echo esc_attr( $main['alt'] ); ?>" style="width:100%;height:100%;object-fit:cover;">
    </div>
<?php foreach ( (array) $sides as $side ) :
    $pos = $side['position'] ? 'object-position:' . $side['position'] . ';' : '';
    ?>
    <div class="visit-hero-mosaic__side">
        <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $side['image']['url'] ) ); ?>" alt="<?php echo esc_attr( $side['image']['alt'] ); ?>" style="width:100%;height:100%;object-fit:cover;<?php echo esc_attr( $pos ); ?>">
    </div>
<?php endforeach; ?>
</div>
