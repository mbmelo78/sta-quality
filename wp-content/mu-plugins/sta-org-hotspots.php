<?php

/**
 * Plugin Name: STA Organograma Hotspots
 * Description: Shortcode [sta_org_hotspots] para organograma interativo com hotspots, links e modais.
 * Version: 1.0.0
 * Author: Marcolino Melo - MKTL
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('sta_org_hotspots_shortcode')) {
	function sta_org_hotspots_shortcode($atts) {
		$a = shortcode_atts([
			'bg'           => '#',
			'presidente'   => '#',
			'vps'          => '#',
			'conselheirosAdministrativo' => '/juizes-conselheiros-seccao-do-contencioso-administrativo/',
			'conselheirosTributario' => '/juizes-conselheiros-seccao-do-contencioso-tributario/',
		], $atts, 'sta_org_hotspots');

		if (empty($a['bg'])) {
			return '<em>Falta o atributo bg com a URL da imagem do organograma.</em>';
		}

		$uid = 'sta-hot-' . wp_generate_uuid4();

		ob_start();
		?>
		<style>
			#<?php echo esc_attr($uid); ?>{
				--hint: rgba(15,79,125,.08);
				--shadow: 0 10px 30px rgba(0,0,0,.25);
				font-family: system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
				position: relative;
				max-width: 1400px;
				margin: 0 auto;
			}

			#<?php echo esc_attr($uid); ?> .stage{
				position: relative;
				width: 100%;
				aspect-ratio: 1641 / 768;
				background: url('<?php echo esc_url($a['bg']); ?>') center / cover no-repeat;
				border-radius: 14px;
			}

			#<?php echo esc_attr($uid); ?> .spot{
				position: absolute;
				cursor: pointer;
				border-radius: 10px;
				background: transparent;
				border: 0;
			}

			#<?php echo esc_attr($uid); ?> .spot:hover{
				background: var(--hint);
			}

			#<?php echo esc_attr($uid); ?> .oc-modal{
				position: fixed;
				inset: 0;
				display: none;
				align-items: center;
				justify-content: center;
				background: rgba(0,0,0,.45);
				z-index: 999999;
				padding: 20px;
			}

			#<?php echo esc_attr($uid); ?> .oc-modal[aria-hidden="false"]{
				display: flex;
			}

			#<?php echo esc_attr($uid); ?> .oc-dialog{
				background: #fff;
				color: #0b2239;
				width: min(92vw, 900px);
				border-radius: 18px;
				overflow: hidden;
				box-shadow: var(--shadow);
			}

			#<?php echo esc_attr($uid); ?> .oc-head{
				background: #0f4f7d;
				color: #fff;
				padding: 14px 18px;
				font-weight: 900;
				display: flex;
				justify-content: space-between;
				align-items: center;
				gap: 16px;
			}

			#<?php echo esc_attr($uid); ?> .oc-body{
				padding: 18px;
				max-height: min(70vh, 70rem);
				overflow: auto;
			}

			#<?php echo esc_attr($uid); ?> .close{
				background: none;
				border: 0;
				color: #fff;
				font-size: 22px;
				line-height: 1;
				cursor: pointer;
			}

			#<?php echo esc_attr($uid); ?> .group{
				font-weight: 900;
				color: #0f4f7d;
				margin: 14px 0 6px;
			}

			#<?php echo esc_attr($uid); ?> ul{
				margin: 6px 0 14px 20px;
			}

			@media (max-width: 900px){
				#<?php echo esc_attr($uid); ?> .spot:hover{
					background: transparent;
				}
			}
		</style>

		<div id="<?php echo esc_attr($uid); ?>">
			<div class="stage">
				<div class="spot" data-href="<?php echo esc_url($a['presidente']); ?>" style="left:52.5%; top:1%; width:12%; height:6%"></div>
				<div class="spot" data-href="<?php echo esc_url($a['vps']); ?>" style="left:51%; top:11%; width:15%; height:4.5%; display:none"></div>
				<div class="spot" data-href="<?php echo esc_url($a['conselheirosAdministrativo']); ?>" style="left:47%; top:22%; width:12%; height:30%"></div>                
				<div class="spot" data-href="<?php echo esc_url($a['conselheirosTributario']); ?>" style="left:59%; top:22%; width:12%; height:30%"></div>

				<div class="spot" data-modal="gabinete-presidente" style="left:32.5%; top:20%; width:8.5%; height:6%"></div>
				<div class="spot" data-modal="mp" style="left:84.6%; top:22.5%; width:15%; height:4.6%"></div>
				<div class="spot" data-modal="apoio-vp" style="left:34.7%; top:29.6%; width:9.6%; height:11%"></div>
				<div class="spot" data-modal="gabinete-imprensa" style="left:32.5%; top:44.5%; width:8.5%; height:6%"></div>
				<div class="spot" data-modal="gap-mp" style="left:86.2%; top:34%; width:12%; height:11%"></div>
				<div class="spot" data-modal="conselho-admin" style="left:17.5%; top:59%; width:8.5%; height:6%"></div>
				<div class="spot" data-modal="administrador" style="left:26.5%; top:59%; width:8.5%; height:6%"></div>
				<div class="spot" data-modal="conselho-consultivo" style="left:35.6%; top:59%; width:8.5%; height:6%"></div>
				<div class="spot" data-modal="secretario-superior" style="left:53.7%; top:68.5%; width:10%; height:6%"></div>
				<div class="spot" data-modal="secretaria" style="left:46%; top:79%; width:44%; height:6%; display:none;"></div>
				<div class="spot" data-modal="sec-concencioso-administrativo" style="left:46%; top:87.5%; width:8.3%; height:9%"></div>
				<div class="spot" data-modal="sec-concencioso-tributario" style="left:54.5%; top:87.5%; width:8.3%; height:11%"></div>
				<div class="spot" data-modal="sec-tribunal-conflitos" style="left:63.2%; top:87.5%; width:10.2%; height:11%"></div>
				<div class="spot" data-modal="sec-central" style="left:73.7%; top:87.5%; width:8.5%; height:6%"></div>
				<div class="spot" data-modal="sec-gav-ministeriopublico" style="left:82.5%; top:87.5%; width:7.7%; height:11%"></div>
				<div class="spot" data-modal="direcao-servicos" style="left:0.8%; top:79%; width:16%; height:14.5%"></div>
				<div class="spot" data-modal="div-doc-info" style="left:17.2%; top:79%; width:14.5%; height:14.5%"></div>
				<div class="spot" data-modal="div-org-info" style="left:32%; top:79%; width:13.5%; height:6%"></div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-mp" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Magistrados do Ministério Público</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<div class="group">Procurador-Geral Adjunto Coordenador</div>
						<ul><li>José Francisco Gomes Veras</li></ul>
						<div class="group">Procuradores-Gerais Adjuntos</div>
						<ul>
							<li>António Carlos Tomás Ribeiro</li>
							<li>Emílio António Sampaio Correia</li>
							<li>Helena Maria de Araújo Lima Cluny Rodrigues</li>
							<li>Carlos João Frade Lobato Ferreira</li>
							<li>Carlos Jorge Fernandes dos Santos</li>
							<li>Maria Carolina Durão Pereira</li>
							<li>Ana Rosa Branquinho Dias</li>
							<li>Fernando Manuel da Luz Gomes</li>
							<li>Maria do Sameiro Sousa de Barros Rios da Fonseca</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-gap-mp" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Gabinete de Apoio aos Juízes Conselheiros e aos Magistrados do Ministério Público</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body"><em>brevemente...</em></div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-gabinete-presidente" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Gabinete do Presidente</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<div class="group">Chefe de Gabinete</div>
						<ul><li>Joaquim Mira Branquinho</li></ul>
						<div class="group">Adjuntos</div>
						<ul>
							<li>Filomena Maria Sereno Mateus Leitão</li>
							<li>Marta Isabel Martins Costa dos Santos</li>
							<li>Rozária de Fátima da Cunha Mendes dos Santos Serra</li>
						</ul>
						<div class="group">Técnicos Especialistas</div><em>…</em>
						<div class="group">Secretárias</div>
						<ul>
							<li>Maria Clara Rangel Rocha</li>
							<li>Graça Maria Costa Pereira</li>
						</ul>
						<div class="group">Motoristas</div>
						<ul>
							<li>José Alexandre Ramos Carvalho</li>
							<li>Paulo Jorge de Melo Antunes</li>
							<li>Rogério José Almeida Lourenço</li>
							<li>Rui Nunes Gonçalves</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-apoio-vp" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Apoio Administrativo aos Vice-Presidentes</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body"><div class="group">Secretárias</div><em>…</em></div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-gabinete-imprensa" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Gabinete de Imprensa</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body"><em>brevemente...</em></div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-conselho-admin" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Conselho Administrativo</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<ul>
							<li>Jorge Miguel Barroso de Aragão Seia, Presidente do Supremo Tribunal Administrativo.</li>
							<li>Francisco António Pedrosa de Areal Rothes, Vice-Presidente do Supremo Tribunal Administrativo.</li>
							<li>José Francisco Fonseca da Paz, Vice-Presidente do Supremo Tribunal Administrativo.</li>
							<li>Rogério Paulo Martins Pereira, Administrador.</li>
							<li>Maria de Fátima Cravinho da Costa Madeira Sangalho, Diretora dos Serviços Administrativos e Financeiros.</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-administrador" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Administrador</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body"><ul><li>Rogério Paulo Martins Pereira</li></ul></div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-conselho-consultivo" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Conselho Consultivo</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<ul>
							<li>Jorge Miguel Barroso de Aragão Seia, Presidente do Supremo Tribunal Administrativo.</li>
							<li>Francisco António Pedrosa de Areal Rothes, Vice-Presidente do Supremo Tribunal Administrativo.</li>
							<li>José Francisco Fonseca da Paz, Vice-Presidente do Supremo Tribunal Administrativo.</li>
							<li>Um Juiz Conselheiro da Secção de Contencioso Administrativo, a designar pelo Plenário.</li>
							<li>Um Juiz Conselheiro da Secção de Contencioso Tributário, a designar pelo Plenário.</li>
							<li>José Francisco Gomes Veras, Procurador-Geral-adjunto, coordenador da atividade do Ministério Público no Tribunal.</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-secretario-superior" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Secretário de Tribunal Superior</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body"><ul><li>Maria Zita Pais Paula</li></ul></div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-secretaria" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Secretaria Judicial</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body"><ul><li>Maria Zita Pais Paula</li></ul></div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-sec-concencioso-administrativo" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Secção de Contencioso Administrativo</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<ul>
							<li>Rui Manuel da Silva Martins Laranjeira</li>
							<li>Almerinda de Fátima de Jesus Antunes</li>
							<li>Anabela Teixeira dos Santos</li>
							<li>Maria de Fátima Simões Fernandes Barata</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-sec-concencioso-tributario" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Secção de Contencioso Tributário</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<ul>
							<li>Acácio Ribeiro Laia Cardoso</li>
							<li>Carla Maria Camacho Fernandes</li>
							<li>Frederico Ricardo Lourenço Rodrigues Lourenço</li>
							<li>Luís Neves Tiago Santos</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-sec-tribunal-conflitos" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Plenário, Pleno das Secções e Tribunal dos Conflitos</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<ul>
							<li>Teresa Manuela Correia de Paiva</li>
							<li>Ana Isabel Silvestre Sousa Santos</li>
							<li>Maria Donzilia Ribeiro Nogueira</li>
							<li>Maria Fernanda Assunção Consciência Valente</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-sec-central" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Secção Central</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<ul>
							<li>Maria Gabriela Braem dos Santos</li>
							<li>Leila Catarina Carreira da Silva</li>
							<li>Maria Salomé Belo Nunes Flambó</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-sec-gav-ministeriopublico" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Gabinete de Apoio ao Ministério Público</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<ul>
							<li>Josefa Maria Antunes Coelho Lopes</li>
							<li>Paula Alexandra Duque dos Santos Oliveira Martins Pereira</li>
							<li>Silvia Maria Mina da Silva Oliveira Roque</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-direcao-servicos" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Direção de Serviços Administrativos e Financeiros</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<div class="group">Diretora de Serviços</div>
						<ul><li>Maria de Fátima Cravinho da Costa Madeira Sangalho</li></ul>
						<div class="group">Serviços</div>
						<ul>
							<li>José António Garcias Estradas</li>
							<li>Ilda Maria Lopes dos Santos Cerqueira</li>
							<li>Isabel Maria dos Santos Paiva Vaz de Almeida</li>
							<li>Maria Alice de Oliveira Borges</li>
							<li>Maria de Fátima da Silva Neves</li>
						</ul>
						<div class="group">Serviços Gerais</div>
						<ul>
							<li>Bárbara Maria Ramos Correia Veiga</li>
							<li>Isabel Maria de Almeida Correia Rodrigues</li>
							<li>Paula Maria de Sousa Francisco</li>
							<li>Vítor Manuel Dias Gomes Pimenta</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-div-doc-info" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Divisão de Documentação e Informação Jurídica</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<div class="group">Chefe de Divisão</div>
						<ul><li>Maria Leonor Mira Trigueiros Sampaio</li></ul>
						<div class="group">Apoio Jurídico</div>
						<ul>
							<li>Anabela Berardo Airoso Vieira Matias</li>
							<li>Armando António Alves Barbosa</li>
							<li>Dora Mafalda Alexandre Afonso</li>
							<li>Isabel Maria Horta da Silva Santos Gonçalves Rapazote</li>
							<li>José António Romana Baleiras</li>
							<li>Maria Manuela Lopes de Brito Saraiva Barreto</li>
							<li>Maria Manuela Pires Rodrigues</li>
							<li>Merícia Maria Barreto da Silva</li>
							<li>David Sérgio Cordeiro Valente Casquinha</li>
						</ul>
						<div class="group">Biblioteca</div>
						<ul>
							<li>Maria Cristina Passos Oliveira dos Santos Elias</li>
							<li>Georgina Patrício Correia Henrique</li>
							<li>Sónia Cristina Libório Paixão</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="oc-modal" id="<?php echo esc_attr($uid); ?>-modal-div-org-info" aria-hidden="true">
				<div class="oc-dialog">
					<div class="oc-head"><div>Divisão de Organização e Informática</div><button class="close" type="button">&times;</button></div>
					<div class="oc-body">
						<ul>
							<li>Ana Filomena Costa Janota</li>
							<li>Isabel Maria Chaves Ferreira</li>
							<li>Margarida Maria Soares Seabra dos Santos Costa</li>
							<li>Rui Miguel Martins Monteiro</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<script>
		(function(){
			const root = document.getElementById('<?php echo esc_js($uid); ?>');
			if (!root) return;

			root.querySelectorAll('.spot[data-href]').forEach(function(spot){
				spot.addEventListener('click', function(){
					const href = spot.getAttribute('data-href');
					if (href && href !== '#') {
						window.location.href = href;
					}
				});
			});

			function openModal(id){
				const modal = document.getElementById('<?php echo esc_js($uid); ?>-modal-' + id);
				if (!modal) return;
				modal.setAttribute('aria-hidden', 'false');
				document.body.style.overflow = 'hidden';
				const closeBtn = modal.querySelector('.close');
				if (closeBtn) closeBtn.focus();
			}

			function closeModal(modal){
				if (!modal) return;
				modal.setAttribute('aria-hidden', 'true');
				document.body.style.overflow = '';
			}

			root.querySelectorAll('.spot[data-modal]').forEach(function(spot){
				spot.addEventListener('click', function(){
					openModal(spot.getAttribute('data-modal'));
				});
			});

			root.querySelectorAll('.oc-modal').forEach(function(modal){
				modal.addEventListener('click', function(e){
					if (e.target === modal) {
						closeModal(modal);
					}
				});

				const btn = modal.querySelector('.close');
				if (btn) {
					btn.addEventListener('click', function(){
						closeModal(modal);
					});
				}
			});

			document.addEventListener('keydown', function(e){
				if (e.key !== 'Escape') return;
				root.querySelectorAll('.oc-modal[aria-hidden="false"]').forEach(function(modal){
					closeModal(modal);
				});
			});
		})();
		</script>
		<?php

		return ob_get_clean();
	}

	add_shortcode('sta_org_hotspots', 'sta_org_hotspots_shortcode');
}