<?php
/**
 * Plugin Name: MU – STA Custom Login Logo
 * Description: Substitui o logo do ecrã de login.
 * Author: Marcolino Melo - MKTL
 */

add_action('login_head', function () {
    // Usa URL ABSOLUTA para evitar problemas de caminhos / subdiretórios / multisite
    $logo_url = '/img/sta-logo-black.png';

    ?>
    <style id="sta-login-logo">
      /* Regras fortes e tardias para vencer qualquer CSS de plugins/tema */
      #login h1 a, .login h1 a {
        background-image: url('<?php echo esc_url($logo_url); ?>') !important;
        background-size: contain !important;
        background-repeat: no-repeat !important;
        width: 300px !important;   /* ajusta ao tamanho do teu ícone */        
        margin: 0 auto !important;
        padding: 0 !important;
        text-indent: -9999px !important; /* garante que o texto não aparece */
      }
    </style>
    <?php
}, 999); // prioridade alta para sair no fim do <head>

add_filter('login_headerurl', fn() => home_url('/'));
add_filter('login_headertext', fn() => get_bloginfo('name'));
