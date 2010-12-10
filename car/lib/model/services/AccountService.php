<?php 

class AccountService{
	
	public static function createUser($nom,$prenom,$login, $password,$email,$tel,$profil) {
		$user = new sfGuardUser ( );
		$user->setNom( $nom );
		$user->setPrenom( $prenom );
		$user->setPassword ( $password );
		$user->setUsername ( $login );
		$user->setMail ( $email );
		$user->setTel ( $tel );
		$user->save ();
		
		$user->addGroupByName($profil);
		return $user;
	}
	
	public static function getGroupByName($name){
		
		$groups = Doctrine_Query::create ()->from ( 'sfGuardGroup g' )->where ( "g.name = '" . $name . "'" )->execute ();
		
		if(count($groups)>0){
			return $groups [0];
		}
		return NULL;
		
	}
	
}

?>