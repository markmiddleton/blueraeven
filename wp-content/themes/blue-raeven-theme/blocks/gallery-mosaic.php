<?php
/**
 * Gallery Mosaic — square photo mosaic with crossfade rotation
 * (Our Story / Farmstand "Fields & Family" style). Markup and inline JS
 * mirror the legacy hand-coded row exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$label   = get_field( 'label' );
$title   = get_field( 'title' );
$tiles   = get_field( 'tiles' );
$pool    = get_field( 'pool' );
$swap_ms = (int) ( get_field( 'swap_ms' ) ?: 3500 );
$fade_ms = (int) ( get_field( 'fade_ms' ) ?: 900 );
$anchor  = get_field( 'anchor' ) ?: 'storyGallery';

if ( ! $tiles || ! $pool ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Gallery Mosaic — choose starting photos and a rotation pool.</p>';
    }
    return;
}

// Alt for JS-inserted rotation images: follow the first tile's alt text.
$rotation_alt = $tiles[0]['alt'];
?>
<section class="section section--cream">
    <div class="container">
        <div class="section__header">
            <div class="section__label"><?php echo esc_html( $label ); ?></div>
            <h2 class="section__title"><?php echo esc_html( $title ); ?></h2>
            <div class="section__divider"></div>
        </div>
        <div class="gallery" id="<?php echo esc_attr( $anchor ); ?>">
<?php foreach ( $tiles as $i => $tile ) :
    $cls = 0 === $i ? 'gallery__item gallery__item--large' : 'gallery__item';
    ?>
            <div class="<?php echo $cls; ?>"><img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $tile['url'] ) ); ?>" alt="<?php echo esc_attr( $tile['alt'] ); ?>" loading="lazy"></div>
<?php endforeach; ?>
        </div>
        <script>
        (function(){
            var POOL = [
<?php
$pool_count = count( $pool );
foreach ( $pool as $i => $img ) {
    $comma = ( $i < $pool_count - 1 ) ? ',' : '';
    echo '                "' . esc_url( wp_make_link_relative( $img['url'] ) ) . '"' . $comma . "\n";
}
?>
            ];
            var gallery = document.getElementById('<?php echo esc_js( $anchor ); ?>');
            if (!gallery) return;
            var items = Array.prototype.slice.call(gallery.querySelectorAll('.gallery__item'));
            var SWAP_MS = <?php echo $swap_ms; ?>, FADE_MS = <?php echo $fade_ms; ?>;
            function topSrc(item){
                var imgs = item.getElementsByTagName('img');
                return imgs.length ? imgs[imgs.length - 1].getAttribute('src') : null;
            }
            function inUse(){ return items.map(topSrc); }
            var queue = [];
            function shuffle(a){
                for (var i = a.length - 1; i > 0; i--){
                    var j = Math.floor(Math.random() * (i + 1));
                    var t = a[i]; a[i] = a[j]; a[j] = t;
                }
                return a;
            }
            // Cycle through a shuffled queue of the whole pool; every image is shown
            // once before any repeats. Skip items currently on-screen so no two tiles
            // display the same image at the same time.
            function pickNext(){
                if (queue.length === 0) queue = shuffle(POOL.slice());
                var used = inUse();
                for (var i = 0; i < queue.length; i++){
                    if (used.indexOf(queue[i]) === -1) return queue.splice(i, 1)[0];
                }
                // Every queued item happens to be on-screen; reshuffle and retry.
                queue = shuffle(POOL.slice());
                return pickNext();
            }
            function swapOne(){
                var item = items[Math.floor(Math.random() * items.length)];
                if (item.getAttribute('data-swapping') === '1') return;
                var next = pickNext();
                var pre = new Image();
                pre.onload = function(){
                    item.setAttribute('data-swapping', '1');
                    var overlay = document.createElement('img');
                    overlay.className = 'is-incoming';
                    overlay.alt = '<?php echo esc_js( $rotation_alt ); ?>';
                    overlay.src = next;
                    item.appendChild(overlay);          // layered on top of current
                    void overlay.offsetWidth;           // reflow so opacity:0 takes effect
                    requestAnimationFrame(function(){
                        overlay.classList.remove('is-incoming');  // crossfade in
                    });
                    setTimeout(function(){
                        var imgs = item.getElementsByTagName('img');
                        while (imgs.length > 1) { item.removeChild(imgs[0]); } // drop old layer
                        item.setAttribute('data-swapping', '0');
                    }, FADE_MS + 80);
                };
                pre.src = next;
            }
            setInterval(swapOne, SWAP_MS);
        })();
        </script>
    </div>
</section>
