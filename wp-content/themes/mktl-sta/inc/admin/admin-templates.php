<?php

if( !defined( 'ABSPATH' ) )
	exit; 

class lawsight_Admin_Templates extends lawsight_Base{

	public function __construct() {
		$this->add_action( 'admin_menu', 'register_page', 20 );
	}
 
	public function register_page() {
		add_submenu_page(
			'pxlart',
		    esc_html__( 'Templates', 'Lawsight' ),
		    esc_html__( 'Templates', 'Lawsight' ),
		    'manage_options',
		    'edit.php?post_type=pxl-template',
		    false
		);
	}
}
new lawsight_Admin_Templates;
