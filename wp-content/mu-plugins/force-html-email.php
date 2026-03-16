<?php
/**
 * MU – Força envio de emails em HTML no WordPress.
 * Aplica-se a todos os envios via wp_mail() (incl. Loginizer).
 * Author: Marcolino Melo - MKTL
 */
add_filter('wp_mail_content_type', function () { return 'text/html'; }, 999);
add_filter('wp_mail_charset', function () { return 'UTF-8'; }, 999);
