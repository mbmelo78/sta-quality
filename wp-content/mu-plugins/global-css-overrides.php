<?php
/**
 * Plugin Name: Global CSS Overrides (MU)
 * Description: Carrega CSS global transversal ao site, independente do tema/Elementor.
 * Author: Marcolino Melo - MKTL
 * Version: 1.1.0
 */

if (!defined('ABSPATH')) exit;

function mu_global_css_path(): string {
  return WP_CONTENT_DIR . '/mu-plugins/global-overrides.css';
}

function mu_global_css_url(): string {
  return content_url('mu-plugins/global-overrides.css');
}

add_action('wp_enqueue_scripts', function () {
  if (is_admin()) return;

  $path = mu_global_css_path();
  $url  = mu_global_css_url();

  // Em DEV: melhor forma de garantir "sem cache" é inline (não há request, logo não há cache).
  $dev_mode = (defined('WP_DEBUG') && WP_DEBUG);

  if ($dev_mode && file_exists($path)) {
    // Regista um handle "vazio" e injeta CSS inline
    wp_register_style('mu-global-overrides', false, [], null);
    wp_enqueue_style('mu-global-overrides');

    $css = file_get_contents($path);
    if ($css !== false && $css !== '') {
      wp_add_inline_style('mu-global-overrides', $css);
    }
    return;
  }

  // Em produção: carrega o ficheiro e usa filemtime como cache-busting (recarrega quando muda)
  $ver = file_exists($path) ? (string) filemtime($path) : null;

  wp_register_style('mu-global-overrides', $url, [], $ver);
  wp_enqueue_style('mu-global-overrides');

}, 9999);