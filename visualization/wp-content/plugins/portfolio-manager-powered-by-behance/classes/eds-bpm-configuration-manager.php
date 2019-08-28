<?php
if ( ! defined( 'WPINC' ) ) {
	die;
} 
include_once EDS_BPM_Loader::$abs_path. '/classes/eds-bpm-config.php'; 
       
    
if(!class_exists("EDS_BPM_Configuration_Manager")){
class EDS_BPM_Configuration_Manager{    
	
	private static $config = null ;

	private $general_config_key;
	private $advanced_config_key;
	private $navigation_button_config_key;
	
	private $slug;

	private $plugin_config_tabs;

	private $general_config ;
	private $advanced_config;
	private $navigation_button_config;

	private function __construct() {
		
		$this->slug = EDS_BPM_Config::$eds_bpm_cofig_menu_slug;
		
		$this->general_config_key = EDS_BPM_Config::$general_config_key;
		$this->advanced_config_key = EDS_BPM_Config::$advanced_config_key;
		$this->navigation_button_config_key = EDS_BPM_Config::$navigation_button_config_key;

		$this->plugin_config_tabs = array();
		$this->general_config = array();
		$this->advanced_config = array();
		$this->navigation_button_config = array();
	}
	
	public static function get_instance(){
		if(NULL == self::$config){
			self::$config = new EDS_BPM_Configuration_Manager();
		}
		return self::$config;
	}
	
	public function get_slug()
	{
		return $this->slug;
	}
	
	public function get_general_config_key()
	{
		return $this->general_config_key;
	}
	
	public function get_advanced_config_key()
	{
		return $this->advanced_config_key;
	}
	
	public function get_navigation_button_config_key()
	{
		return $this->navigation_button_config_key;
	}
	
	public function load_configuration(){
		
		$this->general_config = EDS_BPM_Config::get_general_config();
		$this->advanced_config = EDS_BPM_Config::get_advanced_config();
		$this->navigation_button_config = EDS_BPM_Config::get_navigation_button_config();
		
	}


	public function register_general_configuration(){

		$this->plugin_config_tabs[$this->general_config_key] = __('General', 'eds-bpm');
		
		add_settings_section( EDS_BPM_Config::$general_section,
							__('General Settings','eds-bpm'), 
							array( $this, 'section_general_desc' ),
							$this->general_config_key );
			
		add_settings_field( 'behance_api_key',
							__('Behance API Key','eds-bpm'), 
							array( $this, 'field_behance_api_key' ),
							$this->general_config_key,
							EDS_BPM_Config::$general_section);
	
		add_settings_field( 'result_per_page',
							__('Results per Page in Backend','eds-bpm'), 
							array( $this, 'field_result_per_page' ),
							$this->general_config_key,
							EDS_BPM_Config::$general_section);
							
		add_settings_field( 'view_project_on_behance',
							__('View Project on Behance','eds-bpm'), 
							array( $this, 'field_view_project_on_behance' ),
							$this->general_config_key,
							EDS_BPM_Config::$general_section);
							
		add_settings_field( 'open_in_different_tab',
							__('Open Project in New Tab','eds-bpm'), 
							array( $this, 'field_open_in_different_tab' ),
							$this->general_config_key,
							EDS_BPM_Config::$general_section);
		
		register_setting( $this->general_config_key, $this->general_config_key, array($this, 'sanitize_general_settings'));

	}

	public function section_general_desc() { 
		echo __('General configurations related to Portfolio Manager.', 'eds-bpm'); 
	}
	
	public function field_behance_api_key() {
		
		$html= '<input
			type="text"
			name="'.$this->general_config_key.'[behance_api_key]"
			value="'.esc_attr(isset($this->general_config['behance_api_key'])?$this->general_config['behance_api_key']:'').'" />';
		
		echo $html;
	}
	
	public function field_result_per_page(){
		$html= '<input
			type="text"
			name="'.$this->general_config_key.'[result_per_page]"
			value="'.esc_attr(isset($this->general_config['result_per_page'])?$this->general_config['result_per_page']:'').'" />';
		
		echo $html;
	}	
	
	public function field_view_project_on_behance(){
		$value = isset($this->general_config['view_project_on_behance'])?$this->general_config['view_project_on_behance']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input			
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->general_config_key.'[view_project_on_behance]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	public function field_open_in_different_tab(){
		$value = isset($this->general_config['open_in_different_tab'])?$this->general_config['open_in_different_tab']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input			
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->general_config_key.'[open_in_different_tab]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	public function sanitize_general_settings($input){
		$input['behance_api_key'] = trim($input['behance_api_key']);
		$input['result_per_page'] = absint(trim($input['result_per_page']));
		
		return $input;
	}	
	
	
	
	public function register_advanced_configuration(){
		$this->plugin_config_tabs[$this->advanced_config_key] = __('Advanced', 'eds-bpm');
	
		add_settings_section( EDS_BPM_Config::$advanced_section, 
							__('Advanced Plugin Settings', 'eds-bpm'), 
							array( $this, 'section_advanced_desc' ), 
							$this->advanced_config_key );
							
		add_settings_field( 'project_background_color', 
							__('Project Background Color'), 
							array( $this, 'field_project_background_color' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );
		
		add_settings_field( 'loading_icon_color',
							__('Loading Icon Color'),
							array( $this, 'field_loading_icon_color' ),
							$this->advanced_config_key,
							EDS_BPM_Config::$advanced_section );
							
		add_settings_field( 'show_project_title', 
							__('Show Project Title'), 
							array( $this, 'field_show_project_title' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );
		
		add_settings_field( 'show_creative_fields', 
							__('Show Creative Fields'), 
							array( $this, 'field_show_creative_fields' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );
		
		add_settings_field( 'show_project_by', 
							__('Show Project By'), 
							array( $this, 'field_show_project_by' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );
	
		add_settings_field( 'show_about_project', 
							__('Show About Project'), 
							array( $this, 'field_show_about_project' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );

		add_settings_field( 'show_publish_date', 
							__('Show Publish Date'), 
							array( $this, 'field_show_publish_date' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );
		
		add_settings_field( 'show_views', 
							__('Show Total Project Views'), 
							array( $this, 'field_show_views' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );
							
		add_settings_field( 'show_appreciations', 
							__('Show Total Project Appreciations'), 
							array( $this, 'field_show_appreciations' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );		
							
		add_settings_field( 'show_comments', 
							__('Show Total Project Comments'), 
							array( $this, 'field_show_comments' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );	
		
		add_settings_field( 'show_tags', 
							__('Show Project Tags'), 
							array( $this, 'field_show_tags' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );
		
		add_settings_field( 'show_tools_used', 
							__('Show Project Tools Used'), 
							array( $this, 'field_show_tools_used' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );
		
		add_settings_field( 'show_copyright_info', 
							__('Show Project Copyright Info'), 
							array( $this, 'field_show_copyright_info' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );
		
		add_settings_field( 'eds_bpm_custom_css', 
							__('Custom CSS'), 
							array( $this, 'field_show_eds_bpm_custom_css' ), 
							$this->advanced_config_key, 
							EDS_BPM_Config::$advanced_section );
		
							
		register_setting( $this->advanced_config_key, $this->advanced_config_key);
	}

	public function section_advanced_desc() { 
		echo 'Advanced settings.'; 
	}

	public function field_project_background_color() {
		$html= '<input
			type="text"
			id ="project_background_color" 
			name="'.$this->advanced_config_key.'[project_background_color]"
			value="'.esc_attr( isset($this->advanced_config['project_background_color'])?$this->advanced_config['project_background_color']:'').'" />';		
		
		echo $html;
		
	}	
	
	public function field_loading_icon_color() {
		$html= '<input
			type="text"
			id ="loading_icon_color"
			name="'.$this->advanced_config_key.'[loading_icon_color]"
			value="'.esc_attr( isset($this->advanced_config['loading_icon_color'])?$this->advanced_config['loading_icon_color']:'').'" />';
		
		echo $html;
		
	}
	
	public function field_show_project_title(){
		
		$value = isset($this->advanced_config['show_project_title'])?$this->advanced_config['show_project_title']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input			
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->advanced_config_key.'[show_project_title]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	
	public function field_show_creative_fields(){
		
		$value = isset($this->advanced_config['show_creative_fields'])?$this->advanced_config['show_creative_fields']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->advanced_config_key.'[show_creative_fields]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	public function field_show_project_by(){
		
		$value = isset($this->advanced_config['show_project_by'])?$this->advanced_config['show_project_by']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->advanced_config_key.'[show_project_by]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	public function field_show_about_project(){
		
		$value = isset($this->advanced_config['show_about_project'])?$this->advanced_config['show_about_project']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->advanced_config_key.'[show_about_project]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	public function field_show_publish_date(){		
		$value = isset($this->advanced_config['show_publish_date'])?$this->advanced_config['show_publish_date']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->advanced_config_key.'[show_publish_date]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	public function field_show_views(){
		
		$value = isset($this->advanced_config['show_views'])?$this->advanced_config['show_views']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->advanced_config_key.'[show_views]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	public function field_show_appreciations(){
		
		$value = isset($this->advanced_config['show_appreciations'])?$this->advanced_config['show_appreciations']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->advanced_config_key.'[show_appreciations]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	public function field_show_comments(){
		
		$value = isset($this->advanced_config['show_comments'])?$this->advanced_config['show_comments']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->advanced_config_key.'[show_comments]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
		
	public function field_show_tags(){
		
		$value = isset($this->advanced_config['show_tags'])?$this->advanced_config['show_tags']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->advanced_config_key.'[show_tags]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	
	
	public function field_show_tools_used(){
		
		$value = isset($this->advanced_config['show_tools_used'])?$this->advanced_config['show_tools_used']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->advanced_config_key.'[show_tools_used]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	public function field_show_copyright_info(){
		
		$value = isset($this->advanced_config['show_copyright_info'])?$this->advanced_config['show_copyright_info']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"			
			class="project_attribute_switches" 
			name="'.$this->advanced_config_key.'[show_copyright_info]"
			value="yes" '.$checked.' 
			 />';
		
		echo $html;
	}
	
	function field_show_eds_bpm_custom_css(){
		$value = isset($this->advanced_config['eds_bpm_custom_css'])?$this->advanced_config['eds_bpm_custom_css']:'';
	
		$html ='<textarea
					name ="'.$this->advanced_config_key.'[eds_bpm_custom_css]"
					rows ="5"
				>'.$value.'</textarea>';
		echo $html;
	}
	
	
	public function register_navigation_button_configuration(){
		
		$this->plugin_config_tabs[$this->navigation_button_config_key] = __('Navigation Buttons', 'eds-bpm');
		
		add_settings_section( EDS_BPM_Config::$navigation_button_section,
				__('Navigation Settings', 'eds-bpm'),
				array( $this, 'section_navigation_button_desc' ),
				$this->navigation_button_config_key );
		
		add_settings_field( 'show_prev_next_btn',
				__('Show Previous/Next Buttons'),
				array( $this, 'field_show_prev_next_btn' ),
				$this->navigation_button_config_key,
				EDS_BPM_Config::$navigation_button_section );		
		
		add_settings_field( 'prev_next_project_order',
				__('Project Order'),
				array( $this, 'field_prev_next_project_order' ),
				$this->navigation_button_config_key,
				EDS_BPM_Config::$navigation_button_section );
		
		add_settings_field( 'prev_next_btn_style',
				__('Button Style'),
				array( $this, 'field_prev_next_btn_style' ),
				$this->navigation_button_config_key,
				EDS_BPM_Config::$navigation_button_section );
		
		add_settings_field( 'prev_next_btn_position',
				__('Button Position'),
				array( $this, 'field_prev_next_btn_position' ),
				$this->navigation_button_config_key,
				EDS_BPM_Config::$navigation_button_section );
		
		add_settings_field( 'prev_next_btn_icon',
				__('Show Button Arrows'),
				array( $this, 'field_prev_next_btn_icon' ),
				$this->navigation_button_config_key,
				EDS_BPM_Config::$navigation_button_section );
				
		add_settings_field( 'prev_btn_text',
				__('Previous Button Text'),
				array( $this, 'field_prev_btn_text' ),
				$this->navigation_button_config_key,
				EDS_BPM_Config::$navigation_button_section );
		
		add_settings_field( 'prev_btn_text_color',
				__('Previous Button Text Color'),
				array( $this, 'field_prev_btn_text_color' ),
				$this->navigation_button_config_key,
				EDS_BPM_Config::$navigation_button_section );
		
		add_settings_field( 'prev_btn_bg_color',
				__('Previous Button Background Color'),
				array( $this, 'field_prev_btn_bg_color' ),
				$this->navigation_button_config_key,
				EDS_BPM_Config::$navigation_button_section );		
		
		add_settings_field( 'next_btn_text',
				__('Next Button Text'),
				array( $this, 'field_next_btn_text' ),
				$this->navigation_button_config_key,
				EDS_BPM_Config::$navigation_button_section );
		
		add_settings_field( 'next_btn_text_color',
				__('Next Button Text Color'),
				array( $this, 'field_next_btn_text_color' ),
				$this->navigation_button_config_key,
				EDS_BPM_Config::$navigation_button_section );
		
		add_settings_field( 'next_btn_bg_color',
				__('Next Button Background Color'),
				array( $this, 'field_next_btn_bg_color' ),
				$this->navigation_button_config_key,
				EDS_BPM_Config::$navigation_button_section );
		
		register_setting( $this->navigation_button_config_key, $this->navigation_button_config_key);
		
	}
	
	public function section_navigation_button_desc() {
		echo 'Navigation buttons related settings for Single Project View.';
	}
	
	public function field_show_prev_next_btn(){
	
		$value = isset($this->navigation_button_config['show_prev_next_btn'])?$this->navigation_button_config['show_prev_next_btn']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"
			class="project_attribute_switches"
			name="'.$this->navigation_button_config_key.'[show_prev_next_btn]"
			value="yes" '.$checked.'
			 />';
	
		echo $html;
	}
	
	public function field_prev_next_project_order(){
	
		$value = isset($this->navigation_button_config['prev_next_project_order'])?$this->navigation_button_config['prev_next_project_order']:'doc';
		
		$html = '<select name ="'.$this->navigation_button_config_key.'[prev_next_project_order]">'.
				'<option value="doc" '.(($value == 'doc') ? 'selected':'').'>'. 'Date: Project added on Website'. '</option>'.				
				'<option value="b_create_date" '.(($value == 'b_create_date') ? 'selected':'').'>'. 'Date: Project added on Behance'. '</option>'.
				'</select>';
		
		echo $html;
	}
	
	public function field_prev_next_btn_position(){
	
		$value = isset($this->navigation_button_config['prev_next_btn_position'])?$this->navigation_button_config['prev_next_btn_position']:'top';
	
		$html = '<select name ="'.$this->navigation_button_config_key.'[prev_next_btn_position]">'.
				'<option value="top" '.(($value == 'top') ? 'selected':'').'>'. 'Top'. '</option>'.
				'<option value="bottom" '.(($value == 'bottom') ? 'selected':'').'>'. 'Bottom'. '</option>'.
				'<option value="both" '.(($value == 'both') ? 'selected':'').'>'. 'Both'. '</option>'.				
				'</select>';
	
		echo $html;
	}
	
	
	public function field_prev_next_btn_style(){
	
		$value = isset($this->navigation_button_config['prev_next_btn_style'])?$this->navigation_button_config['prev_next_btn_style']:'default';
	
		$html = '<select name ="'.$this->navigation_button_config_key.'[prev_next_btn_style]">'.
				'<option value="eds-bpm-default" '.(($value == 'eds-bpm-default') ? 'selected':'').'>'. 'Default'. '</option>'.
				'<option value="eds-bpm-material" '.(($value == 'eds-bpm-material') ? 'selected':'').'>'. 'Material'. '</option>'.
				'<option value="eds-bpm-circular" '.(($value == 'eds-bpm-circular') ? 'selected':'').'>'. 'Circular'. '</option>'.
				'</select>';
	
		echo $html;
	}
	
	
	
	public function field_prev_next_btn_icon(){
	
		$value = isset($this->navigation_button_config['prev_next_btn_icon'])?$this->navigation_button_config['prev_next_btn_icon']:'';
		$checked = (isset($value) && $value=='yes')?'checked':'';
		$html= '<input
			 data-on-text="YES"
			 data-off-text="NO"
			type="checkbox"
			class="project_attribute_switches"
			name="'.$this->navigation_button_config_key.'[prev_next_btn_icon]"
			value="yes" '.$checked.'
			 />';
	
		echo $html;
	}
	
	
	public function field_prev_btn_text(){
		$value = isset($this->navigation_button_config['prev_btn_text'])?$this->navigation_button_config['prev_btn_text']:'';
		
		$html ='<input
					type ="text"
					name ="'.$this->navigation_button_config_key.'[prev_btn_text]"
					value="'.$value.'"
				/>';
		
		echo $html;
	}
	
	public function field_prev_btn_text_color(){
		$html= '<input
			type="text"
			id ="prev_btn_text_color"
			name="'.$this->navigation_button_config_key.'[prev_btn_text_color]"
			value="'.esc_attr( isset($this->navigation_button_config['prev_btn_text_color'])?$this->navigation_button_config['prev_btn_text_color']:'').'" />';
		
		echo $html;
	}
	
	public function field_prev_btn_bg_color(){
		$html= '<input
			type="text"
			id ="prev_btn_bg_color"
			name="'.$this->navigation_button_config_key.'[prev_btn_bg_color]"
			value="'.esc_attr( isset($this->navigation_button_config['prev_btn_bg_color'])?$this->navigation_button_config['prev_btn_bg_color']:'').'" />';
	
		echo $html;
	}
	
	
	public function field_next_btn_text(){
		$value = isset($this->navigation_button_config['next_btn_text'])?$this->navigation_button_config['next_btn_text']:'';
	
		$html ='<input
					type ="text"
					name ="'.$this->navigation_button_config_key.'[next_btn_text]"
					value="'.$value.'"
				/>';
	
		echo $html;
	}
	
	public function field_next_btn_text_color(){
		$html= '<input
			type="text"
			id ="next_btn_text_color"
			name="'.$this->navigation_button_config_key.'[next_btn_text_color]"
			value="'.esc_attr( isset($this->navigation_button_config['next_btn_text_color'])?$this->navigation_button_config['next_btn_text_color']:'').'" />';
	
		echo $html;
	}
	
	public function field_next_btn_bg_color(){
		$html= '<input
			type="text"
			id ="next_btn_bg_color"
			name="'.$this->navigation_button_config_key.'[next_btn_bg_color]"
			value="'.esc_attr( isset($this->navigation_button_config['next_btn_bg_color'])?$this->navigation_button_config['next_btn_bg_color']:'').'" />';
	
		echo $html;
	}	
	
	public function init_configuration_page()
	{		
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->general_config_key;
		$curl_flag = EDS_BPM_Config::is_curl_loaded();
	    ?>
	    <?php if(  null !== $curl_flag  && false == $curl_flag ):?>
		<div class="alert alert-danger alert-dismissible eds-bpm-alert" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  	<i class="fa fa-times-circle"></i><?php _e('CURL module is not enabled.', 'eds-bpm'); ?>
		</div>
		<?php endif; ?>
		<h2>Portfolio Manager - Settings</h2>	        
	    <div class="wrap">
	        <?php $this->init_configuration_tab(); ?>
	        <form method="post" action="options.php">
	            <?php wp_nonce_field( 'update-options' ); ?>
	            <?php settings_fields( $tab ); ?>
	            <?php do_settings_sections( $tab ); ?>
	            <?php submit_button(); ?>
	        </form>
	    </div>
	    <?php
	}
	
	
	public function init_configuration_tab(){
		$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->general_config_key;

	    screen_icon();
	    
	    echo '<h2 class="nav-tab-wrapper">';
	    foreach ( $this->plugin_config_tabs as $tab_key => $tab_caption ) {
	        $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
	        echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->slug . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
	    }
	    echo '</h2>';
	}
	
}
}