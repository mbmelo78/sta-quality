<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
get_template_part( 'inc/admin/libs/tgmpa/class-tgm-plugin-activation' );

add_action( 'tgmpa_register', 'lawsight_register_required_plugins' );
function lawsight_register_required_plugins() {
    include( locate_template( 'inc/admin/demo-data/demo-config.php' ) );
    $pxl_server_info = apply_filters( 'pxl_server_info', ['plugin_url' => 'https://api.casethemes.net/plugins/'] ) ; 
    $default_path = $pxl_server_info['plugin_url'];  
    $images = get_template_directory_uri() . '/inc/admin/assets/img/plugins';
    $plugins = array(

        array(
            'name'               => esc_html__('Redux Framework', 'Lawsight'),
            'slug'               => 'redux-framework',
            'required'           => true,
            'logo'        => $images . '/redux.png',
            'description' => esc_html__( 'Build theme options and post, page options for WordPress Theme.', 'Lawsight' ),
        ),

        array(
            'name'               => esc_html__('Elementor', 'Lawsight'),
            'slug'               => 'elementor',
            'required'           => true,
            'logo'        => $images . '/elementor.png',
            'description' => esc_html__( 'Introducing a WordPress website builder, with no limits of design. A website builder that delivers high-end page designs and advanced capabilities', 'Lawsight' ),
        ),

        array(
            'name'               => esc_html__('Case Addons', 'Lawsight'),
            'slug'               => 'case-addons',
            'source'             => 'case-addons.zip',
            'required'           => true,
            'logo'        => $images . '/case-addons.png',
            'description' => esc_html__( 'Main process and Powerful Elements Plugin, exclusively for Lawsight WordPress Theme.', 'Lawsight' ),
        ),

        array(
            'name'               => esc_html__('Revolution Slider', 'Lawsight'),
            'slug'               => 'revslider',
            'source'             => 'revslider.zip',
            'required'           => true,
            'logo'        => $images . '/rev-slider.png',
            'description' => esc_html__( 'Revolution Slider helps beginner-and mid-level designers WOW their clients with pro-level visuals.', 'Lawsight' )
        ),

        array(
            'name'               => esc_html__('Booked', 'Lawsight'),
            'slug'               => 'booked',
            'source'             => 'booked.zip',
            'required'           => true,
            'logo'        => $images . '/badge.png',
            'description' => esc_html__( 'Appoiment helps beginner-and mid-level designers WOW their clients with pro-level visuals.', 'Lawsight' )
        ),
  
        array(
            'name'               => esc_html__('Contact Form 7', 'Lawsight'),
            'slug'               => 'contact-form-7',
            'required'           => true,
            'logo'        => $images . '/contact-f7.png',
            'description' => esc_html__( 'Contact Form 7 can manage multiple contact forms, you can customize the form and the mail contents flexibly with simple markup', 'Lawsight' ),
        ),

        array(
            'name'               => esc_html__('Mailchimp', 'Lawsight'),
            'slug'               => "mailchimp-for-wp",
            'required'           => true,
            'logo'        => $images . '/mailchimp.png',
            'description' => esc_html__( 'Allowing your visitors to subscribe to your newsletter should be easy. With this plugin, it finally is.', 'Lawsight' ),
        ),
        
        array(
            'name'               => esc_html__('WooCommerce', 'Lawsight'),
            'slug'               => "woocommerce",
            'required'           => true,
            'logo'        => $images . '/woo.png',
            'description' => esc_html__( 'WooCommerce is the world’s most popular open-source eCommerce solution.', 'Lawsight' ),
        ),
    );
 

    $config = array(
        'default_path' => $default_path,           // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'is_automatic' => true,
    );

    tgmpa( $plugins, $config );

}