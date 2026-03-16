<?php
/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets.
 *
 * @package Case-Themes
 * @since Lawsight 1.0
 */

if(!defined('DEV_MODE')){ define('DEV_MODE', true); }

if(!defined('THEME_DEV_MODE_ELEMENTS') && is_user_logged_in()){
    define('THEME_DEV_MODE_ELEMENTS', true);
}
 
require_once get_template_directory() . '/inc/classes/class-main.php';

if ( is_admin() ){ 
	require_once get_template_directory() . '/inc/admin/admin-init.php'; }
 
/**
 * Theme Require
*/
Lawsight()->require_folder('inc');
Lawsight()->require_folder('inc/classes');
Lawsight()->require_folder('inc/theme-options');
Lawsight()->require_folder('template-parts/widgets');
if(class_exists('Woocommerce')){
    Lawsight()->require_folder('woocommerce');
}

// function theme_enqueue_scripts() {
//     wp_enqueue_script('counter-js', get_template_directory_uri() . '/elements/assets/js/counter.js', array('jquery'), '1.0.0', true);
// }
// add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


add_action( 'after_setup_theme', 'remove_woocommerce_gallery_zoom_lightbox_slider', 100 );
function remove_woocommerce_gallery_zoom_lightbox_slider() {
    remove_theme_support( 'wc-product-gallery-zoom' ); // close zoom img in single product
}




// === Imagem de destaque por defeito, global ===
// === Imagem de destaque por defeito (robusto) ===
// Define o ID da imagem da Media Library que queres usar como padrão
if (!defined('MKT_DEFAULT_THUMB_ID')) {
    define('MKT_DEFAULT_THUMB_ID', 6305); // <-- troca pelo ID real
}

add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
});

/**
 * Fornece um _thumbnail_id por defeito quando o post não tem um definido.
 * Evita loops removendo e voltando a adicionar o próprio filtro.
 */
function mktl_default_thumb_meta($value, $object_id, $meta_key, $single) {
    if ($meta_key !== '_thumbnail_id') {
        return $value;
    }

    // Tipos de post onde aplicar
    $type = get_post_type($object_id);
    if (!in_array($type, ['post'], true)) { // adiciona outros CPTs se precisares
        return $value;
    }

    // Evitar loop: ler meta real removendo temporariamente o filtro
    remove_filter('get_post_metadata', 'mktl_default_thumb_meta', 10);

    $existing = get_post_meta($object_id, '_thumbnail_id', true);

    // Repor o filtro
    add_filter('get_post_metadata', 'mktl_default_thumb_meta', 10, 4);

    // Se já houver thumbnail, respeita-o
    if (!empty($existing)) {
        return $value;
    }

    // Se não houver, devolve o ID padrão
    if (defined('MKT_DEFAULT_THUMB_ID') && MKT_DEFAULT_THUMB_ID > 0) {
        return $single ? (int) MKT_DEFAULT_THUMB_ID : [ (int) MKT_DEFAULT_THUMB_ID ];
    }

    return $value;
}
add_filter('get_post_metadata', 'mktl_default_thumb_meta', 10, 4);

/**
 * Se algum template pedir diretamente o HTML e vier vazio,
 * renderiza a imagem padrão no size solicitado.
 */
function mktl_default_thumb_html($html, $post_id, $thumb_id, $size, $attr) {
    if (!empty($html)) {
        return $html;
    }
    if (!defined('MKT_DEFAULT_THUMB_ID') || MKT_DEFAULT_THUMB_ID <= 0) {
        return $html;
    }
    return wp_get_attachment_image((int) MKT_DEFAULT_THUMB_ID, $size, false, array_merge(
        ['class' => 'wp-post-image'],
        is_array($attr) ? $attr : []
    ));
}
add_filter('post_thumbnail_html', 'mktl_default_thumb_html', 10, 5);


// Forçar traduções específicas
// 1) Forçar tradução via gettext (prioridade muito alta)
add_filter('gettext', 'st_force_recent_posts_pt', 9999, 3);
function st_force_recent_posts_pt( $translated, $original, $domain ) {
    // Match exato (vários temas usam isto)
    if ( $original === 'Recent Posts' ) {
        return 'Recentes';
    }
    // Se já veio traduzido por outro sítio, ainda assim força
    if ( $translated === 'Recent Posts' ) {
        return 'Recentes';
    }
    // Variantes: "Recent posts", "Recent Posts:", etc.
    if ( preg_match('/^recent\s+posts:?$/i', $original) || preg_match('/^recent\s+posts:?$/i', $translated) ) {
        return 'Recentes';
    }
    // Search... -> Pesquisa... (mantém reticências usadas)
    if ( preg_match('/^Search(\.\.\.|…)?$/u', $original, $m) ) {
        return 'Pesquisa' . ($m[1] ?? '');
    }
    return $translated;
}

