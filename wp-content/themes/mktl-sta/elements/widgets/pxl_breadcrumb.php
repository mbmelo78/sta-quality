<?php
pxl_add_custom_widget(
    array(
        'name' => 'pxl_breadcrumb',
        'title' => esc_html__('Case Breadcrumb', 'Lawsight' ),
        'icon' => 'eicon-yoast',
        'categories' => array('pxltheme-core'),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_style',
                    'label' => esc_html__('Style', 'Lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name' => 'text_color',
                            'label' => esc_html__('Text Color', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-breadcrumb' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'active_color',
                            'label' => esc_html__('Active Color', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-breadcrumb span.breadcrumb-entry' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'hover_color',
                            'label' => esc_html__('Hover Color', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-breadcrumb a:hover' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'text_typography',
                            'label' => esc_html__('Text Typography', 'Lawsight' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .pxl-breadcrumb',
                        ),
                    ),
                ),
                lawsight_widget_animation_settings(),
            ),
        ),
    ),
    lawsight_get_class_widget_path()
);