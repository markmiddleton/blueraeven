<?php
/**
 * Pre-Order Section — white centered section listing farmstand-only pies by
 * category with a CTA (Pies page style). Markup mirrors the legacy
 * hand-coded rows exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$heading    = get_field( 'heading' );
$script     = get_field( 'script' );
$categories = get_field( 'categories' );
$btn_label  = get_field( 'btn_label' );
$btn_url    = get_field( 'btn_url' );

if ( ! $heading && ! $categories ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Pre-Order Section — add a heading and categories.</p>';
    }
    return;
}

$cat_count = is_array( $categories ) ? count( $categories ) : 0;
?>
<section class="section section--white">
    <div class="container container--narrow" style="text-align: center;">
        <h2 style="font-family: var(--font-header-primary); font-size: 2rem; color: var(--navy); margin-bottom: 1rem; text-transform: uppercase;"><?php echo esc_html( $heading ); ?></h2>
        <p style="font-family: var(--font-script); font-size: clamp(2rem, 4vw, 2.6rem); color: var(--berry); margin-bottom: 2rem;"><?php echo esc_html( $script ); ?></p>

        <div style="max-width: 700px; margin: 0 auto;">
<?php foreach ( (array) $categories as $i => $cat ) :
    // Last category carries extra space before the button.
    $mb = ( $i === $cat_count - 1 ) ? '2rem' : '1rem';
    ?>
            <p style="font-family: var(--font-body); color: var(--charcoal); margin-bottom: <?php echo $mb; ?>;"><strong style="color: var(--navy);"><?php echo esc_html( $cat['label'] ); ?>:</strong> <?php echo esc_html( $cat['items'] ); ?></p>
<?php endforeach; ?>
        </div>

        <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn--berry" style="font-family: var(--font-header-primary); text-transform: uppercase; padding: 1rem 2.5rem; font-size: 1.1rem;"><?php echo esc_html( $btn_label ); ?></a>
    </div>
</section>
