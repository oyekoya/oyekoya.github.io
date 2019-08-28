<?php
if ( ! defined( 'WPINC' ) ) {
	die;
} 
include_once EDS_BPM_Loader::$abs_path. '/classes/eds-bpm-config.php';
include_once EDS_BPM_Loader::$abs_path. '/classes/eds-bpm-frontend-db.php';
include_once EDS_BPM_Loader::$abs_path. '/classes/eds-bpm-behance.php';
 
       
if(!class_exists("EDS_BPM_Frontend_Layout_Manager")){
	class EDS_BPM_Frontend_Layout_Manager{
		
		var $enable_pretty_url = null;      
		public function __construct(){
			 
			//Getting the flag for pretty url from configuration 				
			$this->enable_pretty_url = get_option('permalink_structure');
		}    
		
		public function initialize($attributes, $content = null){	
			if(is_singular()){	
				$db = new EDS_BPM_Frontend_DB();
				global  $wp_rewrite;
				
				if(is_front_page() && !is_home())
					$project_identifier = !empty($_GET["ch_eds_bpid"]) ? $_GET["ch_eds_bpid"]: null;
				else
					$project_identifier = get_query_var("eds_bpid", null); //this can be id or slug			
				
				
				
				if($project_identifier!=null){
					
					$output = $this->generate_single_project_layout($project_identifier);
					
					wp_localize_script( 'eds-bpm-site-js', 'eds_bpm_view_type', 'single_project' );
					
					
				}else{
						
					extract( shortcode_atts( array(
						'layout_type' => '',
						'id' =>''						
					), $attributes ) );
					
					wp_localize_script( 'eds-bpm-site-js', 'eds_bpm_view_type', $layout_type );
					wp_localize_script( 'eds-bpm-site-js', 'eds_bpm_attr', $attributes );
					
					switch($layout_type){
						case 'single_project':
							$output = $this->generate_single_project_layout( $id );				
							break;
						
						case 'single_cat':
							$output = $this->generate_single_cat_layout($layout_type,$attributes);
							break;
							
						case 'multi_cat':
							$output = $this->generate_multi_cat_layout($layout_type,$attributes);
							break;	
					}
				}
				return $output;
			}else{
				return "";
			}
			
		}
		
		private function generate_multi_cat_layout($layout,$attributes){
			$db = new EDS_BPM_Frontend_DB();
			
			$config = EDS_BPM_Config::get_advanced_config();
			$general_config = EDS_BPM_Config::get_general_config();
			
			$view_on_behance = (isset($general_config['view_project_on_behance']) && $general_config['view_project_on_behance']=="yes");
			
			$open_in_different_tab = (isset($general_config['open_in_different_tab']) && $general_config['open_in_different_tab']=="yes");
			
			$url = $this->get_current_page_url();
			
			$show_all = false;
			
			//Getting the site url and 
			$siteUrl = get_home_url();		
			$currentPost = get_post(get_the_ID());
			$enable_pretty_url = $this->enable_pretty_url;
			
			extract( shortcode_atts( array(
				'id' => '',
				'featured' => 'n',								
				'order_by' => 'id',
				'ordering' => 'asc'							
			), $attributes ) );
	
			
			//$id_list_string
			$id_list = explode(",",$id);
			
			if(in_array("-1", $id_list)){
				$show_all = true;		
			}
			
			$categories = $db->get_category_list($id_list, $show_all);
			 
			$projects = $db->get_project_list($layout, $id_list, $show_all, $featured, $order_by, $ordering);			
		
			ob_start();
			include EDS_BPM_Loader::$abs_path. '/layouts/eds-bpm-multi-cat.php';		
			$output = ob_get_contents();
			ob_end_clean();
			
			return $output;
		}
		
		
		private function generate_single_cat_layout($layout, $attributes){
			$db = new EDS_BPM_Frontend_DB();
			
			$config = EDS_BPM_Config::get_advanced_config();	
			$general_config = EDS_BPM_Config::get_general_config();
			
			$view_on_behance = (isset($general_config['view_project_on_behance']) && $general_config['view_project_on_behance']=="yes");
			$open_in_different_tab = (isset($general_config['open_in_different_tab']) && $general_config['open_in_different_tab']=="yes");
			
			$url = $this->get_current_page_url();
			
			//Getting the site url and 
			$siteUrl = get_home_url();		
			$currentPost = get_post(get_the_ID());
			$enable_pretty_url = $this->enable_pretty_url;
			
			extract( shortcode_atts( array(
				'id' => '',
				'featured' => 'n',
				'mosaic_style' => '1',			
				'sct' => 'y',
				'scd' => 'y',
				'sci' => 'y',			
				'order_by' => 'id',
				'ordering' => 'asc'										
			), $attributes ) );
			
			$category = $db->get_single_category($id);
			
			$projects = $db->get_project_list($layout, $id, null, $featured, $order_by, $ordering);		
		
			ob_start();
			include EDS_BPM_Loader::$abs_path. '/layouts/eds-bpm-single-cat.php';		
			$output = ob_get_contents();
			ob_end_clean();
			
			return $output;		
		}
		
		private function generate_single_project_layout($project_identifier){
				
			$db = new EDS_BPM_Frontend_DB();
			$behance = new EDS_BPM_Behance();
					
			$config = EDS_BPM_Config::get_advanced_config();	
			$nav_btn_config = EDS_BPM_Config::get_navigation_button_config();
			
			$project = $db->get_single_project($project_identifier);
			
			//Getting the site url and
			$siteUrl = get_home_url();
			$currentPost = get_post(get_the_ID());
			$enable_pretty_url = $this->enable_pretty_url;			
			$prev_project = null;
			$next_project = null;
			if(isset($project)) {
				$project_order_by = (isset($nav_btn_config['prev_next_project_order']) && !empty($nav_btn_config['prev_next_project_order']) ) ? $nav_btn_config['prev_next_project_order'] : 'doc';  
				$prev_project = $db->get_prev_project($project, $project_order_by);
				$next_project = $db->get_next_project($project, $project_order_by);
			}			
			
			$response = $behance->get_behance_project($project->b_project_id);
			
			$status = $response->status;
			$b_pr_data = $response->data;
			
			ob_start();
			include EDS_BPM_Loader::$abs_path. '/layouts/eds-bpm-single-project.php';
			$output = ob_get_contents();
			ob_end_clean();
			
			return $output;
			
		}
		
		private function get_current_page_url() {
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
		
	}
}