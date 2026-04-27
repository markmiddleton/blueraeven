<?php
/**
 * Title: Order Callout
 * Slug: blue-raeven/order-callout
 * Categories: blue-raeven-ctas
 * Description: Image and text CTA for special orders
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<section class="section">
    <div class="container">
        <div class="order-callout">
            <div class="order-callout__image">
                <img src="<?php echo esc_url( $base_url ); ?>/2026/04/contact_giftbox.jpg" alt="Pie gift box" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <div class="order-callout__text">
                <h3>Special Orders &amp; Events</h3>
                <p>
                    Planning a wedding, corporate event, or family reunion? We offer
                    bulk pie orders, custom flavors, and special packaging for your occasion.
                </p>
                <a href="tel:5035550142" class="btn btn--berry" style="align-self:flex-start;">
                    Call to Order
                </a>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
