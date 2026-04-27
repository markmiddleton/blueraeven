<?php
/**
 * Title: Photo Banner
 * Slug: blue-raeven/photo-banner
 * Categories: blue-raeven-content
 * Description: Full-width image banner strip
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<div class="photo-banner">
    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/farm_banner.jpg" alt="Oregon berry farm panoramic view">
</div>
<!-- /wp:html -->
