<?php

require_once dirname(__FILE__).'/../generic/GenericService.php';

class UserService extends GenericService{
	protected $context = null;

	public function createUser(CreateUserVO $user){		
		return AmjiUser::createUser($user);
	}
	
	public function addContact($idcontact){		
		
	}
	
	public function inviteContact($idcontact){		
		$user = $this->getUser()->getAttribute(Sessions::USERCONNECTED);
		return AmjiUser::inviteContact($user->getIduser(),$idcontact);
	}
}

?>