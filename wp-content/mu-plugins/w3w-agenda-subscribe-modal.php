<?php
/**
 * Plugin Name: W3W - Agenda | Subscribe Modal
 * Description: Na página da agenda institucional, troca o dropdown "Subscrever o calendário" por um modal com as mesmas opções.
 * Autor: Marcolino Melo - MKTL 
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) exit;

function w3w_agenda_modal_is_target_page(): bool {
    if (is_admin()) return false;

    $uri = strtok($_SERVER['REQUEST_URI'] ?? '', '?');

    return stripos($uri, '/agenda-institucional') !== false;
}

add_action('wp_enqueue_scripts', function () {
    if (!w3w_agenda_modal_is_target_page()) return;

    $css = <<<CSS
/* esconder dropdown original quando o plugin estiver ativo */
html.w3w-agenda-modal-ready .tribe-events-c-subscribe-dropdown__content{
    display:none !important;
}

/* garantir cursor no botão */
html.w3w-agenda-modal-ready .tribe-events-c-subscribe-dropdown__button{
    cursor:pointer;
}

/* overlay */
#w3wAgendaSubscribeModal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    display:none;
    align-items:center;
    justify-content:center;
    padding:20px;
    z-index:999999;
}

#w3wAgendaSubscribeModal.w3w-open{
    display:flex;
}

/* caixa */
#w3wAgendaSubscribeModal .w3w-modal-dialog{
    width:min(520px, 100%);
    background:#fff;
    border-radius:12px;
    box-shadow:0 20px 50px rgba(0,0,0,.18);
    overflow:hidden;
}

/* header */
#w3wAgendaSubscribeModal .w3w-modal-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:18px 20px;
    border-bottom:1px solid rgba(0,0,0,.08);
}

#w3wAgendaSubscribeModal .w3w-modal-title{
    margin:0;
    font-size:20px;
    line-height:1.2;
    font-weight:700;
    color:#111;
}

#w3wAgendaSubscribeModal .w3w-modal-close{
    border:0;
    background:transparent;
    cursor:pointer;
    font-size:28px;
    line-height:1;
    padding:0;
    color:#333;
}

/* body */
#w3wAgendaSubscribeModal .w3w-modal-body{
    padding:18px 20px 20px;
}

#w3wAgendaSubscribeModal .w3w-subscribe-list{
    list-style:none;
    margin:0;
    padding:0;
    display:grid;
    gap:10px;
}

#w3wAgendaSubscribeModal .w3w-subscribe-item{
    margin:0;
    padding:0;
}

#w3wAgendaSubscribeModal .w3w-subscribe-link{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    width:100%;
    padding:14px 16px;
    border:1px solid rgba(0,0,0,.10);
    border-radius:10px;
    background:#fff;
    text-decoration:none;
    color:#1d1d1d;
    transition:.2s ease;
}

#w3wAgendaSubscribeModal .w3w-subscribe-link:hover{
    background:#f7f9fc;
    border-color:rgba(0,0,0,.18);
}

#w3wAgendaSubscribeModal .w3w-subscribe-link-text{
    display:block;
    font-weight:600;
    line-height:1.3;
}

#w3wAgendaSubscribeModal .w3w-subscribe-link-icon{
    flex:0 0 auto;
    opacity:.75;
    font-size:14px;
}

/* pequeno ajuste no botão original */
html.w3w-agenda-modal-ready .tribe-events-c-subscribe-dropdown__button-text{
    pointer-events:none;
}
html.w3w-agenda-modal-ready .tribe-events-c-subscribe-dropdown__button-icon{
    pointer-events:none;
}

@media (max-width: 640px){
    #w3wAgendaSubscribeModal .w3w-modal-dialog{
        width:100%;
        border-radius:10px;
    }

    #w3wAgendaSubscribeModal .w3w-modal-title{
        font-size:18px;
    }
}
CSS;

    wp_register_style('w3w-agenda-subscribe-modal', false);
    wp_enqueue_style('w3w-agenda-subscribe-modal');
    wp_add_inline_style('w3w-agenda-subscribe-modal', $css);

    $js = <<<'JS'
