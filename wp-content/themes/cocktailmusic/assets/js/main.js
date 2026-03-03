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
     * Validation helpers
     */
    var validators = {
        email: function(value) {
            if (!value) return '';
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(value) ? '' : 'Adresse email invalide. Ex : jean@exemple.fr';
        },

        telephone: function(value) {
            if (!value) return '';
            var cleaned = value.replace(/[\s.\-]/g, '');
            var re = /^(?:(?:\+33|0033)0?|0)[1-9]\d{8}$/;
            return re.test(cleaned) ? '' : 'Numero invalide. Format attendu : 06 12 34 56 78';
        },

        code_postal: function(value) {
            if (!value) return '';
            var re = /^\d{5}$/;
            return re.test(value.trim()) ? '' : 'Code postal invalide. Format attendu : 5 chiffres (ex: 59000)';
        },

        nom: function(value) {
            if (!value || !value.trim()) return 'Le nom est obligatoire';
            return '';
        },

        prenom: function(value) {
            if (!value || !value.trim()) return 'Le prenom est obligatoire';
            return '';
        },

        type_event: function(value) {
            if (!value) return 'Veuillez selectionner un type d\'evenement';
            return '';
        }
    };

    function showFieldError(field, message) {
        var container = field.closest('.devis-form__field');
        if (!container) return;

        var errorEl = container.querySelector('.devis-form__error');
        if (errorEl) {
            errorEl.textContent = message;
        }

        if (message) {
            container.classList.add('has-error');
            container.classList.remove('is-valid');
        } else if (field.value.trim()) {
            container.classList.remove('has-error');
            container.classList.add('is-valid');
        } else {
            container.classList.remove('has-error');
            container.classList.remove('is-valid');
        }
    }

    /**
     * Form validation
     */
    function handleFormValidation() {
        var forms = document.querySelectorAll('.devis-form');

        forms.forEach(function(form) {
            // Real-time validation on blur
            var inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(function(input) {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');

                    var name = this.getAttribute('name');
                    if (validators[name]) {
                        var error = validators[name](this.value);
                        showFieldError(this, error);
                    }
                });

                // Clear error on input
                input.addEventListener('input', function() {
                    var container = this.closest('.devis-form__field');
                    if (container && container.classList.contains('has-error')) {
                        var name = this.getAttribute('name');
                        if (validators[name]) {
                            var error = validators[name](this.value);
                            if (!error) {
                                showFieldError(this, '');
                            }
                        }
                    }
                });
            });

            // Submit validation
            form.addEventListener('submit', function(e) {
                var hasError = false;

                // Validate required fields
                var requiredChecks = [
                    { name: 'nom', label: 'nom' },
                    { name: 'prenom', label: 'prenom' },
                    { name: 'email', label: 'email' },
                    { name: 'telephone', label: 'telephone' },
                    { name: 'type_event', label: 'type d\'evenement' }
                ];

                requiredChecks.forEach(function(check) {
                    var field = form.querySelector('[name="' + check.name + '"]');
                    if (!field) return;

                    var value = field.value.trim();
                    var error = '';

                    if (!value) {
                        error = 'Ce champ est obligatoire';
                        hasError = true;
                    } else if (validators[check.name]) {
                        error = validators[check.name](value);
                        if (error) hasError = true;
                    }

                    showFieldError(field, error);
                });

                // Validate optional fields with format
                var optionalChecks = ['code_postal'];
                optionalChecks.forEach(function(name) {
                    var field = form.querySelector('[name="' + name + '"]');
                    if (!field || !field.value.trim()) return;

                    if (validators[name]) {
                        var error = validators[name](field.value);
                        if (error) {
                            hasError = true;
                            showFieldError(field, error);
                        }
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    // Scroll to first error
                    var firstError = form.querySelector('.has-error');
                    if (firstError) {
                        var headerHeight = header ? header.offsetHeight : 0;
                        var pos = firstError.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
                        window.scrollTo({ top: pos, behavior: 'smooth' });
                    }
                    return;
                }

                // Add loading state
                var submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Envoi en cours...';
                }
            });
        });
    }

    /**
     * Intersection Observer for animations
     */
    function handleScrollAnimations() {
        var animatedElements = document.querySelectorAll('.service-card, .value-card, .sector, .stat, .timeline__item, .contact-card');

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function(entries) {
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
