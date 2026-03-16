<?php
/**
 * Plugin Name: W3W - PDF Button File Size
 * Description: Mostra o tamanho do ficheiro abaixo do título dos botões Elementor com link para PDF, apenas na página de estatísticas judiciais.
 * Autor: Marcolino Melo - MKTL
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) exit;

/**
 * Página alvo
 */
function w3w_pdf_fs_is_target_page(): bool {
    if (is_admin()) return false;

    $uri = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
    return stripos($uri, '/actividade-processual/estatisticas-judiciais') !== false;
}

/**
 * Formatar bytes
 */
function w3w_pdf_fs_format_bytes($bytes): string {
    $bytes = (float) $bytes;

    if ($bytes <= 0) return '';

    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $power = (int) floor(log($bytes, 1024));
    $power = min($power, count($units) - 1);

    $value = $bytes / pow(1024, $power);

    if ($power === 0) {
        return number_format($value, 0, ',', '.') . ' ' . $units[$power];
    }

    return number_format($value, 2, ',', '.') . ' ' . $units[$power];
}

/**
 * Converte URL local do site em caminho físico
 */
function w3w_pdf_fs_url_to_local_path(string $url): string {
    $url = trim($url);
    if ($url === '') return '';

    $parsed = wp_parse_url($url);
    if (!$parsed) return '';

    $path = $parsed['path'] ?? '';
    if ($path === '') return '';

    // URL relativa
    if (!isset($parsed['host'])) {
        return rtrim(ABSPATH, '/\\') . $path;
    }

    // URL absoluta do mesmo domínio
    $site_host = wp_parse_url(home_url(), PHP_URL_HOST);
    $file_host = $parsed['host'] ?? '';

    if (!$site_host || !$file_host || strcasecmp($site_host, $file_host) !== 0) {
        return '';
    }

    return rtrim(ABSPATH, '/\\') . $path;
}

/**
 * Obter tamanho do ficheiro a partir do URL
 */
function w3w_pdf_fs_get_size_from_url(string $url): string {
    $local_path = w3w_pdf_fs_url_to_local_path($url);

    if (!$local_path || !file_exists($local_path) || !is_file($local_path)) {
        return '';
    }

    $size = @filesize($local_path);
    if ($size === false || $size <= 0) {
        return '';
    }

    return w3w_pdf_fs_format_bytes($size);
}

/**
 * CSS + JS
 */
