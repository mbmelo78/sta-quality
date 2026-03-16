<?php if(!function_exists('lawsight_configs')){
    function lawsight_configs($value){
        $primary_darker = Lawsight()->get_opt('primary_color', '#5f2dde');
        $primary_darker_10 = pxl_darker_color($primary_darker, $primary_darker_10=1);
        $primary_darker_20 = pxl_darker_color($primary_darker, $primary_darker_20=1.3);
        $primary_darker_30 = pxl_darker_color($primary_darker, $primary_darker_30=3);
        $primary_darker_40 = pxl_darker_color($primary_darker, $primary_darker_40=4);

        $configs = [
            'theme_colors' => [
                'primary'   => [
                    'title' => esc_html__('Primary', 'Lawsight'), 
                    'value' => Lawsight()->get_opt('primary_color', '#236093')
                ],
                'gradient-first'   => [
                    'title' => esc_html__('Gradient First', 'Lawsight'), 
                    'value' => Lawsight()->get_opt('gradient_first_color', '#4a8fc2')
                ],
                'secondary'   => [
                    'title' => esc_html__('Secondary', 'Lawsight'), 
                    'value' => Lawsight()->get_opt('secondary_color', '#4a8fc2')
                ],
                'third'   => [
                    'title' => esc_html__('Third', 'Lawsight'), 
                    'value' => Lawsight()->get_opt('third_color', '#1A476D')
                ],
                'dark'   => [
                    'title' => esc_html__('Dark', 'Lawsight'), 
                    'value' => Lawsight()->get_opt('dark_color', '#111827')
                ],
                'body-bg'   => [
                    'title' => esc_html__('Body Background Color', 'Lawsight'), 
                    'value' => Lawsight()->get_page_opt('body_bg_color', '#fff')
                ],
                'primary-darker-10'   => [
                    'title' => esc_html__('Primary Darker Color 10', 'Lawsight'),
                    'value' => $primary_darker_10
                ],
                'primary-darker-20'   => [
                    'title' => esc_html__('Primary Darker Color 20', 'Lawsight'), 
                    'value' => $primary_darker_20
                ],
                'primary-darker-30'   => [
                    'title' => esc_html__('Primary Darker Color 30', 'Lawsight'), 
                    'value' => $primary_darker_30
                ],
                'primary-darker-40'   => [
                    'title' => esc_html__('Primary Darker Color 40', 'Lawsight'), 
                    'value' => $primary_darker_40
                ]
            ],
            'link' => [
                'color' => Lawsight()->get_opt('link_color', ['regular' => '#D5AA6D'])['regular'],
                'color-hover'   => Lawsight()->get_opt('link_color', ['hover' => '#fe0054'])['hover'],
                'color-active'  => Lawsight()->get_opt('link_color', ['active' => '#fe0054'])['active'],
            ],
            'gradient' => [
                'color-from' => Lawsight()->get_opt('gradient_color', ['from' => '#6000ff'])['from'],
                'color-to' => Lawsight()->get_opt('gradient_color', ['to' => '#fe0054'])['to'],
            ],
            'gradient2' => [
                'color-from' => Lawsight()->get_opt('gradient_color2', ['from' => '#8c92f6'])['from'],
                'color-to' => Lawsight()->get_opt('gradient_color2', ['to' => '#f9d78f'])['to'],
            ],
               
        ];
        return $configs[$value];
    }
}
if(!function_exists('lawsight_inline_styles')) {
    function lawsight_inline_styles() {  
        
        $theme_colors      = lawsight_configs('theme_colors');
        $link_color        = lawsight_configs('link');
        $gradient_color    = lawsight_configs('gradient');
        $gradient_color2   = lawsight_configs('gradient2');

        ob_start();
        echo ':root{';
            
            foreach ($theme_colors as $color => $value) {
                printf('--%1$s-color: %2$s;', str_replace('#', '',$color),  $value['value']);
            }
            foreach ($theme_colors as $color => $value) {
                printf('--%1$s-color-rgb: %2$s;', str_replace('#', '',$color),  lawsight_hex_rgb($value['value']));
            }
            foreach ($link_color as $color => $value) {
                printf('--link-%1$s: %2$s;', $color, $value);
            }
            foreach ($gradient_color as $color => $value) {
                printf('--gradient-%1$s: %2$s;', $color, $value);
            }
            foreach ($gradient_color2 as $color => $value) {
                printf('--gradient-%1$s2: %2$s;', $color, $value);
            }

        echo '}';

        return ob_get_clean();
         
    }
}
 