<?php
require_once dirname(__FILE__) . '/classes/eds-bpm-config.php';  

if(! defined('WP_UNINSTALL_PLUGIN'))
	exit();

try{
	//Removing Registered Options
	delete_option(EDS_BPM_Config::$general_config_key);
	delete_option(EDS_BPM_Config::$advanced_config_key);
	delete_option(EDS_BPM_Config::$navigation_button_config_key);
	delete_option('bpm_db_version'); 
	   
	//Removing plugin related tables
	global $wpdb;
			
	$category_table = $wpdb->prefix . EDS_BPM_Config::$category_table;
	$project_table = $wpdb->prefix . EDS_BPM_Config::$project_table;

	$wpdb->query("DROP TABLE IF EXISTS `$category_table`");
	$wpdb->query("DROP TABLE IF EXISTS `$project_table`");
	
	//Unsetting the rewrite rule 
	global $wp_rewrite;
	
	$rules = $wp_rewrite->rules;
	
	if (isset( $rules['(.?.+?)/bproject/(.?.+?)/?$'] ) ) {			
		unset($rules['(.?.+?)/bproject/(.?.+?)/?$']);	
	}	
	if (isset( $rules['([^/]+)/bproject/(.?.+?)/?$'] ) ) {			
		unset($rules['([^/]+)/bproject/(.?.+?)/?$']);			
	}
	$wp_rewrite->flush_rules();
}catch(Exception $e){}  
