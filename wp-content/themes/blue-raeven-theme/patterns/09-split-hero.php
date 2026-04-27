<?php
/**
 * Title: Split Hero
 * Slug: blue-raeven/split-hero
 * Categories: blue-raeven-heroes
 * Description: 50/50 image and text hero layout
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<div class="pie-hero-split">
    <div class="pie-hero-split__image">
        <img src="<?php echo esc_url( $base_url ); ?>/2026/04/pies_flatlay.jpg" alt="Berry pies flat lay" style="width:100%;height:100%;object-fit:cover;">
    </div>
    <div class="pie-hero-split__text">
        <h2>Baked Fresh Daily</h2>
        <div class="script">Reminiscent of the good ol' days</div>
        <p>
            Every Blue Raeven pie starts with fruit from our own fields. We hand-pick
            at peak ripeness and bake in small batches using family recipes.
        </p>
    </div>
</div>
<!-- /wp:html -->
