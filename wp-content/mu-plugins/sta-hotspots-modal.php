<?php
/**
 * Plugin Name: STA Hotspots Modal
 * Description: Hotspots clicáveis sobre a imagem do organograma STA com modal.
 * Version: 1.1.0
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('wp_head', function () {
	?>
	<style>
		.sta-hotspot-target {
			position: relative !important;
		}

		.sta-hotspot-layer {
            position:absolute;
            left:0%;
            top:0%;
            width:100%;
            height:100%;
            z-index:20;
            pointer-events:none;
        }

		.sta-hotspot {
			position: absolute;
			display: block;
			border: 0;
			padding: 0;
			margin: 0;
			/*outline: 2px solid rgba(255, 0, 0, 0.35); /* debug visível */
			cursor: pointer;
			pointer-events: auto;
            background: transparent !important;
		}

		.sta-hotspot:hover {
			background: rgba(0, 115, 170, 0.20);
		}

		.sta-modal-overlay {
			position: fixed;
			inset: 0;
			background: rgba(0,0,0,0.58);
			z-index: 999999;
			display: none;
			align-items: center;
			justify-content: center;
			padding: 24px;
		}

		.sta-modal-overlay.is-open {
			display: flex;
		}

		.sta-modal-box {
			background: #fff;
			width: min(920px, 100%);
			max-height: 88vh;
			overflow: auto;
			border-radius: 18px;
			box-shadow: 0 24px 70px rgba(0,0,0,0.30);
			position: relative;
			padding: 28px;
		}

		.sta-modal-close {
			position: absolute !important;
			top: 12px;
			right: 12px;
			width: 20px;
			height: 20px;
			border: 0;
			border-radius: 999px;
			background: #fff !important;
			color: #236093 !important;
			font-size: 30px !important;
			line-height: 1;
			cursor: pointer;
		}

		.sta-modal-title {
			margin: 0 48px 18px 0;
			font-size: 28px;
			line-height: 1.2;
			color: #0f4c81;
			font-weight: 700;
		}

		.sta-modal-content {
			font-size: 16px;
			line-height: 1.7;
			color: #1f2937;
		}

		.sta-modal-content p {
			margin: 0 0 14px;
		}

		.sta-modal-content ul {
			margin: 0 0 16px 20px;
			padding: 0;
		}

		.sta-modal-content li {
			margin: 0 0 10px;
		}

		body.sta-modal-open {
			overflow: hidden;
		}

		@media (max-width: 767px) {
			.sta-modal-box {
				padding: 22px 18px 18px;
				border-radius: 14px;
			}

			.sta-modal-title {
				font-size: 22px;
			}
		}
	</style>
	<?php
}, 99);

