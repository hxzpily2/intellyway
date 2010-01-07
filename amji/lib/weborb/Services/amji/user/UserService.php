<?php

require_once dirname(__FILE__).'/../generic/GenericService.php';

class UserService extends GenericService{
	protected $context = null;

	public function createUser(CreateUserVO $user){
		$user->email = "test";
		$user->password = "000000";
		return AmjiUser::createUser($user);
	}
}

?>