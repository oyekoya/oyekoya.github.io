<?php

if ( ! defined( 'WPINC' ) ) {
	die; 
}    

include_once dirname(__FILE__).'/eds-bpm-loader.php';
include_once dirname(__FILE__).'/eds-bpm-config.php';
include_once dirname(__FILE__).'/eds-bpm-db.php';
     
if(!class_exists("EDS_BPM_VCExtension")){
	
	class EDS_BPM_VCExtension {
		
		public function integrate_with_vc() {
			
			if ( ! defined( 'WPB_VC_VERSION' ) ) {				
				return;
			}			
			
			$version = explode(".", WPB_VC_VERSION );
			
			if( isset( $version ) && !empty( $version ) && count($version) >= 2) {
		
				if( intval($version[0]) < 4 ){
					return;
				}
				
				if( intval($version[0]) == 4 && intval($version[1]) < 1 ){
					return;
				}			
				
			}
						
			vc_add_shortcode_param( 'eds_bpm_multiselect_dropdown', array( $this, 'eds_bpm_multiselect_dropdown_handler' ) );
			vc_add_shortcode_param( 'eds_bpm_hiddeninput', array( $this, 'eds_bpm_hiddeninput_handler' ) );
			
			//init single project module
			$this->init_single_project_element();
			
			//init single category module
			$this->init_single_category_element();
			
			//init multiple category module
			$this->init_multiple_category_element(); 
		
		}	
		
		
		public function eds_bpm_multiselect_dropdown_handler( $settings, $value ) {
			
			if( is_array( $value ) ){
				$selected_categories = $value;
			} else {
				$selected_categories = array($value);
			}
			
			$options = "";
			if( in_array( '-1', $selected_categories ) ){
				$options .= '<option value="-1" selected >All</option>';
			} else {
				$options .= '<option value="-1">All</option>';
			}	
			
			foreach( $settings['value'] as $category ) {				
				if( in_array($category['id'], $selected_categories ) ){
					$options .= '<option value="'. $category['id']  .'" selected >'.$category['name'].'</option>';
				} else {
					$options .= '<option value="'. $category['id']  .'" >'.$category['name'].'</option>';
				}				
			}
			
			return '<select name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-select ' .
					esc_attr( $settings['param_name'] ) . ' ' .
					esc_attr( $settings['type'] ) . '_field" size="5" multiple >' . $options . '</select>';
		}
		
		public function eds_bpm_hiddeninput_handler( $settings, $value ) {
			return '<input  name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-hidden ' .
					esc_attr( $settings['param_name'] ) . ' ' .
					esc_attr( $settings['type'] ) . '_field" type="hidden" value="'.$settings['value'].'" />';
		}	
		
		
		private function init_single_project_element() {
			
			$projects = array();
			$db = new EDS_BPM_DB();
			$projects = $db->get_project_list();
			
			vc_map( array(
					"name" => __("Single Project Layout", 'eds-bpm'),
					"description" => __("Layout to display single project", 'eds-bpm'),
					"base" => "edsbportmansp",
					"class" => "",
					"controls" => "full",
					"icon" => plugins_url('images/vc-bpm.png', EDS_BPM_Loader::$abs_file),
					"category" => __('Portfolio Manager', 'eds-bpm'),
					"params" => array(						
						array(
								"type" => "dropdown",								
								"class" => "",
								"heading" => __("Project", 'eds-bpm'),
								"param_name" => "id",
								"value" => $projects,	
								'admin_label' => true,
								'save_always' => true								
						),
						array(
								"type" => "eds_bpm_hiddeninput",								
								"class" => "",
								"heading" => "",
								"param_name" => "layout_type",
								"value" => "single_project",								
								'save_always' => true
						)					
					)
			) );
			
		}
		
		
		private function init_single_category_element() {
			
			$categories = array();
			$db = new EDS_BPM_DB();
			$categories = $db->get_layout_category_list();
			
			vc_map( array(
					"name" => __("Single Category Layout", 'eds-bpm'),
					"description" => __("Layout to display single category", 'eds-bpm'),
					"base" => "edsbportmansc",
					"class" => "",
					"controls" => "full",
					"icon" => plugins_url('images/vc-bpm.png', EDS_BPM_Loader::$abs_file),
					"category" => __('Portfolio Manager', 'eds-bpm'),
					"params" => array(							
							array(
									"type" => "dropdown",
									"class" => "",
									"heading" => __("Category", 'eds-bpm'),
									"param_name" => "id",
									"value" => $categories,		
									'admin_label' => true,
									'save_always' => true
							),
							array(
									"type" => "dropdown",									
									"class" => "",
									"heading" => __("Show Only Featured", 'eds-bpm'),
									"param_name" => "featured",
									"value" => array(
										__('No', 'eds-bpm') => "n",
										__('Yes', 'eds-bpm') => "y"										 
									),															
									'save_always' => true
							),
							array(
									"type" => "dropdown",									
									"class" => "",
									"heading" => __("Mosaic Style", 'eds-bpm'),
									"param_name" => "mosaic_style",
									"value" => array(
											__('Style 1', 'eds-bpm') => "one",
											__('Style 2', 'eds-bpm') => "two",
											__('Style 3', 'eds-bpm') => "three",
											__('Style 4', 'eds-bpm') => "four",
											__('Style 5', 'eds-bpm')  => "five" 
									),									
									'save_always' => true
							),
							array(
									"type" => "textfield",									
									"class" => "",
									"heading" => __("Margin between Tiles (in pixel)", 'eds-bpm'),
									"param_name" => "tile_margin",
									"value" => "20",									
									'save_always' => true
							),
							array(
									"type" => "dropdown",									
									"class" => "",
									"heading" => __("Show Category Title", 'eds-bpm'),
									"param_name" => "sct",
									"value" => array(
										__('No', 'eds-bpm') => "n",
										__('Yes', 'eds-bpm') => "y"										 
									),						
									'save_always' => true
							),
							array(
									"type" => "dropdown",									
									"class" => "",
									"heading" => __("Show Category Description", 'eds-bpm'),
									"param_name" => "scd",
									"value" => array(
										__('No', 'eds-bpm') => "n",
										__('Yes', 'eds-bpm') => "y"										 
									),						
									'save_always' => true
							),
							array(
									"type" => "dropdown",									
									"class" => "",
									"heading" => __("Show Category Image", 'eds-bpm'),
									"param_name" => "sci",
									"value" => array(
										__('No', 'eds-bpm') => "n",
										__('Yes', 'eds-bpm') => "y"										 
									),							
									'save_always' => true
							),
							array(
									"type" => "dropdown",									
									"class" => "",
									"heading" => __("Order By", 'eds-bpm'),
									"param_name" => "order_by",
									"value" => array(
										__('Default', 'eds-bpm') => "id",
										__('Project Name', 'eds-bpm') => "b_project_name",
										__('Creation Date on Behance', 'eds-bpm') => "b_create_date"
									),									
									'save_always' => true
							),
							array(
									"type" => "dropdown",									
									"class" => "",
									"heading" => __("Ordering", 'eds-bpm'),
									"param_name" => "ordering",
									"value" => array(
										__('Ascending', 'eds-bpm') => "asc",
										__('Descending', 'eds-bpm') => "desc" 											
									),									
									'save_always' => true
							),
							array(
									"type" => "eds_bpm_hiddeninput",
									"class" => "",
									"heading" => "",
									"param_name" => "layout_type",
									"value" => "single_cat",
									'save_always' => true
							)						
					)
			) );
			
		}
		
		
		private function init_multiple_category_element() {
			$categories = array();
			$db = new EDS_BPM_DB();
			$categories = $db->get_layout_category_list();
				
			vc_map( array(
					"name" => __("Multiple Categories Layout", 'eds-bpm'),
					"description" => __("Layout to display multiple categories", 'eds-bpm'),
					"base" => "edsbportmanmc",
					"class" => "",
					"controls" => "full",
					"icon" => plugins_url('images/vc-bpm.png', EDS_BPM_Loader::$abs_file),
					"category" => __('Portfolio Manager', 'eds-bpm'),
					"params" => array(
							array(
									"type" => "eds_bpm_multiselect_dropdown",
									"group" => "Basic Settings",
									"class" => "",									
									"heading" => __("Category", 'eds-bpm'),
									"param_name" => "id",
									"value" => $categories,			
									'admin_label' => true,
									'save_always' => true
							),
							array(
									"type" => "dropdown",
									"group" => "Basic Settings",
									"class" => "",
									"heading" => __("Show Only Featured", 'eds-bpm'),
									"param_name" => "featured",
									"value" => array(
										__('No', 'eds-bpm') => "n",
										__('Yes', 'eds-bpm') => "y"										 
									),								
									'save_always' => true
							),
							array(
									"type" => "dropdown",
									"group" => "Basic Settings",									
									"class" => "",
									"heading" => __("Mosaic Style", 'eds-bpm'),
									"param_name" => "mosaic_style",
									"value" => array(
											__('Style 1', 'eds-bpm') => "one",
											__('Style 2', 'eds-bpm') => "two",
											__('Style 3', 'eds-bpm') => "three",
											__('Style 4', 'eds-bpm') => "four",
											__('Style 5', 'eds-bpm')  => "five" 
									),									
									'save_always' => true
							),
							array(
									"type" => "textfield",
									"group" => "Basic Settings",
									"class" => "",
									"heading" => __("Margin between Tiles (in pixel)", 'eds-bpm'),
									"param_name" => "tile_margin",
									"value" => "20",									
									'save_always' => true
							),
							array(
									"type" => "dropdown",
									"group" => "Basic Settings",									
									"class" => "",
									"heading" => __("Order By", 'eds-bpm'),
									"param_name" => "order_by",
									"value" => array(
										__('Default', 'eds-bpm') => "id",
										__('Project Name', 'eds-bpm') => "b_project_name",
										__('Creation Date on Behance', 'eds-bpm') => "b_create_date"
									),									
									'save_always' => true
							),
							array(
									"type" => "dropdown",
									"group" => "Basic Settings",
									"class" => "",
									"heading" => __("Ordering", 'eds-bpm'),
									"param_name" => "ordering",
									"value" => array(
										__('Ascending', 'eds-bpm') => "asc",
										__('Descending', 'eds-bpm') => "desc" 											
									),									
									'save_always' => true
							),
							array(
									"type" => "colorpicker",
									"group" => "Tab Settings",
									"class" => "",
									"heading" => __("Unselected Background Color", 'eds-bpm'),
									"param_name" => "tab_ubc",
									"value" => "#e1e1e1",									
									'save_always' => true
							),
							array(
									"type" => "colorpicker",
									"group" => "Tab Settings",
									"class" => "",
									"heading" => __("Unselected Text Color", 'eds-bpm'),
									"param_name" => "tab_utc",
									"value" => "#252c33",									
									'save_always' => true
							),
							array(
									"type" => "colorpicker",
									"group" => "Tab Settings",									
									"class" => "",
									"heading" => __("Selected Background Color", 'eds-bpm'),
									"param_name" => "tab_sbc",
									"value" => "#afafaf",									
									'save_always' => true
							),
							array(
									"type" => "colorpicker",
									"group" => "Tab Settings",									
									"class" => "",
									"heading" => __("Selected Text Color", 'eds-bpm'),
									"param_name" => "tab_stc",
									"value" => "#ffffff",									
									'save_always' => true
							),
							array(
									"type" => "colorpicker",
									"group" => "Tab Settings",									
									"class" => "",
									"heading" => __("Hover Background Color", 'eds-bpm'),
									"param_name" => "tab_hbc",
									"value" => "#c9c9c9",									
									'save_always' => true
							),
							array(
									"type" => "colorpicker",
									"group" => "Tab Settings",									
									"class" => "",
									"heading" => __("Hover Text Color", 'eds-bpm'),
									"param_name" => "tab_htc",
									"value" => "#252c33",									
									'save_always' => true
							),
							array(
									"type" => "eds_bpm_hiddeninput",
									"group" => "Basic Settings",									
									"class" => "",
									"heading" => "",
									"param_name" => "layout_type",
									"value" => "multi_cat",
									'save_always' => true
							)					
					)
			) );
		}
		
	}
	
}