<?php
/**
 * Title: Seasonal Callout
 * Slug: blue-raeven/seasonal-callout
 * Categories: blue-raeven-ctas
 * Description: U-Pick seasonal callout with circular image
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<section class="section">
    <div class="container">
        <div class="seasonal-callout">
            <div class="seasonal-callout__image">
                <img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_fruit.png" alt="U-Pick" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            </div>
            <div>
                <div class="seasonal-callout__title">U-Pick Berry Season</div>
                <p class="seasonal-callout__text">
                    During peak season, bring the family out for our U-Pick experience.
                    Grab a basket and head into the fields to pick your own berries
                    fresh off the vine. It's a favorite tradition for families all
                    across the valley. Check our social media for current picking
                    conditions and availability.
                </p>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