// 2) Em muitos temas, o título do widget passa por este filtro
add_filter('widget_title', 'st_force_widget_title_recent_posts', 9999);
function st_force_widget_title_recent_posts( $title ) {
    // Remove tags e espaços
    $plain = trim(wp_strip_all_tags($title));
    if ( preg_match('/^recent\s+posts:?$/i', $plain) ) {
        return 'Recentes';
    }
    return $title;
}

add_filter('site_transient_update_plugins', function($value) {
    if (isset($value->response['cookieadmin-pro/cookieadmin-pro.php'])) {
        unset($value->response['cookieadmin-pro/cookieadmin-pro.php']);
    }
    return $value;
});

// Ocultar aviso de atualização/licença do Slider Revolution
add_filter('pre_site_transient_update_plugins', function($value) {
    unset($value->response['revslider/revslider.php']);
    return $value;
});


add_action('admin_head', function() {
    echo '<style>.update-message, .plugin-update-tr { display: none !important; }</style>';
});

// Login: trocar o logo do WordPress pelo /img/icon.png
add_action('login_enqueue_scripts', function () {
    $logo = esc_url( home_url('/img/icon.png') ); // ficheiro no webroot
    echo '<style>
      .login h1 a {
        background-image:url(' . $logo . ') !important;
        background-size: contain !important;
        background-repeat: no-repeat !important;
        width: 120px !important;   /* ajusta ao tamanho do teu ícone */
        height: 120px !important;  /* idem */
        padding: 0 !important;
      }
    </style>';
});

// (Opcional) alterar link e título do logo
add_filter('login_headerurl', fn() => home_url('/'));
add_filter('login_headertext', fn() => get_bloginfo('name'));



// [sta_upcoming_events count="3" cat="slug1,slug2" show_image="1" show_venue="0" title_tag="h3" link_text="Saber mais" img_size="medium" image_dim="120"]
add_shortcode('sta_upcoming_events', function($atts){
  $a = shortcode_atts([
    'count'       => 3,
    'cat'         => '',
    'show_image'  => '1',
    'show_venue'  => '0',
    'title_tag'   => 'h3',
    'date_format' => 'd/m/Y',
    'time_format' => 'H:i',
    'link_text'   => 'Saber mais',
    'img_size'    => 'medium',  // tamanho WP: thumbnail/medium/large...
    'image_dim'   => '150'      // lado do quadrado (px)
  ], $atts, 'sta_upcoming_events');

  if (!function_exists('tribe_get_events')) return '';

  $args = [
    'posts_per_page' => (int) $a['count'],
    'start_date'     => 'now',
    'eventDisplay'   => 'list',
    'orderby'        => 'event_date',
    'order'          => 'ASC',
  ];

  if ($a['cat'] !== '') {
    $args['tax_query'] = [[
      'taxonomy' => 'tribe_events_cat',
      'field'    => 'slug',
      'terms'    => array_map('sanitize_title', explode(',', $a['cat'])),
    ]];
  }

  $events = tribe_get_events($args);
  if (!$events) return '<div class="sta-events-empty">Sem eventos agendados.</div>';

  $dim = max(60, (int)$a['image_dim']); // segurança

  ob_start();
  echo '<div class="sta-events-list">';
  foreach ($events as $event) {
    $data = '';//$a['time_format'];

    $id    = $event->ID;
    $url   = esc_url(get_permalink($id));
    $title = esc_html(get_the_title($id));
    $date  = esc_html(tribe_get_start_date($id, false, $a['date_format'].' '.$data ));
    $venue = ($a['show_venue'] === '1') ? trim(tribe_get_venue($id)) : '';

    echo '<article class="sta-event-row">';

    // MEDIA (foto/placeholder)
    if ($a['show_image'] === '1') {
      $img_url = get_the_post_thumbnail_url($id, $a['img_size']);
      echo '<a class="sta-event-media" href="'.$url.'" style="--sta-dim:'.$dim.'px">';
      if ($img_url) {
        echo '<img src="'.esc_url($img_url).'" alt="'.$title.'" loading="lazy">';
      } else {
        echo '<span class="sta-event-ph">FOTO</span>';
      }
      echo '</a>';
    }

    // BODY
    echo '<div class="sta-event-body">';
      echo '<'.$a['title_tag'].' class="sta-event-title"><a href="'.$url.'">'.$title.'</a></'.$a['title_tag'].'>';
      echo '<div class="sta-event-meta">'.$date.($venue ? '<br>'.esc_html($venue) : '').'</div>';
      echo '<a class="sta-event-cta btnEvents" href="'.$url.'">'.$a['link_text'].'</a>';
    echo '</div>';

    echo '</article>';
  }
  echo '</div>';
  return ob_get_clean();
});


// Filtra a query do Elementor (Query ID: sta_upcoming) para próximos eventos
add_action('elementor/query/sta_upcoming', function($query){
  $query->set('post_type', 'tribe_events');
  $query->set('meta_key', '_EventStartDate');
  $query->set('orderby', 'meta_value');
  $query->set('order', 'ASC');
  $query->set('meta_query', [[
    'key'     => '_EventStartDate',
    'value'   => current_time('mysql'),
    'compare' => '>=',
    'type'    => 'DATETIME'
  ]]);
  // (Opcional) filtrar por categoria:
  // $query->set('tax_query', [[
  //   'taxonomy'=>'tribe_events_cat','field'=>'slug','terms'=>['institucional']
  // ]]);
});


