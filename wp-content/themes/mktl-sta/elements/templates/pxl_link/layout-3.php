<?php
global $wp;
$html_id = pxl_get_element_id($settings)
// $label_link=$widget->get_setting('label_link');?>

<div class="pxl-link-wrap">
    <h3 class="pxl-widget-title pxl-empty"><?php echo esc_html($settings['wg_title']); ?></h3>
    <?php if(isset($settings['link']) && !empty($settings['link']) && count($settings['link'])): 
        $current_url_path = home_url( add_query_arg( array(), $wp->request ) ); ?>
        <ul id="pxl-link-<?php echo esc_attr($html_id) ?>" class="pxl-link pxl-link-l3 <?php echo esc_attr($settings['style'].' '.$settings['type']); ?>">
            <?php
                foreach ($settings['link'] as $key => $link):
                    $icon_key = $widget->get_repeater_setting_key( 'pxl_icon', 'icons', $key );
                    $widget->add_render_attribute( $icon_key, [
                        'class' => $link['pxl_icon'],
                        'aria-hidden' => 'true',
                    ] );
                    $link_key = $widget->get_repeater_setting_key( 'link', 'value', $key );
                    if ( ! empty( $link['link']['url'] ) ) {
                        $widget->add_render_attribute( $link_key, 'href', $link['link']['url'] );

                        if ( $link['link']['is_external'] ) {
                            $widget->add_render_attribute( $link_key, 'target', '_blank' );
                        }

                        if ( $link['link']['nofollow'] ) {
                            $widget->add_render_attribute( $link_key, 'rel', 'nofollow' );
                        }
                    }
                    $link_attributes = $widget->get_render_attribute_string( $link_key );
                    $active_cls = '' ;
                    $current_id = get_the_ID();
                    if( $current_id > 0 ){
                        $current_url = get_the_permalink( $current_id, false );
                        if( $link['link']['url'] == $current_url || $link['link']['url'].'/' == $current_url || $link['link']['url'] == $current_url.'/')
                            $active_cls = 'active';
                    }
                    if( $link['link']['url'] == $current_url_path || $link['link']['url'].'/' == $current_url_path || $link['link']['url'] == $current_url_path.'/')
                        $active_cls = 'active';
                    $text = $widget->parse_text_editor( $link['text'] );
                    $label_link = $widget->parse_text_editor( $link['label_link'] ); 
                    ?>
                    <li class="pxl-item--link <?php echo esc_attr($active_cls.' '.$settings['pxl_animate'])?>">
                        <?php if(!empty($link['pxl_icon']['value'])){ ?>
                            <span class="pxl-link--icon bg-<?php echo esc_attr($settings['bg_icon_color_type']); ?>">
                                <?php \Elementor\Icons_Manager::render_icon( $link['pxl_icon'], [ 'aria-hidden' => 'true' ], 'i' ); ?>
                            </span>
                        <?php } ?>    
                        <?php if(!empty($label_link)) : ?>
			                <label class="pxl-label">
                                <?php echo esc_attr($label_link); ?>
                            </label>
		                <?php endif; ?>
                        <a class="<?php if($settings['icon_color_type'] == 'gradient') { echo 'pxl-icon-color-gradient'; } ?>" <?php echo implode( ' ', [ $link_attributes ] ); ?>>
                            <span class="pxl-link--text"><?php echo pxl_print_html($text); ?></span>
                        </a>
                        
                    </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>