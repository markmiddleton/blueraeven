<?php
/**
 * Title: Navigation Bar
 * Slug: blue-raeven/navigation-bar
 * Categories: blue-raeven-global
 * Description: Fixed header with logo, navigation links, and mobile toggle
 * Block Types: core/template-part/header
 */
?>
<!-- wp:html -->
<nav class="nav">
    <div class="container nav__inner">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav__brand">
            <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/logo-white.png" alt="Blue Raeven" class="nav__logo-img">
        </a>
        <div class="nav__links" id="navLinks">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <a href="<?php echo esc_url( home_url( '/story/' ) ); ?>">Our Story</a>
            <a href="<?php echo esc_url( home_url( '/products/' ) ); ?>">Our Pies</a>
            <a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>">Farm Stand</a>
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
        </div>
        <button class="nav__toggle" id="navToggle" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>
<!-- /wp:html -->
