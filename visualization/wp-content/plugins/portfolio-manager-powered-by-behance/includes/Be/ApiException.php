<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
if(!class_exists("ApiException")){
class ApiException extends \Exception {}
}
