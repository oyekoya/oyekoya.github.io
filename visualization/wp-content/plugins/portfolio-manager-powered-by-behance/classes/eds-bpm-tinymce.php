<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

include_once dirname(__FILE__).'/eds-bpm-db.php';

if(!class_exists("EDS_BPM_TinyMCE")){
class EDS_BPM_TinyMCE{
	
	public function __construct(){
		
	}
	
	function add_edsbportman_tinymce_plugin($plugin_array){
	
		$plugin_array['edsbportman'] = plugin_dir_url(__FILE__).'../js/eds-bpm-tinymce.js';
		return $plugin_array;
	
	}
	
	function register_edsbportman_button($buttons){
		
		array_push($buttons, "|", "edsbportman");
		return $buttons;
	
	}
	
	function eds_refresh_mce($ver) {
	  $ver += 3;
	  return $ver;
	}
	
	function add_edsbportman_button() {
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;
		if ( get_user_option('rich_editing') == 'true') {
			add_filter('mce_external_plugins', array($this, 'add_edsbportman_tinymce_plugin'));
			add_filter('mce_buttons', array($this, 'register_edsbportman_button'));
		}
	}	
	
	function get_layout_data(){
		$response = array();
		$db = new EDS_BPM_DB();
		$layout_type = isset($_POST['layout-type'])?$_POST['layout-type']:'';
		switch($layout_type){
			case 'single_project':
				$response = $db->get_project_list();
				break;
			
			case 'single_cat':
				$response = $db->get_layout_category_list();
				break;
				
			case 'multi_cat':
				$response = $db->get_layout_category_list();
				break;
		}
		echo json_encode($response);
		wp_die();
	}
	
	function get_popup(){
		include_once dirname(__FILE__).'/../includes/eds-bpm-tinymce-popup.php';
		wp_die();
	}
}
}