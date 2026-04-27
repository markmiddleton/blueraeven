/**
 * Blue Raeven Theme JavaScript
 */
(function() {
    'use strict';

    // Mobile nav toggle
    function initMobileNav() {
        const toggle = document.getElementById('navToggle');
        const links = document.getElementById('navLinks');

        if (!toggle || !links) return;

        toggle.addEventListener('click', function() {
            links.classList.toggle('open');
        });

        links.querySelectorAll('a').forEach(function(a) {
            a.addEventListener('click', function() {
                links.classList.remove('open');
            });
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
        initHeroCarousel();
    });

})();
