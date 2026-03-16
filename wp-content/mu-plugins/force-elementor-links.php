<?php
/*
Plugin Name: Force Links Style (Elementor/PXL)
Author: Marcolino Melo - MKTL
*/

add_action('wp_head', function(){ ?>
<style>

  /* 0) REGRA BASE: links externos NÃO são sublinhados por defeito */
  a.external-marked{
    text-decoration: none !important;
    font-weight: inherit !important;
  }

  /* 1) SÓ sublinhar em conteúdo de texto (parágrafos) */
  .pxl-item--inner p a.external-marked,
  .elementor-widget-container .elementor-text-editor p a.external-marked,
  .elementor-widget-container .elementor-text-editor li a.external-marked{
    text-decoration: underline !important;
    font-weight: 700 !important;
  }




</style>
<?php });