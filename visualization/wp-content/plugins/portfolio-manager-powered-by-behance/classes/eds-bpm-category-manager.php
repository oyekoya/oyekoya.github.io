<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}


include_once EDS_BPM_Loader::$abs_path. '/classes/eds-bpm-db.php';
include_once EDS_BPM_Loader::$abs_path. '/classes/eds-bpm-config.php';
include_once EDS_BPM_Loader::$abs_path. '/includes/category-filter-bean.php';
include_once EDS_BPM_Loader::$abs_path. '/includes/pagination.php';
include_once EDS_BPM_Loader::$abs_path. '/includes/response-bean.php';

if(!class_exists("EDS_BPM_Category_Manager")){
class EDS_BPM_Category_Manager{
	var $general_config = null;
	var $url = null;
	
	public function __construct(){
		$this->general_config = EDS_BPM_Config::get_general_config();
		/* $this->url = $_SERVER['PHP_SELF'].'?page='.EDS_BPM_Config::$eds_bpm_category_menu_slug; */
		$this->url =  get_admin_url( null, 'admin.php' ) . '?page='.EDS_BPM_Config::$eds_bpm_category_menu_slug;				
	}
	
	public function initialize(){
		$layout = isset($_REQUEST['bpm-layout'])?$_REQUEST['bpm-layout']:'default';
		$task = isset($_REQUEST['bpm-task'])?$_REQUEST['bpm-task']:'default';
		$filters = new Category_Filter_Bean();
		$data = null;
		$url = $this->url;
		$page_slug = EDS_BPM_Config::$eds_bpm_top_menu_slug;
		$bpm_id = isset($_REQUEST['bpm-id'])?$_REQUEST['bpm-id']:"0";
		$default_template_url = EDS_BPM_Loader::$abs_path . '/layouts/eds-bpm-category-default.php';
		$edit_template_url = EDS_BPM_Loader::$abs_path . '/layouts/eds-bpm-category-edit.php';
		
		$curl_flag = EDS_BPM_Config::is_curl_loaded();
		
		switch($task){			
			case 'new':
				$data = $this->new_category();
				break;
				
			case 'edit':
				$data = $this->edit_category($bpm_id);
				break;
				
			case 'search':
				$filters->set_filters();
				$data = $this->get_categories($filters);					
				break;
			
			case 'clear':
				$filters->clear_filters();
				$data = $this->get_categories($filters);
				break;
			
			case 'default':
				$data = $this->get_categories($filters);
				break;		
				
			case 'save':
				$this->save_category();	
				wp_redirect($url);exit;				 					
				break;
				
			case 'publish':
				$this->publish_category();
				wp_redirect($url);exit;										
				break;
			
			case 'unpublish':
				$this->unpublish_category();
				wp_redirect($url);exit;										
				break;

			case 'delete':
				$this->delete_category();
				wp_redirect($url);exit;					
				break;

			case 'trash':
				$this->trash_category();
				wp_redirect($url);exit;					
				break;
		}
		
		include_once EDS_BPM_Loader::$abs_path . '/layouts/eds-bpm-categories.php';
		
	}
	
	private function get_categories($filters){
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
		$data['response'] = $response = $db->get_categories($filters);		
		
		$data['pagination_code'] = $pagination->get_pagination_code(EDS_BPM_Config::$result_per_page, 
															$filters->get_page_number(), 
															$this->url.'&bpm-ob='.$filters->get_order_by().'&bpm-o='.$filters->get_ordering().'&bpm-pno=',
															$response->total_rows[0]);
		return $data;
	}
	
	
	private function new_category(){
		$data = array();
		$data['flag'] = Response_Bean::getFlag();
		$data['msg'] = Response_Bean::getMsg();

		//Unsetting the flags to avoid wrong message in the next request
		Response_Bean::unsetFlag();
		Response_Bean::unsetMsg();
		
		$category = new stdClass();
		
		$category->id = null;
		$category->name = null;
		$category->slug = null;
		$category->icon = null;		
		$category->description = null;		
		
		$data['category'] = $category;
		return $data;
	}
	
	private function edit_category($bpm_cat_id){
		$data = array();
		$data['flag'] = Response_Bean::getFlag();
		$data['msg'] = Response_Bean::getMsg();

		//Unsetting the flags to avoid wrong message in the next request
		Response_Bean::unsetFlag();
		Response_Bean::unsetMsg();
		
		$db = new EDS_BPM_DB();	
		$category = $db->get_category_details($bpm_cat_id);
		$data['category'] = $category;
		return $data;
	}
	
	private function save_category(){
		$db = new EDS_BPM_DB();
		$flag = $db->save_category();
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg( __('Category saved successfully.' , 'eds-bpm'));	
		else 
			Response_Bean::setMsg(__('Problem in saving category.','eds-bpm'));
		
		return;
	}
	
private function publish_category(){
		$db = new EDS_BPM_DB();
		
		$flag = $db->publish_category();
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg(__("Category published successfully.","eds-bpm"));	
		else 
			Response_Bean::setMsg(__("Problem in publishing category.","eds-bpm"));
		
		return;
	}
	
	private function unpublish_category(){
		$db = new EDS_BPM_DB();
		
		$flag = $db->unpublish_category();
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg(__("Category unpublished successfully.","eds-bpm"));	
		else 
			Response_Bean::setMsg(__("Problem in unpublishing category.","eds-bpm"));
		
		return;
	}
	
	private function delete_category(){
		$db = new EDS_BPM_DB();
		
		$flag = $db->delete_category();
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg(__("Category deleted successfully.","eds-bpm"));	
		else 
			Response_Bean::setMsg(__("Problem in deleting category.","eds-bpm"));
		
		return;
	}
	
	private function trash_category(){
		$db = new EDS_BPM_DB();
		$flag = $db->trash_category();
		
		Response_Bean::setFlag($flag);
		if($flag)
			Response_Bean::setMsg(__("Category removed successfully.","eds-bpm"));	
		else 
			Response_Bean::setMsg(__("Problem in removing category.","eds-bpm"));
		
		
		return;
	}
}
}