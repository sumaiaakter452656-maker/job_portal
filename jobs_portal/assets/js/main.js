/* JobPortal BD — UI helpers (design only, no backend logic) */
document.addEventListener('DOMContentLoaded', function () {
  // Sidebar: keep scroll position between pages + keep active menu visible
  var sideBody = document.querySelector('.sidebar .offcanvas-body');
  if (sideBody) {
    try {
      var saved = sessionStorage.getItem('sidebarScroll');
      if (saved !== null) sideBody.scrollTop = parseInt(saved, 10);
    } catch (e) {}
    var activeLink = sideBody.querySelector('.sidebar-nav a.active');
    if (activeLink) {
      var a = activeLink.getBoundingClientRect(), b = sideBody.getBoundingClientRect();
      if (a.top < b.top || a.bottom > b.bottom) {
        sideBody.scrollTop += (a.top - b.top) - (b.height / 2) + (a.height / 2);
      }
    }
    sideBody.addEventListener('scroll', function () {
      try { sessionStorage.setItem('sidebarScroll', sideBody.scrollTop); } catch (e) {}
    });
  }

  // Bootstrap tooltips
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
    new bootstrap.Tooltip(el);
  });

  // Save / bookmark job toggle (UI only)
  document.querySelectorAll('.btn-save').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      btn.classList.toggle('saved');
    });
  });

  // Back to top button
  var topBtn = document.querySelector('.back-to-top');
  if (topBtn) {
    window.addEventListener('scroll', function () {
      topBtn.classList.toggle('show', window.scrollY > 400);
    });
    topBtn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // Fade-up on scroll
  var items = document.querySelectorAll('.fade-up');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
      });
    }, { threshold: 0.1 });
    items.forEach(function (el) { io.observe(el); });
  } else {
    items.forEach(function (el) { el.classList.add('in'); });
  }

  // Password show / hide
  document.querySelectorAll('.toggle-password').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var input = btn.closest('.input-group').querySelector('input');
      var show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      btn.querySelector('i').className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
  });

  // Upload zone: open file picker + show file name
  document.querySelectorAll('.upload-zone').forEach(function (zone) {
    var input = zone.querySelector('input[type="file"]');
    if (!input) return;
    zone.addEventListener('click', function () { input.click(); });
    input.addEventListener('change', function () {
      var label = zone.querySelector('.file-name');
      if (label && input.files.length) label.textContent = input.files[0].name;
    });
  });

  // CV template switcher (cv-preview.php)
  document.querySelectorAll('[data-cv-template]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('[data-cv-template]').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      document.querySelectorAll('.cv-layout').forEach(function (l) { l.classList.add('d-none'); });
      var target = document.getElementById('cv-' + btn.dataset.cvTemplate);
      if (target) target.classList.remove('d-none');
    });
  });
});