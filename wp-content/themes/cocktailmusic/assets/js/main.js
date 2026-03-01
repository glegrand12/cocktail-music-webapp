/**
 * Cocktail Music - Main JavaScript
 *
 * @package CocktailMusic
 */

(function() {
    'use strict';

    // DOM Elements
    const header = document.getElementById('site-header');
    const menuToggle = document.getElementById('menu-toggle');
    const mainNav = document.getElementById('main-nav');

    /**
     * Header scroll effect
     */
    function handleHeaderScroll() {
        if (!header) return;

        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }

    /**
     * Mobile menu toggle
     */
    function handleMenuToggle() {
        if (!menuToggle || !mainNav) return;

        menuToggle.addEventListener('click', function() {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';

            menuToggle.setAttribute('aria-expanded', !isExpanded);
            mainNav.classList.toggle('active');

            // Prevent body scroll when menu is open
            document.body.style.overflow = mainNav.classList.contains('active') ? 'hidden' : '';
        });

        // Close menu when clicking on a link
        const navLinks = mainNav.querySelectorAll('a');
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                mainNav.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (mainNav.classList.contains('active') &&
                !mainNav.contains(e.target) &&
                !menuToggle.contains(e.target)) {
                mainNav.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }
        });
    }

    /**
     * Smooth scroll for anchor links
     */
    function handleSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');

                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    e.preventDefault();

                    const headerHeight = header ? header.offsetHeight : 0;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    /**
     * Form validation enhancement
     */
    function handleFormValidation() {
        const forms = document.querySelectorAll('.devis-form');

        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');

                // Add loading state
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Envoi en cours...';
                }

                // Basic validation is handled by HTML5 required attribute
                // This just adds visual feedback
            });

            // Add focus styles
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(function(input) {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
        });
    }

    /**
     * Intersection Observer for animations
     */
    function handleScrollAnimations() {
        const animatedElements = document.querySelectorAll('.service-card, .value-card, .sector, .stat, .timeline__item, .contact-card');

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            animatedElements.forEach(function(el) {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        }
    }

    /**
     * Initialize
     */
    function init() {
        // Header scroll
        window.addEventListener('scroll', handleHeaderScroll, { passive: true });
        handleHeaderScroll();

        // Mobile menu
        handleMenuToggle();

        // Smooth scroll
        handleSmoothScroll();

        // Form validation
        handleFormValidation();

        // Scroll animations
        handleScrollAnimations();
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
