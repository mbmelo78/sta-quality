<div class="pxl-icon-box pxl-icon-box2 pxl-flipbox <?php echo esc_attr($settings['style'].' '.$settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
    <div class="pxl-flipbox--wrap">
        <div class="pxl-item--holder pxl-flipbox--front">
            <?php if ( $settings['icon_type'] == 'icon' && !empty($settings['pxl_icon']['value']) ) : ?>
                <div class="pxl-item--icon">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' ); ?>
                </div>
            <?php endif; ?>
            <?php if ( $settings['icon_type'] == 'image' && !empty($settings['icon_image']['id']) ) : ?>
                <div class="pxl-item--icon">
                    <?php $img_icon  = pxl_get_image_by_size( array(
                            'attach_id'  => $settings['icon_image']['id'],
                            'thumb_size' => 'full',
                        ) );
                        $thumbnail_icon    = $img_icon['thumbnail'];
                    echo pxl_print_html($thumbnail_icon); ?>
                </div>
            <?php endif; ?>
            <<?php echo esc_attr($settings['title_tag']); ?> class="pxl-item--title el-empty"><?php echo pxl_print_html($settings['title']); ?></<?php echo esc_attr($settings['title_tag']); ?>>
            <div class="pxl-item--description el-empty"><?php echo pxl_print_html($settings['desc']); ?></div>
        </div>
        
        <div class="pxl-item--backdrop bg-image pxl-flipbox--back">
            <?php if ( ! empty( $settings['btn_link']['url'] ) ) {
                $widget->add_render_attribute( 'btn_link', 'href', $settings['btn_link']['url'] );

                if ( $settings['btn_link']['is_external'] ) {
                    $widget->add_render_attribute( 'btn_link', 'target', '_blank' );
                }

                if ( $settings['btn_link']['nofollow'] ) {
                    $widget->add_render_attribute( 'btn_link', 'rel', 'nofollow' );
                } ?>
                <div class="pxl-item--readmore">
                    <a class="btn btn-text-parallax " <?php pxl_print_html($widget->get_render_attribute_string( 'btn_link' )); ?>>
                        <span class="pxl--btn-text"><?php echo esc_html($settings['btn_text']); ?></span>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>