<?php
/**
 * Blue Raeven Block Theme Functions
 *
 * @package Blue_Raeven
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

// Theme constants
define( 'BLUE_RAEVEN_VERSION', '2.2.3' );
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
    // Use filemtime for cache busting - automatically updates when file changes
    $theme_css_path = BLUE_RAEVEN_DIR . '/assets/css/theme.css';
    $theme_css_version = file_exists( $theme_css_path ) ? filemtime( $theme_css_path ) : BLUE_RAEVEN_VERSION;
    wp_enqueue_style(
        'blue-raeven-theme',
        BLUE_RAEVEN_URI . '/assets/css/theme.css',
        array( 'blue-raeven-adobe-fonts', 'blue-raeven-local-fonts' ),
        $theme_css_version
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

/**
 * Add custom favicon links
 */
function blue_raeven_favicon_links() {
    ?>
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="manifest" href="/site.webmanifest" />
    <?php
}
add_action( 'wp_head', 'blue_raeven_favicon_links', 1 );

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
 * Keep uploaded originals intact. WP's default 2560px "big image" threshold
 * silently replaces large uploads with a -scaled copy, which breaks
 * pixel-exact assets (e.g. the 2728px hero pan images whose animation
 * keyframes depend on exact width). All site images are pre-optimized
 * before upload, so the safety net is unnecessary.
 */
add_filter( 'big_image_size_threshold', '__return_false' );

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

    /*
     * Component-migration blocks (see MIGRATION-PLAN.md). Render templates
     * intentionally mirror the legacy hand-coded markup exactly. Each entry:
     * name => [ title, description, dashicon, keywords[] ].
     * Template path is blocks/{name}.php; field groups live in acf-json/.
     */
    $migration_blocks = array(
        'story-banner' => array(
            __( 'Story Banner', 'blue-raeven' ),
            __( 'Full-width photo banner with title, script subhead, and CTA button.', 'blue-raeven' ),
            'cover-image',
            array( 'banner', 'story', 'photo', 'cta' ),
        ),
        'page-hero' => array(
            __( 'Page Hero', 'blue-raeven' ),
            __( 'Navy or wood headline banner for the top of a page.', 'blue-raeven' ),
            'heading',
            array( 'hero', 'title', 'header' ),
        ),
        'content-blocks' => array(
            __( 'Content Blocks', 'blue-raeven' ),
            __( 'Prose section: paragraphs with optional floated photos, centered buttons.', 'blue-raeven' ),
            'text-page',
            array( 'content', 'prose', 'paragraphs' ),
        ),
        'product-list' => array(
            __( 'Product List', 'blue-raeven' ),
            __( 'Photo, intro paragraphs, and product cards (Jams & Spreads style).', 'blue-raeven' ),
            'list-view',
            array( 'products', 'jams', 'cards' ),
        ),
        'category-list' => array(
            __( 'Category List', 'blue-raeven' ),
            __( 'Intro, categorized item lists, and a button (Other Confections style).', 'blue-raeven' ),
            'editor-ul',
            array( 'categories', 'confections', 'list' ),
        ),
        'instructions-faqs' => array(
            __( 'Instruction Cards + FAQs', 'blue-raeven' ),
            __( 'Image instruction cards with step lists, plus an FAQ list.', 'blue-raeven' ),
            'editor-help',
            array( 'instructions', 'baking', 'faq', 'steps' ),
        ),
        'photo-banner' => array(
            __( 'Photo Banner', 'blue-raeven' ),
            __( 'Full-width photo strip.', 'blue-raeven' ),
            'format-image',
            array( 'photo', 'banner', 'image' ),
        ),
        'story-block' => array(
            __( 'Story Block', 'blue-raeven' ),
            __( 'Framed photo beside prose paragraphs; photo left or right.', 'blue-raeven' ),
            'align-pull-left',
            array( 'story', 'text', 'photo', '50/50' ),
        ),
        'timeline' => array(
            __( 'Timeline', 'blue-raeven' ),
            __( 'Vertical history timeline with entries and photos.', 'blue-raeven' ),
            'backup',
            array( 'timeline', 'history', 'journey' ),
        ),
        'gallery-mosaic' => array(
            __( 'Gallery Mosaic', 'blue-raeven' ),
            __( 'Square photo mosaic with crossfading rotation.', 'blue-raeven' ),
            'format-gallery',
            array( 'gallery', 'photos', 'mosaic', 'rotation' ),
        ),
        'feature-links' => array(
            __( 'Feature Links', 'blue-raeven' ),
            __( 'Icon cards linking to other pages.', 'blue-raeven' ),
            'screenoptions',
            array( 'features', 'links', 'icons' ),
        ),
        'testimonial' => array(
            __( 'Testimonial', 'blue-raeven' ),
            __( 'Wood-background centered customer quote.', 'blue-raeven' ),
            'format-quote',
            array( 'quote', 'testimonial', 'review' ),
        ),
        'photo-collage' => array(
            __( 'Photo Collage', 'blue-raeven' ),
            __( 'Large main photo with stacked side photos.', 'blue-raeven' ),
            'images-alt2',
            array( 'photos', 'collage', 'mosaic' ),
        ),
        'retailer-section' => array(
            __( 'Retailer Section', 'blue-raeven' ),
            __( 'Grocery retailer buttons plus an area-farmstands list.', 'blue-raeven' ),
            'store',
            array( 'retailers', 'grocers', 'stores' ),
        ),
        'info-cards' => array(
            __( 'Location Info Cards', 'blue-raeven' ),
            __( 'Torn-paper location cards with address, hours, and phone.', 'blue-raeven' ),
            'location',
            array( 'locations', 'hours', 'address' ),
        ),
        'find-cards' => array(
            __( 'Find Cards', 'blue-raeven' ),
            __( '3-up image cards with titles and descriptions.', 'blue-raeven' ),
            'grid-view',
            array( 'cards', 'images', 'find' ),
        ),
        'directions-split' => array(
            __( 'Directions Split', 'blue-raeven' ),
            __( 'Google Maps embed beside directions text.', 'blue-raeven' ),
            'location-alt',
            array( 'map', 'directions', 'address' ),
        ),
    );

    foreach ( $migration_blocks as $block_name => $def ) {
        acf_register_block_type( array(
            'name'            => $block_name,
            'title'           => $def[0],
            'description'     => $def[1],
            'render_template' => BLUE_RAEVEN_DIR . '/blocks/' . $block_name . '.php',
            'category'        => 'blue-raeven',
            'icon'            => $def[2],
            'keywords'        => $def[3],
            'mode'            => 'preview',
            'supports'        => array(
                'align'  => false,
                'anchor' => false,
                'mode'   => true,
            ),
        ) );
    }
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

