<?php
/**
 * Title: CTA Banner - Pies
 * Slug: blue-raeven/cta-banner-pies
 * Categories: blue-raeven-ctas
 * Description: CTA with two buttons for visit and order
 */
?>
<!-- wp:html -->
<section class="section">
    <div class="container">
        <div class="cta-banner" style="padding-top:0;">
            <p class="cta-banner__text">Come taste the difference</p>
            <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
                <a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>" class="btn btn--primary">Visit the Farm Stand</a>
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--navy">Place a Special Order</a>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
