<?php
// 'pxl-splitting',
// 'pxl-typography-animation',
pxl_add_custom_widget(
    array(
        'name' => 'pxl_heading',
        'title' => esc_html__('Case Heading', 'Lawsight' ),
        'icon' => 'eicon-heading',
        'categories' => array('pxltheme-core'),
        'scripts'    => array(
            'gsap',
            'pxl-scroll-trigger',
            'pxl-splitText',
        ),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'Lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'source_type',
                            'label' => esc_html__('Source Type', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'text' => 'Text',
                                'title' => 'Page Title',
                            ],
                            'default' => 'text',
                        ),
                        array(
                            'name' => 'title',
                            'label' => esc_html__('Title', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::TEXTAREA,
                            'label_block' => true,
                            'condition' => [
                                'source_type' => ['text'],
                            ],
                            'description' => 'Create Typewriter text width shortcode: [typewriter text="Text1, Text2"], Highlight text with shortcode: [highlight text="Text"] and Highlight image with shortcode: [highlight_image id_image="123"]',
                        ),
                        array(
                            'name' => 'sub_title',
                            'label' => esc_html__('Sub Title', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'show_underline2',
                            'label' => esc_html__('Show Underline', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::SWITCHER,
                            'default' => 'false',
                        ),
                        array(
                          'name' => 'align',
                            'label' => esc_html__( 'Alignment', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::CHOOSE,
                            'control_type' => 'responsive',
                            'options' => [
                                'left' => [
                                    'title' => esc_html__( 'Left', 'Lawsight' ),
                                    'icon' => 'eicon-text-align-left',
                                ],
                                'center' => [
                                    'title' => esc_html__( 'Center', 'Lawsight' ),
                                    'icon' => 'eicon-text-align-center',
                                ],
                                'right' => [
                                    'title' => esc_html__( 'Right', 'Lawsight' ),
                                    'icon' => 'eicon-text-align-right',
                                ],
                                'justify' => [
                                    'title' => esc_html__( 'Justified', 'Lawsight' ),
                                    'icon' => 'eicon-text-align-justify',
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .pxl-heading' => 'text-align: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'show_underline',
                            'label' => esc_html__('Show Underline', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::SWITCHER,
                            'default' => 'false',
                        ),
                        array(
                            'name' => 'h_width',
                            'label' => esc_html__('Max Width', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 3000,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .pxl-heading .pxl-heading--inner' => 'max-width: {{SIZE}}{{UNIT}};',
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'section_style_title',
                    'label' => esc_html__('Title', 'Lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name' => 'title_tag',
                            'label' => esc_html__('HTML Tag', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'h1' => 'H1',
                                'h2' => 'H2',
                                'h3' => 'H3',
                                'h4' => 'H4',
                                'h5' => 'H5',
                                'h6' => 'H6',
                                'div' => 'div',
                                'span' => 'span',
                                'p' => 'p',
                            ],
                            'default' => 'h3',
                        ),
                        array(
                            'name' => 'title_color',
                            'label' => esc_html__('Title Color', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .pxl-heading .pxl-item--title' => 'color: {{VALUE}};-webkit-text-stroke-color:{{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'title_typography',
                            'label' => esc_html__('Typography', 'Lawsight' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .pxl-heading .pxl-item--title',
                        ),
                        array(
                            'name'         => 'title_box_shadow',
                            'label' => esc_html__( 'Title Shadow', 'Lawsight' ),
                            'type'         => \Elementor\Group_Control_Text_Shadow::get_type(),
                            'control_type' => 'group',
                            'selector'     => '{{WRAPPER}} .pxl-heading .pxl-item--title'
                        ),
                        array(
                            'name' => 'title_space_bottom',
                            'label' => esc_html__('Bottom Spacer', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px' ],
                            'default' => [
                                'size' => 0,
                            ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 300,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .pxl-heading .pxl-item--title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                            ],
                            'separator' => 'after',
                        ),
                        array(
                            'name' => 'h_title_style',
                            'label' => esc_html__('Style', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'style-default' => 'Default',
                            ],
                            'default' => 'style-default',
                        ),
                        array(
                            'name' => 'pxl_animate',
                            'label' => esc_html__('Case Animate', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => lawsight_widget_animate_v2(),
                            'default' => '',
                        ),
                        array(
                            'name' => 'pxl_animate_delay',
                            'label' => esc_html__('Animate Delay', 'Lawsight' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'default' => '0',
                            'description' => 'Enter number. Default 0ms',
                        ),
                    ),
                ),
                array(
                    'name' => 'section_style_title_sub',
                    'label' => esc_html__('Sub Title', 'Lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array_merge(
                        array(
                            array(
                                'name' => 'sub_title_style',
                                'label' => esc_html__('Style', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::SELECT,
                                'options' => [
                                    'px-sub-title-default' => 'Default',
                                    'px-sub-title-shape' => 'Style 1',
                                    'px-sub-title-shape2' => 'Style 2',
                                    'px-sub-title-shape3' => 'Style 3',
                                    'px-sub-title-shape4' => 'Style 4',
                                    'px-sub-title-shape5' => 'Style 5',
                                ],
                                'default' => 'px-sub-title-default',
                            ),
                            array(
                                'name' => 'line_opacity',
                                'label' => esc_html__('Line Opacity (0 - 100)', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::SLIDER,
                                'control_type' => 'responsive',
                                'size_units' => [ '%' ],
                                'default'    => [
                                    'unit' => '%'
                                ],
                                'range' => [
                                    '%' => [
                                        'min' => 0,
                                        'max' => 100,
                                    ],
                                ],
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .px-sub-title-shape4 .pxl-item--subtext::before' => 'opacity: {{SIZE}}%;',
                                ],
                                'condition' => [
                                    'sub_title_style' => ['px-sub-title-shape4'],
                                ],
                            ),
                            array(
                                'name' => 'sub_title_color',
                                'label' => esc_html__('Color', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-item--subtitle' => 'color: {{VALUE}};',
                                    '{{WRAPPER}} .pxl-heading .pxl-item--subtitle .pxl-item--subtext .text-gradient:not(.pxl-icon--heading)' => '--gradient-color-from:{{VALUE}};',
                                ],
                            ),
                            array(
                                'name' => 'sub_title_color_gradient',
                                'label' => esc_html__('Color Gradient To', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-item--subtitle .pxl-item--subtext .text-gradient:not(.pxl-icon--heading)' => '--gradient-color-to:{{VALUE}};',
                                ],
                            ),
                            array(
                                'name' => 'sub_title_color_gradient2',
                                'label' => esc_html__('Color Gradient First', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-item--subtitle .pxl-item--subtext .text-gradient:not(.pxl-icon--heading)' => '--gradient-first-color:{{VALUE}};',
                                ],
                            ),
                            array(
                                'name' => 'sub_title_typography',
                                'label' => esc_html__('Typography', 'Lawsight' ),
                                'type' => \Elementor\Group_Control_Typography::get_type(),
                                'control_type' => 'group',
                                'selector' => '{{WRAPPER}} .pxl-heading .pxl-item--subtitle, {{WRAPPER}} .pxl-heading .pxl-item--subtitle span',
                            ),
                            array(
                                'name' => 'sub_title_space_top',
                                'label' => esc_html__('Top Spacer', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::SLIDER,
                                'control_type' => 'responsive',
                                'size_units' => [ 'px' ],
                                'range' => [
                                    'px' => [
                                        'min' => 0,
                                        'max' => 300,
                                    ],
                                ],
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-item--subtitle' => 'top: {{SIZE}}{{UNIT}};',
                                ],
                            ),
                            array(
                                'name' => 'sub_title_space_bottom',
                                'label' => esc_html__('Bottom Spacer', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::SLIDER,
                                'control_type' => 'responsive',
                                'size_units' => [ 'px' ],
                                'range' => [
                                    'px' => [
                                        'min' => 0,
                                        'max' => 300,
                                    ],
                                ],
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-item--subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                                ],
                            ),
                            array(
                                'name' => 'pxl_animate_sub',
                                'label' => esc_html__('Case Animate', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::SELECT,
                                'options' => lawsight_widget_animate(),
                                'default' => '',
                            ),
                            array(
                                'name' => 'pxl_animate_delay_sub',
                                'label' => esc_html__('Animate Delay', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::TEXT,
                                'default' => '0',
                                'description' => 'Enter number. Default 0ms',
                            ),
                        )
                    ),
                ),
                array(
                    'name' => 'section_style_highlight',
                    'label' => esc_html__('Highlight Text', 'Lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array_merge(
                        array(
                            array(
                                'name' => 'highlight_style',
                                'label' => esc_html__('Style', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::SELECT,
                                'options' => [
                                    'highlight-default' => 'Default',
                                    'highlight-text-gradient' => 'Text Gradient',
                                ],
                                'default' => 'highlight-default',
                            ),
                            array(
                                'name' => 'highlight_color',
                                'label' => esc_html__('Color', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-title--highlight' => 'color: {{VALUE}};',
                                ],
                                'condition' => [
                                    'highlight_style' => ['highlight-default'],
                                ],
                            ),
                            array(
                                'name' => 'highlight_color_from',
                                'label' => esc_html__('Color From', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-title--highlight' => '--gradient-color-from: {{VALUE}};',
                                ],
                                'condition' => [
                                    'highlight_style' => ['highlight-text-gradient'],
                                ],
                            ),
                            array(
                                'name' => 'highlight_color_to',
                                'label' => esc_html__('Color To', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-title--highlight' => '--gradient-color-to: {{VALUE}};',
                                ],
                                'condition' => [
                                    'highlight_style' => ['highlight-text-gradient'],
                                ],
                            ),
                            array(
                                'name' => 'highlight_typography',
                                'label' => esc_html__('Typography', 'Lawsight' ),
                                'type' => \Elementor\Group_Control_Typography::get_type(),
                                'control_type' => 'group',
                                'selector' => '{{WRAPPER}} .pxl-heading .pxl-title--highlight',
                            ),
                            array(
                                'name' => 'highlight_text_image',
                                'label' => esc_html__( 'Text Image', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::MEDIA,
                                'default' => '',
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-title--highlight' => 'background-image: url( {{URL}} );',
                                ],  
                            ),
                            array(
                                'name' => 'highlight_image_position',
                                'label' => esc_html__( 'Text Image Position', 'Lawsight' ),
                                'type'         => \Elementor\Controls_Manager::SELECT,
                                'options'      => array(
                                    ''              => esc_html__( 'Default', 'Lawsight' ),
                                    'center center' => esc_html__( 'Center Center', 'Lawsight' ),
                                    'center left'   => esc_html__( 'Center Left', 'Lawsight' ),
                                    'center right'  => esc_html__( 'Center Right', 'Lawsight' ),
                                    'top center'    => esc_html__( 'Top Center', 'Lawsight' ),
                                    'top left'      => esc_html__( 'Top Left', 'Lawsight' ),
                                    'top right'     => esc_html__( 'Top Right', 'Lawsight' ),
                                    'bottom center' => esc_html__( 'Bottom Center', 'Lawsight' ),
                                    'bottom left'   => esc_html__( 'Bottom Left', 'Lawsight' ),
                                    'bottom right'  => esc_html__( 'Bottom Right', 'Lawsight' ),
                                    'initial'       =>  esc_html__( 'Custom', 'Lawsight' ),
                                ),
                                'default' => '',
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-title--highlight' => 'background-position: {{VALUE}};',
                                ],
                                'condition' => [
                                    'highlight_text_image[url]!' => ''
                                ]        
                            ),
                            array(
                                'name' => 'highlight_image_size',
                                'label' => esc_html__( 'Text Image Size', 'Lawsight' ),
                                'type'         => \Elementor\Controls_Manager::SELECT,
                                'hide_in_inner' => true,
                                'options'      => array(
                                    ''              => esc_html__( 'Default', 'Lawsight' ),
                                    'auto' => esc_html__( 'Auto', 'Lawsight' ),
                                    'cover'   => esc_html__( 'Cover', 'Lawsight' ),
                                    'contain'  => esc_html__( 'Contain', 'Lawsight' ),
                                    'initial'    => esc_html__( 'Custom', 'Lawsight' ),
                                ),
                                'default'      => '',
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-title--highlight' => 'background-size: {{VALUE}};',
                                ],
                                'condition' => [
                                    'highlight_text_image[url]!' => ''
                                ]        
                            ),
                            array(
                                'name' => 'highlight_margin',
                                'label' => esc_html__('Margin', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                                'size_units' => [ 'px' ],
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-title--highlight' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                ],
                                'control_type' => 'responsive',
                            ),
                        )
                    ),
                ),

                array(
                    'name' => 'section_style_highlight_img',
                    'label' => esc_html__('Highlight Image', 'Lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array_merge(
                        array(
                            array(
                                'name' => 'h_img_width',
                                'label' => esc_html__('Width', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::SLIDER,
                                'control_type' => 'responsive',
                                'size_units' => [ 'px' ],
                                'range' => [
                                    'px' => [
                                        'min' => 0,
                                        'max' => 3000,
                                    ],
                                ],
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-image--highlight' => 'width: {{SIZE}}{{UNIT}};',
                                ],
                                'separator' => 'after',
                            ),
                            array(
                                'name' => 'h_img_height',
                                'label' => esc_html__('Height', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::SLIDER,
                                'control_type' => 'responsive',
                                'size_units' => [ 'px' ],
                                'range' => [
                                    'px' => [
                                        'min' => 0,
                                        'max' => 3000,
                                    ],
                                ],
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-image--highlight' => 'height: {{SIZE}}{{UNIT}};',
                                ],
                                'separator' => 'after',
                            ),
                        )
                    ),
                ),

                array(
                    'name' => 'section_style_typewriter',
                    'label' => esc_html__('Typewriter', 'Lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array_merge(
                        array(
                            array(
                                'name' => 'typewriter_color',
                                'label' => esc_html__('Color', 'Lawsight' ),
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-heading .pxl-title--typewriter' => 'color: {{VALUE}};',
                                ],
                            ),
                            array(
                                'name' => 'typewriter_typography',
                                'label' => esc_html__('Typography', 'Lawsight' ),
                                'type' => \Elementor\Group_Control_Typography::get_type(),
                                'control_type' => 'group',
                                'selector' => '{{WRAPPER}} .pxl-heading .pxl-title--typewriter',
                            ),
                        )
                    ),
                ),
            ),
        ),
    ),
    lawsight_get_class_widget_path()
);