<?php
/**
 * Hero Carousel — full-screen rotating hero with pan/video slides, brand
 * graphic, and indicators (Home page). Markup and inline JS mirror the
 * legacy hand-coded row exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$slides   = get_field( 'slides' );
$brand    = get_field( 'brand' );
$duration = (int) ( get_field( 'duration' ) ?: 12000 );

if ( ! $slides ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Hero Carousel — add slides.</p>';
    }
    return;
}
?>
<section class="hero hero--carousel">
    <div class="hero__slides">
<?php foreach ( $slides as $i => $slide ) :
    $active = 0 === $i ? ' active' : '';
    if ( 'video' === $slide['type'] ) :
        ?>
        <div class="hero__slide hero__slide--video<?php echo $active; ?>">
            <video class="hero__video" autoplay muted loop playsinline>
                <source src="<?php echo esc_url( wp_make_link_relative( $slide['video']['url'] ) ); ?>" type="video/mp4">
            </video>
        </div>
<?php else :
        $pan_cls = $slide['from_left'] ? 'hero__pan-image hero__pan-image--from-left' : 'hero__pan-image';
        ?>
        <div class="hero__slide hero__slide--pan<?php echo $active; ?>">
            <div class="<?php echo $pan_cls; ?>" style="background-image: url('<?php echo esc_url( wp_make_link_relative( $slide['image']['url'] ) ); ?>');"></div>
        </div>
<?php endif;
endforeach; ?>
    </div>
    <div class="hero__overlay"></div>
    <div class="hero__content hero__content--top">
        <img class="hero__brand-image" src="<?php echo esc_url( wp_make_link_relative( $brand['url'] ) ); ?>" alt="<?php echo esc_attr( $brand['alt'] ); ?>" decoding="async">
    </div>
    <div class="hero__indicators">
<?php foreach ( $slides as $i => $slide ) : ?>
        <button class="hero__indicator<?php echo 0 === $i ? ' active' : ''; ?>" data-slide="<?php echo $i; ?>"></button>
<?php endforeach; ?>
    </div>
</section>
<script>
(function() {
    const slides = document.querySelectorAll(".hero__slide");
    const indicators = document.querySelectorAll(".hero__indicator");
    const SLIDE_DURATION = <?php echo $duration; ?>; // <?php echo $duration / 1000; ?> seconds per slide
    let current = 0;
    let timer;

    // Ensure all videos are playing (they loop in background)
    function initVideos() {
        document.querySelectorAll(".hero__video").forEach(video => {
            video.play().catch(() => {});
        });
    }

    function showSlide(index) {
        // Update slide visibility
        slides.forEach((slide, i) => {
            slide.classList.toggle("active", i === index);
        });

        // Update indicators
        indicators.forEach((ind, i) => {
            ind.classList.toggle("active", i === index);
        });

        // Restart video from beginning when slide becomes active
        const activeVideo = slides[index].querySelector("video");
        if (activeVideo) {
            activeVideo.currentTime = 0;
            activeVideo.play().catch(() => {});
        }

        current = index;

        // Schedule next slide
        clearTimeout(timer);
        timer = setTimeout(nextSlide, SLIDE_DURATION);
    }

    function nextSlide() {
        showSlide((current + 1) % slides.length);
    }

    // Initialize
    initVideos();
    timer = setTimeout(nextSlide, SLIDE_DURATION);

    // Click indicators
    indicators.forEach(ind => {
        ind.addEventListener("click", () => {
            showSlide(parseInt(ind.dataset.slide));
        });
    });
})();
</script>
