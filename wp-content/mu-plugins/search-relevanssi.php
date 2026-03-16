<?php
if (!defined('ABSPATH')) exit;

add_filter('pre_get_posts', function($q){
  if (is_admin() || !$q->is_main_query() || !$q->is_search()) return;
  $q->set('relevanssi', true);
});