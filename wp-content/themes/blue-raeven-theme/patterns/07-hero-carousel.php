<?php
/**
 * Title: Hero Carousel
 * Slug: blue-raeven/hero-carousel
 * Categories: blue-raeven-heroes
 * Description: Full-screen hero with rotating background slides
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<section class="hero">
    <div class="hero__carousel">
        <div class="hero__slide active" style="background-image: url('<?php echo esc_url( $base_url ); ?>/2026/04/hero_farm.jpg');"></div>
        <div class="hero__slide" style="background-image: url('<?php echo esc_url( $base_url ); ?>/2026/04/hero_pie.jpg');"></div>
        <div class="hero__slide" style="background-image: url('<?php echo esc_url( $base_url ); ?>/2026/04/hero_farmstand.jpg');"></div>
    </div>
    <div class="hero__overlay"></div>
    <div class="hero__indicators">
        <button class="hero__indicator active" data-slide="0" aria-label="Slide 1"></button>
        <button class="hero__indicator" data-slide="1" aria-label="Slide 2"></button>
        <button class="hero__indicator" data-slide="2" aria-label="Slide 3"></button>
    </div>
    <div class="hero__content">
        <h1 class="hero__title"><span class="hero__title-line">Blue <em>Raeven</em> Pie Company</span></h1>
        <p class="hero__script">Because Pie Fixes Everything &reg;</p>
        <p class="hero__desc">
            From our family farm to your table &ndash; handcrafted pies and preserves made with our own fruit, baked with our family recipes, and served with love.
        </p>
        <div class="hero__actions">
            <a href="<?php echo esc_url( home_url( '/pies-more/' ) ); ?>" class="btn btn--primary">Explore Our Pies</a>
            <a href="<?php echo esc_url( home_url( '/farmstand/' ) ); ?>" class="btn btn--outline">Visit the Farm Stand</a>
        </div>
    </div>
</section>
<!-- /wp:html -->
