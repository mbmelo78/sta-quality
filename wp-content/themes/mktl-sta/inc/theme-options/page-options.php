<?php
 
add_action( 'pxl_post_metabox_register', 'lawsight_page_options_register' );
function lawsight_page_options_register( $metabox ) {
 
	$panels = [
		'post' => [
			'opt_name'            => 'post_option',
			'display_name'        => esc_html__( 'Post Options', 'Lawsight' ),
			'show_options_object' => false,
			'context'  => 'advanced',
			'priority' => 'default',
			'sections'  => [
				'post_settings' => [
					'title'  => esc_html__( 'Post Options', 'Lawsight' ),
					'icon'   => 'el el-cog',
					'fields' => array_merge(
						lawsight_sidebar_pos_opts(['prefix' => 'post_', 'default' => true, 'default_value' => '-1']),
						array(
							array(
					            'id'=> 'post_video_link',
					            'type' => 'text',
					            'title' => esc_html__('Video Link', 'Lawsight'),
					            'validate' => 'url',
					            'default' => '',
					        ),
					        array(
								'id'             => 'content_spacing',
								'type'           => 'spacing',
								'output'         => array( '#pxl-wapper #pxl-main' ),
								'right'          => false,
								'left'           => false,
								'mode'           => 'padding',
								'units'          => array( 'px' ),
								'units_extended' => 'false',
								'title'          => esc_html__( 'Spacing Top/Bottom', 'Lawsight' ),
								'default'        => array(
									'padding-top'    => '',
									'padding-bottom' => '',
									'units'          => 'px',
								)
							),
					    )
					)
				]
			]
		],
		'page' => [
			'opt_name'            => 'pxl_page_options',
			'display_name'        => esc_html__( 'Page Options', 'Lawsight' ),
			'show_options_object' => false,
			'context'  => 'advanced',
			'priority' => 'default',
			'sections'  => [
				'header' => [
					'title'  => esc_html__( 'Header', 'Lawsight' ),
					'icon'   => 'el-icon-website',
					'fields' => array_merge(
				        lawsight_header_opts([
							'default'         => true,
							'default_value'   => '-1'
						]),
						lawsight_header_mobile_opts([
							'default'         => true,
							'default_value'   => '-1'
						]),
						array(
							array(
				                'id'       => 'header_display',
				                'type'     => 'button_set',
				                'title'    => esc_html__('Header Display', 'Lawsight'),
				                'options'  => array(
				                    'show' => esc_html__('Show', 'Lawsight'),
				                    'hide'  => esc_html__('Hide', 'Lawsight'),
				                ),
				                'default'  => 'show',
				            ),
				            array(
				                'id'       => 'page_mobile_style',
				                'type'     => 'button_set',
				                'title'    => esc_html__('Mobile Style', 'Lawsight'),
				                'options'  => array(
				                    'inherit'  => esc_html__('Inherit', 'Lawsight'),
				                    'light'  => esc_html__('Light', 'Lawsight'),
				                    'dark'  => esc_html__('Dark', 'Lawsight'),
				                ),
				                'default'  => 'inherit',
				            ),
				            array(
				           		'id'       => 'logo_m',
					            'type'     => 'media',
					            'title'    => esc_html__('Mobile Logo Dark', 'Lawsight'),
					            'default'  => '',
					            'url'      => false,
					        ),
					        array(
				           		'id'       => 'logo_light_m',
					            'type'     => 'media',
					            'title'    => esc_html__('Mobile Logo Light', 'Lawsight'),
					            'default'  => '',
					            'url'      => false,
					        ),
					        array(
				                'id'       => 'p_menu',
				                'type'     => 'select',
				                'title'    => esc_html__( 'Menu', 'Lawsight' ),
				                'options'  => lawsight_get_nav_menu_slug(),
				                'default' => '',
				                'description' => 'When you select Custom Menu. The custom menu will apply to the entire layout when you use Case Nav Menu widget in Elementor and Menu on header layout in Mobile.'
				            ),
					    ),
					    array(
				            array(
				                'id'       => 'sticky_scroll',
				                'type'     => 'button_set',
				                'title'    => esc_html__('Sticky Scroll', 'Lawsight'),
				                'options'  => array(
				                    '-1' => esc_html__('Inherit', 'Lawsight'),
				                    'pxl-sticky-stt' => esc_html__('Scroll To Top', 'Lawsight'),
				                    'pxl-sticky-stb'  => esc_html__('Scroll To Bottom', 'Lawsight'),
				                ),
				                'default'  => '-1',
				            ),
				            array(
				                'id'       => 'header_margin',
				                'type'     => 'spacing',
				                'mode'     => 'margin',
				                'title'    => esc_html__('Margin', 'Lawsight'),
				                'width'    => false,
				                'unit'     => 'px',
				                'output'    => array('#pxl-header-elementor .pxl-header-elementor-main'),
				            ),
				        )
				    )
					 
				],
				'page_title' => [
					'title'  => esc_html__( 'Page Title', 'Lawsight' ),
					'icon'   => 'el el-indent-left',
					'fields' => array_merge(
				        lawsight_page_title_opts([
							'default'         => true,
							'default_value'   => '-1'
						])
				    )
				],
				'content' => [
					'title'  => esc_html__( 'Content', 'Lawsight' ),
					'icon'   => 'el-icon-pencil',
					'fields' => array_merge(
						lawsight_sidebar_pos_opts(['prefix' => 'page_', 'default' => false, 'default_value' => '0']),
						array(
					        array(
								'id'             => 'content_spacing',
								'type'           => 'spacing',
								'output'         => array( '#pxl-wapper #pxl-main' ),
								'right'          => false,
								'left'           => false,
								'mode'           => 'padding',
								'units'          => array( 'px' ),
								'units_extended' => 'false',
								'title'          => esc_html__( 'Spacing Top/Bottom', 'Lawsight' ),
								'default'        => array(
									'padding-top'    => '',
									'padding-bottom' => '',
									'units'          => 'px',
								)
							), 
					    )
					)
				],
				'footer' => [
					'title'  => esc_html__( 'Footer', 'Lawsight' ),
					'icon'   => 'el el-website',
					'fields' => array_merge(
				        lawsight_footer_opts([
							'default'         => true,
							'default_value'   => '-1'
						]),
						array(
							array(
				                'id'       => 'footer_display',
				                'type'     => 'button_set',
				                'title'    => esc_html__('Footer Display', 'Lawsight'),
				                'options'  => array(
				                    'show' => esc_html__('Show', 'Lawsight'),
				                    'hide'  => esc_html__('Hide', 'Lawsight'),
				                ),
				                'default'  => 'show',
				            ),
							array(
				                'id'       => 'p_footer_fixed',
				                'type'     => 'button_set',
				                'title'    => esc_html__('Footer Fixed', 'Lawsight'),
				                'options'  => array(
				                    'inherit' => esc_html__('Inherit', 'Lawsight'),
				                    'on' => esc_html__('On', 'Lawsight'),
				                    'off' => esc_html__('Off', 'Lawsight'),
				                ),
				                'default'  => 'inherit',
				            ),
				            array(
				                'id'       => 'back_top_top_style',
				                'type'     => 'button_set',
				                'title'    => esc_html__('Back to Top Style', 'Lawsight'),
				                'options'  => array(
				                    'style-default' => esc_html__('Default', 'Lawsight'),
				                    'style-round' => esc_html__('Round', 'Lawsight'),
				                ),
				                'default'  => 'style-default',
				            ),
						)
				    )
				],
				'colors' => [
					'title'  => esc_html__( 'Colors', 'Lawsight' ),
					'icon'   => 'el el-website',
					'fields' => array_merge(
				        array(
				        	array(
							    'id'        => 'page_body_color',
							    'type'      => 'color',
							    'title'     => esc_html__('Body Background Color', 'Lawsight'),
							    'default'   => '',
							    'transparent' => false,
							    'output'    => array(
							        'background-color' => 'body',
							    )
							),
				        	array(
					            'id'          => 'primary_color',
					            'type'        => 'color',
					            'title'       => esc_html__('Primary Color', 'Lawsight'),
					            'transparent' => false,
					            'default'     => ''
					        ),
					        array(
					            'id'          => 'gradient_color',
					            'type'        => 'color_gradient',
					            'title'       => esc_html__('Gradient Color', 'Lawsight'),
					            'transparent' => false,
					            'default'  => array(
					                'from' => '',
					                'to'   => '', 
					            ),
					        ),
					    )
				    )
				],
				'extra' => [
					'title'  => esc_html__( 'Extra', 'Lawsight' ),
					'icon'   => 'el el-website',
					'fields' => array_merge(
				        array(
				        	array(
					            'id' => 'body_custom_class',
					            'type' => 'text',
					            'title' => esc_html__('Body Custom Class', 'Lawsight'),
					        ),
					    )
				    )
				]
			]
		],
		'portfolio' => [
			'opt_name'            => 'pxl_portfolio_options',
			'display_name'        => esc_html__( 'Portfolio Options', 'Lawsight' ),
			'show_options_object' => false,
			'context'  => 'advanced',
			'priority' => 'default',
			'sections'  => [
				'header' => [
					'title'  => esc_html__( 'General', 'Lawsight' ),
					'icon'   => 'el-icon-website',
					'fields' => array_merge(
						array(
							array(
					            'id'=> 'portfolio_excerpt',
					            'type' => 'textarea',
					            'title' => esc_html__('Excerpt', 'Lawsight'),
					            'validate' => 'html_custom',
					            'default' => '',
					        ),
					        array(
								'id'             => 'content_spacing',
								'type'           => 'spacing',
								'output'         => array( '#pxl-wapper #pxl-main' ),
								'right'          => false,
								'left'           => false,
								'mode'           => 'padding',
								'units'          => array( 'px' ),
								'units_extended' => 'false',
								'title'          => esc_html__( 'Content Spacing Top/Bottom', 'Lawsight' ),
								'default'        => array(
									'padding-top'    => '',
									'padding-bottom' => '',
									'units'          => 'px',
								)
							),
						)
				    )
				],
			]
		],
		'service' => [
			'opt_name'            => 'pxl_service_options',
			'display_name'        => esc_html__( 'Service Options', 'Lawsight' ),
			'show_options_object' => false,
			'context'  => 'advanced',
			'priority' => 'default',
			'sections'  => [
				'header' => [
					'title'  => esc_html__( 'General', 'Lawsight' ),
					'icon'   => 'el-icon-website',
					'fields' => array_merge(
						array(
							array(
					            'id'=> 'service_external_link',
					            'type' => 'text',
					            'title' => esc_html__('External Link', 'Lawsight'),
					            'validate' => 'url',
					            'default' => '',
					        ),
							array(
					            'id'=> 'service_excerpt',
					            'type' => 'textarea',
					            'title' => esc_html__('Excerpt', 'Lawsight'),
					            'validate' => 'html_custom',
					            'default' => '',
					        ),
					        array(
					            'id'       => 'service_icon_type',
					            'type'     => 'button_set',
					            'title'    => esc_html__('Icon Type', 'Lawsight'),
					            'options'  => array(
					                'icon'  => esc_html__('Icon', 'Lawsight'),
					                'image'  => esc_html__('Image', 'Lawsight'),
					            ),
					            'default'  => 'icon'
					        ),
					        array(
					            'id'       => 'service_icon_font',
					            'type'     => 'pxl_iconpicker',
					            'title'    => esc_html__('Icon', 'Lawsight'),
					            'required' => array( 0 => 'service_icon_type', 1 => 'equals', 2 => 'icon' ),
            					'force_output' => true
					        ),
					        array(
					            'id'       => 'service_icon_img',
					            'type'     => 'media',
					            'title'    => esc_html__('Icon Image', 'Lawsight'),
					            'default' => '',
					            'required' => array( 0 => 'service_icon_type', 1 => 'equals', 2 => 'image' ),
				            	'force_output' => true
					        ),
					        array(
								'id'             => 'content_spacing',
								'type'           => 'spacing',
								'output'         => array( '#pxl-wapper #pxl-main' ),
								'right'          => false,
								'left'           => false,
								'mode'           => 'padding',
								'units'          => array( 'px' ),
								'units_extended' => 'false',
								'title'          => esc_html__( 'Content Spacing Top/Bottom', 'Lawsight' ),
								'default'        => array(
									'padding-top'    => '',
									'padding-bottom' => '',
									'units'          => 'px',
								)
							),
						),
						lawsight_footer_opts([
							'default'         => true,
							'default_value'   => '-1'
						])
				    )
				],
			]
		],

		'pxl-template' => [ //post_type
			'opt_name'            => 'pxl_hidden_template_options',
			'display_name'        => esc_html__( 'Template Options', 'Lawsight' ),
			'show_options_object' => false,
			'context'  => 'advanced',
			'priority' => 'default',
			'sections'  => [
				'header' => [
					'title'  => esc_html__( 'General', 'Lawsight' ),
					'icon'   => 'el-icon-website',
					'fields' => array(
						array(
							'id'    => 'template_type',
							'type'  => 'select',
							'title' => esc_html__('Type', 'Lawsight'),
				            'options' => [
				            	'df'       	   => esc_html__('Select Type', 'Lawsight'), 
								'header'       => esc_html__('Header Desktop', 'Lawsight'),
								'header-mobile'       => esc_html__('Header Mobile', 'Lawsight'),
								'footer'       => esc_html__('Footer', 'Lawsight'), 
								'mega-menu'    => esc_html__('Mega Menu', 'Lawsight'), 
								'page-title'   => esc_html__('Page Title', 'Lawsight'), 
								'tab' => esc_html__('Tab', 'Lawsight'),
								'hidden-panel' => esc_html__('Hidden Panel', 'Lawsight'),
								'popup' => esc_html__('Popup', 'Lawsight'),
								'page' => esc_html__('Page', 'Lawsight'),
								'slider' => esc_html__('Slider', 'Lawsight'),
				            ],
				            'default' => 'df',
				        ),
				        array(
							'id'    => 'header_type',
							'type'  => 'select',
							'title' => esc_html__('Header Type', 'Lawsight'),
				            'options' => [
				            	'px-header--default'       	   => esc_html__('Default', 'Lawsight'), 
								'px-header--transparent'       => esc_html__('Transparent', 'Lawsight'),
								'px-header--left_sidebar'       => esc_html__('Left Sidebar', 'Lawsight'),
				            ],
				            'default' => 'px-header--default',
				            'indent' => true,
                			'required' => array( 0 => 'template_type', 1 => 'equals', 2 => 'header' ),
				        ),

				        array(
							'id'    => 'header_mobile_type',
							'type'  => 'select',
							'title' => esc_html__('Header Type', 'Lawsight'),
				            'options' => [
				            	'px-header--default'       	   => esc_html__('Default', 'Lawsight'), 
								'px-header--transparent'       => esc_html__('Transparent', 'Lawsight'),
				            ],
				            'default' => 'px-header--default',
				            'indent' => true,
                			'required' => array( 0 => 'template_type', 1 => 'equals', 2 => 'header-mobile' ),
				        ),

				        array(
							'id'    => 'hidden_panel_position',
							'type'  => 'select',
							'title' => esc_html__('Hidden Panel Position', 'Lawsight'),
				            'options' => [
				            	'top'       	   => esc_html__('Top', 'Lawsight'),
				            	'right'       	   => esc_html__('Right', 'Lawsight'),
				            ],
				            'default' => 'right',
				            'required' => array( 0 => 'template_type', 1 => 'equals', 2 => 'hidden-panel' ),
				        ),
				        array(
				            'id'          => 'hidden_panel_height',
				            'type'        => 'text',
				            'title'       => esc_html__('Hidden Panel Height', 'Lawsight'),
				            'subtitle'       => esc_html__('Enter number.', 'Lawsight'),
				            'transparent' => false,
				            'default'     => '',
				            'force_output' => true,
				            'required' => array( 0 => 'hidden_panel_position', 1 => 'equals', 2 => 'top' ),
				        ),
				        array(
				            'id'          => 'hidden_panel_boxcolor',
				            'type'        => 'color',
				            'title'       => esc_html__('Box Color', 'Lawsight'),
				            'transparent' => false,
				            'default'     => '',
				            'required' => array( 0 => 'template_type', 1 => 'equals', 2 => 'hidden-panel' ),
				        ),
				        array(
				            'id'          => 'header_sidebar_width',
				            'type'        => 'slider',
				            'title'       => esc_html__('Header Sidebar Width', 'Lawsight'),
				            "default"   => 300,
						    "min"       => 50,
						    "step"      => 1,
						    "max"       => 900,
				            'force_output' => true,
				            'required' => array( 0 => 'header_type', 1 => 'equals', 2 => 'px-header--left_sidebar' ),
				        ),

				        array(
							'id'    => 'header_sidebar_style',
							'type'  => 'select',
							'title' => esc_html__('Header Sidebar Style', 'Lawsight'),
				            'options' => [
				            	'px-header-sidebar-style1'      => esc_html__('Style 1', 'Lawsight'), 
								'px-header-sidebar-style2'      => esc_html__('Style 2', 'Lawsight'),
				            ],
				            'default' => 'px-header-sidebar-style1',
				            'indent' => true,
                			'required' => array( 0 => 'header_type', 1 => 'equals', 2 => 'px-header--left_sidebar' ),
				        ),
					),
				    
				],
			]
		],
	];
 
	$metabox->add_meta_data( $panels );
}
 