add_action('wp_enqueue_scripts', function () {
    if (!w3w_pdf_fs_is_target_page()) return;

    $css = <<<CSS
.elementor-widget-button.w3w-pdf-size a.elementor-button .elementor-button-content-wrapper,
a.elementor-button.w3w-pdf-size .elementor-button-content-wrapper{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:3px;
    width:100%;
}

.elementor-widget-button.w3w-pdf-size a.elementor-button .elementor-button-icon,
a.elementor-button.w3w-pdf-size .elementor-button-icon{
    margin:0 0 2px 0 !important;
}

.elementor-widget-button.w3w-pdf-size a.elementor-button .elementor-button-text,
a.elementor-button.w3w-pdf-size .elementor-button-text{
    display:block;
    line-height:1.15;
}

.w3w-pdf-filesize{
    display:block;
    font-size:12px;
    line-height:1.15;
    opacity:.78;
    font-weight:500;
    margin-top:2px;
}
CSS;

    wp_register_style('w3w-pdf-filesize', false);
    wp_enqueue_style('w3w-pdf-filesize');
    wp_add_inline_style('w3w-pdf-filesize', $css);

    wp_register_script('w3w-pdf-filesize', false, [], null, true);
    wp_enqueue_script('w3w-pdf-filesize');

    $ajax_url = admin_url('admin-ajax.php');
    $nonce = wp_create_nonce('w3w_pdf_fs_nonce');

    $js = '
(function(){
  var ajaxUrl = ' . wp_json_encode($ajax_url) . ';
  var nonce = ' . wp_json_encode($nonce) . ';

  function isTargetPage(){
    return location.pathname.indexOf("/actividade-processual/estatisticas-judiciais") !== -1;
  }

  function normalizeHref(href){
    if(!href) return "";
    try{
      return new URL(href, window.location.origin).href;
    }catch(e){
      return href;
    }
  }

  function isPdfHref(href){
    if(!href) return false;
    return href.toLowerCase().indexOf(".pdf") !== -1;
  }

  function hasTargetClass(anchor){
    if(!anchor) return false;

    if(anchor.classList.contains("w3w-pdf-size")) return true;

    var widget = anchor.closest(".elementor-widget-button");
    if(widget && widget.classList.contains("w3w-pdf-size")) return true;

    return false;
  }

  function injectSize(anchor, sizeText){
    if(!anchor || !sizeText) return;

    var wrapper = anchor.querySelector(".elementor-button-content-wrapper");
    var title = anchor.querySelector(".elementor-button-text");

    if(!wrapper || !title) return;
    if(wrapper.querySelector(".w3w-pdf-filesize")) return;

    var meta = document.createElement("span");
    meta.className = "w3w-pdf-filesize";
    meta.textContent = sizeText;

    title.insertAdjacentElement("afterend", meta);
  }

  function requestSize(anchor){
    if(!anchor) return;
    if(anchor.dataset.w3wPdfSizeDone === "1") return;
    if(anchor.dataset.w3wPdfSizeLoading === "1") return;

    var href = anchor.getAttribute("href") || "";
    if(!isPdfHref(href)) return;
    if(!hasTargetClass(anchor)) return;

    anchor.dataset.w3wPdfSizeLoading = "1";

    var form = new FormData();
    form.append("action", "w3w_pdf_fs_get_size");
    form.append("nonce", nonce);
    form.append("file_url", normalizeHref(href));

    fetch(ajaxUrl, {
      method: "POST",
      body: form,
      credentials: "same-origin"
    })
    .then(function(r){ return r.json(); })
    .then(function(res){
      if(res && res.success && res.data && res.data.size){
        injectSize(anchor, res.data.size);
      }
    })
    .catch(function(){})
    .finally(function(){
      anchor.dataset.w3wPdfSizeDone = "1";
      anchor.dataset.w3wPdfSizeLoading = "0";
    });
  }

  function run(){
    if(!isTargetPage()) return;

    document.querySelectorAll("a.elementor-button.elementor-button-link[href]").forEach(function(anchor){
      requestSize(anchor);
    });
  }

  document.addEventListener("DOMContentLoaded", run);

  new MutationObserver(function(){
    run();
  }).observe(document.documentElement, {
    childList: true,
    subtree: true
  });
})();
';

    wp_add_inline_script('w3w-pdf-filesize', $js);
}, 20);

/**
 * AJAX endpoint
 */
add_action('wp_ajax_w3w_pdf_fs_get_size', 'w3w_pdf_fs_ajax_get_size');
add_action('wp_ajax_nopriv_w3w_pdf_fs_get_size', 'w3w_pdf_fs_ajax_get_size');

function w3w_pdf_fs_ajax_get_size() {
    $nonce = $_POST['nonce'] ?? '';
    if (!wp_verify_nonce($nonce, 'w3w_pdf_fs_nonce')) {
        wp_send_json_error(['message' => 'Nonce inválido.'], 403);
    }

    $file_url = trim((string) ($_POST['file_url'] ?? ''));
    if ($file_url === '') {
        wp_send_json_error(['message' => 'URL em falta.'], 400);
    }

    if (stripos($file_url, '.pdf') === false) {
        wp_send_json_error(['message' => 'O ficheiro não é PDF.'], 400);
    }

    $size = w3w_pdf_fs_get_size_from_url($file_url);

    if ($size === '') {
        wp_send_json_error(['message' => 'Não foi possível obter o tamanho do ficheiro.'], 404);
    }

    wp_send_json_success([
        'size' => $size,
    ]);
}