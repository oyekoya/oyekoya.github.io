<?php

if ( ! defined( 'WPINC' ) ) {
	die; 
}    

include_once dirname(__FILE__).'/eds-bpm-config.php';   
     
if(!class_exists("EDS_BPM_Loader")){
class EDS_BPM_Loader{
	public static $abs_path = null;
	public static $abs_file = null;
	public static $init_classes = null;
	     
	public function __construct($file_loc, $classes) {
		
	    self::$abs_path = dirname($file_loc);
	    self::$abs_file = $file_loc;
	    self::$init_classes = $classes;  	    
	}   
	 
	public function load(){
		
		
		//Registering activation hook to initialize the db and other requirements on activation
		register_activation_hook(self::$abs_file, array($this, 'plugin_install'));
		
		/* Checking for DB Updates */
		add_action('plugins_loaded', array($this, 'update_db'));
		
		/*Load Text Domain for translation */
		add_action('plugins_loaded', array($this, 'plugin_textdomain'));
		
		
		
		/*Adding permalink feature in the plugin*/
			$general_config = EDS_BPM_Config::get_general_config();	
			$enable_pretty_url = get_option('permalink_structure');				
			if($enable_pretty_url){		
				add_action( 'wp_loaded',array($this, 'eds_bpm_flush_rules'));
				add_filter( 'rewrite_rules_array',array($this, 'eds_bpm_insert_rewrite_rules'));
			}else{
				add_action( 'wp_loaded',array($this, 'eds_bpm_remove_additional_rule'));
				add_filter( 'rewrite_rules_array',array($this, 'eds_bpm_remove_rewrite_rules'));
				
			}
			
			add_filter( 'query_vars',array($this, 'eds_bpm_insert_query_vars'));
		
		if(is_admin()){
			include_once self::$abs_path . '/classes/eds-bpm-admin.php';
			include_once self::$abs_path . '/classes/eds-bpm-configuration-manager.php';
			include_once self::$abs_path . '/classes/eds-bpm-tinymce.php';
			include_once self::$abs_path . '/classes/eds-bpm-vcextension.php';
			
			//Starting Session//
			add_action('init',array($this, 'eds_bpm_start_session'), 1);

			//Adding Buffer Handler
			add_action('init',array($this, 'eds_bpm_output_buffer'), 1);
			
			//Checking for php version
			add_action( 'admin_notices', array( $this, 'php_version_check' ) );
			
			//Integrating with Visual Composer if available
			$vc_extension = new EDS_BPM_VCExtension();
			add_action('init',array($vc_extension, 'integrate_with_vc'), 1);			
			
			//Adding javascript and CSS related to admin section//
			add_action('admin_init', array($this, 'register_script_css_admin'));
			
			//Registering Options//
			$settings = EDS_BPM_Configuration_Manager::get_instance();
			add_action( 'init', array( $settings, 'load_configuration' ) );
			add_action('admin_init', array($settings, 'register_general_configuration'));
			add_action('admin_init', array($settings, 'register_navigation_button_configuration'));
			add_action('admin_init', array($settings, 'register_advanced_configuration'));
			
			
		
			//Registering the TinyMCE Button
			$tiny_mce = new EDS_BPM_TinyMCE();
			add_action('init', array($tiny_mce,'add_edsbportman_button'));
			add_filter( 'tiny_mce_version', array($tiny_mce,'eds_refresh_mce'));
			
			//Registering Ajax action to get the respective data
			add_action( 'wp_ajax_eds_bpm_get_popup', array($tiny_mce,'get_popup'));
			add_action( 'wp_ajax_eds_bpm_get_layout_data', array($tiny_mce,'get_layout_data'));
			
			//Registering Ajax action to import users
			add_action( 'wp_ajax_eds_bpm_import_projects', array($this,'import_projects'));
			add_action( 'wp_ajax_eds_bpm_save_imported_projects', array($this,'save_imported_projects'));
			
						
			//Adding Custom Actions to Enqueue CSS and JS//
			add_action( 'eds_bpm_load_admin_scripts_on_page',array($this,'eds_bpm_load_js_on_admin_side'), 1000000000);
			add_action( 'eds_bpm_load_admin_styles_on_page',array($this,'eds_bpm_load_css_on_admin_side'), 1000000000);
			
			//Adding Portfolio Manager Menu Item//
			$admin = new EDS_BPM_Admin();
			add_action('admin_menu', array($admin, 'add_bpm_menu'));
			
			
			
			
		}else{
			include_once self::$abs_path . '/classes/eds-bpm-frontend-layout-manager.php';
			
			$frontendLayoutManager = new EDS_BPM_Frontend_Layout_Manager();
			
			//Starting Session//
			add_action('init',array($this, 'eds_bpm_start_session'), 1);
			
			//Adding action to register the scripts
			add_action( 'wp_enqueue_scripts', array($this, 'register_script_css_site') );		
			
			add_shortcode('edsbportman',array($frontendLayoutManager, 'initialize'));					
			add_shortcode('edsbportmansp',array($frontendLayoutManager, 'initialize'));
			add_shortcode('edsbportmansc',array($frontendLayoutManager, 'initialize'));
			add_shortcode('edsbportmanmc',array($frontendLayoutManager, 'initialize'));	
			
		}
		
	}
	
	public function eds_bpm_start_session(){
		if(!session_id()) {
	    	session_start();
	    }
	}
	
	public function eds_bpm_output_buffer(){
		ob_start();
	}
	
	
	
	public function plugin_install() {
		include_once self::$abs_path . '/classes/eds-bpm-install.php';	 
	    $installer = new EDS_BPM_Install();
	    $installer->install();
	}
	
	
	public function update_db() {
		
		global $bpm_db_version;
		
		$installed_version = get_option( 'bpm_db_version' );
		
		if( $installed_version == FALSE ) {
							
			add_option( 'bpm_db_version', '1.0' );
			
			if( $bpm_db_version != '1.0' ) {
				
				include_once self::$abs_path . '/classes/eds-bpm-db.php';
				$db = new EDS_BPM_DB();
				
				if( $db->update_database()) {
					update_option( 'bpm_db_version', $bpm_db_version );
				}
					
			}
			
		} else {
			
			if( $installed_version != $bpm_db_version ) {				
				include_once self::$abs_path . '/classes/eds-bpm-db.php';
				$db = new EDS_BPM_DB();
				
				if( $db->update_database()) {
					update_option( 'bpm_db_version', $bpm_db_version );
				}
					
			} 
		}
				
	}
	
	 
	
	public function plugin_textdomain() {
	    load_plugin_textdomain('eds-bpm', false, dirname(plugin_basename(self::$abs_file)) . '/translations');
	}
		
	public function register_script_css_site(){
		wp_register_style( 'eds-bpm-project-view',plugin_dir_url(__FILE__).'../css/project_view.css');		
		wp_register_style( 'material-design',plugin_dir_url(__FILE__).'../css/material-design-iconic-font.min.css');		
		wp_register_style( 'eds-bpm-mosaic-css',plugin_dir_url(__FILE__).'../css/mosaic_style.css');
		wp_register_style( 'eds-bpm-site-css',plugin_dir_url(__FILE__).'../css/eds-bpm-site.css');		
		
		wp_enqueue_style( 'eds-bpm-mosaic-css' );
		wp_enqueue_style( 'eds-bpm-site-css' );		
		wp_enqueue_style( 'eds-bpm-project-view' );
		wp_enqueue_style( 'material-design' );
		
		wp_register_script( 'eds-bpm-isotope-js',plugin_dir_url(__FILE__).'../js/isotope.pkgd.min.js',array('jquery'), null, true);
		wp_register_script( 'eds-bpm-site-js',plugin_dir_url(__FILE__).'../js/eds-bpm-site.js', array('jquery'), null, true);
		
		wp_enqueue_script( 'eds-bpm-isotope-js');
		wp_enqueue_script( 'eds-bpm-site-js');
		 		
	}
	
	public function register_script_css_admin(){
		wp_register_style( 'eds-bpm-bootstrap-css',plugin_dir_url(__FILE__).'../css/bootstrap.min.css');
		wp_register_style( 'eds-bpm-bootstrap-theme-css',plugin_dir_url(__FILE__).'../css/bootstrap-theme.min.css');
		wp_register_style( 'font-awsome',plugin_dir_url(__FILE__).'../css/font-awesome.min.css');
		wp_register_style( 'eds-bpm-admin-css',plugin_dir_url(__FILE__).'../css/eds-bpm-admin.css');
		wp_register_style( 'pagination-css',plugin_dir_url(__FILE__).'../css/pagination.css');
		wp_register_style( 'bootstrap-switch-css',plugin_dir_url(__FILE__).'../css/bootstrap-switch.min.css');
		
		
		wp_register_script( 'eds-bpm-bootstrap-js',plugin_dir_url(__FILE__).'../js/bootstrap.min.js',array('jquery'), null, true);
		wp_register_script( 'bootstrap-switch-js',plugin_dir_url(__FILE__).'../js/bootstrap-switch.min.js',array('jquery'), null, true);
		wp_register_script( 'eds-bpm-admin-js',plugin_dir_url(__FILE__).'../js/eds-bpm-admin.js',array('wp-color-picker'), null, true);
		wp_localize_script( 'eds-bpm-admin-js', 'edsBPMParam', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		wp_localize_script( 'eds-bpm-admin-js', 'edsBPMMessages', EDS_BPM_Config::get_js_messages());
		
				
	}
	
	public function eds_bpm_load_js_on_admin_side() { 
	    if(is_admin()){
	    	wp_enqueue_script( 'eds-bpm-bootstrap-js');
			wp_enqueue_script( 'bootstrap-switch-js');			
			wp_enqueue_script( 'eds-bpm-admin-js');			
	    }
	}
	
	public function eds_bpm_load_css_on_admin_side() {
		if(is_admin()){
		 	wp_enqueue_media();
			wp_enqueue_style( 'eds-bpm-bootstrap-css' );	
			wp_enqueue_style( 'eds-bpm-bootstrap-theme-css' );
			wp_enqueue_style( 'font-awsome' );
			wp_enqueue_style( 'bootstrap-switch-css' );
			wp_enqueue_style( 'eds-bpm-admin-css' );			
			wp_enqueue_style( 'pagination-css' );
			wp_enqueue_style( 'wp-color-picker' );
		}
	}	
	
	public function eds_bpm_flush_rules(){
		$rules = get_option( 'rewrite_rules' );

		if ( !(isset( $rules['(.?.+?)/bproject/(.?.+?)/?$']) && isset( $rules['([^/]+)/bproject/(.?.+?)/?$'] )) ) {
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}	
	}
	
	public function eds_bpm_insert_rewrite_rules($rules){
		$newrules = array();
		$newrules['(.?.+?)/bproject/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&eds_bpid=$matches[2]';
		$newrules['([^/]+)/bproject/(.?.+?)/?$'] = 'index.php?name=$matches[1]&eds_bpid=$matches[2]';		
		return $newrules + $rules;
	}
	
	public function eds_bpm_remove_rewrite_rules($rules){
		if (isset( $rules['(.?.+?)/bproject/(.?.+?)/?$'] ) ) {			
			unset($rules['(.?.+?)/bproject/(.?.+?)/?$']);			
		}		
		if (isset( $rules['([^/]+)/bproject/(.?.+?)/?$'] ) ) {			
			unset($rules['([^/]+)/bproject/(.?.+?)/?$']);			
		}
		return $rules;
	}
	
	public function eds_bpm_remove_additional_rule(){
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}
	
	public function eds_bpm_insert_query_vars($vars){
		$vars[] = "eds_bpid";
		return $vars;
	}
	
	public function php_version_check() {
		
		$showError = false;		
		$php_version = explode('.',phpversion());
		if( isset( $php_version ) && !empty( $php_version ) ){			
			if( isset( $php_version[0] ) && isset( $php_version[1] ) ){
				if( intval( $php_version[0] ) < 5 ) {
					$showError = true;
				} else if( intval( $php_version[0] ) == 5 && intval( $php_version[1] ) < 3 ) {
					$showError = true;				
				}
			}
			
		}
		if( $showError ):
		?>
		    <div class="notice notice-error is-dismissible">
		        <p><?php _e( "Portfolio Manager - Powered By Behance::: PHP version should be equal or higher than 5.3.0.", 'eds-bpm' ); ?></p>
		    </div>
	    <?php
	    endif;
	}
	
	public function import_projects(){
		
		$response = array(
			"success" => true,
			"msg" => "",
			"projects" => null
		);
		
		$user_id = isset( $_POST['user_id'] ) ? $_POST['user_id'] : '';
		
		if($user_id == '') {
			$response["success"] = false;
			$response["msg"] = __("User id not set", "eds-bpm");
			echo json_encode($response);
			wp_die();
		}
		
		include_once self::$abs_path . '/classes/eds-bpm-project-manager.php';
		
		$project_manager = new EDS_BPM_Project_Manager();
		
		$behance_data = $project_manager->get_user_projects($user_id);
		
		$response["projects"] = $behance_data;
		
		echo json_encode($response);
		
		wp_die();	
	}
	
	public function save_imported_projects(){
	
		$response = array(
				"success" => true,
				"msg" => ""				
		);
		
		$mappings = isset( $_POST['mappings'] ) ? $_POST['mappings'] : null;
	
		if( $mappings == null ) {
			$response["success"] = false;
			$response["msg"] = __("Insufficient data passed. Please try again.", "eds-bpm");
			echo json_encode($response);
			wp_die();
		}
	
		include_once self::$abs_path . '/classes/eds-bpm-project-manager.php';
	
		$project_manager = new EDS_BPM_Project_Manager();
	
		if( !$project_manager->save_imported_projects($projects, $mappings ) ) {
			$response["success"] = false;
			$response["msg"] = __("Problem in saving data. Please try again.", "eds-bpm");
		}	
		
		echo json_encode($response);	
		
		wp_die();
	}
	
}
}