(function(){
  function isTargetPage(){
    return location.pathname.indexOf('/agenda-institucional') !== -1;
  }

  function qs(sel, ctx){
    return (ctx || document).querySelector(sel);
  }

  function qsa(sel, ctx){
    return Array.prototype.slice.call((ctx || document).querySelectorAll(sel));
  }

  function buildModal(){
    var existing = document.getElementById('w3wAgendaSubscribeModal');
    if(existing) return existing;

    var modal = document.createElement('div');
    modal.id = 'w3wAgendaSubscribeModal';
    modal.setAttribute('aria-hidden', 'true');
    modal.innerHTML =
      '<div class="w3w-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="w3wAgendaSubscribeModalTitle">' +
        '<div class="w3w-modal-header">' +
          '<h3 id="w3wAgendaSubscribeModalTitle" class="w3w-modal-title">Subscrever o calendário</h3>' +
          '<button type="button" class="w3w-modal-close" aria-label="Fechar">×</button>' +
        '</div>' +
        '<div class="w3w-modal-body">' +
          '<ul class="w3w-subscribe-list"></ul>' +
        '</div>' +
      '</div>';

    document.body.appendChild(modal);

    modal.addEventListener('click', function(e){
      if(e.target === modal){
        closeModal();
      }
    });

    var closeBtn = qs('.w3w-modal-close', modal);
    if(closeBtn){
      closeBtn.addEventListener('click', closeModal);
    }

    return modal;
  }

  function openModal(){
    var modal = buildModal();
    modal.classList.add('w3w-open');
    modal.setAttribute('aria-hidden', 'false');
    document.documentElement.classList.add('w3w-modal-lock');
    document.body.style.overflow = 'hidden';
  }

  function closeModal(){
    var modal = document.getElementById('w3wAgendaSubscribeModal');
    if(!modal) return;

    modal.classList.remove('w3w-open');
    modal.setAttribute('aria-hidden', 'true');
    document.documentElement.classList.remove('w3w-modal-lock');
    document.body.style.overflow = '';
  }

  function copyOptionsToModal(dropdown){
    var modal = buildModal();
    var list = qs('.w3w-subscribe-list', modal);
    if(!list) return;

    list.innerHTML = '';

    var links = qsa('.tribe-events-c-subscribe-dropdown__list-item-link', dropdown);

    links.forEach(function(link){
      var href = link.getAttribute('href') || '#';
      var target = link.getAttribute('target') || '';
      var rel = link.getAttribute('rel') || '';
      var text = (link.textContent || '').replace(/\s+/g, ' ').trim();

      var li = document.createElement('li');
      li.className = 'w3w-subscribe-item';

      var a = document.createElement('a');
      a.className = 'w3w-subscribe-link';
      a.href = href;
      if(target) a.target = target;
      if(rel) a.rel = rel;

      var isExternal = target === '_blank' || /^https?:/i.test(href) || /^webcal:/i.test(href);

      a.innerHTML =
        '<span class="w3w-subscribe-link-text">' + escapeHtml(text) + '</span>' +
        '<span class="w3w-subscribe-link-icon" aria-hidden="true">' + (isExternal ? '↗' : '→') + '</span>';

      li.appendChild(a);
      list.appendChild(li);
    });
  }

  function escapeHtml(str){
    return (str || '').replace(/[&<>"']/g, function(m){
      return ({
        '&':'&amp;',
        '<':'&lt;',
        '>':'&gt;',
        '"':'&quot;',
        "'":'&#039;'
      })[m];
    });
  }

  function enhanceDropdown(dropdown){
    if(!dropdown || dropdown.dataset.w3wSubscribeModalDone === '1') return;

    var triggerWrap = qs('.tribe-events-c-subscribe-dropdown__button', dropdown);
    var triggerBtn = qs('.tribe-events-c-subscribe-dropdown__button-text', dropdown);

    if(!triggerWrap || !triggerBtn) return;

    copyOptionsToModal(dropdown);

    dropdown.dataset.w3wSubscribeModalDone = '1';
    document.documentElement.classList.add('w3w-agenda-modal-ready');

    function openFromTrigger(e){
      e.preventDefault();
      e.stopPropagation();

      copyOptionsToModal(dropdown);
      openModal();
    }

    triggerWrap.addEventListener('click', openFromTrigger, true);
    triggerBtn.addEventListener('click', openFromTrigger, true);

    triggerBtn.setAttribute('aria-expanded', 'false');
    triggerBtn.setAttribute('aria-haspopup', 'dialog');
  }

  function run(){
    if(!isTargetPage()) return;

    qsa('.tribe-events-c-subscribe-dropdown').forEach(enhanceDropdown);
  }

  document.addEventListener('DOMContentLoaded', run);

  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape'){
      closeModal();
    }
  });

  new MutationObserver(function(){
    run();
  }).observe(document.documentElement, {
    childList: true,
    subtree: true
  });
})();
JS;

    wp_register_script('w3w-agenda-subscribe-modal', false, [], null, true);
    wp_enqueue_script('w3w-agenda-subscribe-modal');
    wp_add_inline_script('w3w-agenda-subscribe-modal', $js);
}, 20);