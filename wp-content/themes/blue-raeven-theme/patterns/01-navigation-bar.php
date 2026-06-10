<?php /* Force sync: 2026-05-13 */ ?>
<?php
/**
 * Title: Navigation Bar
 * Slug: blue-raeven/navigation-bar
 * Categories: blue-raeven-global
 * Description: Fixed header with centered logo, navigation links, and mobile toggle
 * Block Types: core/template-part/header
 *
 * Links + labels are managed in wp-admin → Theme Settings (Header Navigation).
 * Markup reproduces the former hardcoded nav exactly (see MIGRATION-PLAN.md).
 * The logo images remain theme assets by design.
 */

$left_items  = function_exists( 'get_field' ) ? get_field( 'left_items', 'option' ) : array();
$right_items = function_exists( 'get_field' ) ? get_field( 'right_items', 'option' ) : array();
$arrow_svg   = '<svg class="nav__mobile-arrow" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>';
?>
<!-- wp:html -->
<nav class="nav">
    <div class="container nav__inner">
        <div class="nav__links nav__links--left" id="navLinksLeft">
<?php foreach ( (array) $left_items as $item ) :
    $children = $item['children'] ?? array();
    if ( $children ) : ?>
            <div class="nav__dropdown">
                <a href="<?php echo esc_url( blue_raeven_nav_url( $item['url'] ) ); ?>" class="nav__dropdown-trigger"><?php echo esc_html( $item['label'] ); ?></a>
                <div class="nav__dropdown-menu">
<?php foreach ( $children as $child ) : ?>
                    <a href="<?php echo esc_url( blue_raeven_nav_url( $child['url'] ) ); ?>"><?php echo esc_html( $child['label'] ); ?></a>
<?php endforeach; ?>
                </div>
            </div>
<?php else : ?>
            <a href="<?php echo esc_url( blue_raeven_nav_url( $item['url'] ) ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
<?php endif;
endforeach; ?>
        </div>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav__brand">
            <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/blue-raeven-farms-logo.png" alt="Blue Raeven" class="nav__logo-img nav__logo-img--desktop">
            <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/blue-raeven-farms-logo-mobile.png" alt="Blue Raeven" class="nav__logo-img nav__logo-img--mobile">
        </a>
        <div class="nav__links nav__links--right" id="navLinksRight">
<?php foreach ( (array) $right_items as $item ) : ?>
            <a href="<?php echo esc_url( blue_raeven_nav_url( $item['url'] ) ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
<?php endforeach; ?>
        </div>
        <button class="nav__toggle" id="navToggle" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </div>
    <div class="picket-fence-separator" aria-hidden="true"></div>
    <!-- Mobile Menu Panel -->
    <div class="nav__mobile-menu" id="navMobileMenu">
<?php foreach ( (array) $left_items as $item ) :
    $children = $item['children'] ?? array();
    if ( $children ) : ?>
        <div class="nav__mobile-dropdown">
            <button class="nav__mobile-dropdown-trigger" type="button">
                <?php echo esc_html( $item['label'] ); ?>
                <?php echo $arrow_svg; // phpcs:ignore WordPress.Security.EscapeOutput — static SVG ?>
            </button>
<?php if ( ! empty( $item['mobile_overview_label'] ) ) : ?>
            <a href="<?php echo esc_url( blue_raeven_nav_url( $item['url'] ) ); ?>" class="nav__mobile-parent-link"><?php echo esc_html( $item['mobile_overview_label'] ); ?></a>
<?php endif; ?>
            <div class="nav__mobile-submenu">
<?php foreach ( $children as $child ) : ?>
                <a href="<?php echo esc_url( blue_raeven_nav_url( $child['url'] ) ); ?>"><?php echo esc_html( $child['label'] ); ?></a>
<?php endforeach; ?>
            </div>
        </div>
<?php else : ?>
        <a href="<?php echo esc_url( blue_raeven_nav_url( $item['url'] ) ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
<?php endif;
endforeach; ?>
<?php foreach ( (array) $right_items as $item ) : ?>
        <a href="<?php echo esc_url( blue_raeven_nav_url( $item['url'] ) ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
<?php endforeach; ?>
    </div>
</nav>
<!-- /wp:html -->
