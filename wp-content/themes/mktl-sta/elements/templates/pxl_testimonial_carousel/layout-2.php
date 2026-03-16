<?php
$col_xs = $widget->get_setting('col_xs', '');
$col_sm = $widget->get_setting('col_sm', '');
$col_md = $widget->get_setting('col_md', '');
$col_lg = $widget->get_setting('col_lg', '');
$col_xl = $widget->get_setting('col_xl', '');
$col_xxl = $widget->get_setting('col_xxl', '');
if($col_xxl == 'inherit') {
    $col_xxl = $col_xl;
}
$slides_to_scroll = $widget->get_setting('slides_to_scroll');
$arrows = $widget->get_setting('arrows', false);  
$pagination = $widget->get_setting('pagination', false);
$pagination_type = $widget->get_setting('pagination_type', 'bullets');
$pause_on_hover = $widget->get_setting('pause_on_hover', false);
$autoplay = $widget->get_setting('autoplay', false);
$autoplay_speed = $widget->get_setting('autoplay_speed', 5000);
$infinite = $widget->get_setting('infinite', false);  
$speed = $widget->get_setting('speed', 500);
$drap = $widget->get_setting('drap', false);
$opts = [
    'slide_direction'               => 'horizontal',
    'slide_percolumn'               => 1, 
    'slide_mode'                    => 'fade', 
    'slides_to_show'                => 1,
    'slides_to_show_xxl'            => 1, 
    'slides_to_show_lg'             => 1, 
    'slides_to_show_md'             => 1, 
    'slides_to_show_sm'             => 1, 
    'slides_to_show_xs'             => 1, 
    'slides_to_scroll'              => 1,
    'arrow'                         => (bool)$arrows,
    'pagination'                    => (bool)$pagination,
    'pagination_type'               => $pagination_type,
    'autoplay'                      => (bool)$autoplay,
    'pause_on_hover'                => (bool)$pause_on_hover,
    'pause_on_interaction'          => true,
    'delay'                         => (int)$autoplay_speed,
    'loop'                          => (bool)$infinite,
    'speed'                         => (int)$speed
];
$opts_thumb = [
    'slide_direction'               => 'horizontal',
    'slides_to_show'                => 'auto', 
    'slide_mode'                    => 'slide',
    'loop'                          => false,
];
$widget->add_render_attribute( 'carousel', [
    'class'         => 'pxl-swiper-container',
    'dir'           => is_rtl() ? 'rtl' : 'ltr',
    'data-settings' => wp_json_encode($opts)
]);
$widget->add_render_attribute( 'thumb', [
    'class'         => 'pxl-swiper-thumbs',
    'data-settings' => wp_json_encode($opts_thumb)
]);
if(isset($settings['testimonial']) && !empty($settings['testimonial']) && count($settings['testimonial'])): ?>
    <div class="pxl-swiper-slider pxl-testimonial-carousel pxl-testimonial-carousel2" <?php if($drap !== false) : ?>data-cursor-drap="<?php echo esc_attr__('DRAG', 'lawsight'); ?>"<?php endif; ?>>
        <div class="pxl-carousel-inner">

            <div <?php pxl_print_html($widget->get_render_attribute_string( 'carousel' )); ?>>
                <div class="pxl-swiper-wrapper">
                    <?php foreach ($settings['testimonial'] as $key => $value):
                        $title = isset($value['title']) ? $value['title'] : '';
                        $position = isset($value['position']) ? $value['position'] : '';
                        $desc = isset($value['desc']) ? $value['desc'] : '';
                        $image = isset($value['image']) ? $value['image'] : '';
                        $icon_image = isset($value['icon_image']) ? $value['icon_image'] : '';
                        ?>
                        <div class="pxl-swiper-slide">
                            <div class="pxl-item--inner <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
                                <div class="pxl-heading px-sub-title-shape2-style pxl-screen-mobile">
                                    <div class="pxl-heading--inner">
                                        <?php if(!empty($settings['wg_sub_title'])) : ?>
                                            <div class="pxl-item--subtitle px-sub-title-shape2 ">
                                                <span class="pxl-item--subtext">
                                                    <span class="pxl-heading-icon pxl-mr-10">
                                                        <i class="flaticon-icon-menu text-gradient-top"></i>
                                                        <i class="flaticon-icon-menu text-gradient-bottom"></i>
                                                    </span>
                                                    <?php echo esc_attr($settings['wg_sub_title']); ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if(!empty($settings['wg_title'])) : ?>
                                            <h2 class="pxl-item--title wg_title">
                                                <span class="pxl-heading--text"><?php echo esc_html($settings['wg_title']); ?></span>
                                            </h2>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if(!empty($image['id'])) { 
                                    $img = pxl_get_image_by_size( array(
                                        'attach_id'  => $image['id'],
                                        'thumb_size' => 'full',
                                        'class' => 'no-lazyload',
                                    ));
                                    $thumbnail = $img['thumbnail'];?>
                                    <div class="pxl-item--avatar">
                                        <?php echo wp_kses_post($thumbnail); ?>
                                    </div>
                                <?php } ?>
                                <div class="pxl-item--holder">
                                    <div class="pxl-heading px-sub-title-shape2-style pxl-screen-desktop">
                                        <div class="pxl-heading--inner">
                                            <?php if(!empty($settings['wg_sub_title'])) : ?>
                                                <div class="pxl-item--subtitle px-sub-title-shape2 ">
                                                    <span class="pxl-item--subtext">
                                                        <span class="pxl-heading-icon pxl-mr-10">
                                                            <i class="flaticon-icon-menu text-gradient-top"></i>
                                                            <i class="flaticon-icon-menu text-gradient-bottom"></i>
                                                        </span>
                                                        <?php echo esc_attr($settings['wg_sub_title']); ?>
                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(!empty($settings['wg_title'])) : ?>
                                                <h2 class="pxl-item--title wg_title">
                                                    <span class="pxl-heading--text"><?php echo esc_html($settings['wg_title']); ?></span>
                                                </h2>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="pxl-testimonial--meta">
                                        <div class="pxl-item--desc el-empty"><?php echo pxl_print_html($desc); ?></div>
                                        <div class="pxl-item--position el-empty"><?php echo pxl_print_html($position); ?></div>
                                        <h5 class="pxl-item--title el-empty"><span><?php echo pxl_print_html($title); ?></span></h5>
                                    </div>
                                </div>
                           </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
        
        <?php if($pagination !== false): ?>
            <div class="pxl-swiper-dots style-1"></div>
        <?php endif; ?>

        <?php if($arrows !== false): ?>
            <div class="pxl-swiper-arrow-wrap style-2">
                <div class="pxl-swiper-arrow pxl-swiper-arrow-prev pxl-cursor--cta">
                    <svg version="1.1" class="rtl-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path d="M492,236H68.442l70.164-69.824c7.829-7.792,7.859-20.455,0.067-28.284c-7.792-7.83-20.456-7.859-28.285-0.068 l-104.504,104c-0.007,0.006-0.012,0.013-0.018,0.019c-7.809,7.792-7.834,20.496-0.002,28.314c0.007,0.006,0.012,0.013,0.018,0.019 l104.504,104c7.828,7.79,20.492,7.763,28.285-0.068c7.792-7.829,7.762-20.492-0.067-28.284L68.442,276H492 c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"/></svg>
                </div>
                <div <?php pxl_print_html($widget->get_render_attribute_string( 'thumb' )); ?>>
                    <div class="pxl-swiper-wrapper swiper-wrapper">
                        <?php foreach ($settings['testimonial'] as $key => $value):
                            $image_thumb = isset($value['image']) ? $value['image'] : '';
                            $image_thumb_small = isset($value['image_thumbnail']) ? $value['image_thumbnail'] : ''; 
                            if(!empty($image_thumb_small['id'])) {
                                $image_thumb['id'] = $image_thumb_small['id'];
                            } ?>
                            <div class="pxl-swiper-slide swiper-slide">
                                <?php if(!empty($image_thumb['id'])) { 
                                    $img = pxl_get_image_by_size( array(
                                        'attach_id'  => $image_thumb['id'],
                                        'thumb_size' => '230x230',
                                        'class' => 'no-lazyload',
                                    ));
                                    $thumbnail = $img['thumbnail'];?>
                                    <div class="pxl-item--thumb">
                                        <?php echo wp_kses_post($thumbnail); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="pxl-swiper-arrow pxl-swiper-arrow-next pxl-cursor--cta">
                    <svg version="1.1" class="rtl-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path d="M506.134,241.843c-0.006-0.006-0.011-0.013-0.018-0.019l-104.504-104c-7.829-7.791-20.492-7.762-28.285,0.068 c-7.792,7.829-7.762,20.492,0.067,28.284L443.558,236H20c-11.046,0-20,8.954-20,20c0,11.046,8.954,20,20,20h423.557 l-70.162,69.824c-7.829,7.792-7.859,20.455-0.067,28.284c7.793,7.831,20.457,7.858,28.285,0.068l104.504-104 c0.006-0.006,0.011-0.013,0.018-0.019C513.968,262.339,513.943,249.635,506.134,241.843z"/></svg>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
<?php endif; ?>
