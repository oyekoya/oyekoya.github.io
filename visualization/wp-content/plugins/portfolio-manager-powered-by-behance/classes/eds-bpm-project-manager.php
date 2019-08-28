<?php

if ( ! defined( 'WPINC' ) ) {
	die;
} 
   
include_once EDS_BPM_Loader::$abs_path. '/classes/eds-bpm-db.php';
include_once EDS_BPM_Loader::$abs_path. '/classes/eds-bpm-config.php';
include_once EDS_BPM_Loader::$abs_path. '/includes/project-filter-bean.php';
include_once EDS_BPM_Loader::$abs_path. '/includes/pagination.php';
include_once EDS_BPM_Loader::$abs_path. '/includes/response-bean.php';
include_once EDS_BPM_Loader::$abs_path. '/classes/eds-bpm-behance.php';

if(!class_exists("EDS_BPM_Project_Manager")){     
class EDS_BPM_Project_Manager{   
	var $general_config = null;
	var $url = null;  
	var $newUrl = null;
	public function __construct(){ 
		$this->general_config = EDS_BPM_Config::get_general_config();
		
		/* $this->url = $_SERVER['PHP_SELF'].'?page='.EDS_BPM_Config::$eds_bpm_top_menu_slug;
		$this->newUrl = $_SERVER['PHP_SELF'].'?page='.EDS_BPM_Config::$eds_bpm_new_project_slug; */		
		$this->url =  get_admin_url( null, 'admin.php' ) . '?page='.EDS_BPM_Config::$eds_bpm_top_menu_slug;
		$this->newUrl = get_admin_url( null, 'admin.php' ) . '?page='.EDS_BPM_Config::$eds_bpm_new_project_slug;
	}
		 
	
	public function initialize(){
		$page_slug = isset($_REQUEST['page'])?$_REQUEST['page']:EDS_BPM_Config::$eds_bpm_top_menu_slug;
		if($page_slug == EDS_BPM_Config::$eds_bpm_top_menu_slug){
			$layout = isset($_REQUEST['bpm-layout'])?$_REQUEST['bpm-layout']:'default';
			$task = isset($_REQUEST['bpm-task'])?$_REQUEST['bpm-task']:'default';
		}else{
			$layout = isset($_REQUEST['bpm-layout'])?$_REQUEST['bpm-layout']:'new';
			$task = isset($_REQUEST['bpm-task'])?$_REQUEST['bpm-task']:'new';
		}
		
		$filters = new Project_Filter_Bean();
		$data = null;
		$url = $this->url;
		$newUrl = $this->newUrl;		
		$bpm_id = isset($_REQUEST['bpm-id'])?$_REQUEST['bpm-id']:"0";	
		$default_template_url = EDS_BPM_Loader::$abs_path . '/layouts/eds-bpm-project-default.php';
		$edit_template_url = EDS_BPM_Loader::$abs_path . '/layouts/eds-bpm-project-edit.php';
		
		$curl_flag = EDS_BPM_Config::is_curl_loaded();
		
		
		
		switch($task){
			case 'new':				
				$data = $this->new_project();
				break;
			
			case 'edit':
				$data = $this->edit_project($bpm_id);
				break;
			
			case 'search':
				$filters->set_filters();
				$data = $this->get_projects($filters);					
				break;
			
			case 'clear':
				$filters->clear_filters();
				$data = $this->get_projects($filters);
				break;
			
			case 'default':
				$data = $this->get_projects($filters);
				break;		
			
			case 'save':
				$this->save_project();
				wp_redirect($url);exit;
				break;
			
			case 'publish':
				$this->publish_project();
				wp_redirect($url);exit;										
				break;
			
			case 'unpublish':
				$this->unpublish_project();
				wp_redirect($url);exit;									
				break;
				
			case 'setfeatured':
				$this->set_project_featured(1);
				wp_redirect($url);exit;										
				break;
				
			case 'unsetfeatured':
				$this->set_project_featured(0);
				wp_redirect($url);exit;					
				break;

			case 'sync':
				$this->synchronize_project();
				wp_redirect($url);exit;
				break;

			case 'delete':
				$this->delete_project();
				wp_redirect($url);exit;					
				break;

			case 'trash':
				$this->trash_project();
				wp_redirect($url);exit;					
				break;
				
		}
		
		include_once EDS_BPM_Loader::$abs_path . '/layouts/eds-bpm-projects.php';	
		
	}
	
	private function get_projects($filters){
		$db = new EDS_BPM_DB();
		$pagination = new EDS_BPM_Pagination();
		$data = array();
		$data['flag'] = Response_Bean::getFlag();
		$data['msg'] = Response_Bean::getMsg();
		
		//Unsetting the flags to avoid wrong message in the next request
		Response_Bean::unsetFlag();
		Response_Bean::unsetMsg();
		
		if(isset($this->general_config['result_per_page']))
			EDS_BPM_Config::$result_per_page = $this->general_config['result_per_page'];

		//Setting the pagination order
		$filters->set_pagination_order();
		
		//getting the project list		 
		$data['response'] = $response = $db->get_projects($filters);

		$data['pagination_code'] = $pagination->get_pagination_code(EDS_BPM_Config::$result_per_page, 
															$filters->get_page_number(), 
															$this->url.'&bpm-ob='.$filters->get_order_by().'&bpm-o='.$filters->get_ordering().'&bpm-pno=',
															$response->total_rows[0]);
			
		return $data;	
	}
	
	
	
	private function new_project(){
		$db = new EDS_BPM_DB();
		$behance = new EDS_BPM_Behance();
		
		//arrays to hold data
		$data = array();		
		
		//Local Variable
		$project = new stdClass();		
		$show_search = true;
		$b_pr_data = null;
		$status = '';
		$msg = null;
		$flag = null;
		$customCSS = null;
		$bp_search_id = null;
		$category_list = null;
		$b_fields ='';
		$sub_task = isset($_REQUEST['bpm-sub-task'])?$_REQUEST['bpm-sub-task']:null;		
		if($sub_task == null){
			$project->id = null;
		}
		if($sub_task == 'b_project_search'){
			
			$bp_search_id = isset($_REQUEST['bp-search-id'])?$_REQUEST['bp-search-id']:null;		
			$be_response = $behance->get_behance_project($bp_search_id);			
			$b_pr_data = $be_response->data;
			$status = trim($be_response->status);
			$msg = $be_response->msg;
			
			if($status == 'S')
			{
				$category_list = $db->get_category_list('published');			
				$project->id = null;
				$project->catid = null;
				$project->slug = null;
				$project->b_project_id = $b_pr_data['id'];
				$project->b_project_name = $b_pr_data['name'];
				$project->b_project_url = $b_pr_data['url'];
				if(isset($b_pr_data['covers']['404']) && trim($b_pr_data['covers']['404']) != '')
					$project->b_project_thumb = $b_pr_data['covers']['404'];
				else if (isset($b_pr_data['covers']['230']) && trim($b_pr_data['covers']['230']) != '')
					$project->b_project_thumb = $b_pr_data['covers']['230'];
				else if (isset($b_pr_data['covers']['202']) && trim($b_pr_data['covers']['202']) != '')
					$project->b_project_thumb = $b_pr_data['covers']['202'];
				else if (isset($b_pr_data['covers']['115']) && trim($b_pr_data['covers']['115']) != '')
					$project->b_project_thumb = $b_pr_data['covers']['115'];
				else 
					$project->b_project_thumb = plugin_dir_url(__FILE__).'../images/default-project-thumb.jpg';
					
				
				foreach ($b_pr_data['fields'] as $b_field){ 
					$b_fields = $b_fields. ', ' . $b_field;
				} 	
				$project->b_creative_fields = substr($b_fields, 2);
				$project->b_create_date = date('Y-m-d H:i:s', $b_pr_data['created_on']);
				$project->b_modified_timestamp = $b_pr_data['modified_on'];
				$project->status = null;
				
				
				//Adding CSS properties from behance
				$customCSS = ".bpm-sr-attribution{ background-image: url('".plugin_dir_url(__FILE__)."../images/by.svg'); } ";
				$customCSS .= ".bpm-sr-noncommercial{ background-image: url('".plugin_dir_url(__FILE__)."../images/nc.svg'); }";				
				$customCSS .= ".bpm-sr-noderivatives{ background-image: url('".plugin_dir_url(__FILE__)."../images/nd.svg'); } ";
				$customCSS .= ".bpm-sr-sharealike{ background-image: url('".plugin_dir_url(__FILE__)."../images/sa.svg'); } ";
				$customCSS .= ".bpm-sr-zero{ background-image: url('".plugin_dir_url(__FILE__)."../images/zero.svg'); } ";
				
				if(isset($b_pr_data['canvas_width']) && !empty($b_pr_data['canvas_width'])){
					$customCSS .= "#bop-project-left { max-width:". $b_pr_data['canvas_width'] ."px; } ";
				}else{
					$customCSS .= "#bop-project-left { max-width:724px; } ";
				}
					
				$customCSS .= "#bop-project-left .bop-primary-project-content{";
				
				if(isset($b_pr_data['styles']['background']['color']))
					$customCSS .= "	background-color: #" . $b_pr_data['styles']['background']['color'] . ";";
					
				if(isset($b_pr_data['styles']['background']['image']['url']))
					$customCSS .= "background-image: url('" . $b_pr_data['styles']['background']['image']['url'] ."');";
		
				if(isset($b_pr_data['styles']['background']['image']['repeat'])){
					$customCSS .= "background-repeat: ". $b_pr_data['styles']['background']['image']['repeat'] . ";";
						
					if($b_pr_data['styles']['background']['image']['repeat'] == "repeat")
						$customCSS .= "background-size: auto";	
					else
						$customCSS .= "background-size: 100% auto;";
				}
		
				if(isset($b_pr_data['styles']['background']['image']['position']))
					$customCSS .= "background-position:". $b_pr_data['styles']['background']['image']['position'] .";";
						
				$customCSS .= " overflow-x: hidden; } ";
				
				if( isset( $b_pr_data['styles']['text']['title'] ) ){
					$customCSS .= " .bop-primary-project-content .title{";
					
					foreach($b_pr_data['styles']['text']['title'] as $p_name => $p_value){
						$p_name = str_replace('_','-' , $p_name);
						$customCSS .= $p_name.':'.$p_value.';';
					}
					
					$customCSS .= " }";
				}
				
				if( isset( $b_pr_data['styles']['text']['subtitle'] ) ){
					$customCSS .= " .bop-primary-project-content .sub-title{";
					
					foreach($b_pr_data['styles']['text']['subtitle'] as $p_name => $p_value){
						$p_name = str_replace('_','-' , $p_name);
						$customCSS .= $p_name.':'.$p_value.';';
					}
					
					$customCSS .= " }";
				}
			
				if( isset( $b_pr_data['styles']['text']['paragraph'] )) {
					$customCSS .= " .bop-primary-project-content p, .bop-primary-project-content .main-text{";
					
					foreach($b_pr_data['styles']['text']['paragraph'] as $p_name => $p_value){
						if( $p_name != 'display') {
							$p_name = str_replace('_','-' , $p_name);
							$customCSS .= $p_name.':'.$p_value.';';
						}
					}
					
					$customCSS .= " }";
				}
				
				if( isset( $b_pr_data['styles']['text']['caption'] )) {
					$customCSS .= " .bop-primary-project-content .caption{";
					
					foreach($b_pr_data['styles']['text']['caption'] as $p_name => $p_value){
						$p_name = str_replace('_','-' , $p_name);
						$customCSS .= $p_name.':'.$p_value.';';
					}
					
					$customCSS .= " }";
				}
					
				if( isset( $b_pr_data['styles']['text']['link'] )) {
					
					$customCSS .= ".bop-primary-project-content a{";
					
					foreach($b_pr_data['styles']['text']['link'] as $p_name => $p_value){
						$p_name = str_replace('_','-' , $p_name);
						$customCSS .= $p_name.':'.$p_value.';';
					}
					
					$customCSS .= " }";
				}		
			}
		}else if($sub_task == 'b_clear_search'){
			$project->id = null;			
			$bp_search_id = null;
			$b_pr_data = null;
			$status = 'F';
			$msg = '';
		}
		
		if($status == 'S'){
			$flag = true;
		}
		else if($status == 'F'){
			$flag = false;
		}else{
			$flag = null;
		}
					
		$data['project'] = $project;
		$data['show_search'] = $show_search;
		$data['b_pr_data'] = $b_pr_data;
		$data['status'] = $status;		
		$data['msg'] = $msg;
		$data['flag'] = $flag;
		$data['customCSS'] = $customCSS;
		$data['bp_search_id'] = $bp_search_id;
		$data['category_list'] = $category_list;
		$data['sub_task'] = $sub_task;
		$data['b_fields'] = $b_fields;
		
		return $data;
		
	}
	
	private function edit_project($bpm_id){
		$db = new EDS_BPM_DB();
		$behance = new EDS_BPM_Behance();
		
		//arrays to hold data
		$data = array();		
		
		//Local Variable
		$project = new stdClass();	
		$show_search = false;
		$b_pr_data = null;
		$status = 'F';
		$msg = null;
		$flag = null;
		$customCSS = null;
		$bp_search_id = null;
		$category_list = null;
		$b_fields ='';
		$sub_task = null;
		
		$project = $db->get_project_details($bpm_id);
		
		$be_response = $behance->get_behance_project($project->b_project_id);
			
		$b_pr_data = $be_response->data;
		$status = $be_response->status;
		$msg = $be_response->msg;
		
		if($status == 'S')
		{
			$category_list = $db->get_category_list('published');			
			$project->b_project_id = $b_pr_data['id'];
			$project->b_project_name = $b_pr_data['name'];
			$project->b_project_url = $b_pr_data['url'];
			if(isset($b_pr_data['covers']['404']) && trim($b_pr_data['covers']['404']) != '')
				$project->b_project_thumb = $b_pr_data['covers']['404'];
			else if (isset($b_pr_data['covers']['230']) && trim($b_pr_data['covers']['230']) != '')
				$project->b_project_thumb = $b_pr_data['covers']['230'];
			else if (isset($b_pr_data['covers']['202']) && trim($b_pr_data['covers']['202']) != '')
				$project->b_project_thumb = $b_pr_data['covers']['202'];
			else if (isset($b_pr_data['covers']['115']) && trim($b_pr_data['covers']['115']) != '')
				$project->b_project_thumb = $b_pr_data['covers']['115'];
			else 
				$project->b_project_thumb = plugin_dir_url(__FILE__).'../images/default-project-thumb.jpg';
				
			$b_fields ='';
			foreach ($b_pr_data['fields'] as $b_field){ 
				$b_fields = $b_fields. ', ' . $b_field;
			} 	
			$project->b_creative_fields = substr($b_fields, 2);
			$project->b_create_date = date('Y-m-d H:i:s', $b_pr_data['created_on']);
			$project->b_modified_timestamp = $b_pr_data['modified_on'];
				
			//Adding CSS properties from behance
			$customCSS = ".bpm-sr-attribution{ background-image: url('".plugin_dir_url(__FILE__)."../images/by.svg'); } ";
			$customCSS .= ".bpm-sr-noncommercial{ background-image: url('".plugin_dir_url(__FILE__)."../images/nc.svg'); }";				
			$customCSS .= ".bpm-sr-noderivatives{ background-image: url('".plugin_dir_url(__FILE__)."../images/nd.svg'); } ";
			$customCSS .= ".bpm-sr-sharealike{ background-image: url('".plugin_dir_url(__FILE__)."../images/sa.svg'); } ";
			$customCSS .= ".bpm-sr-zero{ background-image: url('".plugin_dir_url(__FILE__)."../images/zero.svg'); } ";
			
			if(isset($b_pr_data['canvas_width']) && !empty($b_pr_data['canvas_width'])){
				$customCSS .= "#bop-project-left { max-width:". $b_pr_data['canvas_width'] ."px; } ";
			}else{
				$customCSS .= "#bop-project-left { max-width:724px; } ";
			}
				
			$customCSS .= "#bop-project-left .bop-primary-project-content{";
			
			if(isset($b_pr_data['styles']['background']['color']))
				$customCSS .= "	background-color: #" . $b_pr_data['styles']['background']['color'] . ";";
				
			if(isset($b_pr_data['styles']['background']['image']['url']))
				$customCSS .= "background-image: url('" . $b_pr_data['styles']['background']['image']['url'] ."');";
	
			if(isset($b_pr_data['styles']['background']['image']['repeat'])){
				$customCSS .= "background-repeat: ". $b_pr_data['styles']['background']['image']['repeat'] . ";";
					
				if($b_pr_data['styles']['background']['image']['repeat'] == "repeat")
					$customCSS .= "background-size: auto";	
				else
					$customCSS .= "background-size: 100% auto;";
			}
	
			if(isset($b_pr_data['styles']['background']['image']['position']))
				$customCSS .= "background-position:". $b_pr_data['styles']['background']['image']['position'] .";";
					
			$customCSS .= " overflow-x: hidden; } ";
			
			if( isset( $b_pr_data['styles']['text']['title'] ) ){
				$customCSS .= " .bop-primary-project-content .title{";
				
				foreach($b_pr_data['styles']['text']['title'] as $p_name => $p_value){
					$p_name = str_replace('_','-' , $p_name);
					$customCSS .= $p_name.':'.$p_value.';';
				}
				
				$customCSS .= " }";
			}
			
			if( isset( $b_pr_data['styles']['text']['subtitle'] ) ){
				$customCSS .= " .bop-primary-project-content .sub-title{";
				
				foreach($b_pr_data['styles']['text']['subtitle'] as $p_name => $p_value){
					$p_name = str_replace('_','-' , $p_name);
					$customCSS .= $p_name.':'.$p_value.';';
				}
				
				$customCSS .= " }";
			}
		
			if( isset( $b_pr_data['styles']['text']['paragraph'] )) {
				$customCSS .= " .bop-primary-project-content p, .bop-primary-project-content .main-text{";
				
				foreach($b_pr_data['styles']['text']['paragraph'] as $p_name => $p_value){
					if( $p_name != 'display') {
						$p_name = str_replace('_','-' , $p_name);
						$customCSS .= $p_name.':'.$p_value.';';
					}
				}
				
				$customCSS .= " }";
			}
			
			if( isset( $b_pr_data['styles']['text']['caption'] )) {
				$customCSS .= " .bop-primary-project-content .caption{";
				
				foreach($b_pr_data['styles']['text']['caption'] as $p_name => $p_value){
					$p_name = str_replace('_','-' , $p_name);
					$customCSS .= $p_name.':'.$p_value.';';
				}
				
				$customCSS .= " }";
			}
				
			if( isset( $b_pr_data['styles']['text']['link'] )) {
				
				$customCSS .= ".bop-primary-project-content a{";
				
				foreach($b_pr_data['styles']['text']['link'] as $p_name => $p_value){
					$p_name = str_replace('_','-' , $p_name);
					$customCSS .= $p_name.':'.$p_value.';';
				}
				
				$customCSS .= " }";
			}	
						
			
		}
		
		if($status == 'S'){
			$flag = true;
		}
		else if($status == 'F'){
			$flag = false;
		}
		else{
			$flag = null;
		}
			
		$data['project'] = $project;
		$data['show_search'] = $show_search;
		$data['b_pr_data'] = $b_pr_data;
		$data['status'] = $status;		
		$data['msg'] = $msg;
		$data['flag'] = $flag;
		$data['customCSS'] = $customCSS;
		$data['bp_search_id'] = $bp_search_id;
		$data['category_list'] = $category_list;
		$data['sub_task'] = $sub_task;
		$data['b_fields'] = $b_fields;
		
		
		return $data;
		
	}
	
	
	private function save_project(){
		$db = new EDS_BPM_DB();
		$flag = $db->save_project();
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg(__("Project saved successfully.","eds-bpm"));	
		else 
			Response_Bean::setMsg(__("Problem in saving project","eds-bpm"));
								
		return;
	}
	
	
	private function publish_project(){
		$db = new EDS_BPM_DB();
		
		$flag = $db->publish_project();
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg(__("Project published successfully.","eds-bpm"));	
		else 
			Response_Bean::setMsg(__("Problem in publishing Project.","eds-bpm"));
		
		
		return;
	}
	
	private function unpublish_project(){
		$db = new EDS_BPM_DB();
		
		$flag = $db->unpublish_project();
		
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg(__("Project unpublished successfully.","eds-bpm"));	
		else 
			Response_Bean::setMsg(__("Problem in unpublishing Project.","eds-bpm"));
		
		return;
	}
	
	private function set_project_featured($featuredFlag){
		$db = new EDS_BPM_DB();
		
		$flag = $db->set_project_featured($featuredFlag);
			
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg(__("Project updated successfully.","eds-bpm"));	
		else 
			Response_Bean::setMsg(__("Problem in updation of Project.","eds-bpm"));
		return;
	}
	
	private function synchronize_project(){
		$db = new EDS_BPM_DB();
		$behance = new EDS_BPM_Behance();
		
		$flag = true;
		
		$ids = $_REQUEST['entries'];
			
		
		foreach($ids as $id){
			$project = $db->get_project_details($id);
			$be_response = $behance->get_behance_project($project->b_project_id);
			
			$b_pr_data = $be_response->data;
			$status = $be_response->status;
			$msg = $be_response->msg;
			if($status=='S')
				$flag = $flag & $db->update_project($project, $b_pr_data);
			else{
				$flag = false;	
			}				
		}	
		
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg(__("Project synchronized successfully.","eds-bpm"));	
		else 
			Response_Bean::setMsg(__("Problem in synchronizing Project.","eds-bpm"));
		
		return;
	}
	
	
	private function delete_project(){
		$db = new EDS_BPM_DB();
		
		$flag = $db->delete_project();
		
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg(__("Project deleted successfully.","eds-bpm"));	
		else 
			Response_Bean::setMsg(__("Problem in deleting Project.","eds-bpm"));
			
		return;
	}
	
	private function trash_project(){
		$db = new EDS_BPM_DB();
		
		$flag = $db->trash_project();
					
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg(__("Project removed successfully.","eds-bpm"));	
		else 
			Response_Bean::setMsg(__("Problem in removing Project.","eds-bpm"));
		
		return;
	}
	
	
	public function get_user_projects( $user_id ){
		session_start();
		
		$behance = new EDS_BPM_Behance();
		
		$user_projects = $behance->get_user_projects($user_id );
		
		if( isset($user_projects) && !empty($user_projects)) {		
			$_SESSION['bpm_project_import_data'] = $user_projects;
			return $user_projects;
		}
		
		$_SESSION['bpm_project_import_data'] = null;
		return null;		
	}
		
	public function save_imported_projects( $projects, $mappings ) {	
		session_start();
		
		$db = new EDS_BPM_DB();
		
		if( isset($_SESSION['bpm_project_import_data']) && !empty($_SESSION['bpm_project_import_data'])) {
			return $db->save_imported_projects( $_SESSION['bpm_project_import_data'], $mappings );
		}
		
		return false;
	}
	
}
}