<?php 

class AccountService{
	
	public static function createUser($nom,$prenom,$login, $password,$email,$tel) {
		$user = new sfGuardUser ( );
		$user->setNom( $nom );
		$user->setPrenom( $prenom );
		$user->setPassword ( $password );
		$user->setUsername ( $login );
		$user->setMail ( $email );
		$user->setTel ( $tel );
		$user->save ();
		return $user;
	}
	
}

?>