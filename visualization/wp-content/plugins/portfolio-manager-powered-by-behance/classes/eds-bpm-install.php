<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
if(!class_exists("EDS_BPM_Install")){
class EDS_BPM_Install{
	
	public function install(){
		include_once EDS_BPM_Loader::$abs_path . '/classes/eds-bpm-db.php';
		
		$db = new EDS_BPM_DB();		
		$db->create_category_table();
		$db->create_project_table();
		$db->create_default_category();
		
		global $bpm_db_version;		
		add_option( 'bpm_db_version', $bpm_db_version );
		
	}
	
	
}
}