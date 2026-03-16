<?php 
$img_size = '';
if(!empty($settings['img_size'])) {
    $img_size = $settings['img_size'];
} else {
    $img_size = 'full';
}
?>
<div class="pxl-video-player pxl-video-player1 pxl-video-<?php echo esc_attr($settings['btn_video_style']); ?> <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
    <div class="pxl-video--inner">
        <?php if( $settings['image_type'] != 'none' && !empty( $settings['image']['url'] ) ) : 
            $img  = pxl_get_image_by_size( array(
                'attach_id'  => $settings['image']['id'],
                'thumb_size' => $img_size,
            ) );
            $thumbnail    = $img['thumbnail'];
            ?>
            <div class="pxl-video--holder">
                <?php if ($settings['image_type'] == 'img') { ?>
                    <?php if ( ! empty( $settings['image']['url'] ) ) { echo wp_kses_post($thumbnail); } ?>
                <?php } else { ?>
                    <div class="pxl-video--imagebg">
                        <div class="bg-image" style="background-image: url(<?php echo esc_url($settings['image']['url']); ?>);"></div>
                    </div>
                <?php } ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($settings['video_link'])) : ?>
            <div class="btn-video-wrap <?php echo esc_attr($settings['btn_video_position']); ?>">
                <a class="pxl-btn-video pxl-action-popup <?php echo esc_attr($settings['btn_video_style']); ?>" href="<?php echo esc_url($settings['video_link']); ?>">
                    <?php if ( !empty($settings['video_icon']['value']) ) { ?>
                        <?php \Elementor\Icons_Manager::render_icon( $settings['video_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' ); ?>
                    <?php } else { ?>
                        <i class="flaticon-play-button"></i>
                    <?php } ?>
                </a>
            </div>
        <?php endif; ?>
        <?php if(!empty($settings['overlay_color'])) : ?>
            <div class="pxl-overlay-color"></div>
        <?php endif; ?>
    </div>
</div>