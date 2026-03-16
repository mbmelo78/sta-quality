<?php
/**
 * Plugin Name: Site A11Y (MU)
 * Description: Mini-framework de acessibilidade (5 módulos) para este site.
 * Author: Marcolino Melo - MKTL
 * Version: 1.0
 */

if (!defined('ABSPATH')) exit;

add_action('wp_enqueue_scripts', function () {

  $base = content_url('mu-plugins/a11y');

  // CSS base (focus, etc.)
  wp_enqueue_style('mu-a11y', $base . '/a11y.css', [], '1.0');

  // Módulos JS (ordem importa)
  $mods = [
    '/modules/01-skip-link.js',
    '/modules/02-menu-keyboard.js',
    '/modules/03-external-links.js',
    '/modules/04-aria-fixes.js',
    '/modules/05-focus-trap-mobile.js',
  ];

  foreach ($mods as $i => $m) {
    wp_enqueue_script('mu-a11y-' . ($i+1), $base . $m, [], '1.0', true);
  }

  // Config central (ajusta seletores sem mexer nos módulos)
  wp_add_inline_script('mu-a11y-1', 'window.__A11Y_CFG__ = ' . wp_json_encode([
    'menuSelector' => '.pxl-menu-primary',
    'contentSelector' => '#main, main, .site-main, #content',
    'externalLinkTextPT' => ' (link externo)',
  ]) . ';', 'before');

}, 20);