// [sta_highlights cat="destaques-de-jurisprudencia" count="6" cols="3" show_excerpt="1" excerpt_words="28" link_text="Saber mais" accent="#1e7a3f"]
add_shortcode('sta_highlights', function($atts){
  $a = shortcode_atts([
    'cat'           => 'destaques-de-jurisprudencia', // slug da categoria alvo
    'count'         => 6,
    'cols'          => 3,
    'show_excerpt'  => '1',
    'excerpt_words' => 28,
    'link_text'     => 'Saber mais',
    'accent'        => '#1e7a3f',                     // verde
    'date_format'   => 'j \d\e F \d\e Y, H\hi',
  ], $atts, 'sta_highlights');

  $args = [
    'post_type'           => 'post',
    'posts_per_page'      => (int)$a['count'],
    'ignore_sticky_posts' => true,
    'tax_query'           => [[
      'taxonomy' => 'category',
      'field'    => 'slug',
      'terms'    => array_map('sanitize_title', explode(',', $a['cat'])),
    ]],
  ];

  $q = new WP_Query($args);
  if (!$q->have_posts()) return '<div class="sta-events-empty">Sem publicações nesta categoria.</div>';

  $cols = max(1, (int)$a['cols']);
  ob_start();
  echo '<div class="sta-cards" style="--sta-accent:'.esc_attr($a['accent']).'; --sta-cols:'.$cols.';">';

  while ($q->have_posts()) { $q->the_post();
    $id    = get_the_ID();
    $url   = esc_url(get_permalink($id));
    $title = esc_html(get_the_title($id));

    // Data (mês minúsculas + dia)
    $day   = esc_html(get_the_date('d', $id));
    $month = get_the_date('F', $id);
    if (function_exists('mb_strtolower')) $month = mb_strtolower($month, 'UTF-8');
    $month = esc_html($month);
    $when  = esc_html(get_the_date($a['date_format'], $id));

    // Categoria “subtema” (primeira diferente da principal)
    $cat_label = '';
    $cats = get_the_category($id);
    if ($cats) {
      $primary_slug = sanitize_title(current(explode(',', $a['cat'])));
      foreach ($cats as $c) {
        if ($c->slug !== $primary_slug && $c->slug !== 'sem-categoria') { $cat_label = esc_html($c->name); break; }
      }
    }

    // Excerto
    $excerpt = '';
    if ($a['show_excerpt'] === '1') {
      $raw = get_the_excerpt($id);
      if (!$raw) $raw = wp_strip_all_tags(get_post_field('post_content', $id));
      $excerpt = esc_html(wp_trim_words($raw, (int)$a['excerpt_words'], '…'));
    }

    echo '<article class="sta-card">';
      echo '<div class="sta-date-badge">';
        echo '<div class="sta-month">'.$month.'</div>';
        echo '<div class="sta-day">'.$day.'.</div>';
      echo '</div>';

      echo '<div class="sta-card-body">';
        echo '<h3 class="sta-title"><a href="'.$url.'">'.$title.'</a></h3>';
        echo '<div class="sta-when">'.$when.'</div>';
        
        if ($excerpt)   echo '<div class="sta-excerpt"><b>'.$excerpt.'</b></div>';
        echo '<a class="sta-btn btnEvents" href="'.$url.'">'.$a['link_text'].'</a>';
      echo '</div>';
    echo '</article>';
  }
  echo '</div>';
  wp_reset_postdata();
  return ob_get_clean();
});

/**
 * Remove notificações de admin indesejadas.
 */
function ocultar_paineis_promocionais_admin() {
    // Esconder o painel de promoção do Royal Elementor Addons Pro
    remove_action('admin_notices', ['WprAddons\Admin\Wpr_Admin_Notices', 'show_pro_sale_notice']);

    // Esconder o painel de upgrade do ElementsKit Lite
    // O ElementsKit usa uma abordagem um pouco diferente, então tentamos remover a classe que o adiciona.
    if (class_exists('\ElementsKit\Notices')) {
        remove_action('admin_notices', [\ElementsKit\Notices::instance(), 'get_pro']);
    }
}
add_action('admin_init', 'ocultar_paineis_promocionais_admin');

// Ocultar painel "Wpmet Stories" do ElementsKit no dashboard
add_action('wp_dashboard_setup', function() {
    remove_meta_box('wpmet-stories', 'dashboard', 'normal');
}, 99);




/**
 * Ajusta o comprimento do excerpt automático
 */
add_filter('excerpt_length', function($length){
	return 50; // número de palavras
}, 999);

/**
 * Garante que o excerpt termina com ...
 */
add_filter('excerpt_more', function($more){
	return '...';
}, 999);

