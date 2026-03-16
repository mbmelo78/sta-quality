<?php
pxl_add_custom_widget(
    array(
        'name' => 'pxl_download_link',
        'title' => esc_html__( 'Case Download Link', 'lawsight' ),
        'icon' => 'eicon-library-download',
        'categories' => array('pxltheme-core'),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'tab_content',
                    'label' => esc_html__( 'Content', 'lawsight' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'download_link',
                            'label' => esc_html__( 'Download Link', 'lawsight' ),
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'controls' => array(
                                array(
                                    'name' => 'title',
                                    'label' => esc_html__( 'Title', 'lawsight' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'label_block' => true,
                                ),
                                array(
                                    'name' => 'size',
                                    'label' => esc_html__( 'Size', 'lawsight' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'label_block' => true,
                                ),
                                array(
                                    'name' => 'd_link',
                                    'label' => esc_html__('Link', 'lawsight'),
                                    'type' => \Elementor\Controls_Manager::URL,
                                    'label_block' => true,
                                ),
                                array(
                                    'name' => 'pxl_icon',
                                    'label' => esc_html__('Icon File', 'lawsight' ),
                                    'type' => \Elementor\Controls_Manager::ICONS,
                                    'fa4compatibility' => 'icon',
                                ),
                            ),
                            'title_field' => '{{{ title }}}',
                        ),
                    ),
                ),
                lawsight_widget_animation_settings(),
            ),
        ),
    ),
    lawsight_get_class_widget_path()
);