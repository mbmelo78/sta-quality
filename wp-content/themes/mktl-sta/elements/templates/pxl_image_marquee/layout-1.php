<?php
$col_xs = $widget->get_setting('col_xs', '');
$col_sm = $widget->get_setting('col_sm', '');
$col_md = $widget->get_setting('col_md', '');
$col_lg = $widget->get_setting('col_lg', '');
$col_xl = $widget->get_setting('col_xl', '');
$col_xxl = $widget->get_setting('col_xxl', '');

if($col_xxl == '5') {
    $col_xxl = 'pxl5';
} else {
    $col_xxl = 12 / intval($col_xxl);
}

if($col_xl == '5') {
    $col_xl = 'pxl5';
} else {
    $col_xl = 12 / intval($col_xl);
}

if($col_lg == '5') {
    $col_lg = 'pxl5';
} else {
    $col_lg = 12 / intval($col_lg);
}

$col_md = 12 / intval($col_md);
$col_sm = 12 / intval($col_sm);
$col_xs = 12 / intval($col_xs);

$item_class = "col-xxl-$col_xxl  col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
if(isset($settings['marquee']) && !empty($settings['marquee']) && count($settings['marquee'])): ?>
    <div class="pxl-image-marquee1" >
        <div class="pxl-image-hidden-wrap">
            <div class="pxl-image-hidden pxl-flex-middle">
                <?php foreach ($settings['marquee'] as $key => $value):
                    $image = isset($value['image']) ? $value['image'] : ''; ?>
                    <div class="pxl-item--image <?php echo esc_attr($item_class); ?>">
                        <div class="pxl-item--inner <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
                             <?php if(!empty($image['id'])) { 
                                $img_image = pxl_get_image_by_size( array(
                                    'attach_id'  => $image['id'],
                                    'thumb_size' => 'full',
                                    'class' => 'no-lazyload',
                                ));
                                $thumbnail_image = $img_image['thumbnail'];?>
                                <div class="pxl-item--image">
                                    <?php echo wp_kses_post($thumbnail_image); ?>
                                </div>
                            <?php } ?>
                       </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="pxl-image-active pxl-flex-middle">
            <?php foreach ($settings['marquee'] as $key => $value):
                $image = isset($value['image']) ? $value['image'] : '';
                $link_key = $widget->get_repeater_setting_key( 'link', 'value', $key );
                if ( ! empty( $value['link']['url'] ) ) {
                    $widget->add_render_attribute( $link_key, 'href', $value['link']['url'] );

                    if ( $value['link']['is_external'] ) {
                        $widget->add_render_attribute( $link_key, 'target', '_blank' );
                    }

                    if ( $value['link']['nofollow'] ) {
                        $widget->add_render_attribute( $link_key, 'rel', 'nofollow' );
                    }
                }
                $link_attributes = $widget->get_render_attribute_string( $link_key );
                ?>
                <div class="pxl-item--marquee <?php echo esc_attr($item_class); ?>" data-duration="<?php echo esc_attr($settings['slip_duration']); ?>" data-slip-type="<?php echo esc_attr($settings['slip_type']); ?>">
                    <div class="pxl-item--inner pxl-flex-middle <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
                         <?php if(!empty($image['id'])) { 
                            $img_image = pxl_get_image_by_size( array(
                                'attach_id'  => $image['id'],
                                'thumb_size' => 'full',
                                'class' => 'no-lazyload',
                            ));
                            $thumbnail_image = $img_image['thumbnail'];?>
                            <div class="pxl-item--image">
                                <a <?php echo implode( ' ', [ $link_attributes ] ); ?>><?php echo wp_kses_post($thumbnail_image); ?></a>
                            </div>
                        <?php } ?>
                   </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
