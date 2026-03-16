<div class="pxl-banner pxl-banner2">
	<div class="pxl-banner-inner">
		<?php if(!empty($settings['main_img']['id'])) :
			$img = pxl_get_image_by_size( array(
				'attach_id'  => $settings['main_img']['id'],
				'thumb_size' => '322x410',
			));
			$thumbnail = $img['thumbnail']; ?>
			<div class="pxl-main--image" data-parallax='{"y":0}'>
				<?php echo pxl_print_html($thumbnail); ?>
			</div>
		<?php endif; ?>
		<?php if(!empty($settings['secondary_img']['id'])) :
			$img_s = pxl_get_image_by_size( array(
				'attach_id'  => $settings['secondary_img']['id'],
				'thumb_size' => '181x323',
			));
			$thumbnail_s = $img_s['thumbnail']; ?>
			<div class="pxl-secondary--image" data-parallax='{"y":30}'>
				<?php echo pxl_print_html($thumbnail_s); ?>
				<?php if ( !empty($settings['pxl_icon']['value']) ) : ?>
		            <div class="pxl-item--icon pxl-fl-middle">
		                <?php \Elementor\Icons_Manager::render_icon( $settings['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' ); ?>
		            </div>
		        <?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>