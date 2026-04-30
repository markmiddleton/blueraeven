<?php
/**
 * Blue Raeven Block Theme Functions
 *
 * @package Blue_Raeven
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

// Theme constants
define( 'BLUE_RAEVEN_VERSION', '2.2.1' );
define( 'BLUE_RAEVEN_DIR', get_stylesheet_directory() );
define( 'BLUE_RAEVEN_URI', get_stylesheet_directory_uri() );

/**
 * Load theme classes
 */
require_once BLUE_RAEVEN_DIR . '/inc/class-cpt-products.php';

/**
 * Initialize theme
 */
function blue_raeven_init() {
    // Initialize Products CPT
    Blue_Raeven_CPT_Products::init();
}
add_action( 'after_setup_theme', 'blue_raeven_init' );

/**
 * Block theme setup
 */
function blue_raeven_setup() {
    // Add support for block styles
    add_theme_support( 'wp-block-styles' );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( array(
        'https://use.typekit.net/spx7fio.css',
        'assets/css/fonts.css',
        'assets/css/theme.css',
        'style.css',
    ) );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Add support for custom line heights
    add_theme_support( 'custom-line-height' );

    // Add support for custom units
    add_theme_support( 'custom-units' );

    // Add support for link color
    add_theme_support( 'link-color' );

    // Add support for border
    add_theme_support( 'border' );

    // Add support for appearance tools
    add_theme_support( 'appearance-tools' );

    // Register navigation menus
    register_nav_menus( array(
        'primary'   => __( 'Primary Menu', 'blue-raeven' ),
        'footer'    => __( 'Footer Menu', 'blue-raeven' ),
    ) );
}
add_action( 'after_setup_theme', 'blue_raeven_setup' );

/**
 * Enqueue theme styles and scripts
 */
function blue_raeven_enqueue_assets() {
    // Enqueue Adobe Fonts (Typekit)
    // Includes: Citrus Gothic, Hanley Block, Hanley Slim Sans, Futura Condensed
    wp_enqueue_style(
        'blue-raeven-adobe-fonts',
        'https://use.typekit.net/spx7fio.css',
        array(),
        null
    );

    // Enqueue local fonts CSS (Nexa Rust Script)
    wp_enqueue_style(
        'blue-raeven-local-fonts',
        BLUE_RAEVEN_URI . '/assets/css/fonts.css',
        array(),
        BLUE_RAEVEN_VERSION
    );

    // Enqueue main theme CSS (exact copy from static site)
    wp_enqueue_style(
        'blue-raeven-theme',
        BLUE_RAEVEN_URI . '/assets/css/theme.css',
        array( 'blue-raeven-adobe-fonts', 'blue-raeven-local-fonts' ),
        BLUE_RAEVEN_VERSION
    );

    // Enqueue WordPress style.css (for block editor styles)
    wp_enqueue_style(
        'blue-raeven-style',
        get_stylesheet_uri(),
        array( 'blue-raeven-theme' ),
        BLUE_RAEVEN_VERSION
    );

    // Enqueue carousel and mobile nav JavaScript
    wp_enqueue_script(
        'blue-raeven-theme-js',
        BLUE_RAEVEN_URI . '/assets/js/theme.js',
        array(),
        BLUE_RAEVEN_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'blue_raeven_enqueue_assets' );

/**
 * Add Adobe Fonts preconnect for performance
 */
function blue_raeven_preconnect_fonts( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://use.typekit.net',
            'crossorigin' => true,
        );
        $urls[] = array(
            'href' => 'https://p.typekit.net',
            'crossorigin' => true,
        );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'blue_raeven_preconnect_fonts', 10, 2 );

/**
 * Strip broken @font-face rules from WordPress output
 * WordPress caches font-face rules that reference outdated gstatic URLs
 */
function blue_raeven_start_output_buffer() {
    ob_start( 'blue_raeven_filter_font_face' );
}

function blue_raeven_filter_font_face( $html ) {
    // Remove @font-face rules that reference fonts.gstatic.com (broken cached URLs)
    $html = preg_replace(
        '/@font-face\s*\{[^}]*fonts\.gstatic\.com[^}]*\}/is',
        '/* font-face removed by theme */',
        $html
    );
    return $html;
}

