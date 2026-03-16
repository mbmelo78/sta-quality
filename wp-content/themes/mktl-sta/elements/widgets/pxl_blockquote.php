<?php
pxl_add_custom_widget(
    array(
        'name' => 'pxl_blockquote',
        'title' => esc_html__('Case Blockquote', 'lawsight' ),
        'icon' => 'eicon-editor-quote',
        'categories' => array('pxltheme-core'),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        // array(
                        //     'name' => 'title',
                        //     'label' => esc_html__('Title', 'lawsight' ),
                        //     'type' => \Elementor\Controls_Manager::TEXT,
                        //     'label_block' => true,
                        // ),
                        // array(
                        //     'name' => 'sub_title',
                        //     'label' => esc_html__('Sub Title', 'lawsight' ),
                        //     'type' => \Elementor\Controls_Manager::TEXT,
                        //     'label_block' => true,
                        // ),
                        array(
                            'name' => 'desc',
                            'label' => esc_html__('Content', 'lawsight' ),
                            'type' => \Elementor\Controls_Manager::TEXTAREA,
                            'rows' => 10,
                            'show_label' => false,
                        ),
                        array(
                            'name' => 'pxl_icon',
                            'label' => esc_html__('Icon', 'lawsight' ),
                            'type' => \Elementor\Controls_Manager::ICONS,
                            'fa4compatibility' => 'icon',
                            'conditions' => [
                                'relation' => 'or',
                                'terms' => [
                                    [
                                        'terms' => [
                                            ['name' => 'style', 'operator' => 'in', 'value' => ['style4','style5','style6']]
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            ['name' => 'layout', 'operator' => 'in', 'value' => ['2']]
                                        ]
                                    ],
                                ],
                            ]
                        ),
                        // array(
                        //     'name' => 'image',
                        //     'label' => esc_html__( 'Image', 'lawsight' ),
                        //     'type' => \Elementor\Controls_Manager::MEDIA,
                        //     'default' => '',
                        //     'condition' => [
                        //         'layout' => '2',
                        //     ],
                        // ),
                    ),
                ),
                array(
                    'name' => 'section_style_general',
                    'label' => esc_html__('General', 'lawsight'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name' => 'layout',
                            'label' => esc_html__('Layout', 'lawsight' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                '1' => 'Layout 1',
                                '2' => 'Layout 2',
                            ],
                            'default' => '1',
                        ),
                        array(
                            'name' => 'style',
                            'label' => esc_html__('Style', 'lawsight' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'style1' => 'Style 1',
                                'style2' => 'Style 2',
                                'style3' => 'Style 3',
                                'style4' => 'Style 4',
                                'style5' => 'Style 5',
                                'style6' => 'Style 6',
                            ],
                            'default' => 'style1',
                            'condition' => [
                                'layout' => '1',
                            ],
                        ),
                        array(
                            'name' => 'box_color',
                            'label' => esc_html__('Box Color', 'lawsight' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-blockquote .pxl-item--inner blockquote' => 'background-color: {{VALUE}}!important;background-image:none;',
                            ],
                            'condition' => [
                                'style' => ['style1','style2','style3','style4','style6'],
                            ],
                        ),
                        
                        array(
                            'name' => 'desc_color',
                            'label' => esc_html__('Description Color', 'lawsight' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-blockquote .pxl-item--description' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'desc_typography',
                            'label' => esc_html__('Description Typography', 'lawsight' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .pxl-blockquote .pxl-item--description',
                        ),
                        array(
                            'name' => 'icon_color',
                            'label' => esc_html__('Icon Color', 'lawsight' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-blockquote .pxl-item--icon i' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .pxl-blockquote .pxl-item--icon svg' => 'fill: {{VALUE}};',
                            ],
                            'condition' => [
                                'style' => ['style4','style5','style6'],
                            ],
                        ),
                    ),
                ),
                lawsight_widget_animation_settings(),
            ),
        ),
    ),
    lawsight_get_class_widget_path()
);