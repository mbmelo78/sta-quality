document.addEventListener('DOMContentLoaded', () => {
  // 1) Botões/links só com ícone devem ter aria-label
  document.querySelectorAll('a,button').forEach(el => {
    const hasText = (el.textContent || '').trim().length > 0;
    if (hasText) return;

    const hasIcon = el.querySelector('i,svg');
    if (!hasIcon) return;

    if (!el.getAttribute('aria-label') && !el.getAttribute('aria-labelledby')) {
      // fallback genérico (melhor do que nada). Ideal é ires afinando por casos.
      el.setAttribute('aria-label', 'Ação');
    }
  });

  // 2) Imagens decorativas dentro de links: garante aria-hidden no ícone
  document.querySelectorAll('i,svg').forEach(icon => {
    if (!icon.hasAttribute('aria-hidden')) icon.setAttribute('aria-hidden', 'true');
  });
});