<?php
if(isset($settings['download_link']) && !empty($settings['download_link'])): 
    $is_new = \Elementor\Icons_Manager::is_migration_allowed(); ?>
    <div class="pxl-download-link pxl-download-link-1">
        <?php foreach ($settings['download_link'] as $key => $value): 
            $icon_key = $widget->get_repeater_setting_key( 'pxl_icon', 'icons', $key );
            $widget->add_render_attribute( $icon_key, [
                'class' => $value['pxl_icon'],
                'aria-hidden' => 'true',
            ] );
            $link_key = $widget->get_repeater_setting_key( 'd_link', 'value', $key );
            if ( ! empty( $value['d_link']['url'] ) ) {
                $widget->add_render_attribute( $link_key, 'href', $value['d_link']['url'] );

                if ( $value['d_link']['is_external'] ) {
                    $widget->add_render_attribute( $link_key, 'target', '_blank' );
                }

                if ( $value['d_link']['nofollow'] ) {
                    $widget->add_render_attribute( $link_key, 'rel', 'nofollow' );
                }
            }
            $link_attributes = $widget->get_render_attribute_string( $link_key ); ?>
            <div class="pxl--item <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
                <?php if ( $is_new ): ?>
                    <div class="pxl-icon-download pxl-mr-15">
                        <?php \Elementor\Icons_Manager::render_icon( $value['pxl_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                <?php elseif(!empty($value['pxl_icon'])): ?>
                    <div class="pxl-icon-file">
                        <i class="<?php echo esc_attr( $value['pxl_icon'] ); ?>" aria-hidden="true"></i>
                    </div>
                <?php endif; ?>
                <div class="pxl--meta pxl-mr-15">
                    <h5 class="pxl--title pxl-empty"><?php echo pxl_print_html($value['title']); ?></h5>
                    <div class="pxl--size pxl-empty"><?php echo pxl_print_html($value['size']); ?></div>
                </div>
                <div class="pxl-icon-download pxl-mr-5"><i class="flaticon-download"></i></div>
                <a class="pxl--link" <?php echo implode( ' ', [ $link_attributes ] ); ?>></a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>