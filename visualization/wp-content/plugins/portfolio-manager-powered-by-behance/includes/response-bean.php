<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
if(!class_exists("Response_Bean")){
class Response_Bean{
	
	public static function setMsg($msg = ""){
		session_start();
		$_SESSION['eds_bpm_msg'] = $msg; 
	} 
	
	public static function getMsg(){
		session_start();
		if(isset($_SESSION['eds_bpm_msg']))
			return $_SESSION['eds_bpm_msg'];
		
		return null;
	}
	
	public static function unsetMsg(){
		session_start();
		unset($_SESSION['eds_bpm_msg']);
	}
	
	public static function setFlag($flag = true){
		session_start();
		$_SESSION['eds_bpm_flag'] = $flag; 
	} 
	
	public static function getFlag(){
		session_start();
		if(isset($_SESSION['eds_bpm_flag']))
			return $_SESSION['eds_bpm_flag'];
		
		return 	null;
	}
	
	public static function unsetFlag(){
		session_start();
		unset($_SESSION['eds_bpm_flag']);
	}
}
}
