(function(){
  // ---------- mobile nav ----------
  var burger = document.getElementById('hamburger');
  var links  = document.getElementById('navLinks');
  if (burger && links) {
    burger.addEventListener('click', function(){
      var open = links.classList.toggle('open');
      burger.classList.toggle('open', open);
      burger.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    // Dropdown parents (walker: li.dropdown > a.dropdown-toggle) — tap to expand on mobile
    links.querySelectorAll('.dropdown > a').forEach(function(a){
      a.setAttribute('aria-expanded', 'false');
      a.addEventListener('click', function(e){
        if (window.matchMedia('(max-width:1024px)').matches) {
          e.preventDefault();
          var isOpen = a.parentElement.classList.toggle('open');
          a.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }
      });
    });
  }

  // Desktop hover/focus aria state on dropdown parents
  document.querySelectorAll('.nav-links .dropdown').forEach(function(li){
    var a = li.querySelector(':scope > a');
    if (!a) return;
    ['mouseenter','focusin'].forEach(function(ev){ li.addEventListener(ev, function(){ a.setAttribute('aria-expanded','true'); }); });
    ['mouseleave','focusout'].forEach(function(ev){ li.addEventListener(ev, function(){ if(!li.classList.contains('open')) a.setAttribute('aria-expanded','false'); }); });
  });

  // ---------- scrolled nav state ----------
  var nav = document.querySelector('.nav');
  if (nav) {
    window.addEventListener('scroll', function(){
      nav.classList.toggle('scrolled', window.scrollY > 8);
    }, { passive: true });
  }

  // ---------- smooth-scroll anchors (skip bare #) ----------
  document.querySelectorAll('a[href^="#"]').forEach(function(link){
    link.addEventListener('click', function(e){
      var href = link.getAttribute('href');
      if (!href || href === '#') return;
      var target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // ---------- scroll-reveal ----------
  var reveals = document.querySelectorAll('.reveal');
  if (reveals.length) {
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function(entries){
        entries.forEach(function(en){
          if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
        });
      }, { threshold: .18 });
      reveals.forEach(function(el){ io.observe(el); });
      // Fallback: force-reveal anything IO missed after 8s
      setTimeout(function(){ reveals.forEach(function(el){ el.classList.add('in'); }); }, 8000);
    } else {
      reveals.forEach(function(el){ el.classList.add('in'); });
    }
  }

  // ---------- lazy-load below-fold CSS backgrounds ----------
  if ('IntersectionObserver' in window) {
    var bgObserver = new IntersectionObserver(function(entries){
      entries.forEach(function(entry){
        if (entry.isIntersecting) {
          entry.target.classList.add('bg-loaded');
          bgObserver.unobserve(entry.target);
        }
      });
    }, { rootMargin: '250px 0px' });
    ['.vig-distress'].forEach(function(sel){
      var el = document.querySelector(sel);
      if (el) bgObserver.observe(el);
    });
  } else {
    var d = document.querySelector('.vig-distress');
    if (d) d.classList.add('bg-loaded');
  }
})();
