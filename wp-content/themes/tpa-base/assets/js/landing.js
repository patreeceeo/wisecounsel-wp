(function () {
  'use strict';

  // ─── FAQ Accordion ──────────────────────────────────────────────────────────
  function initFaq() {
    var questions = document.querySelectorAll('.lp-faq-question');
    if (!questions.length) return;

    questions.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var item   = btn.closest('.lp-faq-item');
        var answer = item ? item.querySelector('.lp-faq-answer') : null;
        if (!item || !answer) return;

        var isOpen = item.classList.contains('lp-faq-item--open');

        // Close all open items first
        questions.forEach(function (otherBtn) {
          var otherItem   = otherBtn.closest('.lp-faq-item');
          var otherAnswer = otherItem ? otherItem.querySelector('.lp-faq-answer') : null;
          if (!otherItem || !otherAnswer) return;

          otherItem.classList.remove('lp-faq-item--open');
          otherBtn.setAttribute('aria-expanded', 'false');
          otherAnswer.style.maxHeight = null;
        });

        // Open the clicked item if it was closed
        if (!isOpen) {
          item.classList.add('lp-faq-item--open');
          btn.setAttribute('aria-expanded', 'true');
          answer.style.maxHeight = answer.scrollHeight + 'px';
        }
      });
    });
  }

  // ─── Smooth Scroll ──────────────────────────────────────────────────────────
  function initSmoothScroll() {
    var header     = document.querySelector('.lp-header');
    var mobileMenu = document.querySelector('.lp-mobile-menu');
    var toggle     = document.querySelector('.lp-menu-toggle');

    var containers = [header, mobileMenu].filter(Boolean);
    if (!containers.length) return;

    containers.forEach(function (container) {
      container.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
          var targetId = link.getAttribute('href');
          if (!targetId || targetId === '#') return;

          var target = document.querySelector(targetId);
          if (!target) return;

          e.preventDefault();

          var headerHeight = header ? header.offsetHeight : 0;
          var top = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

          window.scrollTo({ top: top, behavior: 'smooth' });

          // Close mobile menu if open
          if (mobileMenu && mobileMenu.classList.contains('lp-mobile-menu--open')) {
            mobileMenu.classList.remove('lp-mobile-menu--open');
            mobileMenu.setAttribute('aria-hidden', 'true');
            if (toggle) {
              toggle.setAttribute('aria-expanded', 'false');
              toggle.classList.remove('lp-menu-toggle--open');
            }
          }
        });
      });
    });
  }

  // ─── Sticky Header Shadow ────────────────────────────────────────────────────
  function initStickyHeader() {
    var header = document.querySelector('.lp-header');
    if (!header) return;

    window.addEventListener('scroll', function () {
      if (window.scrollY > 50) {
        header.classList.add('lp-header--scrolled');
      } else {
        header.classList.remove('lp-header--scrolled');
      }
    }, { passive: true });
  }

  // ─── Mobile Menu Toggle ──────────────────────────────────────────────────────
  function initMobileMenu() {
    var toggle     = document.querySelector('.lp-menu-toggle');
    var mobileMenu = document.querySelector('.lp-mobile-menu');
    if (!toggle || !mobileMenu) return;

    toggle.addEventListener('click', function () {
      var isOpen = mobileMenu.classList.contains('lp-mobile-menu--open');

      mobileMenu.classList.toggle('lp-mobile-menu--open');
      mobileMenu.setAttribute('aria-hidden', isOpen ? 'true' : 'false');
      toggle.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
      toggle.classList.toggle('lp-menu-toggle--open');
    });
  }

  // ─── Scroll Animations ───────────────────────────────────────────────────────
  function initScrollAnimations() {
    var elements = document.querySelectorAll('.lp-fade-up');
    if (!elements.length) return;

    if (!('IntersectionObserver' in window)) {
      elements.forEach(function (el) {
        el.classList.add('lp-visible');
      });
      return;
    }

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('lp-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });

    elements.forEach(function (el) {
      observer.observe(el);
    });
  }

  // ─── Init ────────────────────────────────────────────────────────────────────
  document.addEventListener('DOMContentLoaded', function () {
    initFaq();
    initSmoothScroll();
    initStickyHeader();
    initMobileMenu();
    initScrollAnimations();
  });

})();
