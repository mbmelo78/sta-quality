<main>

	<div class="pxl-dashboard-wrap">

		<?php include_once( get_template_directory() . '/inc/admin/views/admin-tabs.php' ); ?>
		<?php 
		$installed_plugins = get_plugins();
		$plugins = TGM_Plugin_Activation::$instance->plugins;
 		 
		$plugin_requires = array();
		foreach( $plugins as $plugin ){
			$file_path = $plugin['file_path'];
			
			$this_active =  in_array( $plugin['file_path'], (array) get_option( 'active_plugins', array() ), true ) || is_plugin_active_for_network( $plugin );
 
			if( $plugin['required'] === true && !$this_active){
				$plugin_requires[] = $plugin['name'];
			}
		}  
		?>
		<?php 
		 
		$dev_mode = (defined('DEV_MODE') && DEV_MODE);
		if ( 'valid' != get_option( Lawsight()->get_slug().'_purchase_code_status', false ) && !$dev_mode ) :
			
			echo '<div class="error"><p>' .
					sprintf( wp_kses_post( esc_html__( 'The %s theme needs to be registered. %sRegister Now%s', 'Lawsight' ) ), Lawsight()->get_name(), '<a href="' . admin_url( 'admin.php?page=pxlart') . '">' , '</a>' ) . '</p></div>';
		elseif( !empty($plugin_requires) && sizeof($plugin_requires) >= 1 ):

			echo '<div class="error"><p>';
			echo sprintf( wp_kses_post( esc_html__( 'Make sure to activate required plugins prior to import a demo.', 'Lawsight' ) ), Lawsight()->get_name(), '<a class="nt-atpli" href="' . admin_url( 'admin.php?page=pxlart-plugins') . '">' , '</a>' ) . '</p>';
			echo '<ul class="plugin-not-active">';
				foreach( $plugin_requires as $pr ){
					echo '<li>'.$pr.'</li>';
				}
			echo '</ul>';
			echo '<p><a class="btn" href="' . admin_url( 'admin.php?page=pxlart-plugins') . '">Active Now</a></p>';
			echo '</div>';
		else: ?>
	
		<header class="pxl-dsb-header">
			<div class="pxl-dsb-header-inner">
				<h4><?php esc_html_e( 'Import a Demo', 'Lawsight' ); ?></h4>
				<p><?php esc_html_e( 'Choose a pre-built website for starting a quick design process.', 'Lawsight' ) ?></p>
			</div>
			<div class="pxl-msg pxl-dsb-notice">
				<p><span><?php esc_html_e( 'Note:', 'Lawsight' ); ?></span> <?php esc_html_e( 'Make sure to activate required plugins prior to import a demo.', 'Lawsight' ) ?></p>
			</div>
		</header>

		<?php

			include( locate_template( 'inc/admin/demo-data/demo-config.php' ) );
			$i = 0;
			wp_localize_script( 'pxlart-admin', 'pxlart_demos', $demos );

		?>
		<div id="pxl-demos" class="pxl-demos pxl-solid-wrap">

			<div class="pxl-tab-nav">
				<ul>
					<li><a class="active" href="#pxl-demos-elementor" data-filter="elementor">Elementor</a></li>
					<li><a href="#pxl-demos-wpbakery" data-filter="wpbakery">WPBakery</a></li>
				</ul>
			</div>

			<div class="pxl-tab-content">
				<div class="pxl-row">
					<?php foreach( $demos as $id => $demo ): ?>

					<div class="pxl-col pxl-col-4 <?php echo !empty($demo['builder']) ? esc_attr($demo['builder']) : esc_attr('elementor'); ?>">
			
						<div class="pxl-dsb-demo-item">

							<figure>
								<img src="<?php echo esc_url( $demo['screenshot'] ); ?>" alt="<?php echo esc_attr( $demo['title'] ); ?>">
								<div class="pxl-dsb-overlay"></div>
								<div class="pxl-btn-group">
									<a href="#" id="import-id" data-import-id="<?php echo esc_attr( $i ); ?>" data-demo-id="<?php echo esc_attr( $id ); ?>" class="pxl-btn pxl-popup-import">
										<span><?php esc_html_e( 'Import Demo', 'Lawsight' ); ?></span>
									</a><br/>
									<a target="_blank" href="<?php echo esc_url( $demo['preview'] ); ?>" class="pxl-preview-btn">
										<span><?php esc_html_e( 'Preview Demo', 'Lawsight' ); ?></span>
										<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
									</a>
								</div>
							</figure>
							<h3><?php echo esc_html( $demo['title'] ); ?></h3>
						</div>
					</div>

					<?php $i++; ?>
					<?php endforeach; ?>

				</div>
			</div>

		<script type="text/template" id="tmpl-demo-import-modules">
			<div id="pxl-progress-popup" class="pxl-imp-popup-wrap is-active">
				<div class="pxl-imp-progress">
					<h6><?php esc_html_e( 'Importing...', 'Lawsight' ); ?></h6>
					<div id="pxl-progress" class="importing"><?php esc_html_e( 'Working', 'Lawsight' )?> <span>.</span><span>.</span><span>.</span></div>
					<div class="pxl-progressbar">
						<div class="pxl-progressbar-inner" style="width: 0%">
							<span id="pxl-loader" class="pxl-progressbar-percentage"><?php esc_html_e( '0%', 'Lawsight' ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</script>

		<script type="text/template" id="tmpl-demo-popup">
			<div id="pxl-popup" class="pxl-imp-popup-wrap is-active">
				<div class="pxl-imp-popup-inner">
				
					<span class="pxl-imp-popup-close"></span>
					 
					<div class="pxl-imp-popup-content">
						<h4 style="text-align:center; margin-bottom: 30px;"><?php esc_html_e( 'Select all or a few', 'Lawsight' ); ?></h4>
						<div class="pxl-row">
							<div class="pxl-col pxl-col-6">
								<span class="pxl-imp-opt">
									<input id="pxl-imp-media" type="checkbox" value="import_media" checked="">
									<label for="pxl-imp-media"></label>
									<span><?php esc_html_e( 'Media Attachments', 'Lawsight' ); ?></span>
								</span>
							</div>
							<div class="pxl-col pxl-col-6">
								<span class="pxl-imp-opt">
									<input id="pxl-imp-content" type="checkbox" value="import_content" checked="">
									<label for="pxl-imp-content"></label>
									<span><?php esc_html_e( 'Content', 'Lawsight' ); ?></span>
								</span>
							</div>
							<div class="pxl-col pxl-col-6">
								<span class="pxl-imp-opt">
									<input id="pxl-imp-options" type="checkbox" value="import_theme_options" checked="">
									<label for="pxl-imp-options"></label>
									<span><?php esc_html_e( 'Theme Options', 'Lawsight' ) ?></span>
								</span>
							</div>
							<div class="pxl-col pxl-col-6">
								<span class="pxl-imp-opt">
									<input id="pxl-imp-widgets" type="checkbox" value="import_widgets" checked="">
									<label for="pxl-imp-widgets"></label>
									<span><?php esc_html_e( 'Widgets', 'Lawsight' ); ?></span>
								</span>
							</div>
							<?php if(!empty($plugins['revslider'])): ?>
							<div class="pxl-col pxl-col-6">
								<span class="pxl-imp-opt">
									<input id="pxl-imp-revslider" type="checkbox" value="import_slider" checked="">
									<label for="pxl-imp-revslider"></label>
									<span><?php esc_html_e( 'Revslider', 'Lawsight' ); ?></span>
								</span>
							</div>
 							<?php endif; ?>
							<div class="pxl-col pxl-col-6">
								<span class="pxl-imp-opt">
									<input id="pxl-imp-settings" type="checkbox" value="import_settings" checked="">
									<label for="pxl-imp-settings"></label>
									<span><?php esc_html_e( 'Settings', 'Lawsight' ) ?></span>
								</span>
							</div>
						</div>
						<div class="pxl-row" style="padding-top: 30px;">
							<div class="pxl-col pxl-col-12">
								<div class="pxl-imp-skip-posts">
									<span class="pxl-imp-opt-skip-posts" style="margin-bottom: 0; padding-left: 15px;">
										<input id="pxl-imp-skip-posts-existen" name="skip_posts_existen" type="checkbox" value="skip-posts-existen">
										<label for="pxl-imp-skip-posts-existen">
										<span><?php esc_html_e( 'Skip the posts exist. By default, all current content will be deleted.', 'Lawsight' ); ?></span>
										</label>
									</span>
								</div>
								<div class="pxl-imp-crop">
									<span class="pxl-imp-opt-crop" style="margin-bottom: 0; padding-left: 15px;">
										<input id="pxl-imp-crop-img" name="crop-img" type="checkbox" value="crop_img" checked="">
										<label for="pxl-imp-crop-img">
											<span><?php esc_html_e( 'Crop Image after import finish?', 'Lawsight' ); ?></span>
										</label>
									</span>
								</div>
								<button class="pxl-import-btn" data-id="0">
									<span><?php esc_html_e( 'Import Demo', 'Lawsight' ); ?></span>
								</button>
							</div>
						</div>
					</div>
				  
				</div>
			</div>
		
		</script>
			
		</div>
		<?php endif; ?>
	</div>

</main>
