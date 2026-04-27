<?php
/**
 * Title: Pie Feature Block
 * Slug: blue-raeven/pie-feature-block
 * Categories: blue-raeven-content
 * Description: Alternating 50/50 feature sections
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<div class="pie-feature">
    <div class="pie-feature__image">
        <img src="<?php echo esc_url( $base_url ); ?>/2026/04/pie_closeup.jpg" alt="Close up of berry pie slice" style="width:100%;height:100%;object-fit:cover;">
    </div>
    <div class="pie-feature__text" style="background: var(--cream-warm);">
        <div class="pie-feature__label">The Blue Raeven Difference</div>
        <h3 class="pie-feature__name">Fruit-Forward Flavor</h3>
        <p class="pie-feature__desc">
            Our pies are loaded with fruit &mdash; not fillers. We use a higher
            fruit-to-crust ratio than most, so every bite bursts with real berry flavor.
        </p>
    </div>
</div>
<div class="pie-feature pie-feature--reverse pie-feature--dark">
    <div class="pie-feature__image">
        <img src="<?php echo esc_url( $base_url ); ?>/2026/04/pie_boxes.jpg" alt="Blue Raeven pie boxes" style="width:100%;height:100%;object-fit:cover;">
    </div>
    <div class="pie-feature__text">
        <div class="pie-feature__label" style="color:var(--aqua-light);">Take One Home</div>
        <h3 class="pie-feature__name">Ready for Your Table</h3>
        <p class="pie-feature__desc">
            Every pie is packaged with care in our signature Blue Raeven box.
            Whether you're taking one home or gifting to a friend.
        </p>
    </div>
</div>
<!-- /wp:html -->
