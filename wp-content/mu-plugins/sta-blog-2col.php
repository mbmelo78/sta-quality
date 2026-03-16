<?php
/**
 * Plugin Name: STA - Blog em 2 Colunas
 * Description: Força a página de artigos (blog) a mostrar os posts em 2 colunas, mantendo a sidebar.
 * Author: Marcolino Melo - MKTL
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('wp_head', function () {
	if (!is_home()) {
		return;
	}
	?>
	<style>
		/* Grelha principal dos artigos */
		body.home #pxl-content-main{
			display: grid !important;
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 34px;
			align-items: start;
		}

		/* Cada artigo ocupa uma célula */
		body.home #pxl-content-main > article.pxl---post{
			width: 100% !important;
			margin: 0 !important;
			display: block !important;
		}

		/* Paginação ocupa a largura toda */
		body.home #pxl-content-main > .pxl-pagination-wrap{
			grid-column: 1 / -1;
			width: 100%;
		}

		/* Card mais próximo da página notícias */
		body.home #pxl-content-main > article.pxl---post{
			background: #fff;
			box-shadow: 0 10px 30px rgba(0,0,0,.08);
			overflow: hidden;
		}

		body.home #pxl-content-main .pxl-item--image img{
			display: block;
			width: 100%;
			height: 460px;
			object-fit: cover;
		}

		body.home #pxl-content-main .pxl-item--holder{
			padding: 0 0 24px;
		}

		body.home #pxl-content-main .pxl-item--meta{
			padding: 22px 30px 0;
		}

		body.home #pxl-content-main .pxl-item--title{
			padding: 10px 30px 0;
			margin: 0;
			font-size: 24px;
			line-height: 1.25;
		}

		body.home #pxl-content-main .pxl-item--excerpt{
			padding: 18px 30px 0;
			font-size: 16px;
			line-height: 1.6;
		}

		body.home #pxl-content-main .pxl-item--readmore{
			padding: 22px 30px 0;
		}

		/* Mobile */
		@media (max-width: 991px){
			body.home #pxl-content-main{
				grid-template-columns: 1fr !important;
				gap: 24px;
			}

			body.home #pxl-content-main .pxl-item--image img{
				height: auto;
			}
		}
	</style>
	<?php
}, 99);