<?php
if (!class_exists('ReduxFramework')) {
    return;
}
if (class_exists('ReduxFrameworkPlugin')) {
    remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
}

$opt_name = Lawsight()->get_option_name();
$version = Lawsight()->get_version();

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => '', //$theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version'      => $version,
    // Version that appears at the top of your panel
    'menu_type'            => 'submenu', //class_exists('Pxltheme_Core') ? 'submenu' : '',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__('Theme Options', 'Lawsight'),
    'page_title'           => esc_html__('Theme Options', 'Lawsight'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => false,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => false,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-admin-generic',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => true,
    // Show the time the page took to load, etc
    'update_notice'        => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => true,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
    'show_options_object' => false,
    // OPTIONAL -> Give you extra features
    'page_priority'        => 80,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'pxlart', //class_exists('lawsight_Admin_Page') ? 'case' : '',
    // For a full list of options, visit: //codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => 'pxlart-theme-options',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    ),
);

Redux::SetArgs($opt_name, $args);

/*--------------------------------------------------------------
# Colors
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Global Colors', 'Lawsight'),
    'icon'       => 'el el-filter',
    'fields' => array(
        array(
            'id'          => 'primary_color',
            'type'        => 'color',
            'title'       => esc_html__('Primary Color', 'Lawsight'),
            'transparent' => false,
            'default'     => ''
        ),
        array(
            'id'          => 'secondary_color',
            'type'        => 'color',
            'title'       => esc_html__('Secondary Color', 'Lawsight'),
            'transparent' => false,
            'default'     => ''
        ),
        array(
            'id'          => 'third_color',
            'type'        => 'color',
            'title'       => esc_html__('Third Color', 'Lawsight'),
            'transparent' => false,
            'default'     => ''
        ),
        array(
            'id'          => 'dark_color',
            'type'        => 'color',
            'title'       => esc_html__('Dark Color', 'Lawsight'),
            'transparent' => false,
            'default'     => ''
        ),
        array(
            'id'      => 'link_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Link Colors', 'Lawsight'),
            'default' => array(
                'regular' => '',
                'hover'   => '',
                'active'  => ''
            ),
            'output'  => array('a')
        ),
        array(
            'id'          => 'gradient_first_color',
            'type'        => 'color',
            'title'       => esc_html__('Gradient First Color', 'Lawsight'),
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
        array(
            'id'          => 'gradient_color2',
            'type'        => 'color_gradient',
            'title'       => esc_html__('Gradient Color 2', 'Lawsight'),
            'transparent' => false,
            'default'  => array(
                'from' => '',
                'to'   => '', 
            ),
        ),
    )
));

/*--------------------------------------------------------------
# Typography
--------------------------------------------------------------*/
Redux::setSection($opt_name, array(
    'title'  => esc_html__('Typography', 'Lawsight'),
    'icon'   => 'el-icon-text-width',
    'fields' => array(

        array(
            'id'          => 'font_body',
            'type'        => 'typography',
            'title'       => esc_html__('Body Font', 'Lawsight'),
            'google'      => true,
            'font-backup' => false,
            'all_styles'  => true,
            'line-height'  => true,
            'font-size'  => true,
            'text-align'  => false,
            'output'      => array('body'),
            'units'       => 'px',
        ),
        
        array(
            'id'          => 'font_heading_h1',
            'type'        => 'typography',
            'title'       => esc_html__('Heading H1', 'Lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'line-height' => true,
            'font-size'   => true,
            'font-backup' => false,
            'font-style'  => false,
            'output'      => array('h1'),
            'units'       => 'px',
        ),

        array(
            'id'          => 'font_heading_h2',
            'type'        => 'typography',
            'title'       => esc_html__('Heading H2', 'Lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'line-height' => true,
            'font-size'   => true,
            'font-backup' => false,
            'font-style'  => false,
            'output'      => array('h2'),
            'units'       => 'px',
        ),

        array(
            'id'          => 'font_heading_h3',
            'type'        => 'typography',
            'title'       => esc_html__('Heading H3', 'Lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'line-height' => true,
            'font-size'   => true,
            'font-backup' => false,
            'font-style'  => false,
            'output'      => array('h3'),
            'units'       => 'px',
        ),

        array(
            'id'          => 'font_heading_h4',
            'type'        => 'typography',
            'title'       => esc_html__('Heading H4', 'Lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'line-height' => true,
            'font-size'   => true,
            'font-backup' => false,
            'font-style'  => false,
            'output'      => array('h4'),
            'units'       => 'px',
        ),

        array(
            'id'          => 'font_heading_h5',
            'type'        => 'typography',
            'title'       => esc_html__('Heading H5', 'Lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'line-height' => true,
            'font-size'   => true,
            'font-backup' => false,
            'font-style'  => false,
            'output'      => array('h5'),
            'units'       => 'px',
        ),

        array(
            'id'          => 'font_heading_h6',
            'type'        => 'typography',
            'title'       => esc_html__('Heading H6', 'Lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'line-height' => true,
            'font-size'   => true,
            'font-backup' => false,
            'font-style'  => false,
            'output'      => array('h6'),
            'units'       => 'px',
        ),

        array(
            'id'          => 'f_secondary',
            'type'        => 'typography',
            'title'       => esc_html__('Secondary', 'Lawsight'),
            'google'      => true,
            'font-backup' => false,
            'all_styles'  => false,
            'line-height'  => false,
            'font-size'  => false,
            'color'  => false,
            'font-style'  => false,
            'font-weight'  => false,
            'text-align'  => false,
            'units'       => 'px',
            'output'      => array('.ft-secondary'),
        ),

    )
));

/*--------------------------------------------------------------
# General
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('General', 'Lawsight'),
    'icon'   => 'el el-wrench',
    'fields' => array(
        array(
            'id'       => 'site_loader',
            'type'     => 'button_set',
            'title'    => esc_html__('Site Loader', 'Lawsight'),
            'options'  => array(
                'on' => esc_html__('On', 'Lawsight'),
                'off' => esc_html__('Off', 'Lawsight'),
            ),
            'default'  => 'off',
        ),
        array(
            'id'       => 'site_loader_style',
            'type'     => 'button_set',
            'title'    => esc_html__('Site Loader Style', 'Lawsight'),
            'options'  => array(
                'style-1' => esc_html__('Style 1', 'Lawsight'),
                'style-2' => esc_html__('Style 2', 'Lawsight'),
            ),
            'default'  => 'style-1',
            'required' => array( 0 => 'site_loader', 1 => 'equals', 2 => 'on' ),
            'force_output' => true
        ),
        array(
            'id'       => 'site_loader_icon',
            'type'     => 'media',
            'title'    => esc_html__('Site Loader Icon', 'Lawsight'),
            'default' => '',
            'url'      => false,
            'required' => array( 0 => 'site_loader', 1 => 'equals', 2 => 'on' ),
            'force_output' => true
        ),
        array(
            'id'       => 'mouse_move_animation',
            'type'     => 'button_set',
            'title'    => esc_html__('Mouse Move Animation', 'Lawsight'),
            'options'  => array(
                'on' => esc_html__('On', 'Lawsight'),
                'off' => esc_html__('Off', 'Lawsight'),
            ),
            'default'  => 'off',
        ),
        array(
            'id'       => 'smooth_scroll',
            'type'     => 'button_set',
            'title'    => esc_html__('Smooth Scroll', 'Lawsight'),
            'options'  => array(
                'on' => esc_html__('On', 'Lawsight'),
                'off' => esc_html__('Off', 'Lawsight'),
            ),
            'default'  => 'off',
        ),

        array(
            'id'       => 'cookie_policy',
            'type'     => 'button_set',
            'title'    => esc_html__('Cookie Policy', 'Lawsight'),
            'options'  => array(
                'show' => esc_html__('Show', 'Lawsight'),
                'hide' => esc_html__('Hide', 'Lawsight'),
            ),
            'default'  => 'hide',
        ),
        array(
            'id'      => 'cookie_policy_description',
            'type'    => 'text',
            'title'   => esc_html__('Cookie Description', 'Lawsight'),
            'default' => '',
            'required' => array( 0 => 'cookie_policy', 1 => 'equals', 2 => 'show' ),
        ),
        array(
            'id'          => 'cookie_policy_description_typo',
            'type'        => 'typography',
            'title'       => esc_html__('Cookie Description Font', 'Lawsight'),
            'google'      => true,
            'font-backup' => false,
            'all_styles'  => true,
            'line-height'  => true,
            'font-size'  => true,
            'text-align'  => false,
            'color'  => false,
            'output'      => array('.pxl-cookie-policy .pxl-item--description'),
            'units'       => 'px',
            'required' => array( 0 => 'cookie_policy', 1 => 'equals', 2 => 'show' ),
        ),
        array(
            'id'      => 'cookie_policy_btntext',
            'type'    => 'text',
            'title'   => esc_html__('Cookie Button Text', 'Lawsight'),
            'default' => '',
            'required' => array( 0 => 'cookie_policy', 1 => 'equals', 2 => 'show' ),
        ),
        array(
            'id'    => 'cookie_policy_link',
            'type'  => 'select',
            'title' => esc_html__( 'Cookie Button Link', 'Lawsight' ), 
            'data'  => 'page',
            'args'  => array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ),
            'required' => array( 0 => 'cookie_policy', 1 => 'equals', 2 => 'show' ),
        ),

        array(
            'id'       => 'subscribe',
            'type'     => 'button_set',
            'title'    => esc_html__('Subscribe', 'Lawsight'),
            'options'  => array(
                'show' => esc_html__('Show', 'Lawsight'),
                'hide' => esc_html__('Hide', 'Lawsight'),
            ),
            'default'  => 'hide',
        ),
        array(
            'id'      => 'subscribe_layout',
            'type'    => 'select',
            'title'   => esc_html__('Subscribe Layout', 'Lawsight'),
            'desc'    => sprintf(esc_html__('Please create your layout before choosing. %sClick Here%s','Lawsight'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
            'options' => lawsight_get_templates_option('popup'),
            'required' => array( 0 => 'subscribe', 1 => 'equals', 2 => 'show' ),
        ),
        array(
            'id'    => 'popup_effect',
            'type'  => 'select',
            'title' => esc_html__('Subscribe Popup Effect', 'Lawsight'),
            'options' => [
                'fade'           => esc_html__('Fade', 'Lawsight'),
                'fade-slide'           => esc_html__('Fade Slide', 'Lawsight'),
                'zoom'           => esc_html__('Zoom', 'Lawsight'),
            ],
            'default' => 'fade',
            'required' => array( 0 => 'subscribe', 1 => 'equals', 2 => 'show' ),
        ),
    )
));


/*--------------------------------------------------------------
# Header
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Header', 'Lawsight'),
    'icon'   => 'el el-indent-left',
    'fields' => array_merge(
        lawsight_header_opts(),
        array(
            array(
                'id'       => 'sticky_scroll',
                'type'     => 'button_set',
                'title'    => esc_html__('Sticky Scroll', 'Lawsight'),
                'options'  => array(
                    'pxl-sticky-stt' => esc_html__('Scroll To Top', 'Lawsight'),
                    'pxl-sticky-stb'  => esc_html__('Scroll To Bottom', 'Lawsight'),
                ),
                'default'  => 'pxl-sticky-stb',
            ),
        )
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Mobile', 'Lawsight'),
    'icon'       => 'el el-circle-arrow-right',
    'subsection' => true,
    'fields'     => array_merge(
        lawsight_header_mobile_opts(),
        array(
            array(
                'id'       => 'mobile_display',
                'type'     => 'button_set',
                'title'    => esc_html__('Display', 'Lawsight'),
                'options'  => array(
                    'show'  => esc_html__('Show', 'Lawsight'),
                    'hide'  => esc_html__('Hide', 'Lawsight'),
                ),
                'default'  => 'show'
            ),
            array(
                'id'       => 'opt_mobile_style',
                'type'     => 'button_set',
                'title'    => esc_html__('Style', 'Lawsight'),
                'options'  => array(
                    'light'  => esc_html__('Light', 'Lawsight'),
                    'dark'  => esc_html__('Dark', 'Lawsight'),
                ),
                'default'  => 'light',
                'required' => array( 0 => 'mobile_display', 1 => 'equals', 2 => 'show' ),
            ),
            array(
                'id'       => 'logo_m',
                'type'     => 'media',
                'title'    => esc_html__('Logo Dark in Menu Sidebar', 'Lawsight'),
                 'default' => array(
                    'url'=>get_template_directory_uri().'/assets/img/logo.png'
                ),
                'url'      => false,
                'required' => array( 0 => 'mobile_display', 1 => 'equals', 2 => 'show' ),
            ),
            array(
                'id'       => 'logo_light_m',
                'type'     => 'media',
                'title'    => esc_html__('Logo Light in Menu Sidebar', 'Lawsight'),
                'default' => array(
                    'url'=>get_template_directory_uri().'/assets/img/logo-light.png'
                ),
                'url'      => false,
                'required' => array( 0 => 'mobile_display', 1 => 'equals', 2 => 'show' ),
            ),
            array(
                'id'       => 'logo_height',
                'type'     => 'dimensions',
                'title'    => esc_html__('Logo Height', 'Lawsight'),
                'width'    => false,
                'unit'     => 'px',
                'output'    => array('#pxl-header-default .pxl-header-branding img, #pxl-header-default #pxl-header-mobile .pxl-header-branding img, #pxl-header-elementor #pxl-header-mobile .pxl-header-branding img, .pxl-logo-mobile img'),
                'required' => array( 0 => 'mobile_display', 1 => 'equals', 2 => 'show' ),
            ),
            array(
                'id'       => 'search_mobile',
                'type'     => 'switch',
                'title'    => esc_html__('Search Form', 'Lawsight'),
                'default'  => true,
                'required' => array( 0 => 'mobile_display', 1 => 'equals', 2 => 'show' ),
            ),
            array(
                'id'      => 'search_placeholder_mobile',
                'type'    => 'text',
                'title'   => esc_html__('Search Text Placeholder', 'Lawsight'),
                'default' => '',
                'subtitle' => esc_html__('Default: Search...', 'Lawsight'),
                'required' => array( 0 => 'search_mobile', 1 => 'equals', 2 => true ),
            )
        )
    )
));


/*--------------------------------------------------------------
# Footer
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Footer', 'Lawsight'),
    'icon'   => 'el el-website',
    'fields' => array_merge(
        lawsight_footer_opts(),
        array(
            array(
                'id'       => 'back_totop_on',
                'type'     => 'switch',
                'title'    => esc_html__('Button Back to Top', 'Lawsight'),
                'default'  => false,
            ),
            array(
                'id'       => 'footer_fixed',
                'type'     => 'button_set',
                'title'    => esc_html__('Footer Fixed', 'Lawsight'),
                'options'  => array(
                    'on' => esc_html__('On', 'Lawsight'),
                    'off' => esc_html__('Off', 'Lawsight'),
                ),
                'default'  => 'off',
            ),
        ) 
    )
    
));

/*--------------------------------------------------------------
# Page Title area
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Page Title', 'Lawsight'),
    'icon'   => 'el-icon-map-marker',
    'fields' => array_merge(
        lawsight_page_title_opts(),
        array(
            array(
                'id'       => 'ptitle_scroll_opacity',
                'title'    => esc_html__('Scroll Opacity', 'Lawsight'),
                'type'     => 'switch',
                'default'  => false,
            ),
        )
    )
));

/*--------------------------------------------------------------
# WordPress default content
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title' => esc_html__('Blog', 'Lawsight'),
    'icon'  => 'el el-edit',
    'fields'     => array(
    )
));

Redux::setSection($opt_name, array(
    'title' => esc_html__('Blog Archive', 'Lawsight'),
    'icon'  => 'el-icon-pencil',
    'subsection' => true,
    'fields'     => array_merge(
        lawsight_sidebar_pos_opts([ 'prefix' => 'blog_']),
        array(
            array(
                'id'       => 'archive_date',
                'title'    => esc_html__('Date', 'Lawsight'),
                'subtitle' => esc_html__('Display the Date for each blog post.', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true,
            ),
            array(
                'id'       => 'archive_author',
                'title'    => esc_html__('Author', 'Lawsight'),
                'subtitle' => esc_html__('Display the Author for each blog post.', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true,
            ),
            array(
                'id'       => 'archive_category',
                'title'    => esc_html__('Category', 'Lawsight'),
                'subtitle' => esc_html__('Display the Category for each blog post.', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true,
            ),
            array(
                'id'       => 'archive_comment',
                'title'    => esc_html__('Comment', 'Lawsight'),
                'subtitle' => esc_html__('Display the Comment for each blog post.', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true,
            ),
            array(
                'id'      => 'featured_img_size',
                'type'    => 'text',
                'title'   => esc_html__('Featured Image Size', 'Lawsight'),
                'default' => '',
                'subtitle' => 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Default: 370x300 (Width x Height)).',
            ),
            array(
                'id'      => 'archive_excerpt_length',
                'type'    => 'text',
                'title'   => esc_html__('Excerpt Length', 'Lawsight'),
                'default' => '',
                'subtitle' => esc_html__('Default: 50', 'Lawsight'),
            ),
            array(
                'id'      => 'archive_readmore_text',
                'type'    => 'text',
                'title'   => esc_html__('Read More Text', 'Lawsight'),
                'default' => '',
                'subtitle' => esc_html__('Default: Read more', 'Lawsight'),
            ),
        )
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Single Post', 'Lawsight'),
    'icon'       => 'el el-icon-pencil',
    'subsection' => true,
    'fields'     => array_merge(
        lawsight_sidebar_pos_opts([ 'prefix' => 'post_']),
        array(
            array(
                'id'       => 'sg_post_title',
                'type'     => 'button_set',
                'title'    => esc_html__('Page Title Type', 'Lawsight'),
                'options'  => array(
                    'default' => esc_html__('Default', 'Lawsight'),
                    'custom_text' => esc_html__('Custom Text', 'Lawsight'),
                ),
                'default'  => 'default',
            ),
            array(
                'id'      => 'sg_post_title_text',
                'type'    => 'text',
                'title'   => esc_html__('Page Title Text', 'Lawsight'),
                'default' => 'Blog Details',
                'required' => array( 0 => 'sg_post_title', 1 => 'equals', 2 => 'custom_text' ),
            ),
            array(
                'id'      => 'sg_featured_img_size',
                'type'    => 'text',
                'title'   => esc_html__('Featured Image Size', 'Lawsight'),
                'default' => '',
                'subtitle' => 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Default: 370x300 (Width x Height)).',
            ),
            array(
                'id'       => 'post_date',
                'title'    => esc_html__('Date', 'Lawsight'),
                'subtitle' => esc_html__('Display the Date for blog post.', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true
            ),
            array(
                'id'       => 'post_author',
                'title'    => esc_html__('Author', 'Lawsight'),
                'subtitle' => esc_html__('Display the Author for blog post.', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true
            ),
            array(
                'id'       => 'post_comment',
                'title'    => esc_html__('Comment', 'Lawsight'),
                'subtitle' => esc_html__('Display the Comment for blog post.', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true
            ),
            array(
                'id'       => 'post_category',
                'title'    => esc_html__('Category', 'Lawsight'),
                'subtitle' => esc_html__('Display the Category for blog post.', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true
            ),
            array(
                'id'       => 'post_tag',
                'title'    => esc_html__('Tags', 'Lawsight'),
                'subtitle' => esc_html__('Display the Tag for blog post.', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true
            ),
            array(
                'id'       => 'post_navigation',
                'title'    => esc_html__('Navigation', 'Lawsight'),
                'subtitle' => esc_html__('Display the Navigation for blog post.', 'Lawsight'),
                'type'     => 'switch',
                'default'  => false,
            ),
            array(
                'title' => esc_html__('Social', 'Lawsight'),
                'type'  => 'section',
                'id' => 'social_section',
                'indent' => true,
            ),
            array(
                'id'       => 'post_social_share',
                'title'    => esc_html__('Social', 'Lawsight'),
                'subtitle' => esc_html__('Display the Social Share for blog post.', 'Lawsight'),
                'type'     => 'switch',
                'default'  => false,
            ),
            array(
                'id'       => 'social_facebook',
                'title'    => esc_html__('Facebook', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true,
                'indent' => true,
                'required' => array( 0 => 'post_social_share', 1 => 'equals', 2 => '1' ),
            ),
            array(
                'id'       => 'social_twitter',
                'title'    => esc_html__('Twitter', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true,
                'indent' => true,
                'required' => array( 0 => 'post_social_share', 1 => 'equals', 2 => '1' ),
            ),
            array(
                'id'       => 'social_pinterest',
                'title'    => esc_html__('Pinterest', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true,
                'indent' => true,
                'required' => array( 0 => 'post_social_share', 1 => 'equals', 2 => '1' ),
            ),
            array(
                'id'       => 'social_linkedin',
                'title'    => esc_html__('LinkedIn', 'Lawsight'),
                'type'     => 'switch',
                'default'  => true,
                'indent' => true,
                'required' => array( 0 => 'post_social_share', 1 => 'equals', 2 => '1' ),
            ),
        )
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Portfolio', 'Lawsight'),
    'icon'       => 'el el-briefcase',
    'fields'     => array(
        array(
            'id'       => 'portfolio_display',
            'type'     => 'button_set',
            'title'    => esc_html__('Portfolio', 'Lawsight'),
            'options'  => array(
                'on' => esc_html__('On', 'Lawsight'),
                'off' => esc_html__('Off', 'Lawsight'),
            ),
            'default'  => 'on',
        ),
        array(
            'id'       => 'sg_portfolio_title',
            'type'     => 'button_set',
            'title'    => esc_html__('Page Title Type', 'Lawsight'),
            'options'  => array(
                'default' => esc_html__('Default', 'Lawsight'),
                'custom_text' => esc_html__('Custom Text', 'Lawsight'),
            ),
            'default'  => 'default',
            'required' => array( 0 => 'portfolio_display', 1 => 'equals', 2 => 'on' ),
            'force_output' => true
        ),
        array(
            'id'      => 'sg_portfolio_title_text',
            'type'    => 'text',
            'title'   => esc_html__('Page Title Text', 'Lawsight'),
            'default' => 'Single Portfolio',
            'required' => array( 0 => 'sg_portfolio_title', 1 => 'equals', 2 => 'custom_text' ),
        ),
        array(
            'id'      => 'portfolio_slug',
            'type'    => 'text',
            'title'   => esc_html__('Portfolio Slug', 'Lawsight'),
            'default' => '',
            'desc'     => 'Default: portfolio',
            'required' => array( 0 => 'portfolio_display', 1 => 'equals', 2 => 'on' ),
            'force_output' => true
        ),
        array(
            'id'      => 'portfolio_name',
            'type'    => 'text',
            'title'   => esc_html__('Portfolio Name', 'Lawsight'),
            'default' => '',
            'desc'     => 'Default: Portfolio',
            'required' => array( 0 => 'portfolio_display', 1 => 'equals', 2 => 'on' ),
            'force_output' => true
        ),
        array(
            'id'    => 'archive_portfolio_link',
            'type'  => 'select',
            'title' => esc_html__( 'Custom Archive Page Link', 'Lawsight' ), 
            'data'  => 'page',
            'args'  => array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ),
            'required' => array( 0 => 'portfolio_display', 1 => 'equals', 2 => 'on' ),
            'force_output' => true
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Service', 'Lawsight'),
    'icon'       => 'el el-cog',
    'fields'     => array(
        array(
            'id'       => 'service_display',
            'type'     => 'button_set',
            'title'    => esc_html__('Service', 'Lawsight'),
            'options'  => array(
                'on' => esc_html__('On', 'Lawsight'),
                'off' => esc_html__('Off', 'Lawsight'),
            ),
            'default'  => 'on',
        ),
        array(
            'id'       => 'sg_service_title',
            'type'     => 'button_set',
            'title'    => esc_html__('Page Title Type', 'Lawsight'),
            'options'  => array(
                'default' => esc_html__('Default', 'Lawsight'),
                'custom_text' => esc_html__('Custom Text', 'Lawsight'),
            ),
            'default'  => 'default',
            'required' => array( 0 => 'service_display', 1 => 'equals', 2 => 'on' ),
            'force_output' => true
        ),
        array(
            'id'      => 'sg_service_title_text',
            'type'    => 'text',
            'title'   => esc_html__('Page Title Text', 'Lawsight'),
            'default' => 'Single Service',
            'required' => array( 0 => 'sg_service_title', 1 => 'equals', 2 => 'custom_text' ),
        ),
        array(
            'id'      => 'service_slug',
            'type'    => 'text',
            'title'   => esc_html__('Service Slug', 'Lawsight'),
            'default' => '',
            'desc'     => 'Default: service',
            'required' => array( 0 => 'service_display', 1 => 'equals', 2 => 'on' ),
            'force_output' => true
        ),
        array(
            'id'      => 'service_name',
            'type'    => 'text',
            'title'   => esc_html__('Service Name', 'Lawsight'),
            'default' => '',
            'desc'     => 'Default: Services',
            'required' => array( 0 => 'service_display', 1 => 'equals', 2 => 'on' ),
            'force_output' => true
        ),
        array(
            'id'    => 'archive_service_link',
            'type'  => 'select',
            'title' => esc_html__( 'Custom Archive Page Link', 'Lawsight' ), 
            'data'  => 'page',
            'args'  => array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ),
            'required' => array( 0 => 'service_display', 1 => 'equals', 2 => 'on' ),
            'force_output' => true
        ),
    )
));

/*--------------------------------------------------------------
# Shop
--------------------------------------------------------------*/
if(class_exists('Woocommerce')) {
    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Shop', 'Lawsight'),
        'icon'   => 'el el-shopping-cart',
    ));

    Redux::setSection($opt_name, array(
        'title' => esc_html__('Product Archive', 'Lawsight'),
        'icon'  => 'el-icon-pencil',
        'subsection' => true,
        'fields'     => array_merge(
            lawsight_sidebar_pos_opts([ 'prefix' => 'shop_']),
            array(
                array(
                    'id'      => 'shop_featured_img_size',
                    'type'    => 'text',
                    'title'   => esc_html__('Featured Image Size', 'Lawsight'),
                    'default' => '',
                    'subtitle' => 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Default: 370x300 (Width x Height)).',
                ),
                array(
                    'title'         => esc_html__('Products displayed per row', 'Lawsight'),
                    'id'            => 'products_columns',
                    'type'          => 'slider',
                    'subtitle'      => esc_html__('Number product to show per row', 'Lawsight'),
                    'default'       => 3,
                    'min'           => 2,
                    'step'          => 1,
                    'max'           => 5,
                    'display_value' => 'text',
                ),
                array(
                    'title'         => esc_html__('Products displayed per page', 'Lawsight'),
                    'id'            => 'product_per_page',
                    'type'          => 'slider',
                    'subtitle'      => esc_html__('Number product to show', 'Lawsight'),
                    'default'       => 9,
                    'min'           => 3,
                    'step'          => 1,
                    'max'           => 50,
                    'display_value' => 'text'
                ),
            )
        )
    ));

    Redux::setSection($opt_name, array(
        'title' => esc_html__('Single Product', 'Lawsight'),
        'icon'  => 'el-icon-pencil',
        'subsection' => true,
        'fields'     => array_merge(
            array(
                array(
                    'id'       => 'single_img_size',
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Image Size', 'Lawsight'),
                    'unit'     => 'px',
                ),
                array(
                    'id'       => 'sg_product_ptitle',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Page Title Type', 'Lawsight'),
                    'options'  => array(
                        'default' => esc_html__('Default', 'Lawsight'),
                        'custom_text' => esc_html__('Custom Text', 'Lawsight'),
                    ),
                    'default'  => 'default',
                ),
                array(
                    'id'      => 'sg_product_ptitle_text',
                    'type'    => 'text',
                    'title'   => esc_html__('Page Title Text', 'Lawsight'),
                    'default' => 'Shop Details',
                    'required' => array( 0 => 'sg_product_ptitle', 1 => 'equals', 2 => 'custom_text' ),
                ),
                array(
                    'id'       => 'product_title',
                    'type'     => 'switch',
                    'title'    => esc_html__('Product Title', 'Lawsight'),
                    'default'  => false
                ),
                array(
                    'id'       => 'product_social_share',
                    'type'     => 'switch',
                    'title'    => esc_html__('Social Share', 'Lawsight'),
                    'default'  => false
                ),
            )
        )
    ));
}