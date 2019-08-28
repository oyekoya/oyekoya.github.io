<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}


include_once EDS_BPM_Loader::$abs_path . '/classes/eds-bpm-config.php';
include_once EDS_BPM_Loader::$abs_path . '/classes/eds-bpm-project-manager.php';
include_once EDS_BPM_Loader::$abs_path . '/classes/eds-bpm-category-manager.php';
include_once EDS_BPM_Loader::$abs_path . '/classes/eds-bpm-configuration-manager.php';

if(!class_exists("EDS_BPM_Admin")){
class EDS_BPM_Admin{ 
	
	public function __construct(){
		
	}
	
	public function add_bpm_menu(){
		$project_manager = new EDS_BPM_Project_Manager();
		$category_manager = new EDS_BPM_Category_Manager();
		$config_manager = EDS_BPM_Configuration_Manager::get_instance();
		
		$page_hook1 = add_menu_page( /*$page_title*/__('Portfolio Manager - Projects', 'eds-bpm'),
					/*$menu_title*/ __('Portfolio Manager','eds-bpm'),
					/*$capability*/'manage_options',
					/*$menu_slug*/EDS_BPM_Config::$eds_bpm_top_menu_slug,
					/*$function*/array($project_manager, 'initialize'),
					/*$icon_url*/plugin_dir_url(__FILE__).'../images/eds-bpm-16x16.png');

		add_action("admin_print_scripts-" . $page_hook1 , array( $this, 'eds_bpm_add_scripts'));
        add_action("admin_print_styles-".   $page_hook1 , array( $this, 'eds_bpm_add_css') );
        
        
        $page_hook2 = add_submenu_page( /* $parent_slug */ EDS_BPM_Config::$eds_bpm_top_menu_slug,
        			/*$page_title*/__('Portfolio Manager - Projects', 'eds-bpm'),
					/*$menu_title*/ __('All Projects','eds-bpm'),
					/*$capability*/'manage_options',
					/*$menu_slug*/EDS_BPM_Config::$eds_bpm_top_menu_slug,
					/*$function*/array($project_manager, 'initialize'));

		add_action("admin_print_scripts-" . $page_hook2 , array( $this, 'eds_bpm_add_scripts'));
        add_action("admin_print_styles-".   $page_hook2 , array( $this, 'eds_bpm_add_css') );
        
        $page_hook3 = add_submenu_page( /* $parent_slug */ EDS_BPM_Config::$eds_bpm_top_menu_slug,
        			/*$page_title*/__('Portfolio Manager - New Project', 'eds-bpm'),
					/*$menu_title*/ __('Add New','eds-bpm'),
					/*$capability*/'manage_options',
					/*$menu_slug*/EDS_BPM_Config::$eds_bpm_new_project_slug,
					/*$function*/array($project_manager, 'initialize'));

		add_action("admin_print_scripts-" . $page_hook3 , array( $this, 'eds_bpm_add_scripts'));
        add_action("admin_print_styles-".   $page_hook3 , array( $this, 'eds_bpm_add_css') );
        
		
		$page_hook4 = add_submenu_page(/* $parent_slug */ EDS_BPM_Config::$eds_bpm_top_menu_slug, 
						/* $page_title */ __('Portfolio Manager - Categories', 'eds-bpm'), 
						/* $menu_title */__('Categories', 'eds-bpm'), 
						/* $capability */'manage_options', 
						/* $menu_slug */EDS_BPM_Config::$eds_bpm_category_menu_slug, 
						/* $function */ array($category_manager, 'initialize'));
		
		add_action("admin_print_scripts-" . $page_hook4 , array( $this, 'eds_bpm_add_scripts'));
        add_action("admin_print_styles-".   $page_hook4 , array( $this, 'eds_bpm_add_css') );
        
		
		$page_hook5 = add_submenu_page(/* $parent_slug */ EDS_BPM_Config::$eds_bpm_top_menu_slug, 
						/* $page_title */ __('Portfolio Manager - Settings', 'eds-bpm'), 
						/* $menu_title */__('Settings', 'eds-bpm'), 
						/* $capability */'manage_options', 
						/* $menu_slug */EDS_BPM_Config::$eds_bpm_cofig_menu_slug, 
						/* $function */ array($config_manager, 'init_configuration_page'));		
		
		add_action("admin_print_scripts-" . $page_hook5, array( $this, 'eds_bpm_add_scripts'));
        add_action("admin_print_styles-".   $page_hook5, array( $this, 'eds_bpm_add_css') );
		
	}
	
	public function eds_bpm_add_scripts(){
		do_action('eds_bpm_load_admin_scripts_on_page');
	}
	
	public function eds_bpm_add_css(){
		do_action('eds_bpm_load_admin_styles_on_page');	
	}
}
}