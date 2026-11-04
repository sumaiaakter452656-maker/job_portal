/* =====================================================================
   Jobs Portal – Dashboard Scripts (Vanilla JS, no library)
   ===================================================================== */
(function () {
    'use strict';

    const $  = (sel, ctx = document) => ctx.querySelector(sel);
    const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));
    const isMobile = () => window.matchMedia('(max-width: 991.98px)').matches;

    /* ---------------------------------------------------------------
       1. Sidebar toggle (desktop = mini sidebar, mobile = off-canvas)
       --------------------------------------------------------------- */
    function initSidebar() {
        const body = document.body;
        const toggle = $('#sidebarToggle');
        const overlay = $('.sidebar-overlay');
        const closeBtn = $('#sidebarClose');

        try {
            if (!isMobile() && localStorage.getItem('jp_sidebar') === 'collapsed') {
                body.classList.add('sidebar-collapsed');
            }
        } catch (e) { /* storage unavailable */ }

        toggle && toggle.addEventListener('click', () => {
            if (isMobile()) {
                body.classList.toggle('sidebar-open');
            } else {
                body.classList.toggle('sidebar-collapsed');
                try {
                    localStorage.setItem('jp_sidebar', body.classList.contains('sidebar-collapsed') ? 'collapsed' : 'open');
                } catch (e) { /* ignore */ }
            }
        });

        const close = () => body.classList.remove('sidebar-open');
        overlay && overlay.addEventListener('click', close);
        closeBtn && closeBtn.addEventListener('click', close);
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });

        // Active link + close on mobile after navigating to a section
        $$('.side-link').forEach((link) => {
            link.addEventListener('click', () => {
                const href = link.getAttribute('href') || '';
                if (href.startsWith('#') && href.length > 1) {
                    $$('.side-link').forEach((l) => l.classList.remove('active'));
                    link.classList.add('active');
                }
                if (isMobile()) close();
            });
        });

        // In mini mode show the label as tooltip
        $$('.side-link').forEach((link) => {
            const text = link.querySelector('span');
            if (text) link.setAttribute('title', text.textContent.trim());
        });
    }

    /* ---------------------------------------------------------------
       2. Greeting by time of day
       --------------------------------------------------------------- */
    function initGreeting() {
        const el = $('[data-greeting]');
        if (!el) return;
        const h = new Date().getHours();
        el.textContent = h < 12 ? 'Good Morning' : h < 17 ? 'Good Afternoon' : 'Good Evening';
    }

    /* ---------------------------------------------------------------
       3. Animated counters  <span data-count="120" data-prefix="৳">
       --------------------------------------------------------------- */
    function animateCount(el) {
        const target = parseFloat(el.dataset.count) || 0;
        const prefix = el.dataset.prefix || '';
        const suffix = el.dataset.suffix || '';
        const duration = 1100;
        const start = performance.now();
        const fmt = (n) => prefix + Math.round(n).toLocaleString('en-US') + suffix;

        if (target === 0) { el.textContent = fmt(0); return; }

        function tick(now) {
            const p = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            el.textContent = fmt(target * eased);
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    /* ---------------------------------------------------------------
       4. Bar chart (SVG)  <div class="bar-chart" data-labels='[..]'
          data-series='[{"name":"..","color":"#..","values":[..]}]'>
       --------------------------------------------------------------- */
    function renderBarChart(el) {
        let labels, series;
        try {
            labels = JSON.parse(el.dataset.labels || '[]');
            series = JSON.parse(el.dataset.series || '[]');
        } catch (e) { return; }
        if (!labels.length || !series.length) return;

        const W = 640, H = 270, padL = 36, padR = 10, padT = 14, padB = 30;
        const cw = W - padL - padR, ch = H - padT - padB;
        const all = series.flatMap((s) => s.values);
        let max = Math.max(...all, 4);
        const step = Math.pow(10, Math.floor(Math.log10(max)));
        max = Math.ceil(max / step) * step;

        const ns = 'http://www.w3.org/2000/svg';
        const svg = document.createElementNS(ns, 'svg');
        svg.setAttribute('viewBox', `0 0 ${W} ${H}`);
        svg.setAttribute('role', 'img');

        // Grid
        const lines = 4;
        for (let i = 0; i <= lines; i++) {
            const y = padT + (ch / lines) * i;
            const val = Math.round(max - (max / lines) * i);
            const ln = document.createElementNS(ns, 'line');
            ln.setAttribute('x1', padL); ln.setAttribute('x2', W - padR);
            ln.setAttribute('y1', y); ln.setAttribute('y2', y);
            ln.setAttribute('class', 'grid-line');
            svg.appendChild(ln);
            const tx = document.createElementNS(ns, 'text');
            tx.setAttribute('x', padL - 8); tx.setAttribute('y', y + 4);
            tx.setAttribute('text-anchor', 'end');
            tx.setAttribute('class', 'axis-label');
            tx.textContent = val;
            svg.appendChild(tx);
        }

        // Bars
        const group = cw / labels.length;
        const barW = Math.min(22, (group * 0.6) / series.length);
        const gap = 6;
        labels.forEach((lab, i) => {
            const totalW = series.length * barW + (series.length - 1) * gap;
            const x0 = padL + group * i + (group - totalW) / 2;
            series.forEach((s, si) => {
                const v = s.values[i] || 0;
                const h = (v / max) * ch;
                const r = document.createElementNS(ns, 'rect');
                r.setAttribute('x', x0 + si * (barW + gap));
                r.setAttribute('width', barW);
                r.setAttribute('rx', 5);
                r.setAttribute('fill', s.color);
                r.setAttribute('class', 'bar');
                r.setAttribute('y', padT + ch);
                r.setAttribute('height', 0);
                const t = document.createElementNS(ns, 'title');
                t.textContent = `${s.name} (${lab}): ${v}`;
                r.appendChild(t);
                svg.appendChild(r);
                // animate grow
                setTimeout(() => {
                    r.style.transition = 'y .8s ease, height .8s ease';
                    r.setAttribute('y', padT + ch - h);
                    r.setAttribute('height', Math.max(h, v > 0 ? 2 : 0));
                }, 80 + i * 60);
            });
            const lx = document.createElementNS(ns, 'text');
            lx.setAttribute('x', padL + group * i + group / 2);
            lx.setAttribute('y', H - 8);
            lx.setAttribute('text-anchor', 'middle');
            lx.setAttribute('class', 'axis-label');
            lx.textContent = lab;
            svg.appendChild(lx);
        });

        el.innerHTML = '';
        el.appendChild(svg);
    }

    /* ---------------------------------------------------------------
       5. Donut chart (CSS conic-gradient)
          <div class="donut" data-segments='[{"label":"..","value":3,"color":"#.."}]'>
       --------------------------------------------------------------- */
    function renderDonut(el) {
        let segs;
        try { segs = JSON.parse(el.dataset.segments || '[]'); } catch (e) { return; }
        const total = segs.reduce((a, s) => a + (+s.value || 0), 0);

        if (total > 0) {
            let acc = 0;
            const stops = segs.map((s) => {
                const from = (acc / total) * 100;
                acc += +s.value || 0;
                const to = (acc / total) * 100;
                return `${s.color} ${from}% ${to}%`;
            });
            requestAnimationFrame(() => { el.style.background = `conic-gradient(${stops.join(',')})`; });
        }

        const legend = el.dataset.legend ? $(el.dataset.legend) : null;
        if (legend) {
            legend.innerHTML = segs.map((s) =>
                `<div><i style="background:${s.color}"></i>${s.label}<b>${s.value}</b></div>`
            ).join('');
        }
    }

    /* ---------------------------------------------------------------
       6. Progress bars & rings  <div class="progress-bar" data-width="60">
       --------------------------------------------------------------- */
    function fillProgress(el) {
        el.style.width = Math.min(+el.dataset.width || 0, 100) + '%';
    }

    function fillRing(el) {
        const target = Math.min(+el.dataset.progress || 0, 100);
        const label = el.querySelector('span');
        let cur = 0;
        const timer = setInterval(() => {
            cur += Math.max(1, Math.round(target / 30));
            if (cur >= target) { cur = target; clearInterval(timer); }
            el.style.setProperty('--p', cur);
            if (label) label.textContent = cur + '%';
        }, 25);
        if (target === 0) { clearInterval(timer); if (label) label.textContent = '0%'; }
    }

    /* ---------------------------------------------------------------
       7. Reveal on scroll + lazy start of animations
       --------------------------------------------------------------- */
    function initObserver() {
        const run = (el) => {
            if (el.classList.contains('reveal')) el.classList.add('in');
            if (el.dataset.count !== undefined) animateCount(el);
            if (el.classList.contains('bar-chart')) renderBarChart(el);
            if (el.classList.contains('donut')) renderDonut(el);
            if (el.classList.contains('progress-bar')) fillProgress(el);
            if (el.dataset.progress !== undefined) fillRing(el);
        };
        const targets = $$('.reveal, [data-count], .bar-chart, .donut, .progress-bar[data-width], [data-progress]');

        if (!('IntersectionObserver' in window)) { targets.forEach(run); return; }

        const io = new IntersectionObserver((entries) => {
            entries.forEach((en) => {
                if (en.isIntersecting) { run(en.target); io.unobserve(en.target); }
            });
        }, { threshold: 0.15 });
        targets.forEach((t) => io.observe(t));
    }

    /* ---------------------------------------------------------------
       8. Table live search  <input data-table-filter="#tableId">
       --------------------------------------------------------------- */
    function initTableFilter() {
        $$('[data-table-filter]').forEach((input) => {
            const table = $(input.dataset.tableFilter);
            if (!table) return;
            input.addEventListener('input', () => {
                const q = input.value.trim().toLowerCase();
                $$('tbody tr', table).forEach((tr) => {
                    if (tr.classList.contains('no-filter')) return;
                    tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
                });
            });
        });

        // Status filter  <select data-status-filter="#tableId">  (rows have data-status)
        $$('[data-status-filter]').forEach((sel) => {
            const table = $(sel.dataset.statusFilter);
            if (!table) return;
            sel.addEventListener('change', () => {
                const v = sel.value;
                $$('tbody tr[data-status]', table).forEach((tr) => {
                    tr.style.display = !v || tr.dataset.status === v ? '' : 'none';
                });
            });
        });
    }

    /* ---------------------------------------------------------------
       9. Design-only forms: no submit to server yet, just a toast
       --------------------------------------------------------------- */
    function showToast(msg) {
        const el = $('#appToast');
        if (!el || !window.bootstrap) return;
        $('.toast-msg', el).textContent = msg;
        bootstrap.Toast.getOrCreateInstance(el, { delay: 2800 }).show();
    }

    function initDemoForms() {
        $$('form[data-demo]').forEach((form) => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }
                form.classList.remove('was-validated');
                showToast(form.dataset.demo || 'Saved (design preview only)');
            });
        });

        // Bookmark toggle (UI only)
        $$('.bookmark').forEach((b) => {
            b.addEventListener('click', () => {
                b.classList.toggle('on');
                const i = b.querySelector('i');
                if (i) i.className = b.classList.contains('on') ? 'bi bi-bookmark-fill' : 'bi bi-bookmark';
            });
        });

        // Upload zone → open hidden file input, show file name
        $$('.upload-zone').forEach((z) => {
            const input = z.querySelector('input[type=file]');
            if (!input) return;
            z.addEventListener('click', (e) => { if (e.target !== input) input.click(); });
            input.addEventListener('change', () => {
                const name = input.files[0] ? input.files[0].name : '';
                const lbl = z.querySelector('.upload-name');
                if (lbl && name) lbl.textContent = name;
            });
        });
    }

    /* ---------------------------------------------------------------
       10. Topbar search → filters every table on the page
       --------------------------------------------------------------- */
    function initGlobalSearch() {
        const input = $('#globalSearch');
        if (!input) return;
        input.addEventListener('keydown', (e) => {
            if (e.key !== 'Enter') return;
            e.preventDefault();
            const q = input.value.trim().toLowerCase();
            $$('.table-modern tbody tr').forEach((tr) => {
                if (tr.classList.contains('no-filter')) return;
                tr.style.display = !q || tr.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
            const first = $$('.table-modern tbody tr').find((tr) => tr.style.display !== 'none' && !tr.classList.contains('no-filter'));
            if (q && first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }

    /* ---------------------------------------------------------------
       11. Bootstrap tooltips + live clock
       --------------------------------------------------------------- */
    function initMisc() {
        if (window.bootstrap) {
            $$('[data-bs-toggle="tooltip"]').forEach((el) => new bootstrap.Tooltip(el));
        }
        const clock = $('#liveDate');
        if (clock) {
            const upd = () => {
                clock.textContent = new Date().toLocaleDateString('en-GB', {
                    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                });
            };
            upd();
        }
        const yr = $('#year');
        if (yr) yr.textContent = new Date().getFullYear();
    }

    /* ---------------------------------------------------------------
       12. Login page: demo account buttons fill the form
       --------------------------------------------------------------- */
    function initDemoLogin() {
        $$('[data-fill-email]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const email = $('#email'), pass = $('#password');
                if (email) email.value = btn.dataset.fillEmail;
                if (pass) { pass.value = '123456'; pass.focus(); }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initDemoLogin();
        initSidebar();
        initGreeting();
        initObserver();
        initTableFilter();
        initDemoForms();
        initGlobalSearch();
        initMisc();
    });
})();
