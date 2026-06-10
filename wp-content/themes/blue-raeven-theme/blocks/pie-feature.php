<?php
/**
 * Pie Feature — 50/50 photo + cream text panel with CTA (Home page style).
 * Markup mirrors the legacy hand-coded rows exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$image     = get_field( 'image' );
$reverse   = get_field( 'reverse' );
$colored   = get_field( 'colored' );
$label     = get_field( 'label' );
$title     = get_field( 'title' );
$desc      = get_field( 'desc' );
$btn_label = get_field( 'btn_label' );
$btn_url   = get_field( 'btn_url' );

if ( ! $title ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Pie Feature — add a title.</p>';
    }
    return;
}

$root_cls    = $reverse ? 'pie-feature pie-feature--reverse' : 'pie-feature';
$label_style = $colored ? ' style="color:var(--berry);"' : '';
$title_style = $colored ? ' style="color:var(--navy);"' : '';
$desc_style  = $colored ? ' style="color:var(--charcoal);"' : '';
?>
<div class="<?php echo $root_cls; ?>">
    <div class="pie-feature__image">
        <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $image['url'] ) ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" style="width:100%;height:100%;object-fit:cover;">
    </div>
    <div class="pie-feature__text" style="background: var(--cream-warm);">
        <div class="pie-feature__label"<?php echo $label_style; ?>><?php echo esc_html( $label ); ?></div>
        <h3 class="pie-feature__name"<?php echo $title_style; ?>><?php echo esc_html( $title ); ?></h3>
        <p class="pie-feature__desc"<?php echo $desc_style; ?>>
            <?php echo esc_html( $desc ); ?>
        </p>
<?php if ( $btn_label && $btn_url ) : ?>
        <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn--primary" style="margin-top:1.5rem;"><?php echo esc_html( $btn_label ); ?></a>
<?php endif; ?>
    </div>
</div>
