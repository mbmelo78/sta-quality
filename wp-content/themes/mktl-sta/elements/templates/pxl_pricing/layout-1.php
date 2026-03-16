<div class="pxl-pricing pxl-pricing1">
    <!-- thêm icons vào wid -->
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
    <!--hết thêm icons vào wid -->
    <?php if (!empty($settings['popular'])) : ?>
        <div class="pxl-pricing--top pxl-text-center">
            <span><?php echo esc_html($settings['popular']); ?></span>
        </div>
    <?php endif; ?>
    <div class="pxl-pricing--price">
        <span class="pxl-pricing--currency"><?php echo esc_html($settings['currency']); ?></span>

        <span style="display: flex;
    justify-content: center;
    align-items: center;"><?php echo esc_html($settings['price']); ?>
            <span class="pxl-pricing--suffix"><?php echo pxl_print_html($settings['suffix']); ?></span>
            <span class="pxl-pricing--prefix el-empty"><?php echo pxl_print_html($settings['prefix']); ?></span>
        </span>
        

    </div>
    <div class="pxl-pricing--title pxl-empty"><?php echo esc_html($settings['title']); ?></div>
    <div class="pxl-pricing--subtitle pxl-empty"><?php echo esc_html($settings['sub_title']); ?></div>
    <?php if(isset($settings['feature']) && !empty($settings['feature']) && count($settings['feature'])): ?>
        <ul class="pxl-pricing--feature">
            <?php
                foreach ($settings['feature'] as $key => $link):
                    $feature_text = $widget->parse_text_editor( $link['feature_text'] );
                    $feature_active = $widget->parse_text_editor( $link['feature_active'] );  ?>
                    <li>
                        <i class="flaticon-checked text-gradient pxl-mr-12"></i>
                        <?php if($feature_active == 'no') { echo '<del>'; } ?>
                        <?php echo pxl_print_html($feature_text); ?>
                        <?php if($feature_active == 'no') { echo '</del>'; } ?>
                    </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if ( ! empty( $settings['btn_text'] ) ) {
        $widget->add_render_attribute( 'btn_link', 'href', $settings['btn_link']['url'] );

        if ( $settings['btn_link']['is_external'] ) {
            $widget->add_render_attribute( 'btn_link', 'target', '_blank' );
        }

        if ( $settings['btn_link']['nofollow'] ) {
            $widget->add_render_attribute( 'btn_link', 'rel', 'nofollow' );
        } ?>
        <div class="pxl-pricing--button">
            <a class="btn" <?php pxl_print_html($widget->get_render_attribute_string( 'btn_link' )); ?>><span><?php echo esc_html($settings['btn_text']); ?></span></a>
        </div>
    <?php } ?>
</div>