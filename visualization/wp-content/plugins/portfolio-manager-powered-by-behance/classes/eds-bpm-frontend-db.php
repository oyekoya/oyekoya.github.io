<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

include_once EDS_BPM_Loader::$abs_path. '/classes/eds-bpm-config.php';

if(!class_exists("EDS_BPM_Frontend_DB")){
class EDS_BPM_Frontend_DB{
	
	public function __construct(){
		
	}
	
	public function get_category_list($id_list, $show_all){
		try{
			global $wpdb;
			
			$category_table = $wpdb->prefix . EDS_BPM_Config::$category_table;
			
			$where_clause = array();

			$response = new stdClass();

			$query = "SELECT * FROM $category_table ";
			
			$where_clause[0] = "status='published'";
			
			if(!($show_all && sizeof($id_list)==1)){
				$in_clause = '('.implode(",", $id_list).')';
				$where_clause[1] = 'id in'.$in_clause;
			}
			
			$query .= " WHERE " . implode(' AND ', $where_clause);
			
			$reponse = $wpdb->get_results( $query ,OBJECT );

			return $reponse;
			
		}catch(Exception $e){
			return null;
		}
	}
	
	public function get_single_category($id){
		try{
			global $wpdb;
			
			$category_table = $wpdb->prefix . EDS_BPM_Config::$category_table;
			
			$where_clause = array();

			$response = new stdClass();

			$query = "SELECT * FROM $category_table WHERE id = $id";					
			
			$reponse = $wpdb->get_row( $query ,OBJECT );

			return $reponse;
			
		}catch(Exception $e){
			return null;
		}
		
	}
	
	
	public function get_project_list($layout, $cat_ids, $show_all, $featured, $order_by, $ordering){
		try{
			global $wpdb;
			
			$category_table = $wpdb->prefix . EDS_BPM_Config::$category_table;
			$project_table = $wpdb->prefix . EDS_BPM_Config::$project_table;
				
			$response = new stdClass();
			$where_clause = array();
			
			if($layout == 'single_cat'){
				
				$query = "SELECT * FROM `$project_table` p INNER JOIN (SELECT id AS cat_id, slug as cat_slug, name AS cat_name FROM `$category_table`) c ON p.catid = c.cat_id ";
				
				$where_clause[0] = "p.status='published'";
				
				$where_clause[1] = 'p.catid = '. $cat_ids;
				
				if($featured == 'y')
					$where_clause[1] = 'p.featured = 1';
				
			}else if($layout == 'multi_cat'){
								
				$query = "SELECT * FROM `$project_table` p INNER JOIN (SELECT id AS cat_id, slug as cat_slug, name AS cat_name FROM `$category_table`) c ON p.catid = c.cat_id ";
				
				$where_clause[0] = "p.status='published'";
				
				if(!$show_all){
					$in_clause = '('.implode(",", $cat_ids).')';
					$where_clause[1] = 'p.catid in'.$in_clause;
				}						
				
				if($featured == 'y')
					$where_clause[1] = 'p.featured = 1';
			}
			
			$order_by_clause = " ORDER BY p." . $order_by. " " . $ordering;
			
			$query .= " WHERE " . implode(' AND ', $where_clause);
			
			$query .= $order_by_clause;
			
			$reponse = $wpdb->get_results( $query ,OBJECT );

			return $reponse;
			
			
		}catch(Exception $e){
			return null;
		}
	}
	
	public function get_single_project($project_identifier){
		try{
			global $wpdb;
			
			$category_table = $wpdb->prefix . EDS_BPM_Config::$category_table;
			$project_table = $wpdb->prefix . EDS_BPM_Config::$project_table;
			
			$where_clause = array();

			$response = NULL; 

			$query = "SELECT * FROM `$project_table` p INNER JOIN (SELECT id AS cat_id, slug as cat_slug, name AS cat_name FROM `$category_table`) c ON p.catid = c.cat_id ";
			
			if(intval($project_identifier) != 0){

				$where_clause[0] = "p.status='published'";
				$where_clause[1] = "p.id=$project_identifier";
				
				$query_with_id = $query . " WHERE " . implode(' AND ', $where_clause);
				
				$reponse = $wpdb->get_row( $query_with_id ,OBJECT );
								
				if($reponse == NULL ){			
					
					$where_clause[0] = "p.status='published'";
					$where_clause[1] = "p.slug='".$project_identifier."'";
					
					$query_with_slug = $query . " WHERE " . implode(' AND ', $where_clause);
					
					$reponse = $wpdb->get_row( $query_with_slug ,OBJECT );
				
				}		
								
			}else{
				$where_clause[0] = "p.status='published'";
				$where_clause[1] = "p.slug='".$project_identifier."'";
				
				$query_with_slug = $query . " WHERE " . implode(' AND ', $where_clause);
				
				$reponse = $wpdb->get_row( $query_with_slug ,OBJECT );
			}		
			
			return $reponse;
			
		}catch(Exception $e){
			return null;
		}
	}
	
	public function get_prev_project($current_project, $order_by){
		
		try{
			global $wpdb;
				
			$project_table = $wpdb->prefix . EDS_BPM_Config::$project_table;
				
			$where_clause = array();
		
			$response = NULL;
			if( $order_by == 'b_create_date') {
				$query = "SELECT * FROM `$project_table` p WHERE p.b_create_date < '" . $current_project->b_create_date . "' ORDER BY p.b_create_date DESC LIMIT 1";
			} else {
				$query = "SELECT * FROM `$project_table` p WHERE p.doc < '" . $current_project->doc . "' ORDER BY p.doc DESC LIMIT 1";
			}
				
			$reponse = $wpdb->get_row( $query ,OBJECT );	
				
			return $reponse;
				
		}catch(Exception $e){
			return null;
		}
		
	}
	
	public function get_next_project($current_project, $order_by){
		
		try{
			global $wpdb;
		
			$project_table = $wpdb->prefix . EDS_BPM_Config::$project_table;
		
			$where_clause = array();
		
			$response = NULL;
		
			if( $order_by == 'b_create_date') {
				$query = "SELECT * FROM `$project_table` p WHERE p.b_create_date > '" . $current_project->b_create_date . "' ORDER BY p.b_create_date ASC LIMIT 1";
			} else{
				$query = "SELECT * FROM `$project_table` p WHERE p.doc > '" . $current_project->doc . "' ORDER BY p.doc ASC LIMIT 1";
			}
		
			$reponse = $wpdb->get_row( $query ,OBJECT );
		
			return $reponse;
		
		}catch(Exception $e){
			return null;
		}
	
	}
	
	public function get_single_project_via_slug($slug){
		try{
			global $wpdb;
			
			$category_table = $wpdb->prefix . EDS_BPM_Config::$category_table;
			$project_table = $wpdb->prefix . EDS_BPM_Config::$project_table;
			
			$where_clause = array();

			$response = new stdClass();

			$query = "SELECT * FROM `$project_table` p INNER JOIN (SELECT id AS cat_id, slug as cat_slug, name AS cat_name FROM `$category_table`) c ON p.catid = c.cat_id ";

			$where_clause[0] = "p.status='published'";
			$where_clause[1] = "p.slug='$slug'";
			
			$query .= " WHERE " . implode(' AND ', $where_clause);
			
			$reponse = $wpdb->get_row( $query ,OBJECT );

			return $reponse;
			
		}catch(Exception $e){
			return null;
		}
		
	}
	
	public function get_project_id($slug){
		try{
			global $wpdb;
			$project_table = $wpdb->prefix . EDS_BPM_Config::$project_table;
			$query = "SELECT id FROM `$project_table` WHERE slug = '". $slug ."'";
			$project = $wpdb->get_row($query);
			
			return $project->id;			
			
		}catch(Exception $e){
			return null;
		}
	}
	
}
}