document.addEventListener('DOMContentLoaded', () => {
  const cfg = window.__A11Y_CFG__ || {};
  const target = document.querySelector(cfg.contentSelector || 'main');
  if (!target) return;

  // garante que o target pode receber foco
  if (!target.hasAttribute('tabindex')) target.setAttribute('tabindex', '-1');

  const a = document.createElement('a');
  a.href = '#a11y-main';
  a.className = 'a11y-skip-link';
  a.textContent = 'Saltar para o conteúdo';

  // cria âncora antes do main
  let anchor = document.getElementById('a11y-main');
  if (!anchor) {
    anchor = document.createElement('div');
    anchor.id = 'a11y-main';
    anchor.className = 'sr-only';
    target.parentNode.insertBefore(anchor, target);
  }

  a.addEventListener('click', (e) => {
    e.preventDefault();
    target.focus({ preventScroll: false });
  });

  document.body.insertBefore(a, document.body.firstChild);
});