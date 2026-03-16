document.addEventListener('DOMContentLoaded', () => {
  const getModal = () =>
    document.querySelector('[aria-modal="true"]') ||
    document.querySelector('.pxl-menu-mobile.is-open, .pxl-offcanvas.is-open');

  function trap(e, modal) {
    if (e.key !== 'Tab') return;

    const focusables = modal.querySelectorAll('a,button,input,select,textarea,[tabindex]:not([tabindex="-1"])');
    const list = Array.from(focusables).filter(x => !x.hasAttribute('disabled') && x.offsetParent !== null);
    if (!list.length) return;

    const first = list[0];
    const last = list[list.length - 1];

    if (e.shiftKey && document.activeElement === first) {
      e.preventDefault();
      last.focus();
    } else if (!e.shiftKey && document.activeElement === last) {
      e.preventDefault();
      first.focus();
    }
  }

  document.addEventListener('keydown', (e) => {
    const modal = getModal();
    if (!modal) return;
    trap(e, modal);
    if (e.key === 'Escape') {
      // não forçamos fechar (tema trata), mas melhoramos a saída
      const closeBtn = modal.querySelector('[aria-label*="fechar"], .close, .pxl-close');
      if (closeBtn) closeBtn.click();
    }
  });
});