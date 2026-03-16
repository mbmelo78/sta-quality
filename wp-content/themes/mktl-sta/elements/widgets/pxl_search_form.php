<?php
pxl_add_custom_widget(
    array(
        'name' => 'pxl_search_form',
        'title' => esc_html__('Case Search Form', 'lawsight' ),
        'icon' => 'eicon-site-search',
        'categories' => array('pxltheme-core'),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'wg_title',
                            'label' => esc_html__('Widget Title', 'lawsight' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'email_placefolder',
                            'label' => esc_html__('Email Placefolder', 'lawsight' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'style',
                            'label' => esc_html__('Style', 'lawsight' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'style-1' => 'Style 1',
                                'style-2' => 'Style 2',
                            ],
                            'default' => 'style-1',
                        ),
                    ),
                ),
                lawsight_widget_animation_settings(),
            ),
        ),
    ),
    lawsight_get_class_widget_path()
);