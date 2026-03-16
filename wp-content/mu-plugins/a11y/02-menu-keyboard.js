document.addEventListener('DOMContentLoaded', () => {
  const cfg = window.__A11Y_CFG__ || {};
  const menu = document.querySelector(cfg.menuSelector || '.pxl-menu-primary');
  if (!menu) return;

  const closeSiblings = (li) => {
    const parent = li.parentElement;
    if (!parent) return;
    Array.from(parent.children).forEach(sib => {
      if (sib !== li) sib.classList.remove('kb-open');
    });
  };

  menu.addEventListener('focusin', (e) => {
    const a = e.target.closest('a');
    if (!a) return;

    const li = a.closest('li.menu-item-has-children');
    if (!li) return;

    const submenu = li.querySelector(':scope > ul.sub-menu');
    if (!submenu) return;

    closeSiblings(li);
    li.classList.add('kb-open');
    a.setAttribute('aria-expanded', 'true');
  });

  menu.addEventListener('focusout', (e) => {
    const li = e.target.closest('li.menu-item-has-children');
    if (!li) return;

    setTimeout(() => {
      if (!li.contains(document.activeElement)) {
        li.classList.remove('kb-open');
        const a = li.querySelector(':scope > a');
        if (a) a.setAttribute('aria-expanded', 'false');
      }
    }, 0);
  });

  // Evita “#” saltar ao topo e dá ESC para fechar
  menu.addEventListener('click', (e) => {
    const a = e.target.closest('a[href="#"]');
    if (a) e.preventDefault();
  });

  menu.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      menu.querySelectorAll('li.kb-open').forEach(li => li.classList.remove('kb-open'));
      const a = e.target.closest('a');
      if (a) a.focus();
    }
  });
});