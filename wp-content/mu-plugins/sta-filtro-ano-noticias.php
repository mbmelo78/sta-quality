<?php
/**
 * Plugin Name: STA - Filtro por Ano nas Notícias
 * Description: Adiciona filtro de ano na sidebar da página de notícias e filtra a query principal.
 * Author: Marcolino Melo - MKTL
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * 1) Filtrar a query principal do arquivo de posts pela query string ?ano=YYYY
 */
add_action('pre_get_posts', function ($query) {
	if (is_admin() || !$query->is_main_query()) {
		return;
	}

	// Ajusta esta condição se a página de notícias tiver outra estrutura
	if (!is_home() && !is_post_type_archive('post') && !is_category() && !is_tag() && !is_date()) {
		// Mesmo assim, permitimos na página /noticias/ se ela for arquivo de posts
		if (!is_page()) {
			return;
		}
	}

	if (empty($_GET['ano'])) {
		return;
	}

	$ano = absint($_GET['ano']);

	if ($ano < 2000 || $ano > 2100) {
		return;
	}

	$query->set('date_query', [
		[
			'year' => $ano,
		]
	]);
});

/**
 * 2) Shortcode para renderizar o filtro de anos
 * Uso: [sta_filtro_anos]
 */
add_shortcode('sta_filtro_anos', function () {
	global $wpdb;

	$years = $wpdb->get_col("
		SELECT DISTINCT YEAR(post_date)
		FROM {$wpdb->posts}
		WHERE post_type = 'post'
		  AND post_status = 'publish'
		ORDER BY YEAR(post_date) DESC
	");

	if (empty($years)) {
		return '';
	}

	$current_year = isset($_GET['ano']) ? absint($_GET['ano']) : 0;

	// URL base atual sem o parâmetro ano
	$base_url = home_url(add_query_arg([], $_SERVER['REQUEST_URI']));
	$base_url = remove_query_arg('ano', $base_url);
	$clear_url = remove_query_arg('ano', $base_url);

	ob_start();
	?>
	<div class="sta-sidebar-year-filter">
		<h3 class="sta-sidebar-year-filter__title">Ano</h3>
		<ul class="sta-sidebar-year-filter__list">
			<li class="<?php echo $current_year === 0 ? 'is-active' : ''; ?>">
				<a href="<?php echo esc_url($clear_url); ?>">Todos</a>
			</li>

			<?php foreach ($years as $year) : 
				$url = add_query_arg('ano', (int) $year, $base_url);
			?>
				<li class="<?php echo ((int)$current_year === (int)$year) ? 'is-active' : ''; ?>">
					<a href="<?php echo esc_url($url); ?>"><?php echo esc_html($year); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
	return ob_get_clean();
});

/**
 * 3) CSS base
 */
add_action('wp_head', function () {
	?>
	<style>
		.sta-sidebar-year-filter{
			margin: 38px 0 0;
		}
		.sta-sidebar-year-filter__title{
			font-size: 22px;
			font-weight: 700;
			margin: 0 0 18px;
			position: relative;
		}
		.sta-sidebar-year-filter__title::after{
			content: "";
			display: block;
			width: 40px;
			height: 3px;
			background: #2f6798;
			margin-top: 10px;
		}
		.sta-sidebar-year-filter__list{
			list-style: none;
			margin: 0;
			padding: 0;
		}
		.sta-sidebar-year-filter__list li{
			border-bottom: 1px solid #e6e6e6;
			margin: 0;
			padding: 0;
		}
		.sta-sidebar-year-filter__list a{
			display: block;
			padding: 14px 0;
			color: #1f1f1f;
			text-decoration: none;
		}
		.sta-sidebar-year-filter__list li.is-active a{
			font-weight: 700;
			color: #2f6798;
		}
	</style>
	<?php
});