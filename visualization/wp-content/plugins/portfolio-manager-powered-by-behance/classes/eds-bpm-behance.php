<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
include_once EDS_BPM_Loader::$abs_path. '/classes/eds-bpm-config.php';
include_once EDS_BPM_Loader::$abs_path. '/includes/Be/ApiException.php';
include_once EDS_BPM_Loader::$abs_path. '/includes/Be/Client.php';

if(!class_exists("EDS_BPM_Behance")){
class EDS_BPM_Behance{
	
	var $general_config = null;
	
	public function __construct(){		
		$this->general_config = EDS_BPM_Config::get_general_config();
	}
	
	public function get_behance_project($id){
		$result = new stdClass();
		$id = trim($id);
		
		$result->data = $this->fetch_project_content($id);
		if($result->data==null || !isset($result->data))
		{
			$result->status = 'F';
			$result->data = null;
			$result->msg = __('Unable to retrieve Project from Behance.' , 'eds-bpm');
		}
		else if($result->data == -1)
		{
			$result->status = 'F';
			$result->data = null;
			$result->msg = __('You need to enter the Behance API Key in Portfolio Manager > Settings > General. Get one from' , 'eds-bpm');
			$result->msg .= ' <a href="https://www.behance.net/dev" target="_blank">'. __('here' , 'eds-bpm') . '</a>';
		}		
		else 
		{
			$result->status = 'S';
			$result->msg = __('Project content retrieved successfully.' , 'eds-bpm');
		}
		return $result;
		
	}
	
	
	private function fetch_project_content($projectID){
		
		$bAPIKey = $this->general_config['behance_api_key']; 
		
		if(isset($bAPIKey) && $bAPIKey!='')
		{
			$clientID= trim($bAPIKey);			
			try {
				$api = new Be_Client( $clientID);
				$data =  $api->getProject( $projectID , true);
				return $data;
			}
			catch(Exception $e)
			{
				return null;				
			}
		}
		else 
			return -1;
	}
	
	public function get_user_projects( $user_id ) {
		$bAPIKey = $this->general_config['behance_api_key'];
		$userProjects = array();
		$pageNumber  = 1;
		if(isset($bAPIKey) && $bAPIKey!='')
		{
			$clientID= trim($bAPIKey);
			try {
				$api = new Be_Client( $clientID);
				while(1) {
					$projects =  $api->getUserProjects( $user_id, array("page" => $pageNumber), true);
					if( !empty( $projects )) {
						$userProjects = array_merge($userProjects, $projects);
						$pageNumber++;
					} else {
						break;
					}
				}
				
				return $userProjects;
			}
			catch(Exception $e)
			{
				return null;
			}
		}
		else
			return null;
		
	}
	
}
}