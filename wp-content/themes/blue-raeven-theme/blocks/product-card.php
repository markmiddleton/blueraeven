<?php
/**
 * Pie Card ACF Block Template
 *
 * Displays a single pie with its ACF custom fields.
 * Used for manual pie selection or in custom layouts.
 *
 * @package Blue_Raeven
 */

// Get the selected pie
$pie_id = get_field( 'pie' );

if ( ! $pie_id ) {
    echo '<p>Please select a pie.</p>';
    return;
}

$pie = get_post( $pie_id );
if ( ! $pie ) {
    return;
}

// Get pie custom fields
$pie_tag = get_field( 'pie_tag', $pie_id );
$pie_price = get_field( 'pie_price', $pie_id );
$pie_availability = get_field( 'pie_availability', $pie_id );
$featured_image = get_the_post_thumbnail_url( $pie_id, 'pie-card' );

// Determine availability class
$availability_class = '';
if ( $pie_availability === 'limited' ) {
    $availability_class = 'br-pie-card--limited';
} elseif ( $pie_availability === 'seasonal' ) {
    $availability_class = 'br-pie-card--seasonal';
} elseif ( $pie_availability === 'coming_soon' ) {
    $availability_class = 'br-pie-card--coming-soon';
}
?>

<div class="br-pie-card <?php echo esc_attr( $availability_class ); ?>">
    <?php if ( $featured_image ) : ?>
        <div class="br-pie-card__image">
            <a href="<?php echo get_permalink( $pie_id ); ?>">
                <img src="<?php echo esc_url( $featured_image ); ?>" alt="<?php echo esc_attr( $pie->post_title ); ?>">
            </a>
        </div>
    <?php endif; ?>

    <div class="br-pie-card__content">
        <?php if ( $pie_tag ) : ?>
            <span class="br-pie-card__tag"><?php echo esc_html( $pie_tag ); ?></span>
        <?php endif; ?>

        <h3 class="br-pie-card__title">
            <a href="<?php echo get_permalink( $pie_id ); ?>"><?php echo esc_html( $pie->post_title ); ?></a>
        </h3>

        <?php if ( $pie->post_excerpt ) : ?>
            <p class="br-pie-card__description"><?php echo esc_html( $pie->post_excerpt ); ?></p>
        <?php endif; ?>

        <?php if ( $pie_price ) : ?>
            <span class="br-pie-card__price"><?php echo esc_html( $pie_price ); ?></span>
        <?php endif; ?>
    </div>
</div>