/**
 * Redirect the "Pies & More" landing page to its Pies child page.
 *
 * The page itself stays published so its child pages keep their
 * /pies-more/* URLs; we just 301 the parent landing view to /pies-more/pies/.
 */
function blue_raeven_redirect_pies_more() {
    if ( is_page( 'pies-more' ) ) {
        wp_safe_redirect( home_url( '/pies-more/pies/' ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'blue_raeven_redirect_pies_more' );

/**
 * Legacy URL redirects from the old blueraevenfarmstand.com site structure.
 *
 * Fires only for paths that don't resolve to a real page on the new site
 * (otherwise WP would have already served the page before template_redirect).
 * Matches the path portion of REQUEST_URI, case-insensitive, ignoring
 * trailing slashes and query strings.
 */
function blue_raeven_legacy_redirects() {
    $path = strtolower( trim( (string) parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' ) );
    if ( $path === '' ) {
        return; // homepage, nothing to do
    }

    // Exact-match map: old path => new path (always start with /, end with /).
    $exact = array(
        'home'                    => '/',
        'hours-and-directions'    => '/farmstand/',
        'about'                   => '/story/',
        'contact.html'            => '/contact/',
        'all-our-products'        => '/pies-more/',
        'all-our-products-2'      => '/pies-more/',
        'baking-instructions'     => '/pies-more/baking-instructions-faqs/',
        'product-category/pies'   => '/pies-more/pies/',
        'shop'                    => '/pies-more/pies/',
        'shop/cart'               => '/pies-more/pies/',
        'shop/checkout'           => '/pies-more/pies/',
        'shop/my-account'         => '/pies-more/pies/',
        'shop.1.html'             => '/pies-more/pies/',
    );
    if ( isset( $exact[ $path ] ) ) {
        wp_safe_redirect( home_url( $exact[ $path ] ), 301 );
        exit;
    }

    // Wildcard fallbacks: any deeper path under these prefixes
    if ( strpos( $path, 'product/' ) === 0 ) {
        // Individual product pages (apple-pie, razzle-dazzle, etc.) -> pies listing
        wp_safe_redirect( home_url( '/pies-more/pies/' ), 301 );
        exit;
    }
    if ( strpos( $path, 'product-category/' ) === 0 ) {
        // Other product categories besides /pies/ -> pies & more overview
        wp_safe_redirect( home_url( '/pies-more/' ), 301 );
        exit;
    }
    if ( strpos( $path, 'shop/' ) === 0 ) {
        // Any other /shop/* path (e.g. order tracking, address, etc.) -> pies listing
        wp_safe_redirect( home_url( '/pies-more/pies/' ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'blue_raeven_legacy_redirects' );

/**
 * Google Tag Manager — head snippet.
 * Priority 1 so it prints as high in <head> as possible (GTM best practice).
 */
function blue_raeven_gtm_head() {
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-N79LWGKC');</script>
    <!-- End Google Tag Manager -->
    <?php
}
add_action( 'wp_head', 'blue_raeven_gtm_head', 1 );

/**
 * Google Tag Manager — noscript fallback, right after <body>.
 */
function blue_raeven_gtm_body() {
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N79LWGKC"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
add_action( 'wp_body_open', 'blue_raeven_gtm_body' );

/**
 * Per-page meta descriptions for SEO + AI snippets.
 *
 * Switches on the queried page's slug. All page slugs on this site are
 * unique (verified via `wp post list --post_type=page`), so slug-based
 * dispatch is safe. If a page isn't in the map, no description is emitted
 * (search engines fall back to auto-generated snippets).
 */
function blue_raeven_meta_description() {
    if ( ! is_singular() && ! is_front_page() ) {
        return;
    }

    $description = '';

    if ( is_front_page() ) {
        $description = 'Handcrafted pies from Blue Raeven Farms in Amity, Oregon. Farm-grown berries, family recipes since 1928. Visit our farmstand, pie shop, or local grocers.';
    } else {
        $post = get_queried_object();
        if ( ! $post || ! isset( $post->post_name ) ) {
            return;
        }
        $map = array(
            'story'                     => 'Four generations of farming in Oregon\'s Willamette Valley since 1928. Discover the Lewis family story behind Blue Raeven Farms and our handcrafted pies.',
            'our-berries'               => 'Marionberries, boysenberries, blueberries, and more — grown on 130+ acres at Blue Raeven Farms in Amity, Oregon. The fruit that fills every pie.',
            'farmstand'                 => 'Visit Blue Raeven Farmstand in Amity or our pie shop in McMinnville, OR. Open daily for handcrafted pies, jams, fresh berries, and seasonal treats.',
            'pies'                      => 'Handcrafted fruit pies from Blue Raeven Farms: Apple, Marionberry, Boysenberry, Blue Raeven Berry, and more — made with our own Oregon-grown berries.',
            'jams-spreads'              => 'Small-batch jams and fruit spreads made with farm-grown Oregon berries — old-world recipes from Blue Raeven Farms in Amity, now in stores.',
            'other-confections'         => 'Blueberry, boysenberry, marionberry, raspberry, peach & tayberry syrups — gourmet recipes from Blue Raeven Farms, available at our farmstand.',
            'baking-instructions-faqs'  => 'How to bake your frozen Blue Raeven pie to golden perfection — temperatures, times, and answers to common questions about handling and storage.',
            'wholesale-fundraising'     => 'Sell Blue Raeven pies at your store or use them for fundraising. Wholesale catalog, order forms, and sales sheets — partner with Blue Raeven Farms.',
            'contact'                   => 'Questions, custom orders, or wholesale inquiries? Get in touch with Blue Raeven Farms in Amity, OR — we\'d love to hear from you.',
        );
        if ( isset( $map[ $post->post_name ] ) ) {
            $description = $map[ $post->post_name ];
        }
    }

    if ( $description ) {
        echo "\n" . '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'blue_raeven_meta_description', 2 );

/**
 * JSON-LD structured data.
 *
 *   - Organization: emitted sitewide (brand entity)
 *   - WebSite:      emitted on the home page
 *   - Bakery x 2:   emitted on the /farmstand/ page, one for each physical
 *                   location (Amity Farmstand + McMinnville Pie Company)
 *
 * Output as multiple <script type="application/ld+json"> blocks — easier
 * to validate / read in view-source than a combined @graph.
 */
function blue_raeven_schema() {
    $home = home_url( '/' );
    $logo = esc_url_raw( get_stylesheet_directory_uri() . '/assets/images/blue-raeven-farms-logo.png' );
    $json_flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;

    // ---- Organization (sitewide) ----
    $organization = array(
        '@context'     => 'https://schema.org',
        '@type'        => 'Organization',
        'name'         => 'Blue Raeven Farms',
        'url'          => $home,
        'logo'         => $logo,
        'foundingDate' => '1928',
        'sameAs'       => array(
            'https://www.facebook.com/blueraevenpie',
            'https://www.instagram.com/blueraevenpie',
        ),
    );
    echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $organization, $json_flags ) . '</script>' . "\n";

    // ---- WebSite (homepage only) ----
    if ( is_front_page() ) {
        $website = array(
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => 'Blue Raeven Farms',
            'url'      => $home,
        );
        echo '<script type="application/ld+json">' . wp_json_encode( $website, $json_flags ) . '</script>' . "\n";
    }

    // ---- LocalBusinesses (Amity + McMinnville, on /farmstand/) ----
    if ( is_page( 'farmstand' ) ) {
        $amity = array(
            '@context'   => 'https://schema.org',
            '@type'      => 'Bakery',
            'name'       => 'Blue Raeven Farmstand – Amity',
            'url'        => home_url( '/farmstand/' ),
            'image'      => $logo,
            'telephone'  => '+1-503-835-0740',
            'address'    => array(
                '@type'           => 'PostalAddress',
                'streetAddress'   => '20650 S Hwy 99W',
                'addressLocality' => 'Amity',
                'addressRegion'   => 'OR',
                'postalCode'      => '97101',
                'addressCountry'  => 'US',
            ),
            'openingHoursSpecification' => array(
                array(
                    '@type'     => 'OpeningHoursSpecification',
                    'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ),
                    'opens'     => '09:00',
                    'closes'    => '17:30',
                ),
                array(
                    '@type'     => 'OpeningHoursSpecification',
                    'dayOfWeek' => array( 'Sunday' ),
                    'opens'     => '10:00',
                    'closes'    => '17:00',
                ),
            ),
        );
        echo '<script type="application/ld+json">' . wp_json_encode( $amity, $json_flags ) . '</script>' . "\n";

        $mcminnville = array(
            '@context'   => 'https://schema.org',
            '@type'      => 'Bakery',
            'name'       => 'Blue Raeven Pie Company – McMinnville',
            'url'        => home_url( '/farmstand/' ),
            'image'      => $logo,
            'telephone'  => '+1-503-474-2856',
            'address'    => array(
                '@type'           => 'PostalAddress',
                'streetAddress'   => '1101 NE Alpine Ave',
                'addressLocality' => 'McMinnville',
                'addressRegion'   => 'OR',
                'postalCode'      => '97128',
                'addressCountry'  => 'US',
            ),
            'openingHoursSpecification' => array(
                array(
                    '@type'     => 'OpeningHoursSpecification',
                    'dayOfWeek' => array( 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ),
                    'opens'     => '10:00',
                    'closes'    => '17:30',
                ),
            ),
        );
        echo '<script type="application/ld+json">' . wp_json_encode( $mcminnville, $json_flags ) . '</script>' . "\n";
    }
}
add_action( 'wp_head', 'blue_raeven_schema', 5 );
