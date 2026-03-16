<div class="pxl-blockquote pxl-blockquote1 <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
    <div class="pxl-item--inner">
        <blockquote class="<?php echo esc_attr($settings['style']); ?>">
            <?php if ( !empty($settings['pxl_icon']['value']) ) : ?>
                <div class="pxl-item--icon">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' ); ?>
                </div>
            <?php endif; ?>
            <div class="pxl-item--description"><?php echo pxl_print_html($settings['desc']); ?></div>
            <cite class="pxl-item--title"><?php echo pxl_print_html($settings['title']); ?></cite>
            <?php if($settings['style'] == 'style6') : ?>
                <?php if ( !empty($settings['pxl_icon']['value']) ) : ?>
                    <div class="pxl-item--icon-fixed">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' ); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </blockquote>
    </div>
</div>