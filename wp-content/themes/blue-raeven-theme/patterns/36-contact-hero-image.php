<?php
/**
 * Title: Contact Hero Image
 * Slug: blue-raeven/contact-hero-image
 * Categories: blue-raeven-heroes
 * Description: Photo banner with overlay text
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<div class="contact-hero-image">
    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/contact_banner.jpg" alt="Farm lifestyle">
    <div class="contact-hero-image__overlay">
        <h2>Say Hello</h2>
        <p>from our farm to your inbox</p>
    </div>
</div>
<!-- /wp:html -->
