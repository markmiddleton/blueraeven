<?php
/**
 * Title: Process Steps
 * Slug: blue-raeven/process-steps
 * Categories: blue-raeven-content
 * Description: Numbered 4-column process steps
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<section class="section">
    <div class="container">
        <div class="section__header">
            <div class="section__label">Farm to Pie</div>
            <h2 class="section__title">How We Bake</h2>
            <div class="section__divider"></div>
        </div>
        <div class="process-steps">
            <div class="process-step">
                <div class="process-step__image">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_fruit.png" alt="Hand-Picked" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                </div>
                <div class="process-step__title">Hand-Picked</div>
                <div class="process-step__desc">Every berry is picked by hand at the peak of ripeness.</div>
            </div>
            <div class="process-step">
                <div class="process-step__image">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_fruit.png" alt="Sorted" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                </div>
                <div class="process-step__title">Sorted &amp; Selected</div>
                <div class="process-step__desc">Only the finest fruit makes the cut.</div>
            </div>
            <div class="process-step">
                <div class="process-step__image">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_pie.png" alt="Crafted" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                </div>
                <div class="process-step__title">Crafted by Hand</div>
                <div class="process-step__desc">Each crust is rolled and filled with care.</div>
            </div>
            <div class="process-step">
                <div class="process-step__image">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_pie.png" alt="Baked" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                </div>
                <div class="process-step__title">Baked to Perfection</div>
                <div class="process-step__desc">Golden crust, bubbling fruit. Fresh from our ovens.</div>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
