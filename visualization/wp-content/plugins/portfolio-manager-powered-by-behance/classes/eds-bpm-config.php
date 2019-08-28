<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}     
  
if(!class_exists("EDS_BPM_Config")){ 
class EDS_BPM_Config{     
	 
	public static $project_table = "bpm_projects";
	public static $category_table = "bpm_categories";
	
	public static $eds_bpm_top_menu_slug = "eds-bpm-top-menu";
	public static $eds_bpm_new_project_slug = "eds-bpm-new-project";
	public static $eds_bpm_category_menu_slug = "eds-bpm-cat-menu";
	
	public static $eds_bpm_cofig_menu_slug = "eds-bpm-config-menu";
	
	public static $general_config_key = "eds-bpm-general-config";
	public static $advanced_config_key = "eds-bpm-advanced-config";
	public static $general_section = "eds-bpm-general-section";
	public static $advanced_section = "eds-bpm-advanced-section";
	
	public static $navigation_button_config_key = "eds-bpm-navigation-btn";
	public static $navigation_button_section = "eds-bpm-navigation-btn-section";
	
	public static $result_per_page = 10;
	
	public static $advanced_config = null;
	public static $general_config = null;
	public static $navigation_button_config = null;	
	
	public static function get_js_messages() {
		return array(
				'chooseImage' => __('Choose Image', 'eds-bpm'),
				'selectCategory' => __('Please select atleast one Category','eds-bpm'),
				'deleteSelectedCategory' => __('Are you sure, you wish to delete the selected category(s)?','eds-bpm'),
				'permanentDeleteSelectedCategory' => __('Are you sure, you wish to permanently delete the selected category?','eds-bpm'),
				'selectOneProject' => __('Please select atleast one Project','eds-bpm'),
				'deleteSelectedProject' => __('Are you sure, you wish to delete the selected project(s)?','eds-bpm'),
				'permanentDeleteSelectedProject' => __('Are you sure, you wish to permanently delete the selected project(s)?','eds-bpm'),
				'provideUserId' => __('Please provide user id.','eds-bpm'),
				'importingProjects' => __('Importing Projects...','eds-bpm'),
				'projectsImported' => __('Project(s) Imported.','eds-bpm'),
				'unableImportingProjects' => __('Unable to import projects, please check the Behance User Id and Behance API key in settings.','eds-bpm'),
				'problemImportingProjects' => __('A problem occured while importing projects. Please try again later.','eds-bpm'),
				'noProjectAvailable' => __('No Project available to save. kindly import the projects first.','eds-bpm'),
				'savingProjects' => __('Saving Projects, It might take some time...','eds-bpm'),
				'projectsSaved' => __('Projects saved successfully, refreshing page now.','eds-bpm'),
				'problemSavingProjects' => __('Problem occured while saving projects. Please try again after some time. If the problem persist, please','eds-bpm'),
				'contactPluginAdministor' => __('contact plugin administrator','eds-bpm'),
				'behanceProjectId' => __('Please enter Behance Project ID','eds-bpm'),
				'inputNumericValue' => __('Please enter a numeric value','eds-bpm'),
				'portfolioManager' => __('Portfolio Manager - Powered by Behance','eds-bpm'),
				'authorName' => __('Eleopard Design Studios Pvt. Ltd.','eds-bpm'),
				
		); 
	}
	
	public static function get_advanced_config(){
		if(self::$advanced_config ==null){
			self::$advanced_config = array();
				
			if(get_option( self::$advanced_config_key ) === false){			
			    self::$advanced_config = array_merge( array(
			        'project_background_color' => '#f1f1f1',
			    	'loading_icon_color' => '#333333',
			    	'show_project_title' => 'yes',
			    	'show_creative_fields' =>'yes',
			    	'show_project_by' => 'yes',
			    	'show_about_project' => 'yes',
			    	'show_publish_date' => 'yes',
			    	'show_views' => 'yes',
			    	'show_appreciations' => 'yes',
			    	'show_comments' => 'yes',			    	
			    	'show_tags' => 'yes',
			    	'show_tools_used' => 'yes',    	
			    	'show_copyright_info' => 'yes',
			    	'eds_bpm_custom_css' => ''		    	
			        ), self::$advanced_config ); 
			}else
				self::$advanced_config = (array) get_option( EDS_BPM_Config::$advanced_config_key);
		}
				
		return self::$advanced_config;		
	}
	
	
	public static function get_navigation_button_config(){
		if(self::$navigation_button_config ==null){
			self::$navigation_button_config = array();
	
			if(get_option( self::$navigation_button_config_key ) === false){
				self::$navigation_button_config = array_merge( array(
						'show_prev_next_btn' => 'yes',
						'prev_next_project_order' => 'doc',
						'prev_btn_text' =>'Prev',
						'prev_btn_text_color' => '#ffffff',
						'prev_btn_bg_color' => '#333333',
						'next_btn_text' => 'Next',
						'next_btn_text_color' => '#ffffff',
						'next_btn_bg_color' => '#333333',
						'prev_next_btn_style' => 'default',
						'prev_next_btn_position' => 'top',
						'prev_next_btn_icon' => 'yes'						
				), self::$navigation_button_config );
			}else
				self::$navigation_button_config = (array) get_option( EDS_BPM_Config::$navigation_button_config_key);
		}
	
		return self::$navigation_button_config;
	}
	
	public static function get_general_config(){
		if(self::$general_config ==null){
			
			self::$general_config = array();
						
			if(get_option( self::$general_config_key ) === false){				
				self::$general_config = array_merge( array(
			        'behance_api_key' => '',			    	
			    	'result_per_page' => self::$result_per_page,
					'view_project_on_behance' => '',
					'open_in_different_tab' => 'yes',			    			    			    	
			        ), self::$general_config );
			}else{
				self::$general_config = (array) get_option( EDS_BPM_Config::$general_config_key);
			}
				
		}
		
		return self::$general_config;
	}
	
	
	public static function get_current_page_url() {
	 	$pageURL = 'http';
	 	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 	$pageURL .= "://";
	 	if ($_SERVER["SERVER_PORT"] != "80") {
	  		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 	} else {
	  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 	}
	 	return $pageURL;
	}
	
	public static function trim_all( $str , $what = NULL , $with = ' ' )
	{
	    if( $what === NULL )
	    {
	        //  Character      Decimal      Use
	        //  "\0"            0           Null Character
	        //  "\t"            9           Tab
	        //  "\n"           10           New line
	        //  "\x0B"         11           Vertical Tab
	        //  "\r"           13           New Line in Mac
	        //  " "            32           Space
	       
	        $what   = "\\x00-\\x20";    //all white-spaces and control chars
	    }
	   
	    return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
	}
	
	public static function is_curl_loaded() {
    	return extension_loaded( 'curl' );		
  	}
}
}