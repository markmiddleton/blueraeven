<?php
/**
 * Title: Image Gallery
 * Slug: blue-raeven/image-gallery
 * Categories: blue-raeven-content
 * Description: Masonry 3-column image gallery
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<section class="section section--cream">
    <div class="container">
        <div class="section__header">
            <div class="section__label">Life on the Farm</div>
            <h2 class="section__title">Our Fields &amp; Family</h2>
            <div class="section__divider"></div>
        </div>
        <div class="gallery">
            <div class="gallery__item gallery__item--tall">
                <img src="<?php echo esc_url( $base_url ); ?>/2026/04/gallery_tall1.jpg" alt="Oregon berry farm at sunrise">
            </div>
            <div class="gallery__item">
                <img src="<?php echo esc_url( $base_url ); ?>/2026/04/gallery1.jpg" alt="Fresh picked blackberries">
            </div>
            <div class="gallery__item">
                <img src="<?php echo esc_url( $base_url ); ?>/2026/04/gallery2.jpg" alt="Pie cooling on windowsill">
            </div>
            <div class="gallery__item">
                <img src="<?php echo esc_url( $base_url ); ?>/2026/04/gallery3.jpg" alt="Family berry picking">
            </div>
            <div class="gallery__item">
                <img src="<?php echo esc_url( $base_url ); ?>/2026/04/gallery4.jpg" alt="Hands holding blueberries">
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
