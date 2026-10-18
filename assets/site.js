(function () {
  var b = document.getElementById('menu-btn'), n = document.getElementById('mobile-nav');
  if (b && n) b.addEventListener('click', function () { var o = n.hidden; n.hidden = !o; b.setAttribute('aria-expanded', String(o)); b.setAttribute('aria-label', o ? 'Close menu' : 'Open menu'); b.textContent = o ? '✕' : '☰'; });
  var g = document.querySelector('[data-gallery]'); if (!g) return;
  var imgs = [].slice.call(g.querySelectorAll('[data-src]')), i = 0, box, fig, im, load, opener, x0 = 0;
  function show(k) { i = (k + imgs.length) % imgs.length; load.hidden = false; im.style.opacity = 0; im.src = imgs[i].dataset.src; im.alt = imgs[i].querySelector('img').alt; cap.textContent = im.alt + ' · ' + (i + 1) + ' / ' + imgs.length; }
  function close() { box.remove(); document.body.style.overflow = ''; document.removeEventListener('keydown', key); if (opener) opener.focus(); }
  function key(e) { if (e.key === 'Escape') close(); if (e.key === 'ArrowRight') show(i + 1); if (e.key === 'ArrowLeft') show(i - 1); }
  var cap;
  function open(k, el) {
    opener = el; box = document.createElement('div'); box.className = 'lightbox'; box.setAttribute('role', 'dialog'); box.setAttribute('aria-modal', 'true'); box.setAttribute('aria-label', 'Project gallery');
    box.innerHTML = '<button type="button" class="lb-btn lb-close" aria-label="Close gallery">✕</button>' + (imgs.length > 1 ? '<button type="button" class="lb-btn lb-prev" aria-label="Previous image">‹</button><button type="button" class="lb-btn lb-next" aria-label="Next image">›</button>' : '') + '<figure class="lb-fig"><span class="lb-load" role="status">Loading…</span><img alt=""><figcaption class="small"></figcaption></figure>';
    im = box.querySelector('img'); load = box.querySelector('.lb-load'); cap = box.querySelector('figcaption'); im.onload = function () { load.hidden = true; im.style.opacity = 1; };
    box.addEventListener('click', function (e) { if (e.target === box) close(); });
    box.querySelector('.lb-close').addEventListener('click', close);
    var p = box.querySelector('.lb-prev'), nx = box.querySelector('.lb-next'); if (p) { p.addEventListener('click', function (e) { e.stopPropagation(); show(i - 1); }); nx.addEventListener('click', function (e) { e.stopPropagation(); show(i + 1); }); }
    box.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }); box.addEventListener('touchend', function (e) { var d = e.changedTouches[0].clientX - x0; if (Math.abs(d) > 50) show(i + (d < 0 ? 1 : -1)); });
    document.body.appendChild(box); document.body.style.overflow = 'hidden'; document.addEventListener('keydown', key); show(k); box.querySelector('.lb-close').focus();
  }
  imgs.forEach(function (el, k) { el.addEventListener('click', function () { open(k, el); }); });
})();
