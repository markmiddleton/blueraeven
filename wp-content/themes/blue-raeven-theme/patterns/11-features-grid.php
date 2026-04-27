<?php
/**
 * Title: Features Grid
 * Slug: blue-raeven/features-grid
 * Categories: blue-raeven-content
 * Description: 4-column icon feature cards
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<section class="section" style="padding: 2rem 0 3rem;">
    <div class="container">
        <div class="features">
            <div class="feature">
                <div class="feature__icon">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_fruit.png" alt="Farm Fresh Fruit">
                </div>
                <div class="feature__title">Farm Fresh Fruit</div>
                <div class="feature__desc">Picked at peak ripeness from our own Oregon fields.</div>
            </div>
            <div class="feature">
                <div class="feature__icon">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_pie.png" alt="Handcrafted Pies">
                </div>
                <div class="feature__title">Handcrafted Pies</div>
                <div class="feature__desc">Small-batch baked daily with time-honored family recipes.</div>
            </div>
            <div class="feature">
                <div class="feature__icon">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_heritage.png" alt="Family Heritage">
                </div>
                <div class="feature__title">Family Heritage</div>
                <div class="feature__desc">Generations of farming tradition in every bite.</div>
            </div>
            <div class="feature">
                <div class="feature__icon">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_farmstand.png" alt="Local Farm Stand">
                </div>
                <div class="feature__title">Local Farm Stand</div>
                <div class="feature__desc">A welcoming stop for fresh fruit, pies, and community.</div>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
