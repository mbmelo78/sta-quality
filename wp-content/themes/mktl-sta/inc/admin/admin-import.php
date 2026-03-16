<?php
/**
* The lawsight_Admin_Import class
*/

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class lawsight_Admin_Import extends lawsight_Admin_Page {

	public function __construct() {

		$this->id = 'pxlart-import-demos';
		$this->page_title = esc_html__( 'Import Demos', 'Lawsight' );
		$this->menu_title = esc_html__( 'Import Demos', 'Lawsight' );
		$this->parent = 'pxlart';
		//$this->position = '10';

		parent::__construct();
	}

	public function display() {
		include_once( get_template_directory() . '/inc/admin/views/admin-demos.php' );
	}


	public function save() {

	}
}
new lawsight_Admin_Import;