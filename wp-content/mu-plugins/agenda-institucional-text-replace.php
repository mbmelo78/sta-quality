<?php
/**
 * Plugin Name: STA - Agenda Institucional (ajuste de textos)
 * Autor: Marcolino Melo - MKTL
 */

if (!defined('ABSPATH')) exit;

function sta_is_agenda_institucional(): bool {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $path = parse_url($uri, PHP_URL_PATH) ?: '';
    return (strpos($path, '/agenda-institucional/') === 0) || ($path === '/agenda-institucional');
}

add_filter('gettext', function($translated, $text, $domain) {

    if (!sta_is_agenda_institucional()) return $translated;

    // Título Events
    if ($text === 'Events') {
        return 'Agenda Institucional';
    }

    return $translated;

}, 20, 3);