<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if(!class_exists("Project_Filter_Bean")){
class Project_Filter_Bean{
	var $page_number = 1;
	var $order_by = 'doc';
	var $ordering = 'desc';
	
	public function set_filters(){
		session_start();
		//Getting the GET / POST Filters		
		global $wpdb;
		$_SESSION['filter_pname'] = (isset($_REQUEST['bpm-project-name']) && $_REQUEST['bpm-project-name']!='')?$_REQUEST['bpm-project-name']:null;		
		$_SESSION['filter_pcategory'] = (isset($_REQUEST['bpm-project-category']) && $_REQUEST['bpm-project-category']!='')?$_REQUEST['bpm-project-category']:null;
		$_SESSION['filter_pstatus'] = (isset($_REQUEST['bpm-project-status']) && $_REQUEST['bpm-project-status']!='')?$_REQUEST['bpm-project-status']:null;
	}
	
	public function clear_filters(){
		session_start();
		$_SESSION['filter_pname'] = '';
		$_SESSION['filter_pcategory'] = null;
		$_SESSION['filter_pstatus'] = null;
		
		$this->page_number = 1;
		$this->order_by = 'doc';
		$this->ordering = 'desc';		
	}
	
	public function set_pagination_order(){
		$this->page_number = (isset($_REQUEST['bpm-pno']) && $_REQUEST['bpm-pno']!='')?absint($_REQUEST['bpm-pno']):1;
		$this->order_by = (isset($_REQUEST['bpm-ob']) && $_REQUEST['bpm-ob']!='')?esc_sql($_REQUEST['bpm-ob']):'doc';
		$this->ordering = (isset($_REQUEST['bpm-o']) && $_REQUEST['bpm-o']!='')?esc_sql($_REQUEST['bpm-o']):'desc';
	}
	
	
	public function get_filter_pname(){
		session_start();
		return $_SESSION['filter_pname'];
	}
	
	public function get_filter_pcategory(){
		session_start();
		return $_SESSION['filter_pcategory'];
	}
	
	public function get_filter_pstatus(){
		session_start();
		return $_SESSION['filter_pstatus'];
	}
	
	public function get_page_number(){		
		return $this->page_number;
	}
	
	public function get_order_by(){
		
		return $this->order_by;
	}
	
	public function get_ordering(){
		return $this->ordering;
	}
	
}
}