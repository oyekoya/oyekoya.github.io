<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if(!class_exists("Category_Filter_Bean")){
class Category_Filter_Bean{
	
	var $page_number = 1;
	var $order_by = 'doc';
	var $ordering = 'desc';
	
	public function set_filters(){
		session_start();
		//Getting the GET / POST Filters		
		global $wpdb;		
		$_SESSION['filter_category'] = (isset($_REQUEST['bpm-cat-name']) && $_REQUEST['bpm-cat-name']!='')?$_REQUEST['bpm-cat-name']:null;
		$_SESSION['filter_status'] = (isset($_REQUEST['bpm-cat-status']) && $_REQUEST['bpm-cat-status']!='')?$_REQUEST['bpm-cat-status']:null;
	}
	
	public function clear_filters(){
		session_start();
		$_SESSION['filter_category'] = '';
		$_SESSION['filter_status'] = null;
		
		$this->page_number = 1;
		$this->order_by = 'doc';
		$this->ordering = 'desc';		
	}
	
	public function set_pagination_order(){
		$this->page_number = (isset($_REQUEST['bpm-pno']) && $_REQUEST['bpm-pno']!='')?absint($_REQUEST['bpm-pno']):1;
		$this->order_by = (isset($_REQUEST['bpm-ob']) && $_REQUEST['bpm-ob']!='')?esc_sql($_REQUEST['bpm-ob']):'doc';
		$this->ordering = (isset($_REQUEST['bpm-o']) && $_REQUEST['bpm-o']!='')?esc_sql($_REQUEST['bpm-o']):'desc';
	}
		
	public function get_filter_category(){
		session_start();
		return $_SESSION['filter_category'];
	}
	
	public function get_filter_status(){
		session_start();
		return $_SESSION['filter_status'];
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