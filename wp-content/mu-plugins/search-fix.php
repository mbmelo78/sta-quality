<?php
if (!defined('ABSPATH')) exit;

add_action('pre_get_posts', function ($q) {
  if (is_admin() || !$q->is_main_query()) return;

  if ($q->is_search()) {
    $q->set('post_type', ['post', 'page']);
    $q->set('post_status', 'publish');
  }
});