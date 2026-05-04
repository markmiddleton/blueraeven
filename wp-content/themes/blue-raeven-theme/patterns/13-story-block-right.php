<?php
/**
 * Title: Story Block Right
 * Slug: blue-raeven/story-block-right
 * Categories: blue-raeven-content
 * Description: Image right, text left with gold frame accent
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<section class="section">
    <div class="container">
        <div class="story" style="direction: rtl;">
            <div style="direction: ltr;">
                <div class="story__text">
                    <h3>Pies Fix Everything</h3>
                    <p>
                        Every pie begins long before it reaches your table. It starts in the fields, where we choose varieties for flavor, not production. We harvest berries at peak ripeness and freeze them to lock in flavor and juiciness year-round.
                    </p>
                    <p>
                        As our team has grown, we still show up early, work hard, and treat everyone as an extension of our own family. We believe in supporting our neighbors, honoring our roots, and sharing the kind of pie goodness that brings people closer.
                    </p>
                    <p><strong>Enjoy our pie and welcome to our family.</strong><br>&mdash; The Lewis Family</p>
                </div>
            </div>
            <div style="direction: ltr;">
                <div class="story__image-wrap">
                    <div class="story__image-frame">
                        <img src="<?php echo esc_url( $base_url ); ?>/2026/04/story_baking.jpg" alt="Handcrafted pie making">
                    </div>
                    <div class="story__frame-accent"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
