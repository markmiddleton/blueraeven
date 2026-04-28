<?php
/**
 * Title: Features Grid
 * Slug: blue-raeven/features-grid
 * Categories: blue-raeven-content
 * Description: 3-column icon feature cards
 */
$icons_url = get_theme_file_uri( 'assets/icons' );
?>
<!-- wp:html -->
<section class="section" style="padding: 2rem 0 3rem;">
    <div class="container">
        <div class="features">
            <div class="feature">
                <div class="feature__icon">
                    <img src="<?php echo esc_url( $icons_url ); ?>/our-pies.png" alt="Our Pies">
                </div>
                <div class="feature__title">Our Pies</div>
                <div class="feature__desc">Small-batch baked daily with time-honored family recipes.</div>
            </div>
            <div class="feature">
                <div class="feature__icon">
                    <img src="<?php echo esc_url( $icons_url ); ?>/our-story.png" alt="Our Story">
                </div>
                <div class="feature__title">Our Story</div>
                <div class="feature__desc">Generations of farming tradition in the heart of Oregon wine country.</div>
            </div>
            <div class="feature">
                <div class="feature__icon">
                    <img src="<?php echo esc_url( $icons_url ); ?>/where-to-buy.png" alt="Where to Buy">
                </div>
                <div class="feature__title">Where to Buy</div>
                <div class="feature__desc">Find our pies at the farm stand and select local retailers.</div>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
