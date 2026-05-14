<?php /* Force sync: 2026-05-13 */ ?>
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
                <a href="<?php echo esc_url( home_url( '/pies-more/' ) ); ?>" class="nav__dropdown-trigger">Pies &amp; More</a>
                <div class="nav__dropdown-menu">
                    <a href="<?php echo esc_url( home_url( '/pies-more/pies/' ) ); ?>">Pies</a>
                    <a href="<?php echo esc_url( home_url( '/pies-more/jams-spreads/' ) ); ?>">Jams &amp; Spreads</a>
                    <a href="<?php echo esc_url( home_url( '/pies-more/other-confections/' ) ); ?>">Other Confections</a>
                    <a href="<?php echo esc_url( home_url( '/pies-more/baking-instructions-faqs/' ) ); ?>">Baking Instructions &amp; FAQs</a>
                </div>
            </div>
            <div class="nav__dropdown">
                <a href="<?php echo esc_url( home_url( '/story/' ) ); ?>" class="nav__dropdown-trigger">Our Story</a>
                <div class="nav__dropdown-menu">
                    <a href="<?php echo esc_url( home_url( '/story/fine-ingredients/' ) ); ?>">Fine Ingredients</a>
                </div>
            </div>
        </div>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav__brand">
            <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/blue-raeven-farms-logo.png" alt="Blue Raeven" class="nav__logo-img nav__logo-img--desktop">
            <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/blue-raeven-farms-logo-mobile.png" alt="Blue Raeven" class="nav__logo-img nav__logo-img--mobile">
        </a>
        <div class="nav__links nav__links--right" id="navLinksRight">
            <a href="<?php echo esc_url( home_url( '/farmstand/' ) ); ?>">Find Us</a>
            <a href="<?php echo esc_url( home_url( '/wholesale-fundraising/' ) ); ?>">Wholesale</a>
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
        </div>
        <button class="nav__toggle" id="navToggle" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </div>
    <div class="picket-fence-separator" aria-hidden="true"></div>
    <!-- Mobile Menu Panel -->
    <div class="nav__mobile-menu" id="navMobileMenu">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
        <div class="nav__mobile-dropdown">
            <button class="nav__mobile-dropdown-trigger" type="button">
                Pies &amp; More
                <svg class="nav__mobile-arrow" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
            </button>
            <a href="<?php echo esc_url( home_url( '/pies-more/' ) ); ?>" class="nav__mobile-parent-link">Pies &amp; More Overview</a>
            <div class="nav__mobile-submenu">
                <a href="<?php echo esc_url( home_url( '/pies-more/pies/' ) ); ?>">Pies</a>
                <a href="<?php echo esc_url( home_url( '/pies-more/jams-spreads/' ) ); ?>">Jams &amp; Spreads</a>
                <a href="<?php echo esc_url( home_url( '/pies-more/other-confections/' ) ); ?>">Other Confections</a>
                <a href="<?php echo esc_url( home_url( '/pies-more/baking-instructions-faqs/' ) ); ?>">Baking Instructions &amp; FAQs</a>
            </div>
        </div>
        <div class="nav__mobile-dropdown">
            <button class="nav__mobile-dropdown-trigger" type="button">
                Our Story
                <svg class="nav__mobile-arrow" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
            </button>
            <a href="<?php echo esc_url( home_url( '/story/' ) ); ?>" class="nav__mobile-parent-link">Our Story Overview</a>
            <div class="nav__mobile-submenu">
                <a href="<?php echo esc_url( home_url( '/story/fine-ingredients/' ) ); ?>">Fine Ingredients</a>
            </div>
        </div>
        <a href="<?php echo esc_url( home_url( '/farmstand/' ) ); ?>">Find Us</a>
        <a href="<?php echo esc_url( home_url( '/wholesale-fundraising/' ) ); ?>">Wholesale</a>
        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
    </div>
</nav>
<!-- /wp:html -->
