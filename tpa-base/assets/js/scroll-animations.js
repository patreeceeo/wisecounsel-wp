/**
 * TPA Base — Scroll-triggered animations.
 *
 * Elements with [data-anim] are observed by IntersectionObserver.
 * When they enter the viewport, class 'visible' is added after
 * an optional delay, triggering CSS transitions.
 *
 * Attributes:
 *   data-anim              — marks element for observation (required)
 *   data-delay="200"       — ms delay before .visible is added (default: 0)
 *   data-direction="up"    — animation direction: up, left, right, fade, scale (default: up)
 *
 * Matched to the IntersectionObserver pattern used across all TPA mockups
 * (John Tobin, Amanda Harmon, Crystal Gayle, Holly Erskine, Joe Henson).
 */
(function () {
    'use strict';

    // Bail if IntersectionObserver isn't supported (very old browsers)
    if (!('IntersectionObserver' in window)) {
        // Show everything immediately
        document.querySelectorAll('[data-anim]').forEach(function (el) {
            el.classList.add('visible');
        });
        return;
    }

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                var el = entry.target;
                var delay = parseInt(el.getAttribute('data-delay') || '0', 10);

                if (delay > 0) {
                    setTimeout(function () {
                        el.classList.add('visible');
                    }, delay);
                } else {
                    el.classList.add('visible');
                }

                observer.unobserve(el);
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    });

    document.querySelectorAll('[data-anim]').forEach(function (el) {
        observer.observe(el);
    });
})();
