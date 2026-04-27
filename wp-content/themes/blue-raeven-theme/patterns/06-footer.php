<?php
/**
 * Title: Footer
 * Slug: blue-raeven/footer
 * Categories: blue-raeven-global
 * Description: 4-column footer with brand, links and copyright
 * Block Types: core/template-part/footer
 */
?>
<!-- wp:html -->
<footer class="footer">
    <div class="container">
        <div class="footer__inner">
            <div>
                <div class="footer__brand-name">Blue <span>Raeven</span></div>
                <p class="footer__brand-desc">Family heritage that delivers on community values. Local, fruit-forward, made with Oregon's finest fruit from our family farm.</p>
            </div>
            <div>
                <div class="footer__heading">Explore</div>
                <ul class="footer__link-list">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/story/' ) ); ?>">Our Story</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/products/' ) ); ?>">Our Pies</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>">Farm Stand</a></li>
                </ul>
            </div>
            <div>
                <div class="footer__heading">Visit</div>
                <ul class="footer__link-list">
                    <li><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>">Directions</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>">Hours</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <div class="footer__heading">Connect</div>
                <ul class="footer__link-list">
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Newsletter</a></li>
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            <span>&copy; <?php echo date('Y'); ?> Blue Raeven Farm &amp; Pie. All rights reserved.</span>
            <span>Amity, Oregon</span>
            <a href="https://brilliancenw.com" class="footer__credit">Site by Brilliance</a>
        </div>
    </div>
</footer>
<!-- /wp:html -->
