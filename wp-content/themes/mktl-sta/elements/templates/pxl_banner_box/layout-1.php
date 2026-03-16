<div class="pxl-banner pxl-banner1">
	<div class="pxl-banner-inner">
		<div class="pxl-banner-top">
			<?php if(!empty($settings['main_img']['id'])) :
				$img = pxl_get_image_by_size( array(
					'attach_id'  => $settings['main_img']['id'],
					'thumb_size' => 'full',
				));
				$thumbnail = $img['thumbnail']; ?>
				<div class="pxl-main--image">
					<?php echo pxl_print_html($thumbnail); ?>
				</div>
			<?php endif; ?>
			<?php if(!empty($settings['secondary_img']['id'])) :
				$img_s = pxl_get_image_by_size( array(
					'attach_id'  => $settings['secondary_img']['id'],
					'thumb_size' => 'full',
				));
				$thumbnail_s = $img_s['thumbnail']; ?>
				<div class="pxl-secondary--image">
					<?php echo pxl_print_html($thumbnail_s); ?>
					<?php if(!empty($settings['title'])) : ?>
						<div class="pxl-counter--wrap">
							<div class="pxl-counter--number">
					            <span class="pxl-counter--value effect-default" data-duration="2000" data-startnumber="1" data-endnumber="<?php echo esc_attr($settings['number']); ?>" data-to-value="<?php echo esc_attr($settings['number']); ?>">1</span>
					            <?php if(!empty($settings['suffix'])) : ?>
					                <span class="pxl-counter--suffix"><?php echo pxl_print_html($settings['suffix']); ?></span>
					            <?php endif; ?>
					        </div>
					        <div class="pxl-counter--title"><?php echo esc_html($settings['title']); ?></div>
					    </div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>