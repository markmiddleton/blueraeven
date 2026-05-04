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
                <h3>Our Family, Our Farm, Our Pie Tradition</h3>
                <p>
                    Our story began on a 4th generation family farm in Amity, Oregon, where Ron and Jamie Lewis have been building their legacy in the Willamette Valley since 1987, growing the kind of fruit that tastes like sunshine, rain, and hard work all at once.
                </p>
                <p>
                    In 2007, we decided that the best use for our family-grown fruit was to create delicious, hand-crafted pies. We believe a great pie starts with great local fruit.
                </p>
                <a href="<?php echo esc_url( home_url( '/story/' ) ); ?>" class="btn btn--navy">Read Our Story</a>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
