<?php
/**
 * Plugin Name: External Button Indicator (MU)
 * Description: Adiciona ícone e indicação acessível apenas a botões Elementor externos.
 * Author: Marcolino Melo - MKTL
 * Version: 1.1
 */

if (!defined('ABSPATH')) exit;

add_action('wp_footer', function() {
?>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const siteHost = window.location.hostname;

    document.querySelectorAll("a.elementor-button[href]").forEach(function(link) {

        try {
            const url = new URL(link.href);

            if (
                url.hostname !== siteHost &&
                !link.href.startsWith("mailto:") &&
                !link.href.startsWith("tel:") &&
                !link.href.startsWith("#")
            ) {

                if (!link.classList.contains("external-marked")) {

                    link.classList.add("external-marked");

                    // Criar ícone Font Awesome
                    const icon = document.createElement("i");
                    icon.className = "fas fa-external-link-alt external-icon";
                    icon.setAttribute("aria-hidden", "true");

                    // Texto acessível
                    const srText = document.createElement("span");
                    srText.className = "sr-only";
                    srText.textContent = " (link externo)";

                    const wrapper = link.querySelector(".elementor-button-content-wrapper");

                    if (wrapper) {
                        wrapper.appendChild(icon);
                        wrapper.appendChild(srText);
                    }
                                        
                }
            }
        } catch (e) {}
    });

});
</script>
<?php
});