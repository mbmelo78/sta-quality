document.addEventListener('DOMContentLoaded', () => {
  const cfg = window.__A11Y_CFG__ || {};
  const siteHost = window.location.hostname;

  document.querySelectorAll('a[href]').forEach(a => {
    const href = a.getAttribute('href') || '';
    if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) return;

    let url;
    try { url = new URL(href, window.location.origin); } catch { return; }

    const isExternal = url.hostname && url.hostname !== siteHost;
    if (!isExternal) return;

    // noopener/noreferrer para target blank
    if (a.target === '_blank') {
      const rel = (a.getAttribute('rel') || '').split(/\s+/).filter(Boolean);
      if (!rel.includes('noopener')) rel.push('noopener');
      if (!rel.includes('noreferrer')) rel.push('noreferrer');
      a.setAttribute('rel', rel.join(' '));
    }

    if (a.classList.contains('external-marked')) return;
    a.classList.add('external-marked');

    // Ícone (Font Awesome já existe no teu site)
    const icon = document.createElement('i');
    icon.className = 'fas fa-external-link-alt';
    icon.setAttribute('aria-hidden', 'true');
    icon.style.marginLeft = '6px';
    icon.style.fontSize = '0.85em';

    // Texto acessível
    const sr = document.createElement('span');
    sr.className = 'sr-only';
    sr.textContent = cfg.externalLinkTextPT || ' (link externo)';

    // Se existir wrapper de texto no menu PXL, anexa lá para não rebentar layout
    const textWrap = a.querySelector('.pxl-menu-item-text') || a;
    textWrap.appendChild(icon);
    textWrap.appendChild(sr);
  });
});