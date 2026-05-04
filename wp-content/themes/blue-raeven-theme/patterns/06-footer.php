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
        <div class="footer__inner footer__inner--three-col">
            <div>
                <div class="footer__heading">Explore</div>
                <ul class="footer__link-list">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/story/' ) ); ?>">Our Story</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/pies-more/' ) ); ?>">Our Pies</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/farmstand/' ) ); ?>">Find Us</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/wholesale-fundraising/' ) ); ?>">Wholesale &amp; Fundraising</a></li>
                </ul>
            </div>
            <div>
                <div class="footer__heading">Visit</div>
                <ul class="footer__link-list footer__link-list--visit">
                    <li>
                        <a href="https://maps.google.com/?q=20650+S+Hwy+99W,+Amity,+OR+97101" target="_blank" rel="noopener">Amity Farm Stand</a>
                        <span class="footer__hours">Mon–Sat: 9am–5:30pm; Sun: 10am–5pm</span>
                    </li>
                    <li>
                        <a href="https://maps.google.com/?q=1101+NE+Alpine+Ave,+McMinnville,+OR+97128" target="_blank" rel="noopener">McMinnville Pie Shop</a>
                        <span class="footer__hours">Tue–Sat: 10am–5:30pm</span>
                    </li>
                    <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <div class="footer__heading">Connect</div>
                <ul class="footer__link-list">
                    <li><a href="https://www.facebook.com/blueraevenfarmstand" target="_blank" rel="noopener">Facebook</a></li>
                    <li><a href="https://www.instagram.com/blueraevenpie" target="_blank" rel="noopener">Instagram</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Newsletter</a></li>
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            <span>&copy; <?php echo date('Y'); ?> Blue Raeven Farm &amp; Pie. All rights reserved.</span>
        </div>
    </div>
</footer>
<!-- /wp:html -->
