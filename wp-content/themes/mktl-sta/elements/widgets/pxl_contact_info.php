<?php
pxl_add_custom_widget(
    array(
        'name' => 'pxl_contact_info',
        'title' => esc_html__('Case Contact Info', 'Lawsight' ),
        'icon' => 'eicon-info-box',
        'categories' => array('pxltheme-core'),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'Lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'title',
                            'label' => esc_html__('Title', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'sub_title',
                            'label' => esc_html__('Sub Title', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'sub_title2',
                            'label' => esc_html__('Sub Title2', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'link',
                            'label' => esc_html__('Link', 'Lawsight'),
                            'type' => \Elementor\Controls_Manager::URL,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'pxl_icon',
                            'label' => esc_html__('Icon', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::ICONS,
                            'fa4compatibility' => 'icon',
                        ),
                    ),
                ),
                array(
                    'name' => 'section_style',
                    'label' => esc_html__('Style', 'Lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name' => 'title_color',
                            'label' => esc_html__('Title Color', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-contact-info .pxl-item--title' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'title_typography',
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'label' => esc_html__('Title Typography', 'Lawsight' ),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .pxl-contact-info .pxl-item--title',
                        ),
                        array(
                            'name' => 'subtitle_color',
                            'label' => esc_html__('Sub Title Color', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-contact-info .pxl-item--subtitle' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'subtitle_typography',
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'label' => esc_html__('Sub Title Typography', 'Lawsight' ),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .pxl-contact-info .pxl-item--subtitle',
                        ),
                    ),
                ),
                Lawsight_widget_animation_settings(),
            ),
        ),
    ),
    Lawsight_get_class_widget_path()
);