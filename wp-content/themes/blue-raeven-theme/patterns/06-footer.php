<?php /* Force sync: 2026-05-13 */ ?>
<?php
/**
 * Title: Footer
 * Slug: blue-raeven/footer
 * Categories: blue-raeven-global
 * Description: 4-column footer with brand, links and copyright
 * Block Types: core/template-part/footer
 *
 * Content managed in wp-admin → Theme Settings (Footer). Markup reproduces
 * the former hardcoded footer exactly (see MIGRATION-PLAN.md).
 */

$has_acf = function_exists( 'get_field' );
$g = function ( $name ) use ( $has_acf ) {
    return $has_acf ? get_field( $name, 'option' ) : '';
};

$brand_name   = $g( 'brand_name' );
$brand_script = $g( 'brand_script' );
$brand_desc   = $g( 'brand_desc' );
// Repeaters: only ever iterate a real array of rows. If the option is missing
// or malformed (e.g. ACF returns the raw row-count string), treat as empty so
// the footer renders instead of fataling. Inner loops also guard each row.
$explore      = is_array( $g( 'explore_links' ) )   ? $g( 'explore_links' )   : array();
$visit        = is_array( $g( 'visit_locations' ) ) ? $g( 'visit_locations' ) : array();
$connect      = is_array( $g( 'connect_links' ) )   ? $g( 'connect_links' )   : array();
$social       = is_array( $g( 'social' ) )          ? $g( 'social' )          : array();

// Fixed social icon SVGs (footer set, incl. newsletter envelope).
$social_svgs = array(
    'facebook'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
    'instagram'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
    'newsletter' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>',
);
$social_aria = array( 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'newsletter' => 'Newsletter' );
?>
<!-- wp:html -->
<footer class="footer">
    <div class="container">
        <div class="footer__inner">
            <div>
                <div class="footer__brand-name"><?php echo esc_html( $brand_name ); ?></div>
                <div class="footer__brand-script"><?php echo esc_html( $brand_script ); ?></div>
                <p class="footer__brand-desc"><?php echo esc_html( $brand_desc ); ?></p>
            </div>
            <div>
                <div class="footer__heading"><?php echo esc_html( $g( 'explore_heading' ) ); ?></div>
                <ul class="footer__link-list">
<?php foreach ( $explore as $link ) : if ( ! is_array( $link ) ) { continue; } ?>
                    <li><a href="<?php echo esc_url( blue_raeven_nav_url( $link['url'] ?? '' ) ); ?>"><?php echo esc_html( $link['label'] ?? '' ); ?></a></li>
<?php endforeach; ?>
                </ul>
            </div>
            <div>
                <div class="footer__heading"><?php echo esc_html( $g( 'visit_heading' ) ); ?></div>
                <ul class="footer__link-list footer__link-list--visit">
<?php foreach ( $visit as $loc ) : if ( ! is_array( $loc ) ) { continue; } ?>
                    <li>
                        <a href="<?php echo esc_url( $loc['map_url'] ?? '' ); ?>" target="_blank" rel="noopener" class="footer__location-name"><?php echo esc_html( $loc['name'] ?? '' ); ?></a>
<?php foreach ( ( is_array( $loc['hours'] ?? null ) ? $loc['hours'] : array() ) as $h ) : if ( ! is_array( $h ) ) { continue; } ?>
                        <span class="footer__hours"><?php echo esc_html( $h['line'] ?? '' ); ?></span>
<?php endforeach; ?>
                    </li>
<?php endforeach; ?>
                </ul>
            </div>
            <div>
                <div class="footer__heading"><?php echo esc_html( $g( 'connect_heading' ) ); ?></div>
                <ul class="footer__link-list">
<?php foreach ( $connect as $link ) : if ( ! is_array( $link ) ) { continue; } ?>
                    <li><a href="<?php echo esc_url( blue_raeven_nav_url( $link['url'] ?? '' ) ); ?>"><?php echo esc_html( $link['label'] ?? '' ); ?></a></li>
<?php endforeach; ?>
                </ul>
                <div class="footer__social">
<?php foreach ( $social as $s ) :
    $p = is_array( $s ) ? ( $s['platform'] ?? '' ) : '';
    if ( ! isset( $social_svgs[ $p ] ) ) {
        continue;
    }
    ?>
                    <a href="<?php echo esc_url( blue_raeven_nav_url( $s['url'] ?? '' ) ); ?>"<?php echo 'newsletter' === $p ? '' : ' target="_blank" rel="noopener"'; ?> aria-label="<?php echo esc_attr( $social_aria[ $p ] ); ?>">
                        <?php echo $social_svgs[ $p ]; // phpcs:ignore WordPress.Security.EscapeOutput — static SVG ?>
                    </a>
<?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <span>&copy; <?php echo date( 'Y' ); ?> <?php echo esc_html( $g( 'copyright' ) ); ?></span>
            <span><?php echo esc_html( $g( 'bottom_location' ) ); ?></span>
            <a href="<?php echo esc_url( $g( 'credit_url' ) ); ?>" class="footer__credit"><?php echo esc_html( $g( 'credit_label' ) ); ?></a>
        </div>
    </div>
</footer>
<!-- /wp:html -->
