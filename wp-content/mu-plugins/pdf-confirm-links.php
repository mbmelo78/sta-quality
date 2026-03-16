<?php
/**
 * Plugin Name: PDF Confirm Links (MU)
 * Description: Intercepta cliques em links .pdf e mostra popup com opções (abrir nova aba / download).
 * Author: Marcolino Melo - MKTL
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) exit;

add_action('wp_enqueue_scripts', function () {
  // Só no front-end
  if (is_admin()) return;

  // CSS inline
  $css = <<<CSS
.pdfconfirm-backdrop{
  position:fixed; inset:0;
  background:rgba(0,0,0,.55);
  display:none; align-items:center; justify-content:center;
  z-index:999999;
}
.pdfconfirm-modal{
  width:min(400px, calc(100% - 24px));
  background:#fff;
  border-radius:14px;
  box-shadow:0 20px 60px rgba(0,0,0,.25);
  padding:18px 18px 14px;
  font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
}
.pdfconfirm-title{
    font-size:18px;
    font-weight:700;
    text-align:center;
    margin:20 0 20px; }
.pdfconfirm-desc{ font-size:14px; line-height:1.4; margin:0 0 14px; color:#333; }
.pdfconfirm-actions{ display:flex; gap:10px; flex-wrap:wrap; justify-content:center; }
.pdfconfirm-btn{
  appearance:none; border:1px solid #d0d0d0; background:#f6f6f6;
  padding:10px 12px; border-radius:10px; cursor:pointer; font-weight:600; font-size:14px;
}
.pdfconfirm-btn.primary{ background:#236093; color:#fff; border-color:#111; }
.pdfconfirm-btn.link{ background:#cecece; border-color:transparent; color:#444; }
.pdfconfirm-backdrop[data-open="1"]{ display:flex; }
CSS;

  // Enfileirar um "handle" vazio e anexar inline (não depende do tema)
  wp_register_style('pdfconfirm-mu', false);
  wp_enqueue_style('pdfconfirm-mu');
  wp_add_inline_style('pdfconfirm-mu', $css);

  // JS inline
  $js = <<<JS
(function () {
  function isPdfUrl(url) {
    if (!url) return false;
    try {
      var u = new URL(url, window.location.href);
      var path = u.pathname.toLowerCase();
      return path.endsWith(".pdf");
    } catch (e) {
      var s = String(url).toLowerCase();
      s = s.split("?")[0].split("#")[0];
      return s.endsWith(".pdf");
    }
  }

  var backdrop = document.createElement("div");
  backdrop.className = "pdfconfirm-backdrop";
  backdrop.innerHTML =
    '<div class="pdfconfirm-modal" role="dialog" aria-modal="true" aria-labelledby="pdfconfirm-title">' +
      '<h3 class="pdfconfirm-title" id="pdfconfirm-title">Documento em PDF</h3>' +
      '<div class="pdfconfirm-actions">' +
        '<button type="button" class="pdfconfirm-btn link" data-action="cancel">Cancelar</button>' +
        '<button type="button" class="pdfconfirm-btn primary" data-action="open">Abrir Documento</button>' +
      '</div>' +
    '</div>';

  var currentUrl = null;

  function openModal(pdfUrl) {
    currentUrl = pdfUrl;
    backdrop.setAttribute("data-open", "1");
  }
  function closeModal() {
    backdrop.setAttribute("data-open", "0");
    currentUrl = null;
  }

  document.addEventListener("DOMContentLoaded", function () {
    document.body.appendChild(backdrop);
  });

  backdrop.addEventListener("click", function (e) {
    if (e.target === backdrop) closeModal();
  });

  backdrop.addEventListener("click", function (e) {
    var btn = e.target.closest && e.target.closest("button[data-action]");
    if (!btn) return;

    var action = btn.getAttribute("data-action");
    if (action === "cancel") return closeModal();
    if (!currentUrl) return closeModal();

    if (action === "open") {
      window.open(currentUrl, "_blank", "noopener,noreferrer");
      return closeModal();
    }

    if (action === "download") {
      var a = document.createElement("a");
      a.href = currentUrl;
      a.download = ""; // pode ser ignorado em cross-origin
      a.rel = "noopener";
      document.body.appendChild(a);
      a.click();
      a.remove();
      return closeModal();
    }
  });

  document.addEventListener("click", function (e) {
    var a = e.target.closest && e.target.closest("a[href]");
    if (!a) return;

    if (a.getAttribute("data-no-pdfconfirm") === "1") return;

    var href = a.getAttribute("href");
    if (!isPdfUrl(href)) return;

    // Respeitar cliques "modificados"
    if (e.ctrlKey || e.metaKey || e.shiftKey || e.button === 1) return;

    e.preventDefault();
    openModal(a.href);
  }, true);

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && backdrop.getAttribute("data-open") === "1") closeModal();
  });
})();
JS;

  wp_register_script('pdfconfirm-mu', false, [], null, true);
  wp_enqueue_script('pdfconfirm-mu');
  wp_add_inline_script('pdfconfirm-mu', $js);
});