function blue_raeven_end_output_buffer() {
    if ( ob_get_level() > 0 ) {
        ob_end_flush();
    }
}

add_action( 'wp_head', 'blue_raeven_start_output_buffer', -9999 );
add_action( 'wp_footer', 'blue_raeven_end_output_buffer', 9999 );

// Also try to prevent WordPress from generating them in the first place
add_filter( 'wp_theme_json_data_theme', function( $theme_json ) {
    $data = $theme_json->get_data();
    if ( isset( $data['settings']['typography']['fontFamilies'] ) ) {
        foreach ( $data['settings']['typography']['fontFamilies'] as &$family ) {
            unset( $family['fontFace'] );
        }
    }
    return $theme_json->update_with( $data );
}, 99 );

// Disable WordPress Fonts API
remove_action( 'wp_head', 'wp_print_font_faces', 50 );

/**
 * Add custom image sizes
 */
function blue_raeven_add_image_sizes() {
    add_image_size( 'product-card', 600, 450, true );
    add_image_size( 'product-card-large', 800, 600, true );
    add_image_size( 'hero-banner', 1920, 800, true );
    add_image_size( 'gallery-thumb', 400, 300, true );
}
add_action( 'after_setup_theme', 'blue_raeven_add_image_sizes' );

/**
 * Make custom image sizes selectable
 */
function blue_raeven_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'product-card'       => __( 'Pie Card (600x450)', 'blue-raeven' ),
        'product-card-large' => __( 'Pie Card Large (800x600)', 'blue-raeven' ),
        'hero-banner'    => __( 'Hero Banner (1920x800)', 'blue-raeven' ),
        'gallery-thumb'  => __( 'Gallery Thumbnail (400x300)', 'blue-raeven' ),
    ) );
}
add_filter( 'image_size_names_choose', 'blue_raeven_custom_image_sizes' );

/**
 * Register block patterns
 */
function blue_raeven_register_block_patterns() {
    // Register pattern categories matching block inventory
    register_block_pattern_category( 'blue-raeven', array(
        'label' => __( 'Blue Raeven', 'blue-raeven' ),
    ) );

    register_block_pattern_category( 'blue-raeven-global', array(
        'label' => __( 'Blue Raeven: Global', 'blue-raeven' ),
    ) );

    register_block_pattern_category( 'blue-raeven-heroes', array(
        'label' => __( 'Blue Raeven: Heroes', 'blue-raeven' ),
    ) );

    register_block_pattern_category( 'blue-raeven-content', array(
        'label' => __( 'Blue Raeven: Content', 'blue-raeven' ),
    ) );

    register_block_pattern_category( 'blue-raeven-cards', array(
        'label' => __( 'Blue Raeven: Cards & Grids', 'blue-raeven' ),
    ) );

    register_block_pattern_category( 'blue-raeven-ctas', array(
        'label' => __( 'Blue Raeven: Forms & CTAs', 'blue-raeven' ),
    ) );

    register_block_pattern_category( 'blue-raeven-lists', array(
        'label' => __( 'Blue Raeven: Lists', 'blue-raeven' ),
    ) );

    // Manually register patterns that aren't auto-loading
    $manual_patterns = array(
        '29-page-hero-farmstand',
        '30-seasonal-callout',
        '31-directions-split',
        '32-cta-banner-contact',
        '33-page-hero-story',
        '34-cta-banner-pies',
        '35-page-hero-contact',
        '36-contact-hero-image',
        '37-social-cta',
    );

    foreach ( $manual_patterns as $pattern_file ) {
        $pattern_path = get_stylesheet_directory() . '/patterns/' . $pattern_file . '.php';
        if ( file_exists( $pattern_path ) ) {
            $file_content = file_get_contents( $pattern_path );

            // Extract pattern metadata from header
            preg_match( '/Title:\s*(.+)/i', $file_content, $title );
            preg_match( '/Slug:\s*(.+)/i', $file_content, $slug );
            preg_match( '/Categories:\s*(.+)/i', $file_content, $categories );
            preg_match( '/Description:\s*(.+)/i', $file_content, $description );

            if ( ! empty( $slug[1] ) ) {
                // Execute PHP and capture output
                ob_start();
                include $pattern_path;
                $pattern_content = ob_get_clean();

                register_block_pattern(
                    trim( $slug[1] ),
                    array(
                        'title'       => isset( $title[1] ) ? trim( $title[1] ) : '',
                        'description' => isset( $description[1] ) ? trim( $description[1] ) : '',
                        'categories'  => isset( $categories[1] ) ? array( trim( $categories[1] ) ) : array(),
                        'content'     => $pattern_content,
                    )
                );
            }
        }
    }
}
add_action( 'init', 'blue_raeven_register_block_patterns' );

