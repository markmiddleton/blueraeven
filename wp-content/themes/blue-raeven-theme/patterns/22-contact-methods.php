<?php
/**
 * Title: Contact Methods Grid
 * Slug: blue-raeven/contact-methods
 * Categories: blue-raeven-cards
 * Description: 3-column contact info cards with icons
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<section class="section">
    <div class="container">
        <div class="contact-methods">
            <div class="contact-method">
                <div class="contact-method__icon"><img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_farmstand.png" alt="" style="width:100%;height:100%;object-fit:contain;"></div>
                <div class="contact-method__title">Visit Us</div>
                <div class="contact-method__text">
                    20650 S. Hwy 99W<br>
                    Amity, Oregon 97101<br>
                    <a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>">Get Directions</a>
                </div>
            </div>
            <div class="contact-method">
                <div class="contact-method__icon"><img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_heritage.png" alt="" style="width:100%;height:100%;object-fit:contain;"></div>
                <div class="contact-method__title">Call Us</div>
                <div class="contact-method__text">
                    (503) 555-0142<br>
                    Mon&ndash;Sat, 9am&ndash;6pm<br>
                    <a href="tel:5035550142">Give Us a Ring</a>
                </div>
            </div>
            <div class="contact-method">
                <div class="contact-method__icon"><img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_pie.png" alt="" style="width:100%;height:100%;object-fit:contain;"></div>
                <div class="contact-method__title">Email Us</div>
                <div class="contact-method__text">
                    hello@blueraeven.com<br>
                    We reply within 24 hours<br>
                    <a href="mailto:hello@blueraeven.com">Send a Message</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
