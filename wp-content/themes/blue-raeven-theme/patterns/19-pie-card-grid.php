<?php
/**
 * Title: Pie Card Grid
 * Slug: blue-raeven/pie-card-grid
 * Categories: blue-raeven-cards
 * Description: Product card grid with tags and prices
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<section class="section section--cream">
    <div class="container">
        <div class="section__header">
            <div class="section__label">The Menu</div>
            <h2 class="section__title">Our Seasonal Selection</h2>
            <div class="section__script">Let us take you back!</div>
            <div class="section__divider"></div>
        </div>
        <p class="section__intro">Our pies rotate with the seasons, featuring whatever is freshest from the fields. Here are some of our most beloved flavors.</p>
        <div class="pies-grid">
            <div class="pie-card">
                <div class="pie-card__image">
                    <span class="pie-card__tag">Signature</span>
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/marionberry_pie.jpg" alt="Marionberry Pie">
                </div>
                <div class="pie-card__body">
                    <h3 class="pie-card__name">Marionberry Pie</h3>
                    <p class="pie-card__desc">Oregon's prized marionberry baked in a buttery, flaky crust. Sweet, tangy, and unforgettable.</p>
                    <div class="pie-card__meta">
                        <div class="pie-card__fruit"><img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_fruit.png" alt="" style="width:28px;height:28px;"></div>
                        <div class="pie-card__price">Seasonal</div>
                    </div>
                </div>
            </div>
            <div class="pie-card">
                <div class="pie-card__image">
                    <span class="pie-card__tag">Classic</span>
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/triple_berry_pie.jpg" alt="Triple Berry Pie">
                </div>
                <div class="pie-card__body">
                    <h3 class="pie-card__name">Triple Berry Pie</h3>
                    <p class="pie-card__desc">A medley of blueberries, raspberries, and blackberries in our signature lattice-top crust.</p>
                    <div class="pie-card__meta">
                        <div class="pie-card__fruit"><img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_fruit.png" alt="" style="width:28px;height:28px;"></div>
                        <div class="pie-card__price">Seasonal</div>
                    </div>
                </div>
            </div>
            <div class="pie-card">
                <div class="pie-card__image">
                    <span class="pie-card__tag">Comfort</span>
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/blueberry_crumble_pie.jpg" alt="Blueberry Crumble">
                </div>
                <div class="pie-card__body">
                    <h3 class="pie-card__name">Blueberry Crumble</h3>
                    <p class="pie-card__desc">Plump blueberries under a golden brown sugar crumble topping. Comfort in every forkful.</p>
                    <div class="pie-card__meta">
                        <div class="pie-card__fruit"><img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_fruit.png" alt="" style="width:28px;height:28px;"></div>
                        <div class="pie-card__price">Seasonal</div>
                    </div>
                </div>
            </div>
            <div class="pie-card">
                <div class="pie-card__image">
                    <span class="pie-card__tag">Farm Fresh</span>
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/strawberry_rhubarb_pie.jpg" alt="Strawberry Rhubarb Pie">
                </div>
                <div class="pie-card__body">
                    <h3 class="pie-card__name">Strawberry Rhubarb</h3>
                    <p class="pie-card__desc">The perfect balance of sweet strawberry and tart rhubarb, straight from the spring harvest.</p>
                    <div class="pie-card__meta">
                        <div class="pie-card__fruit"><img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_fruit.png" alt="" style="width:28px;height:28px;"></div>
                        <div class="pie-card__price">Seasonal</div>
                    </div>
                </div>
            </div>
            <div class="pie-card">
                <div class="pie-card__image">
                    <span class="pie-card__tag">Limited</span>
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/pecan_pie.jpg" alt="Pecan Pie">
                </div>
                <div class="pie-card__body">
                    <h3 class="pie-card__name">Pecan Pie</h3>
                    <p class="pie-card__desc">Rich, buttery pecan filling in a golden crust, topped with a generous layer of toasted pecans.</p>
                    <div class="pie-card__meta">
                        <div class="pie-card__fruit"><img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_fruit.png" alt="" style="width:28px;height:28px;"></div>
                        <div class="pie-card__price">Seasonal</div>
                    </div>
                </div>
            </div>
            <div class="pie-card">
                <div class="pie-card__image">
                    <span class="pie-card__tag">Northwest</span>
                    <img src="<?php echo esc_url( $base_url ); ?>/2026/04/boysenberry_pie.jpg" alt="Boysenberry Pie">
                </div>
                <div class="pie-card__body">
                    <h3 class="pie-card__name">Boysenberry Pie</h3>
                    <p class="pie-card__desc">Deep, rich boysenberry filling in a perfectly golden crust. A Pacific Northwest classic.</p>
                    <div class="pie-card__meta">
                        <div class="pie-card__fruit"><img src="<?php echo esc_url( $base_url ); ?>/2026/04/icon_fruit.png" alt="" style="width:28px;height:28px;"></div>
                        <div class="pie-card__price">Seasonal</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /wp:html -->
