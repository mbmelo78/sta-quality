<?php
/**
 * Plugin Name: Relevanssi - Elementor Text Index (MU)
 * Description: Extrai texto do _elementor_data para um meta leve e manda o Relevanssi indexar esse meta, sem “hang”.
 * Author: Marcolino Melo - MKTL
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

const RVI_META = '_rvi_elementor_text';

/**
 * Extrai texto útil do JSON do Elementor (recursivo).
 */
function rvi_extract_text_from_elementor($data): string {
    $out = [];

    $walk = function($node) use (&$walk, &$out) {
        if (is_array($node)) {
            // Elementor costuma guardar texto em chaves como "title", "text", "editor", "description"
            foreach (['title','text','editor','description','heading','content'] as $k) {
                if (isset($node[$k]) && is_string($node[$k])) {
                    $out[] = wp_strip_all_tags($node[$k]);
                }
            }
            foreach ($node as $v) {
                $walk($v);
            }
        } elseif (is_object($node)) {
            foreach (get_object_vars($node) as $v) {
                $walk($v);
            }
        }
    };

    $walk($data);

    // Limpa e compacta
    $text = trim(preg_replace('/\s+/', ' ', implode(' ', array_filter($out))));
    return $text;
}

/**
 * Em cada save de página/post, guarda um meta “limpo” para indexação.
 */
add_action('save_post', function($post_id) {
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) return;

    $post = get_post($post_id);
    if (!$post || $post->post_status !== 'publish') return;

    // só pages/posts (ajusta se precisares)
    if (!in_array($post->post_type, ['page','post'], true)) return;

    $raw = get_post_meta($post_id, '_elementor_data', true);
    if (!$raw) {
        delete_post_meta($post_id, RVI_META);
        return;
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        // fallback: indexar uma versão “strip” do raw (não ideal mas evita zero)
        $text = wp_strip_all_tags($raw);
    } else {
        $text = rvi_extract_text_from_elementor($decoded);
    }

    // Evita guardar megas de texto inútil
    if (strlen($text) > 200000) {
        $text = substr($text, 0, 200000);
    }

    update_post_meta($post_id, RVI_META, $text);
}, 20);

/**
 * Diz ao Relevanssi para indexar este meta “leve”.
 * (Depois tens de Rebuild index.)
 */
add_filter('relevanssi_content_to_index', function($content, $post) {
    $extra = get_post_meta($post->ID, RVI_META, true);
    if ($extra) {
        $content .= ' ' . $extra;
    }
    return $content;
}, 10, 2);