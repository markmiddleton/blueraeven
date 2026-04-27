<?php
/**
 * Title: Mosaic Hero
 * Slug: blue-raeven/mosaic-hero
 * Categories: blue-raeven-heroes
 * Description: 2x2 image grid with text overlay
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<div class="visit-hero-mosaic">
    <div class="visit-hero-mosaic__main">
        <img src="<?php echo esc_url( $base_url ); ?>/2026/04/visit_hero.jpg" alt="Blue Raeven Farm Stand" style="width:100%;height:100%;object-fit:cover;">
        <div class="visit-hero-mosaic__overlay">
            <h2>Come Visit Us</h2>
            <p>at the farm stand</p>
        </div>
    </div>
    <div class="visit-hero-mosaic__side">
        <img src="<?php echo esc_url( $base_url ); ?>/2026/04/visit_scene1.jpg" alt="Farm stand scene" style="width:100%;height:100%;object-fit:cover;">
    </div>
    <div class="visit-hero-mosaic__side">
        <img src="<?php echo esc_url( $base_url ); ?>/2026/04/visit_scene2.jpg" alt="Berry picking" style="width:100%;height:100%;object-fit:cover;">
    </div>
</div>
<!-- /wp:html -->
