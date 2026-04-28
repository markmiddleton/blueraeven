/**
 * Blue Raeven Theme JavaScript
 */
(function() {
    'use strict';

    // Mobile nav toggle
    function initMobileNav() {
        const toggle = document.getElementById('navToggle');
        const linksLeft = document.getElementById('navLinksLeft');
        const linksRight = document.getElementById('navLinksRight');

        if (!toggle) return;

        toggle.addEventListener('click', function() {
            if (linksLeft) linksLeft.classList.toggle('open');
            if (linksRight) linksRight.classList.toggle('open');
        });

        document.querySelectorAll('.nav__links a').forEach(function(a) {
            a.addEventListener('click', function() {
                if (linksLeft) linksLeft.classList.remove('open');
                if (linksRight) linksRight.classList.remove('open');
            });
        });
    }

    // Set active nav link based on current page
    function initActiveNav() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav__links a');

        navLinks.forEach(function(link) {
            const linkPath = new URL(link.href).pathname;

            // Exact match or starts with (for child pages)
            if (currentPath === linkPath ||
                (linkPath !== '/' && currentPath.startsWith(linkPath))) {
                link.classList.add('active');
            }
        });
    }

    // Hero carousel
    function initHeroCarousel() {
        const slides = document.querySelectorAll('.hero__slide');
        const indicators = document.querySelectorAll('.hero__indicator');

        if (slides.length === 0) return;

        let currentSlide = 0;
        let autoSlideInterval;

        function goToSlide(index) {
            slides[currentSlide].classList.remove('active');
            if (indicators[currentSlide]) {
                indicators[currentSlide].classList.remove('active');
            }

            currentSlide = index;
            if (currentSlide >= slides.length) currentSlide = 0;
            if (currentSlide < 0) currentSlide = slides.length - 1;

            slides[currentSlide].classList.add('active');
            if (indicators[currentSlide]) {
                indicators[currentSlide].classList.add('active');
            }
        }

        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 6000);
        }

        // Click on indicators
        indicators.forEach(function(indicator, index) {
            indicator.addEventListener('click', function() {
                clearInterval(autoSlideInterval);
                goToSlide(index);
                startAutoSlide();
            });
        });

        startAutoSlide();
    }

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileNav();
        initActiveNav();
        initHeroCarousel();
    });

})();
