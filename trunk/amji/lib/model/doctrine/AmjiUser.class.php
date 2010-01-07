<?php

/**
 * AmjiUser
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class AmjiUser extends BaseAmjiUser
{
	public static function userIsExist($login) {
		$getUsernameUser = Doctrine_Query::create ()->select ( 'u.email' )->from ( 'AmjiUser u' )->where ( "email = '" . $login . "'" )->execute ();
		$oldUsername = $getUsernameUser [0];

		if ($oldUsername->getEmail () != NULL)
			return 1;
		else
			return 0;
	}

	public static function createUser(CreateUserVO $uservo){
		
		
			if(!AmjiUser::userIsExist($uservo->email)){
				$user = new sfGuardUser ( );
				$user->setPassword ( $uservo->password );
				$user->setUsername ( $uservo->email );
				
				$user->save ();
				
				$compte = new AmjiUser();
				$compte->setEmail();
				$compte->setNom();
				 
			}else{
				throw new GenericException("",Errors::MAILEXIST);
			}
				
		
	}
}