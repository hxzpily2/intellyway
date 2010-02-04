<?php

require_once dirname(__FILE__).'/../../generic/GenericService.php';

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
	
	public function login($login,$password){
		$user = AmjiUser::getUser ( $login, $password );
		if($user!=NULL){
			$this->getUser ()->setAttribute ( Sessions::USERCONNECTED, $user );
			$this->getUser ()->setAttribute ( 'user_id', $user->getId (), 'sfGuardSecurityUser' );
			$this->getUser ()->setAuthenticated ( true );
			$this->getUser ()->clearCredentials ();
			$this->getUser ()->addCredentials ( $user->getAllPermissionNames () );
			$user->setLastLogin ( date ( 'Y-m-d h:i:s' ) );
			return $user;
		}else{
			return NULL;
		}
		$user->save ();		
	}
}

?>