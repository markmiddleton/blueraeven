<?php
/**
 * Timeline — cream section with header and vertical timeline entries
 * (Our Story page style). Markup mirrors the legacy hand-coded rows
 * exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$label  = get_field( 'label' );
$title  = get_field( 'title' );
$script = get_field( 'script' );
$items  = get_field( 'items' );

if ( ! $items ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Timeline — add entries.</p>';
    }
    return;
}
?>
<section class="section section--cream">
    <div class="container">
        <div class="section__header">
            <div class="section__label"><?php echo esc_html( $label ); ?></div>
            <h2 class="section__title"><?php echo esc_html( $title ); ?></h2>
<?php if ( $script ) : ?>
            <p class="section__script"><?php echo esc_html( $script ); ?></p>
<?php endif; ?>
            <div class="section__divider"></div>
        </div>
        <div class="timeline">
<?php foreach ( $items as $item ) : ?>
            <div class="timeline__item">
                <div class="timeline__year"><?php echo esc_html( $item['year_title'] ); ?></div>
                <div class="timeline__text"><?php echo esc_html( $item['text'] ); ?></div>
<?php if ( ! empty( $item['images'] ) ) : ?>
                <div class="timeline__images">
<?php foreach ( $item['images'] as $img ) :
    $crop = $img['crop'] ? ' class="' . esc_attr( $img['crop'] ) . '"' : '';
    ?>
                    <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $img['image']['url'] ) ); ?>" alt="<?php echo esc_attr( $img['image']['alt'] ); ?>"<?php echo $crop; ?> loading="lazy">
<?php endforeach; ?>
                </div>
<?php endif; ?>
            </div>
<?php endforeach; ?>
        </div>
    </div>
</section>
