/**
 * Blue Raeven Theme JavaScript
 */
(function() {
    'use strict';

    // Mobile nav toggle
    function initMobileNav() {
        const toggle = document.getElementById('navToggle');
        const mobileMenu = document.getElementById('navMobileMenu');

        if (!toggle || !mobileMenu) return;

        // Toggle mobile menu
        toggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('open');
            toggle.classList.toggle('active');
        });

        // Accordion dropdowns
        const dropdownTriggers = mobileMenu.querySelectorAll('.nav__mobile-dropdown-trigger');
        dropdownTriggers.forEach(function(trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const dropdown = trigger.closest('.nav__mobile-dropdown');

                // Close other open dropdowns
                dropdownTriggers.forEach(function(otherTrigger) {
                    const otherDropdown = otherTrigger.closest('.nav__mobile-dropdown');
                    if (otherDropdown !== dropdown) {
                        otherDropdown.classList.remove('open');
                    }
                });

                // Toggle this dropdown
                dropdown.classList.toggle('open');
            });
        });

        // Close menu when clicking a link
        mobileMenu.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                mobileMenu.classList.remove('open');
                toggle.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileMenu.contains(e.target) && !toggle.contains(e.target)) {
                mobileMenu.classList.remove('open');
                toggle.classList.remove('active');
            }
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

    // Lightbox for timeline images
    function initLightbox() {
        // Create lightbox element
        const lightbox = document.createElement('div');
        lightbox.className = 'lightbox';
        lightbox.innerHTML = `
            <div class="lightbox__content">
                <button class="lightbox__close" aria-label="Close">&times;</button>
                <img src="" alt="">
                <div class="lightbox__caption"></div>
            </div>
        `;
        document.body.appendChild(lightbox);

        const lightboxImg = lightbox.querySelector('img');
        const lightboxCaption = lightbox.querySelector('.lightbox__caption');
        const closeBtn = lightbox.querySelector('.lightbox__close');

        // Open lightbox on timeline image click
        document.querySelectorAll('.timeline__images img').forEach(function(img) {
            img.addEventListener('click', function() {
                lightboxImg.src = img.src;
                lightboxImg.alt = img.alt;
                lightboxCaption.textContent = img.alt;
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });

        // Close lightbox
        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }

        closeBtn.addEventListener('click', closeLightbox);

        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                closeLightbox();
            }
        });
    }

    // Hero carousel (for simple image-only carousels)
    // Skips if videos are present - those are handled by inline scripts
    function initHeroCarousel() {
        const slides = document.querySelectorAll('.hero__slide');
        const indicators = document.querySelectorAll('.hero__indicator');

        // Skip if no slides or if videos present (handled by inline script)
        if (slides.length === 0) return;
        if (document.querySelector('.hero__slide video')) return;

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

    // Interactive pie cards (mobile tap to reveal)
    function initPieCards() {
        const pieCards = document.querySelectorAll('.pie-card');

        if (pieCards.length === 0) return;

        pieCards.forEach(function(card) {
            card.addEventListener('click', function(e) {
                // Check if we're on a touch device
                if (window.matchMedia('(hover: none)').matches) {
                    e.preventDefault();

                    // Close other open cards
                    pieCards.forEach(function(otherCard) {
                        if (otherCard !== card) {
                            otherCard.classList.remove('is-active');
                        }
                    });

                    // Toggle this card
                    card.classList.toggle('is-active');
                }
            });
        });

        // Close cards when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.pie-card')) {
                pieCards.forEach(function(card) {
                    card.classList.remove('is-active');
                });
            }
        });
    }

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileNav();
        initActiveNav();
        initHeroCarousel();
        initLightbox();
        initPieCards();
    });

})();
