/**
 * TPA Base — Parallax scroll effect.
 *
 * Elements with [data-parallax] get a translateY transform
 * based on their scroll position, creating depth.
 *
 * Attributes:
 *   data-parallax                — marks element for parallax (required)
 *   data-parallax-speed="0.15"  — intensity, 0-0.5 (default: 0.15)
 *
 * The element should be position:absolute inside a position:relative parent,
 * with overflow:hidden on the parent. The parallax element is typically a
 * background image container.
 *
 * Uses requestAnimationFrame for smooth 60fps performance.
 * Matched to the parallax pattern in John Tobin and other TPA mockups.
 */
(function () {
    'use strict';

    var elements = document.querySelectorAll('[data-parallax]');
    if (!elements.length) return;

    var ticking = false;

    function updateParallax() {
        var winHeight = window.innerHeight;

        elements.forEach(function (el) {
            var parent = el.parentElement;
            if (!parent) return;

            var rect = parent.getBoundingClientRect();

            // Only compute if visible in viewport
            if (rect.top < winHeight && rect.bottom > 0) {
                var speed = parseFloat(el.getAttribute('data-parallax-speed') || '0.15');
                var offset = rect.top * -speed;
                el.style.transform = 'translateY(' + offset + 'px)';
            }
        });

        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }, { passive: true });

    // Initial call in case elements are visible on load
    updateParallax();
})();
