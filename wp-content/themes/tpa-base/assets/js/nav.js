/**
 * TPA Base — Navigation behavior.
 * Mobile hamburger toggle, dropdown accordion on mobile,
 * close on link click, body scroll lock when open.
 */
(function () {
    'use strict';

    var toggle = document.querySelector('.nav-toggle');
    var mobileMenu = document.querySelector('.mobile-menu');

    if (!toggle || !mobileMenu) return;

    // ── Hamburger toggle ──
    toggle.addEventListener('click', function () {
        var isOpen = mobileMenu.classList.toggle('open');
        toggle.classList.toggle('active');
        toggle.setAttribute('aria-expanded', isOpen);
        mobileMenu.setAttribute('aria-hidden', !isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // ── Close on link click ──
    mobileMenu.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function (e) {
            // Don't close if it's a parent menu item (has submenu)
            var li = this.closest('li');
            if (li && li.classList.contains('menu-item-has-children')) {
                return; // Handled by accordion below
            }
            closeMobile();
        });
    });

    // ── Mobile dropdown accordion ──
    mobileMenu.querySelectorAll('.menu-item-has-children > a').forEach(function (parentLink) {
        parentLink.addEventListener('click', function (e) {
            var submenu = this.nextElementSibling;
            if (submenu && submenu.tagName === 'UL') {
                e.preventDefault();
                submenu.classList.toggle('open');
                this.classList.toggle('expanded');
            }
        });
    });

    // ── Close on escape key ──
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('open')) {
            closeMobile();
        }
    });

    function closeMobile() {
        mobileMenu.classList.remove('open');
        toggle.classList.remove('active');
        toggle.setAttribute('aria-expanded', 'false');
        mobileMenu.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }
})();
