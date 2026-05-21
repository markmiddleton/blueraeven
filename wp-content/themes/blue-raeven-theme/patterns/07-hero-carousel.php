<?php
/**
 * Title: Hero Carousel
 * Slug: blue-raeven/hero-carousel
 * Categories: blue-raeven-heroes
 * Description: Full-screen hero with slow pan background
 */
$theme_url = get_template_directory_uri();
?>
<!-- wp:html -->
<section class="hero hero--pan">
    <div class="hero__pan-image" style="background-image: url('<?php echo esc_url( $theme_url ); ?>/assets/images/blue-raeven-farmtable.jpg');"></div>
    <div class="hero__overlay"></div>
    <div class="hero__content">
        <h1 class="hero__title"><span class="hero__title-line">Blue <em>Raeven</em> Pie Company</span></h1>
        <p class="hero__script">Because Pie Fixes Everything &reg;</p>
        <div class="hero__actions">
            <a href="<?php echo esc_url( home_url( '/pies-more/' ) ); ?>" class="btn btn--primary">Explore Our Pies</a>
            <a href="<?php echo esc_url( home_url( '/farmstand/' ) ); ?>" class="btn btn--outline">Visit the Farm Stand</a>
        </div>
    </div>
</section>
<!-- /wp:html -->
