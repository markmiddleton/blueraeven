<?php
/**
 * Title: Navigation Bar
 * Slug: blue-raeven/navigation-bar
 * Categories: blue-raeven-global
 * Description: Fixed header with centered logo, navigation links, and mobile toggle
 * Block Types: core/template-part/header
 */
?>
<!-- wp:html -->
<nav class="nav">
    <div class="container nav__inner">
        <div class="nav__links nav__links--left" id="navLinksLeft">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <div class="nav__dropdown">
                <a href="<?php echo esc_url( home_url( '/story/' ) ); ?>" class="nav__dropdown-trigger">Our Story</a>
                <div class="nav__dropdown-menu">
                    <a href="<?php echo esc_url( home_url( '/story/family-farm/' ) ); ?>">Family Farm</a>
                    <a href="<?php echo esc_url( home_url( '/story/fruit-from-the-farm/' ) ); ?>">Fruit From The Farm</a>
                </div>
            </div>
            <div class="nav__dropdown">
                <a href="<?php echo esc_url( home_url( '/pies-more/' ) ); ?>" class="nav__dropdown-trigger">Pies &amp; More</a>
                <div class="nav__dropdown-menu">
                    <a href="<?php echo esc_url( home_url( '/pies-more/pies/' ) ); ?>">Pies</a>
                    <a href="<?php echo esc_url( home_url( '/pies-more/jams-spreads/' ) ); ?>">Jams &amp; Spreads</a>
                    <a href="<?php echo esc_url( home_url( '/pies-more/other-confections/' ) ); ?>">Other Confections</a>
                    <a href="<?php echo esc_url( home_url( '/pies-more/baking-instructions-faqs/' ) ); ?>">Baking Instructions &amp; FAQs</a>
                </div>
            </div>
        </div>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav__brand">
            <div class="nav__logo-bg">
                <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/logo-navy.png" alt="Blue Raeven" class="nav__logo-img">
            </div>
        </a>
        <div class="nav__links nav__links--right" id="navLinksRight">
            <a href="<?php echo esc_url( home_url( '/farmstand/' ) ); ?>">Farmstand</a>
            <a href="<?php echo esc_url( home_url( '/wholesale-fundraising/' ) ); ?>">Wholesale</a>
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
        </div>
        <button class="nav__toggle" id="navToggle" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </div>
    <div class="nav__hatch" aria-hidden="true"></div>
</nav>
<!-- /wp:html -->
