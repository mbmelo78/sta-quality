<?php
/**
 * Plugin Name: PXL ScrollTop Instant Start
 * Author: Marcolino Melo - MKTL
 */
add_action('wp_enqueue_scripts', function () {

  // usa wp_footer para garantir que o elemento já existe
  add_action('wp_footer', function () { ?>
    <script>
      (function(){
        // Captura o clique ANTES dos listeners do tema
        document.addEventListener('click', function(e){
          var a = e.target.closest && e.target.closest('a.pxl-scroll-top');
          if(!a) return;

          // Mata o comportamento do tema (inclui jQuery handlers)
          e.preventDefault();
          e.stopPropagation();
          if (e.stopImmediatePropagation) e.stopImmediatePropagation();

          // Inicia já no próximo frame (zero “1 segundo parado”)
          requestAnimationFrame(function(){
            window.scrollTo({ top: 0, behavior: 'smooth' });
          });
        }, true); // <-- CAPTURING
      })();
    </script>
  <?php }, 999);

}, 999);