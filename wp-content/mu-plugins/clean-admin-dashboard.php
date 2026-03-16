<?php

/**

 * Plugin Name: Clean Admin Dashboard (custom)

 * Description: Remove painéis/banners promocionais e widgets de plugins no Painel WP.

 * Author: Marcolino Melo - MKTL

 */



// 1) Remover (quase) todos os admin_notices no Painel

add_action('load-index.php', function () {

    // remove todas as notices (inclui promos dos plugins)

    remove_all_actions('admin_notices');

    remove_all_actions('all_admin_notices');

});



// 2) Remover widgets de dashboard conhecidos (Elementor/Elementskit/afins)

add_action('wp_dashboard_setup', function () {

    // Elementor

    remove_meta_box('e-dashboard-overview', 'dashboard', 'normal');     // Elementor Overview

    // Royal Elementor Addons (ids comuns; se não existir, ignora)

    remove_meta_box('rea_dashboard_widget', 'dashboard', 'normal');

    // ElementsKit

    remove_meta_box('elementskit_dashboard_widget', 'dashboard', 'normal');

    remove_meta_box('elementskit-dashboard', 'dashboard', 'normal');

    // Outros genéricos que alguns plugins usam

    remove_meta_box('welcome_panel', 'dashboard', 'normal');

});



// 3) CSS de salvaguarda só na página do Painel (para banners “teimosos”)

add_action('admin_head-index.php', function () {

    echo '<style>

        /* Notificações promocionais comuns */

        .notice, .update-nag, .e-notice, .elementskit-admin-notice,

        .rea-admin-notice, .rkit-admin-notice, .royal-addons-notice {

            display:none !important;

        }

        /* Alguns plugins injetam blocos fora das notices */

        .wrap .rea-wrap, .wrap .elementskit-dashboard, .wrap .rkit-dashboard {

            display:none !important;

        }

    </style>';

});

