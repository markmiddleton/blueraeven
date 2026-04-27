<?php
/**
 * Products Custom Post Type
 *
 * @package Blue_Raeven
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Blue_Raeven_CPT_Products
 *
 * Registers the Products custom post type and related taxonomies.
 * Used for pies, jams, jellies, and other farm stand products.
 */
class Blue_Raeven_CPT_Products {

    /**
     * Post type slug
     */
    const POST_TYPE = 'product';

    /**
     * Taxonomy slug
     */
    const TAXONOMY = 'product_category';

    /**
     * Initialize the class
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'register_post_type' ) );
        add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );
        add_action( 'acf/init', array( __CLASS__, 'register_acf_fields' ) );
        add_action( 'manage_' . self::POST_TYPE . '_posts_columns', array( __CLASS__, 'add_admin_columns' ) );
        add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', array( __CLASS__, 'render_admin_columns' ), 10, 2 );
    }

    /**
     * Register the Products custom post type
     */
    public static function register_post_type() {
        $labels = array(
            'name'                  => _x( 'Products', 'Post type general name', 'blue-raeven' ),
            'singular_name'         => _x( 'Product', 'Post type singular name', 'blue-raeven' ),
            'menu_name'             => _x( 'Products', 'Admin Menu text', 'blue-raeven' ),
            'name_admin_bar'        => _x( 'Product', 'Add New on Toolbar', 'blue-raeven' ),
            'add_new'               => __( 'Add New', 'blue-raeven' ),
            'add_new_item'          => __( 'Add New Product', 'blue-raeven' ),
            'new_item'              => __( 'New Product', 'blue-raeven' ),
            'edit_item'             => __( 'Edit Product', 'blue-raeven' ),
            'view_item'             => __( 'View Product', 'blue-raeven' ),
            'all_items'             => __( 'All Products', 'blue-raeven' ),
            'search_items'          => __( 'Search Products', 'blue-raeven' ),
            'parent_item_colon'     => __( 'Parent Products:', 'blue-raeven' ),
            'not_found'             => __( 'No products found.', 'blue-raeven' ),
            'not_found_in_trash'    => __( 'No products found in Trash.', 'blue-raeven' ),
            'featured_image'        => _x( 'Product Photo', 'Overrides the "Featured Image" phrase', 'blue-raeven' ),
            'set_featured_image'    => _x( 'Set product photo', 'Overrides the "Set featured image" phrase', 'blue-raeven' ),
            'remove_featured_image' => _x( 'Remove product photo', 'Overrides the "Remove featured image" phrase', 'blue-raeven' ),
            'use_featured_image'    => _x( 'Use as product photo', 'Overrides the "Use as featured image" phrase', 'blue-raeven' ),
            'archives'              => _x( 'Product Archives', 'The post type archive label', 'blue-raeven' ),
            'insert_into_item'      => _x( 'Insert into product', 'Overrides the "Insert into post" phrase', 'blue-raeven' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this product', 'Overrides the "Uploaded to this post" phrase', 'blue-raeven' ),
            'filter_items_list'     => _x( 'Filter products list', 'Screen reader text', 'blue-raeven' ),
            'items_list_navigation' => _x( 'Products list navigation', 'Screen reader text', 'blue-raeven' ),
            'items_list'            => _x( 'Products list', 'Screen reader text', 'blue-raeven' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'products', 'with_front' => false ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-store',
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            'template'           => array(),
            'template_lock'      => false,
        );

        register_post_type( self::POST_TYPE, $args );
    }

    /**
     * Register the Product Category taxonomy
     */
    public static function register_taxonomy() {
        $labels = array(
            'name'              => _x( 'Product Categories', 'taxonomy general name', 'blue-raeven' ),
            'singular_name'     => _x( 'Product Category', 'taxonomy singular name', 'blue-raeven' ),
            'search_items'      => __( 'Search Product Categories', 'blue-raeven' ),
            'all_items'         => __( 'All Product Categories', 'blue-raeven' ),
            'parent_item'       => __( 'Parent Product Category', 'blue-raeven' ),
            'parent_item_colon' => __( 'Parent Product Category:', 'blue-raeven' ),
            'edit_item'         => __( 'Edit Product Category', 'blue-raeven' ),
            'update_item'       => __( 'Update Product Category', 'blue-raeven' ),
            'add_new_item'      => __( 'Add New Product Category', 'blue-raeven' ),
            'new_item_name'     => __( 'New Product Category Name', 'blue-raeven' ),
            'menu_name'         => __( 'Categories', 'blue-raeven' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'product-category' ),
        );

        register_taxonomy( self::TAXONOMY, array( self::POST_TYPE ), $args );

        // Register default categories
        self::register_default_categories();
    }

    /**
     * Register default product categories
     */
    private static function register_default_categories() {
        $default_categories = array(
            'pies'      => __( 'Pies', 'blue-raeven' ),
            'jams'      => __( 'Jams & Jellies', 'blue-raeven' ),
            'seasonal'  => __( 'Seasonal', 'blue-raeven' ),
        );

        foreach ( $default_categories as $slug => $name ) {
            if ( ! term_exists( $slug, self::TAXONOMY ) ) {
                wp_insert_term( $name, self::TAXONOMY, array( 'slug' => $slug ) );
            }
        }
    }

    /**
     * Register ACF fields for Products
     */
    public static function register_acf_fields() {
        if ( ! function_exists( 'acf_add_local_field_group' ) ) {
            return;
        }

        acf_add_local_field_group( array(
            'key'      => 'group_product_details',
            'title'    => __( 'Product Details', 'blue-raeven' ),
            'fields'   => array(
                // Tag/Badge field
                array(
                    'key'           => 'field_product_tag',
                    'label'         => __( 'Tag / Badge', 'blue-raeven' ),
                    'name'          => 'product_tag',
                    'type'          => 'text',
                    'instructions'  => __( 'Display tag shown on the product card (e.g., Signature, Classic, Seasonal, Limited)', 'blue-raeven' ),
                    'required'      => 0,
                    'default_value' => '',
                    'placeholder'   => __( 'Signature', 'blue-raeven' ),
                    'maxlength'     => 20,
                ),
                // Price Display field
                array(
                    'key'           => 'field_product_price',
                    'label'         => __( 'Price Display', 'blue-raeven' ),
                    'name'          => 'product_price',
                    'type'          => 'text',
                    'instructions'  => __( 'Price shown on the card (e.g., $24, Seasonal, Market Price)', 'blue-raeven' ),
                    'required'      => 0,
                    'default_value' => 'Seasonal',
                    'placeholder'   => __( '$24', 'blue-raeven' ),
                    'maxlength'     => 20,
                ),
                // Availability field
                array(
                    'key'           => 'field_product_availability',
                    'label'         => __( 'Availability', 'blue-raeven' ),
                    'name'          => 'product_availability',
                    'type'          => 'select',
                    'instructions'  => __( 'Current availability status', 'blue-raeven' ),
                    'required'      => 0,
                    'choices'       => array(
                        'available'    => __( 'Available', 'blue-raeven' ),
                        'seasonal'     => __( 'Seasonal', 'blue-raeven' ),
                        'limited'      => __( 'Limited', 'blue-raeven' ),
                        'coming_soon'  => __( 'Coming Soon', 'blue-raeven' ),
                        'sold_out'     => __( 'Sold Out', 'blue-raeven' ),
                    ),
                    'default_value' => 'seasonal',
                    'return_format' => 'value',
                ),
                // Sort Order field
                array(
                    'key'           => 'field_product_sort_order',
                    'label'         => __( 'Display Order', 'blue-raeven' ),
                    'name'          => 'product_sort_order',
                    'type'          => 'number',
                    'instructions'  => __( 'Lower numbers appear first', 'blue-raeven' ),
                    'required'      => 0,
                    'default_value' => 10,
                    'min'           => 0,
                    'max'           => 100,
                ),
                // Featured toggle
                array(
                    'key'           => 'field_product_featured',
                    'label'         => __( 'Featured Product', 'blue-raeven' ),
                    'name'          => 'product_featured',
                    'type'          => 'true_false',
                    'instructions'  => __( 'Show this product on the homepage', 'blue-raeven' ),
                    'required'      => 0,
                    'default_value' => 0,
                    'ui'            => 1,
                    'ui_on_text'    => __( 'Yes', 'blue-raeven' ),
                    'ui_off_text'   => __( 'No', 'blue-raeven' ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => self::POST_TYPE,
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'side',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
        ) );
    }

    /**
     * Add custom admin columns
     *
     * @param array $columns Existing columns.
     * @return array Modified columns.
     */
    public static function add_admin_columns( $columns ) {
        $new_columns = array();

        foreach ( $columns as $key => $value ) {
            if ( $key === 'title' ) {
                $new_columns[ $key ] = $value;
                $new_columns['product_photo'] = __( 'Photo', 'blue-raeven' );
            } elseif ( $key === 'date' ) {
                $new_columns['product_tag']          = __( 'Tag', 'blue-raeven' );
                $new_columns['product_price']        = __( 'Price', 'blue-raeven' );
                $new_columns['product_availability'] = __( 'Status', 'blue-raeven' );
                $new_columns[ $key ]                 = $value;
            } else {
                $new_columns[ $key ] = $value;
            }
        }

        return $new_columns;
    }

    /**
     * Render custom admin columns
     *
     * @param string $column  Column name.
     * @param int    $post_id Post ID.
     */
    public static function render_admin_columns( $column, $post_id ) {
        // Check if ACF is available
        $has_acf = function_exists( 'get_field' );

        switch ( $column ) {
            case 'product_photo':
                if ( has_post_thumbnail( $post_id ) ) {
                    echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
                } else {
                    echo '<span style="color: #999;">—</span>';
                }
                break;

            case 'product_tag':
                $tag = $has_acf ? get_field( 'product_tag', $post_id ) : get_post_meta( $post_id, 'product_tag', true );
                if ( $tag ) {
                    printf(
                        '<span style="background: %s; color: white; padding: 3px 8px; border-radius: 3px; font-size: 11px; text-transform: uppercase;">%s</span>',
                        '#8a2040',
                        esc_html( $tag )
                    );
                } else {
                    echo '<span style="color: #999;">—</span>';
                }
                break;

            case 'product_price':
                $price = $has_acf ? get_field( 'product_price', $post_id ) : get_post_meta( $post_id, 'product_price', true );
                echo $price ? esc_html( $price ) : '<span style="color: #999;">—</span>';
                break;

            case 'product_availability':
                $availability = $has_acf ? get_field( 'product_availability', $post_id ) : get_post_meta( $post_id, 'product_availability', true );
                $labels = array(
                    'available'   => array( 'label' => __( 'Available', 'blue-raeven' ), 'color' => '#4a7637' ),
                    'seasonal'    => array( 'label' => __( 'Seasonal', 'blue-raeven' ), 'color' => '#d4a853' ),
                    'limited'     => array( 'label' => __( 'Limited', 'blue-raeven' ), 'color' => '#8a2040' ),
                    'coming_soon' => array( 'label' => __( 'Coming Soon', 'blue-raeven' ), 'color' => '#1a3a6b' ),
                    'sold_out'    => array( 'label' => __( 'Sold Out', 'blue-raeven' ), 'color' => '#666' ),
                );

                if ( isset( $labels[ $availability ] ) ) {
                    printf(
                        '<span style="color: %s; font-weight: 500;">%s</span>',
                        $labels[ $availability ]['color'],
                        esc_html( $labels[ $availability ]['label'] )
                    );
                } else {
                    echo '<span style="color: #999;">—</span>';
                }
                break;
        }
    }

    /**
     * Get featured products query
     *
     * @param int $count Number of products to return.
     * @return WP_Query
     */
    public static function get_featured_products( $count = 3 ) {
        return new WP_Query( array(
            'post_type'      => self::POST_TYPE,
            'posts_per_page' => $count,
            'meta_query'     => array(
                array(
                    'key'     => 'product_featured',
                    'value'   => '1',
                    'compare' => '=',
                ),
            ),
            'meta_key'       => 'product_sort_order',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
        ) );
    }

    /**
     * Get all available products
     *
     * @param int $count Number of products to return (-1 for all).
     * @return WP_Query
     */
    public static function get_available_products( $count = -1 ) {
        return new WP_Query( array(
            'post_type'      => self::POST_TYPE,
            'posts_per_page' => $count,
            'meta_query'     => array(
                array(
                    'key'     => 'product_availability',
                    'value'   => array( 'available', 'seasonal', 'limited' ),
                    'compare' => 'IN',
                ),
            ),
            'meta_key'       => 'product_sort_order',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
        ) );
    }
}
