<?php
$active = intval($settings['active']);
$accordion = $widget->get_settings('accordion');
$wg_id = pxl_get_element_id($settings);
if(!empty($accordion)) : ?>
    <div class="pxl-accordion pxl-accordion1 <?php echo esc_attr($settings['style'].' '.$settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
        <?php foreach ($accordion as $key => $value):
            $is_active = ($key + 1) == $active;
            $pxl_id = isset($value['_id']) ? $value['_id'] : '';
            $title = isset($value['title']) ? $value['title'] : '';
            $desc = isset($value['desc']) ? $value['desc'] : '';
            $number = isset($value['number']) ? $value['number'] : '';
            $icon_key = $widget->get_repeater_setting_key( 'pxl_icon', 'icons', $key );
            $widget->add_render_attribute( $icon_key, [
                'class' => $value['pxl_icon'],
                'aria-hidden' => 'true',
            ] ); ?>
            <div class="pxl--item <?php echo esc_attr($is_active ? 'active' : ''); ?>">
                <<?php pxl_print_html($settings['title_tag']); ?> class="pxl-accordion--title" data-target="<?php echo esc_attr('#'.$wg_id.'-'.$pxl_id); ?>">
                    <div class="pxl-title--number pxl-empty"><?php echo esc_html($number); ?></div>
                    <?php if ( ! empty( $value['pxl_icon']['value'] ) ) : ?>
                        <span class="pxl-title--icon pxl-mr-20">
                            <?php \Elementor\Icons_Manager::render_icon( $value['pxl_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </span>
                    <?php endif; ?>
                    <span class="pxl-title--text"><?php echo wp_kses_post($title); ?></span>
                    <?php if($settings['style'] == 'style-default') : ?><span class="pxl-icon--action"><?php \Elementor\Icons_Manager::render_icon( $value['pxl_icon2'], [ 'aria-hidden' => 'true' ] ); ?></span><?php endif; ?>
                </<?php pxl_print_html($settings['title_tag']); ?>>
                <div id="<?php echo esc_attr($wg_id.'-'.$pxl_id); ?>" class="pxl-accordion--content" <?php if($is_active){ ?>style="display: block;"<?php } ?>><?php echo wp_kses_post(nl2br($desc)); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>