add_action('wp_footer', function () {
	?>
	<div class="sta-modal-overlay" id="staModalOverlay" aria-hidden="true">
		<div class="sta-modal-box" role="dialog" aria-modal="true" aria-labelledby="staModalTitle">
			<button type="button" class="sta-modal-close" id="staModalClose" aria-label="Fechar">&times;</button>
			<h2 class="sta-modal-title" id="staModalTitle"></h2>
			<div class="sta-modal-content" id="staModalContent"></div>
		</div>
	</div>

	<script>
	(function () {
		const DEBUG = true;
		const IMAGE_MATCH = 'diagramas_STA_novo.png';

		const HOTSPOTS = [
			{
				id: 'supremo',
				title: 'Supremo Tribunal Administrativo',
				left: 1,
				top: 1,
				width: 98,
				height: 22,
				content: `
					<p>O Supremo Tribunal Administrativo é o órgão superior da hierarquia dos tribunais administrativos e fiscais, aos quais compete o julgamento de litígios emergentes das relações jurídicas administrativas e fiscais, nos termos compreendidos pelo âmbito de jurisdição previsto no artigo 4.º do Estatuto dos Tribunais Administrativos e Fiscais (<a href="https://www.stadministrativo.pt/tribunal/apresentacao/etaf2019" class="external-marked" target="_blank">ETAF<i class="fas fa-external-link-alt" aria-hidden="true" style="margin-left: 6px; font-size: 0.85em;"></i><span class="sr-only"> (link externo)</span></a>).</p>
					<p>Tem sede em Lisboa e jurisdição sobre todo o território nacional.</p>
				`
			},
			{
				id: 'sca',
				title: 'Secção do Contencioso Administrativo',
				left: 1,
				top: 1.5,
				width: 77.5,
				height: 9.5,
				content: `
					<p>A Secção do Contencioso Administrativo do Supremo Tribunal Administrativo funciona em Subsecções (formações de três juízes) ou em pleno.</p>
					<p>O julgamento em cada Formação compete ao relator e a dois juízes.</p>
					<p>O julgamento no Pleno compete ao relator e aos demais juízes em exercício na secção, e só pode funcionar com a presença de, pelo menos, dois terços dos juízes.</p>
				`
			},
			{
				id: 'fsca',
				title: 'Formações da Secção do Contencioso Administrativo',
				left: 1,
				top: 1.5,
				width: 38,
				height: 10,
				content: `
					<p>Compete à Secção do Contencioso Administrativo, em formações de três juízes, conhecer:</p>
					<ul>
						<li>em 1.º grau de jurisdição dos processos em matéria administrativa relativos a acções ou omissões das seguintes entidades (Presidente da República; Assembleia da República e seu Presidente; Conselho de Ministros; Primeiro-Ministro; Tribunal Constitucional, Supremo Tribunal Administrativo, Tribunal de Contas, Tribunais Centrais Administrativos, assim como dos respectivos Presidentes; Conselho Superior de Defesa Nacional; Conselho Superior dos Tribunais Administrativos e Fiscais e seu Presidente; Procurador-Geral da República; Conselho Superior do Ministério Público;</li>
						<li>em 1.º grau de jurisdição dos pedidos de adoção de providências cautelares relativos a processos da sua competência e de execução das suas decisões;</li>
						<li>dos recursos dos acórdãos que aos tribunais centrais administrativos caiba proferir em primeiro grau de jurisdição;</li>
						<li>dos recursos de revista sobre matéria de direito interpostos de acórdãos da Secção de Contencioso Administrativo dos tribunais centrais administrativos e dos tribunais arbitrais.</li>
					</ul>
				`
			},
			{
				id: 'psca',
				title: 'Pleno da Secção do Contencioso Administrativo',
				left: 2.5,
				top: 1.5,
				width: 38,
				height: 10,
				content: `
					<p>Compete ao Pleno da Secção do Contencioso Administrativo:</p>
					<ul>
						<li>dos recursos de acórdãos proferidos pela Secção em 1.º grau de jurisdição;</li>
						<li>dos recursos para uniformização de jurisprudência.</li>
					</ul>
				`
			},
			{
				id: 'sct',
				title: 'Secção do Contencioso Tributário',
				left: 1,
				top: -4,
				width: 77.5,
				height: 9.5,
				content: `
					<p>A Secção do Contencioso Tributário do Supremo Tribunal Administrativo funciona em Subsecções (formações de três juízes) ou em pleno.</p>
					<p>O julgamento em cada Formação compete ao relator e a dois juízes.</p>
					<p>O julgamento no Pleno compete ao relator e aos demais juízes em exercício na secção, e só pode funcionar com a presença de, pelo menos, dois terços dos juízes.</p>
				`
			},
			{
				id: 'plenario',
				title: 'Plenário',
				left: 2,
				top: -5,
				width: 20,
				height: 15,
				content: `
					<p>Compete ao Plenário do Supremo Tribunal Administrativo conhecer dos recursos para uniformização de jurisprudência, quando exista contradição entre acórdãos de ambas as Secções do Supremo Tribunal Administrativo.</p>
				`
			},
			{
				id: 'ssct',
				title: 'Subsecções da Secção do Contencioso Tributário',
				left: 1,
				top: -3.5,
				width: 38,
				height: 10,
				content: `
					<p>Compete à Secção do Contencioso Tributário, em formações de três juízes, conhecer:</p>
					<ul>
						<li>dos recursos dos acórdãos da Secção de Contencioso Tributário dos tribunais centrais administrativos, proferidos em 1.º grau de jurisdição;</li>
						<li>dos recursos interpostos de decisões de mérito dos tribunais tributários, com exclusivo fundamento em matéria de direito, sempre que o valor da causa seja superior à alçada dos tribunais centrais administrativos e o valor da sucumbência seja superior a metade da alçada do tribunal de que se recorre;</li>
						<li>dos recursos de atos administrativos do Conselho de Ministros respeitantes a questões fiscais;</li>
						<li>dos requerimentos de adoção de providências cautelares respeitantes a processos da sua competência, assim como dos pedidos relativos à execução das suas decisões.</li>
					</ul>
				`
			},
			{
				id: 'psct',
				title: 'Pleno da Secção do Contencioso Tributário',
				left: 2.5,
				top: -3.5,
				width: 38,
				height: 10,
				content: `
					<p>Compete ao Pleno da Secção do Contencioso Tributário:</p>
					<ul>
						<li>dos recursos de acórdãos proferidos pela Secção em 1.º grau de jurisdição;</li>
						<li>dos recursos para uniformização de jurisprudência.</li>
					</ul>
				`
			}
		];

		function log(...args) {
			if (DEBUG) console.log('[STA HOTSPOTS]', ...args);
		}

		function getTargetImage() {
			const imgs = document.querySelectorAll('img');
			for (const img of imgs) {
				const src = img.getAttribute('src') || '';
				if (src.includes(IMAGE_MATCH)) {
					return img;
				}
			}
			return null;
		}

		function ensureModalEvents() {
			const overlay = document.getElementById('staModalOverlay');
			const close = document.getElementById('staModalClose');

			if (!overlay || overlay.dataset.bound === '1') return;

			overlay.dataset.bound = '1';

			overlay.addEventListener('click', function (e) {
				if (e.target === overlay) closeModal();
			});

			if (close) {
				close.addEventListener('click', closeModal);
			}

			document.addEventListener('keydown', function (e) {
				if (e.key === 'Escape') closeModal();
			});
		}

		function openModal(title, content) {
			const overlay = document.getElementById('staModalOverlay');
			const titleEl = document.getElementById('staModalTitle');
			const contentEl = document.getElementById('staModalContent');

			if (!overlay || !titleEl || !contentEl) {
				log('Modal não encontrado no DOM.');
				return;
			}

			titleEl.textContent = title;
			contentEl.innerHTML = content;
			overlay.classList.add('is-open');
			document.body.classList.add('sta-modal-open');
		}

		function closeModal() {
			const overlay = document.getElementById('staModalOverlay');
			if (!overlay) return;
			overlay.classList.remove('is-open');
			document.body.classList.remove('sta-modal-open');
		}

		function buildHotspots(img) {
			if (!img) {
				log('Imagem alvo não encontrada.');
				return false;
			}

			const container = img.closest('.pxl-item--image') || img.parentElement;
			if (!container) {
				log('Container da imagem não encontrado.');
				return false;
			}

			if (container.querySelector('.sta-hotspot-layer')) {
				log('Hotspots já existem.');
				return true;
			}

			container.classList.add('sta-hotspot-target');

			const layer = document.createElement('div');
			layer.className = 'sta-hotspot-layer';

			HOTSPOTS.forEach(item => {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'sta-hotspot';
				btn.setAttribute('aria-label', item.title);
				btn.style.left = item.left + '%';
				btn.style.top = item.top + '%';
				btn.style.width = item.width + '%';
				btn.style.height = item.height + '%';

				btn.addEventListener('click', function () {
					openModal(item.title, item.content);
				});

				layer.appendChild(btn);
			});

			container.appendChild(layer);
			log('Hotspots criados com sucesso.', container);
			return true;
		}

		function initHotspots() {
			ensureModalEvents();
			const img = getTargetImage();
			if (!img) {
				log('Ainda não encontrei a imagem.');
				return false;
			}
			return buildHotspots(img);
		}

		document.addEventListener('DOMContentLoaded', function () {
			log('DOMContentLoaded');
			initHotspots();

			let tries = 0;
			const interval = setInterval(function () {
				tries++;
				const done = initHotspots();
				if (done || tries > 20) {
					clearInterval(interval);
					log(done ? 'Inicialização concluída.' : 'Falhou após várias tentativas.');
				}
			}, 500);

			const observer = new MutationObserver(function () {
				initHotspots();
			});

			observer.observe(document.body, {
				childList: true,
				subtree: true
			});
		});
	})();
	</script>
	<?php
}, 999);