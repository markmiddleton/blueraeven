<?php
/**
 * Content Blocks — cream prose section with optional floated photos and
 * centered buttons (Our Berries page style). Markup mirrors the legacy
 * hand-coded rows exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$blocks = get_field( 'blocks' );

if ( ! $blocks ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Content Blocks — add a paragraph or button.</p>';
    }
    return;
}
?>
<section class="section section--cream">
    <div class="container container--narrow">

<?php foreach ( $blocks as $block_row ) :
    if ( 'button' === $block_row['type'] ) :
        $style = $block_row['btn_style'] ?: 'berry';
        ?>
        <div class="content-block content-block--centered">
            <a href="<?php echo esc_url( $block_row['btn_url'] ); ?>" class="btn btn--<?php echo esc_attr( $style ); ?>"><?php echo esc_html( $block_row['btn_label'] ); ?></a>
        </div>

<?php else : ?>
        <div class="content-block">
<?php if ( ! empty( $block_row['image'] ) ) : ?>
            <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $block_row['image']['url'] ) ); ?>" alt="<?php echo esc_attr( $block_row['image']['alt'] ); ?>" style="float: right; width: 33%; max-width: 350px; margin: 0 0 1.5rem 1.5rem; border-radius: 8px;">
<?php endif; ?>
            <p<?php echo $block_row['lead'] ? ' class="lead-text"' : ''; ?>><?php echo esc_html( $block_row['text'] ); ?></p>
        </div>

<?php endif;
endforeach; ?>
    </div>
</section>
