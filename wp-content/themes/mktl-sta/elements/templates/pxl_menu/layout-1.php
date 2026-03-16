<?php
$p_menu = Lawsight()->get_page_opt('p_menu');
if(!empty($p_menu)) {
    $settings['menu'] = $p_menu;
}

$icon_style = '';
if($settings['hover_active_style'] == 'fr-style-ha') {
    $icon_style = '<i class="flaticon-up-right-arrow"></i>';
}

if($settings['hover_active_style'] == 'fr-icon-spacer') {
    $icon_style = '<span class="menu-icon-spacer"><i class="flaticon-icon-menu"></i><i class="flaticon-icon-menu"></i></span>';
}

$arrow_parent_icon = 'pxl-arrow-'.$settings['show_arrow_parent'];

if(!empty($settings['menu'])) { ?>
    <div class="pxl-nav-menu pxl-nav-menu1 <?php echo esc_attr($settings['menu_mega_type'].' '.'pxl-nav-'.$settings['menu_type'].' '.$settings['hover_active_style'].' '.$settings['sub_show_effect'].' '.$settings['pxl_animate']); ?> <?php echo esc_attr($settings['hover_active_style_sub']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
        <?php wp_nav_menu(array(
            'menu_class' => 'pxl-menu-primary clearfix',
            'walker'     => class_exists( 'PXL_Mega_Menu_Walker' ) ? new PXL_Mega_Menu_Walker : '',
            'link_before'     => '<span class="pxl-menu-item-text">',
            'link_after'      => $icon_style.'<i class="'.$arrow_parent_icon.' pxl-hide pxl-ml-4"></i></span>',
            'theme_location' => 'primary')
        ); ?>
        <?php if($settings['hover_active_style'] == 'fr-style-box' || $settings['hover_active_style'] == 'fr-style-box2') : ?>
            <div class="pxl-divider-move"></div>
        <?php endif; ?>
    </div>
<?php } elseif( has_nav_menu( 'primary' ) ) { ?>
    <div class="pxl-nav-menu pxl-nav-menu1 <?php echo esc_attr($settings['menu_mega_type'].' '.'pxl-nav-'.$settings['menu_type'].' '.$settings['hover_active_style'].' '.$settings['sub_show_effect']); ?> <?php echo esc_attr($settings['hover_active_style_sub']); ?>">
        <?php $attr_menu = array(
            'theme_location' => 'primary',
            'menu_class' => 'pxl-menu-primary clearfix',
            'link_before'     => '<span class="pxl-menu-item-text">',
            'link_after'      => $icon_style.'<i class="'.$arrow_parent_icon.' pxl-hide pxl-ml-4"></i></span></span>',
            'walker'         => class_exists( 'PXL_Mega_Menu_Walker' ) ? new PXL_Mega_Menu_Walker : '',
        );
        wp_nav_menu( $attr_menu ); ?>
        <?php if($settings['hover_active_style'] == 'fr-style-box' || $settings['hover_active_style'] == 'fr-style-box2') : ?>
            <div class="pxl-divider-move"></div>
        <?php endif; ?>
    </div>
<?php } ?>