/**
 * Register block styles
 */
function blue_raeven_register_block_styles() {
    // Button styles
    register_block_style( 'core/button', array(
        'name'  => 'berry',
        'label' => __( 'Berry', 'blue-raeven' ),
    ) );

    register_block_style( 'core/button', array(
        'name'  => 'green',
        'label' => __( 'Green', 'blue-raeven' ),
    ) );

    // Group styles
    register_block_style( 'core/group', array(
        'name'  => 'navy-section',
        'label' => __( 'Navy Section', 'blue-raeven' ),
    ) );

    register_block_style( 'core/group', array(
        'name'  => 'cream-section',
        'label' => __( 'Cream Section', 'blue-raeven' ),
    ) );
}
add_action( 'init', 'blue_raeven_register_block_styles' );

/**
 * Add ACF options page
 */
function blue_raeven_acf_options_page() {
    if ( function_exists( 'acf_add_options_page' ) ) {
        acf_add_options_page( array(
            'page_title'    => __( 'Blue Raeven Settings', 'blue-raeven' ),
            'menu_title'    => __( 'Theme Settings', 'blue-raeven' ),
            'menu_slug'     => 'blue-raeven-settings',
            'capability'    => 'edit_theme_options',
            'redirect'      => false,
            'icon_url'      => 'dashicons-store',
            'position'      => 60,
        ) );
    }
}
add_action( 'acf/init', 'blue_raeven_acf_options_page' );

/**
 * Register ACF blocks for Pies display
 */
function blue_raeven_register_acf_blocks() {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    // Product Card Block
    acf_register_block_type( array(
        'name'              => 'product-card',
        'title'             => __( 'Product Card', 'blue-raeven' ),
        'description'       => __( 'Display a single product with its details.', 'blue-raeven' ),
        'render_template'   => BLUE_RAEVEN_DIR . '/blocks/product-card.php',
        'category'          => 'blue-raeven',
        'icon'              => 'store',
        'keywords'          => array( 'product', 'card', 'pie', 'jam' ),
        'supports'          => array(
            'align' => false,
        ),
    ) );

    // Product Grid Block
    acf_register_block_type( array(
        'name'              => 'product-grid',
        'title'             => __( 'Product Grid', 'blue-raeven' ),
        'description'       => __( 'Display a grid of products.', 'blue-raeven' ),
        'render_template'   => BLUE_RAEVEN_DIR . '/blocks/product-grid.php',
        'category'          => 'blue-raeven',
        'icon'              => 'grid-view',
        'keywords'          => array( 'product', 'grid', 'pies', 'jams' ),
        'supports'          => array(
            'align' => array( 'wide', 'full' ),
        ),
    ) );
}
add_action( 'acf/init', 'blue_raeven_register_acf_blocks' );

/**
 * One Click Demo Import configuration
 */
function blue_raeven_ocdi_import_files() {
    return array(
        array(
            'import_file_name'           => 'Blue Raeven Demo',
            'import_file_url'            => BLUE_RAEVEN_URI . '/demo-content/content.xml',
            'import_preview_image_url'   => BLUE_RAEVEN_URI . '/screenshot.png',
            'preview_url'                => 'https://blueraeven.com',
        ),
    );
}
add_filter( 'ocdi/import_files', 'blue_raeven_ocdi_import_files' );

/**
 * Actions after demo import
 */
function blue_raeven_ocdi_after_import() {
    // Set home page
    $home_page = get_page_by_title( 'Home' );
    if ( $home_page ) {
        update_option( 'page_on_front', $home_page->ID );
        update_option( 'show_on_front', 'page' );
    }

    // Set primary menu
    $main_menu = wp_get_nav_menu_object( 'Main Menu' );
    if ( $main_menu ) {
        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations['primary'] = $main_menu->term_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}
add_action( 'ocdi/after_import', 'blue_raeven_ocdi_after_import' );
