<?php
/**
 * Product Grid ACF Block Template
 *
 * Displays a grid of products with filtering options.
 * Uses ACF fields to customize the display.
 *
 * @package Blue_Raeven
 */

// Get block settings
$columns = get_field( 'columns' ) ?: 3;
$count = get_field( 'count' ) ?: 9;
$show_featured_only = get_field( 'featured_only' );
$category = get_field( 'category' );

// Build query args
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => $count,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
);

// Filter by featured
if ( $show_featured_only ) {
    $args['meta_query'] = array(
        array(
            'key'   => 'product_featured',
            'value' => '1',
        ),
    );
}

// Filter by category
if ( $category ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_category',
            'field'    => 'term_id',
            'terms'    => $category,
        ),
    );
}

$products = new WP_Query( $args );

if ( ! $products->have_posts() ) {
    echo '<p class="has-text-align-center has-warmgray-color">No products found. Check back soon!</p>';
    return;
}

$column_class = 'br-product-grid--cols-' . intval( $columns );
?>

<div class="br-product-grid <?php echo esc_attr( $column_class ); ?>">
    <?php while ( $products->have_posts() ) : $products->the_post();
        $product_id = get_the_ID();
        $product_tag = get_field( 'product_tag', $product_id );
        $product_price = get_field( 'product_price', $product_id );
        $product_availability = get_field( 'product_availability', $product_id );
        $featured_image = get_the_post_thumbnail_url( $product_id, 'product-card' );

        $availability_class = '';
        if ( $product_availability === 'limited' ) {
            $availability_class = 'br-product-card--limited';
        } elseif ( $product_availability === 'seasonal' ) {
            $availability_class = 'br-product-card--seasonal';
        } elseif ( $product_availability === 'coming_soon' ) {
            $availability_class = 'br-product-card--coming-soon';
        }
    ?>
        <div class="br-product-card <?php echo esc_attr( $availability_class ); ?>">
            <?php if ( $featured_image ) : ?>
                <div class="br-product-card__image">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo esc_url( $featured_image ); ?>" alt="<?php the_title_attribute(); ?>">
                    </a>
                </div>
            <?php endif; ?>

            <div class="br-product-card__content">
                <?php if ( $product_tag ) : ?>
                    <span class="br-product-card__tag"><?php echo esc_html( $product_tag ); ?></span>
                <?php endif; ?>

                <h3 class="br-product-card__title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <?php if ( has_excerpt() ) : ?>
                    <p class="br-product-card__description"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>

                <?php if ( $product_price ) : ?>
                    <span class="br-product-card__price"><?php echo esc_html( $product_price ); ?></span>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php wp_reset_postdata(); ?>
