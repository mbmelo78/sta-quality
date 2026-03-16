<div class="pxl-blockquote pxl-blockquote2 <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
    <div class="pxl-item--inner">
        <blockquote>
            <div class="pxl-item--description">
                <?php echo pxl_print_html($settings['desc']); ?>
                <?php if ( !empty($settings['pxl_icon']['value']) ) : ?>
                <div class="pxl-item--icon">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' ); ?>
                </div>
            <?php endif; ?>
            </div>
        </blockquote>
    </div>
</div>