<?php
/**
 * Plugin Name: PXL Accordion -> Modal (Hard Override)
 * Description: Ao clicar no título do acordeão PXL, abre o conteúdo num modal em vez de expandir. Só aplica em acordeões marcados com "accodion-modal" OU "accordion-modal" (no acordeão ou num pai).
 * Author: Marcolino Melo - MKTL
 * Version: 1.3.0
 */

if (!defined('ABSPATH')) exit;

add_action('wp_footer', function () { ?>
<style>
  .mktl-modal-backdrop{
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.65);
    z-index: 999999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
  }
  .mktl-modal-backdrop.is-open{ display:flex; }

  .mktl-modal{
    width: min(900px, 100%);
    max-height: min(80vh, 720px);
    overflow: auto;
    background: #fff;
    border-radius: 0px;
    box-shadow: 0 20px 60px rgba(0,0,0,.35);
    padding: 40px;
  }
  .mktl-modal__header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap: 12px;
    margin-bottom: 10px;
  }
  .mktl-modal__title{
    margin:0;
    font-size:18px;
    font-weight:700;
    line-height:1.2;
  }
  .mktl-modal__close{
    border:0;
    cursor:pointer;
    font-size:22px;
    line-height:1;
    padding: 0 20px !important;
  }
  .mktl-modal__body{
    font-size:15px;
    line-height:1.55;
  }
</style>

<div class="mktl-modal-backdrop" id="mktlModalBackdrop" aria-hidden="true">
  <div class="mktl-modal" role="dialog" aria-modal="true" aria-labelledby="mktlModalTitle">
    <div class="mktl-modal__header">
      <h3 class="mktl-modal__title" id="mktlModalTitle"></h3>
      <button type="button" class="mktl-modal__close" id="mktlModalClose" aria-label="Fechar">×</button>
    </div>
    <div class="mktl-modal__body" id="mktlModalBody"></div>
  </div>
</div>

<script>
(function(){
  // ✅ aceita as duas classes: com e sem "r"
  const MODAL_MARKERS = ['accodion-modal', 'accordion-modal'];

  const backdrop = document.getElementById('mktlModalBackdrop');
  const btnClose = document.getElementById('mktlModalClose');
  const titleElM = document.getElementById('mktlModalTitle');
  const bodyElM  = document.getElementById('mktlModalBody');
  let lastActive = null;

  function openModal(title, html){
    lastActive = document.activeElement;
    titleElM.textContent = title || '';
    bodyElM.innerHTML = html || '';
    backdrop.classList.add('is-open');
    backdrop.setAttribute('aria-hidden', 'false');
    setTimeout(()=>btnClose.focus(),0);
  }
  function closeModal(){
    backdrop.classList.remove('is-open');
    backdrop.setAttribute('aria-hidden', 'true');
    titleElM.textContent = '';
    bodyElM.innerHTML = '';
    if (lastActive && lastActive.focus) lastActive.focus();
  }

  backdrop.addEventListener('click', (e)=>{ if (e.target === backdrop) closeModal(); });
  btnClose.addEventListener('click', closeModal);

  document.addEventListener('keydown', (e)=>{
    if (e.key === 'Escape' && backdrop.classList.contains('is-open')) {
      e.preventDefault();
      closeModal();
    }
  });

  // Remove handlers existentes: truque do clone (limpa listeners)
  function replaceWithClone(node){
    const clone = node.cloneNode(true);
    node.parentNode.replaceChild(clone, node);
    return clone;
  }

  function hasModalMarker(el){
    if (!el) return false;
    // tanto no próprio .pxl-accordion como num ancestral
    for (const cls of MODAL_MARKERS){
      if (el.classList?.contains(cls)) return true;
      if (el.closest && el.closest('.' + cls)) return true;
    }
    return false;
  }

  function bindAccordionTitles(root){
    // 👉 não filtramos no querySelector por classe, porque a classe pode estar no pai
    const titles = (root || document).querySelectorAll('.pxl-accordion .pxl-accordion--title');

    titles.forEach((t)=>{
      // só aplica se o acordeão estiver marcado (no acordeão ou num pai)
      const accordion = t.closest('.pxl-accordion');
      if (!hasModalMarker(accordion)) return;

      // evitar rebinding
      if (t.dataset.mktlBound === '1') return;
      t.dataset.mktlBound = '1';

      // limpar listeners do plugin
      const cleanTitle = replaceWithClone(t);
      cleanTitle.dataset.mktlBound = '1';

      // nosso handler
      cleanTitle.addEventListener('click', function(e){
        e.preventDefault();
        e.stopPropagation();

        const sel = cleanTitle.getAttribute('data-target');
        if (!sel || sel[0] !== '#') return;

        // evita problemas de IDs duplicados em loops
        const item = cleanTitle.closest('.pxl--item') || cleanTitle.parentElement;
        let content = item ? item.querySelector(sel) : null;
        if (!content) content = document.querySelector(sel);
        if (!content) return;

        const titleText = (cleanTitle.querySelector('.pxl-title--text')?.textContent || cleanTitle.textContent || '').trim();
        openModal(titleText, content.innerHTML);
      }, true);
    });
  }

  // Bind inicial
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', ()=>bindAccordionTitles(document));
  } else {
    bindAccordionTitles(document);
  }

  // Elementor/loops: observar DOM e bind a novos acordeões
  const obs = new MutationObserver((mutations)=>{
    for (const m of mutations){
      for (const n of m.addedNodes){
        if (!(n instanceof HTMLElement)) continue;
        if (n.querySelector?.('.pxl-accordion .pxl-accordion--title') || n.matches?.('.pxl-accordion')) {
          bindAccordionTitles(n);
        }
      }
    }
  });
  obs.observe(document.documentElement, { childList:true, subtree:true });

})();
</script>
<?php }, 9999);