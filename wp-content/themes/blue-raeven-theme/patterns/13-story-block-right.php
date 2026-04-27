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
                    <h3>From Our Farm to Your Table</h3>
                    <p>
                        We take pride in every step of the process. From carefully tending
                        our berry fields through the growing season, to hand-picking at
                        the perfect moment of ripeness.
                    </p>
                    <p>
                        Our pies aren't made in a factory. They're crafted in our kitchen,
                        by people who care deeply about quality and tradition.
                    </p>
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
