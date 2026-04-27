<?php
/**
 * Title: Story Block Left
 * Slug: blue-raeven/story-block-left
 * Categories: blue-raeven-content
 * Description: Image left, text right with gold frame accent
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<section class="section">
    <div class="container">
        <div class="story">
            <div class="story__image-wrap">
                <div class="story__image-frame">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/farm_photo.jpg" alt="Oregon berry farmer with fresh harvest">
                </div>
                <div class="story__frame-accent"></div>
            </div>
            <div class="story__text">
                <h3>Rooted in Oregon Soil</h3>
                <p>
                    What began as a family passion for growing the finest berries in
                    Oregon's Willamette Valley has blossomed into something truly special.
                    Blue Raeven is more than a farm &mdash; it's a gathering place where
                    the land, the fruit, and the community come together.
                </p>
                <p>
                    Every pie we bake starts in our fields. We grow the berries, pick
                    them at their peak, and craft each pie by hand using recipes passed
                    down through generations.
                </p>
                <a href="<?php echo esc_url( home_url( '/story/' ) ); ?>" class="btn btn--navy">Read Our Story</a>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
