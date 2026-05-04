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
        <h2>The Blue Raeven Difference</h2>
        <div class="script">Fruit-Forward Flavor</div>
        <p>
            Every Blue Raeven pie and gourmet jam starts with fruit from our own fields or local producers. We hand-pick at peak ripeness and bake in small batches using family recipes. No preservatives, no fillers &mdash; just honest, fruit-forward flavor in a flaky crust.
        </p>
    </div>
</div>
<!-- /wp:html -->
