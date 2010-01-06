<?php


class UserService{
	
	public function createUser(){
		//$user = new User();
		
		require_once dirname(__FILE__).'/../../../../../config/ProjectConfiguration.class.php';
    
    	$configuration = ProjectConfiguration::getApplicationConfiguration('amji', 'dev', true);
		sfContext::createInstance($configuration);
		
		$user = new User();
		
		return "test";
	}
}

?>