<?php
/**
 * Title: What You'll Find Cards
 * Slug: blue-raeven/what-youll-find
 * Categories: blue-raeven-cards
 * Description: 3-column offering cards with images
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<section class="section section--cream">
    <div class="container">
        <div class="section__header">
            <div class="section__label">At the Stand</div>
            <h2 class="section__title">What You'll Find</h2>
            <div class="section__script">Fresh from the farm, every day</div>
            <div class="section__divider"></div>
        </div>
        <div class="what-youll-find">
            <div class="find-card">
                <div class="find-card__image">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/visit_pies.jpg" alt="Handcrafted pies" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="find-card__body">
                    <h3 class="find-card__title">Handcrafted Pies</h3>
                    <p class="find-card__desc">Baked fresh daily using our own berries and family recipes.</p>
                </div>
            </div>
            <div class="find-card">
                <div class="find-card__image">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/visit_berries.jpg" alt="Fresh berries" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="find-card__body">
                    <h3 class="find-card__title">Fresh Berries</h3>
                    <p class="find-card__desc">Hand-picked blueberries, marionberries, blackberries.</p>
                </div>
            </div>
            <div class="find-card">
                <div class="find-card__image">
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/visit_jams.jpg" alt="Jams and preserves" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="find-card__body">
                    <h3 class="find-card__title">Jams &amp; Preserves</h3>
                    <p class="find-card__desc">Small-batch jams made with the same fruit we put in our pies.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
