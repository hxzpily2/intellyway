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
	public static function getUser($login, $password) {


		$getUsernameUser = Doctrine_Query::create ()->from ( 'sfGuardUser u' )->where ( "u.username = '" . $login . "'" )->execute ();

		if(sizeof($getUsernameUser)>0)
		$oldUsername = $getUsernameUser [0];



		if (sizeof($getUsernameUser)>0) {
			if($oldUsername->getPassword()==AmjiUser::setPassword($password,$oldUsername->getSalt())){

				return $oldUsername;
			}
			else return NULL;
		} else
		return NULL;
	}

	public static function getUserByEmail($login){
		$users = Doctrine_Query::create ()->from ( 'AmjiUser u' )->where ( "u.email = '" . $login . "'" )->execute ();
					
		return $users[0];
	}
	
	public static function getUserById($id){
		$users = Doctrine_Query::create ()->from ( 'AmjiUser u' )->where ( "u.idamji_user = '" . $id . "'" )->execute ();
					
		return $users[0];
	}

	public static function setPassword($password,$salt) {
		if (! $password && 0 == strlen ( $password )) {
			return;
		}


		$algorithm = sfConfig::get ( 'app_sf_guard_plugin_algorithm_callable', 'sha1' );

		$algorithmAsStr = is_array ( $algorithm ) ? $algorithm [0] . '::' . $algorithm [1] : $algorithm;
		if (! is_callable ( $algorithm )) {
			throw new sfException ( sprintf ( 'The algorithm callable "%s" is not callable.', $algorithmAsStr ) );
		}


		return call_user_func_array ( $algorithm, array ($salt . $password ) ) ;
	}

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
			$compte->setEmail($uservo->email);
			$compte->setNom($uservo->nom);
			$compte->setPrenom($uservo->prenom);
			$compte->setPseudo("");
			$compte->setAdr($uservo->adr);
			$compte->setTel($uservo->tel);
			$compte->setEtudiant($uservo->etudiant);
			$compte->setEcole($uservo->ecole);
			$compte->setNiveau($uservo->niveau);
			$compte->setStatut($uservo->statut);
			$compte->setSalarie($uservo->salarie);
			$compte->setSociete($uservo->societe);
			$compte->setIdamji_statut(AmjiStatut::getStatutId(Constantes::HORSLIGNE));
			$compte->save();
				
			return AmjiUser::getUserByEmail($uservo->email)->getIdamji_user();

		}else{
			throw new Exception(Errors::MAILEXIST);
		}
	}

	public static function addContact($iduser,$idcontact){
		$contact = new AmjiContacts();
		$contact->setIdamjiInvite($idcontact);
		$contact->setIdamjiUser($iduser);
		$contact->save();
		$contact = new AmjiContacts();
		$contact->setIdamjiInvite($iduser);
		$contact->setIdamjiUser($idcontact);
		$contact->save();
		AmjiUser::delInvitation($iduser,$idcontact);
	}

	public static function inviteContact($iduser,$idcontact,$message){
		if(AmjiUser::getInvitation($iduser,$idcontact)==NULL && AmjiUser::getIsContact($iduser,$idcontact)==NULL){
			$invitation = new AmjiInvitation();
			$invitation->setIdamjiInvite($idcontact);
			$invitation->setIdamjiUser($iduser);
			$invitation->setMessage($message);
			$invitation->setAccepted(1);
			$invitation->save();
			
			$amjiuser = AmjiUser::getUserById($idcontact);
			$userVo = new CreateUserVO();
			$userVo->idamji_user = $amjiuser->getIdamji_user();
			$userVo->adr = $amjiuser->getAdr();
			$userVo->ecole = $amjiuser->getEcole();
			$userVo->email = $amjiuser->getEmail();
			$userVo->etudiant = $amjiuser->getEtudiant();
			$userVo->niveau = $amjiuser->getNiveau();
			$userVo->nom = $amjiuser->getNom();
			$userVo->prenom = $amjiuser->getPrenom();
			$userVo->pseudo = $amjiuser->getPseudo();
			$userVo->salarie = $amjiuser->getSalarie();
			$userVo->societe = $amjiuser->getSociete();
			$userVo->statut = $amjiuser->getStatut();
			$userVo->tel = $amjiuser->getTel();
			$userVo->civilite = $amjiuser->getCivilite();
			$userVo->connstatut = Constantes::HORSLIGNE;
			$userVo->humeur = Constantes::NORMAL; 
			return $userVo;
		}else{
			throw new Exception(Errors::INVITATIONEXIST);
		}
	}

	public static function refuseInviteContact($iduser,$idcontact){
		$invitation = AmjiUser::getInvitation($iduser,$idcontact);
		$invitation->setAccepted(0);
		$invitation->update();
	}

	public static function getInvitation($iduser,$idcontact){
		$invitations = Doctrine_Query::create ()->from ( 'AmjiInvitation i' )->where ( "i.idamji_user = " . $iduser  )->andWhere("i.idamji_invite = " . $idcontact )->andWhere("i.accepted = 1" )->execute();
		if (sizeof($invitations)>0)
		return $invitations[0];
		else
		return NULL;
	}
	
	public static function getIsContact($iduser,$idcontact){
		$invitations = Doctrine_Query::create ()->from ( 'AmjiContacts i' )->where ( "i.idamji_user = " . $iduser  )->andWhere("i.idamji_invite = " . $idcontact )->execute();
		if (sizeof($invitations)>0)
		return $invitations[0];
		else
		return NULL;
	}

	public static function delInvitation($iduser,$idcontact){
		Doctrine_Query::create ()->delete ( 'AmjiInvitation i' )->where ( "i.idamji_user = " . $idcontact  )->andWhere("i.idamji_invite = " . $iduser )->execute();
	}

	public static function subscribeGroup($iduser,$idgroup){
		if(AmjiUser::alreadySubGroup($iduser,$idgroup)==NULL){
			$sub = new AmjiSubscribeGroup();
			$sub->setIdamjiGroup($idgroup);
			$sub->setIdamjiUser($iduser);
			$sub->save();
		}else{
			throw new GenericException("",Errors::ALREADYGROUPSUBSCRIBE);
		}
	}

	public static function unsubscribeGroup($iduser,$idgroup){
		$sub = AmjiUser::alreadySubGroup($iduser,$idgroup);
		$sub->del();
	}

	public static function subscribeTopic($iduser,$idtopic){
		if(AmjiUser::alreadySubTopic($iduser,$idtopic)==NULL){
			$topic = new AmjiSubscribe();
			$topic->setAmjiType($idtopic);
			$topic->setIdamjiUser($iduser);
			$topic->save();
		}else{
			throw new GenericException("",Errors::ALREADYTOPICSUBSCRIBE);
		}
	}

	public static function unsubscribeTopic($iduser,$idtopic){
		$topic = AmjiUser::alreadySubTopic($iduser,$idtopic);
		$topic->del();
	}

	public static function alreadySubGroup($iduser,$idgroup){
		$subs = Doctrine_Query::create ()->from ( 'AmjiSubscribeGroup s' )->where ( "idmaji_user = '" . $iduser . "'" )->andWhere("idamji_group = '" . $idgroup . "'")->execute();
		if (sizeof($subs)==0)
		return NULL;
		else
		return $subs[0];
	}

	public static function alreadySubTopic($iduser,$idtopic){
		$topics = Doctrine_Query::create ()->from ( 'AmjiSubscribe s' )->where ( "idmaji_user = '" . $iduser . "'" )->andWhere("idamji_type = '" . $idtopic . "'")->execute();
		if (sizeof($topics)==0)
		return NULL;
		else
		return $topics[0];
	}

	public static function createRequest(CreateRequestVO $req){
		$request = new AmjiRequest();
		//save request

		//save file from session in database and delete them from hard drive
	}
	
	public static function getContacts($iduser){
		$q = Doctrine_Query::create ()->from ( 'AmjiUser u' )->leftJoin ( 'u.AmjiContacts c' )->where('c.idamji_user = '.$iduser);
		return $q->execute ();
	}
	
	public static function getInvitations($iduser){
		$q = Doctrine_Query::create ()->from ( 'AmjiUser u' )->leftJoin ( 'u.AmjiInvitation i' )->where('i.idamji_user = '.$iduser);
		return $q->execute ();
	}
	
	public static function getUsersInvitations($iduser){
		$q = Doctrine_Query::create ()->from ( 'AmjiInvitation i' )->where('i.idamji_invite = '.$iduser);
		return $q->execute ();
	}
	
	public static function searchContact($critere){
		$q = Doctrine_Query::create ()->from ( 'AmjiUser u' )->where("u.nom like '%$critere%'")->orWhere("u.prenom like '%$critere%'")->orWhere("u.prenom like '%$critere%'")->orWhere("u.email like '%$critere%'")->orWhere("u.societe like '%$critere%'")->orWhere("u.ecole like '%$critere%'")->orWhere("u.statut like '%$critere%'");
		return $q->execute ();
	}
	
	public static function isContact($iduser,$id){
		$q = Doctrine_Query::create ()->from ( 'AmjiContacts c' )->where('c.idamji_user = '.$iduser)->andWhere('c.idamji_invite = '.$id);
		
		$liste = $q->execute ();
		if(sizeof($liste>0))
			return true;
		else return false;
	}
	
	public static function getInfoContact($email){
		$amjiuser = AmjiUser::getUserByEmail($email);
		$userVo = new CreateUserVO();
		$userVo->idamji_user = $amjiuser->getIdamji_user();
		$userVo->adr = $amjiuser->getAdr();
		$userVo->ecole = $amjiuser->getEcole();
		$userVo->email = $amjiuser->getEmail();
		$userVo->etudiant = $amjiuser->getEtudiant();
		$userVo->niveau = $amjiuser->getNiveau();
		$userVo->nom = $amjiuser->getNom();
		$userVo->prenom = $amjiuser->getPrenom();
		$userVo->pseudo = $amjiuser->getPseudo();
		$userVo->salarie = $amjiuser->getSalarie();
		$userVo->societe = $amjiuser->getSociete();
		$userVo->statut = $amjiuser->getStatut();
		$userVo->tel = $amjiuser->getTel();
		$userVo->civilite = $amjiuser->getCivilite();
		$userVo->connstatut = AmjiStatut::getStatutById($amjiuser->getIdamji_statut());;
		$userVo->humeur = $amjiuser->getHumeur(); 
		return $userVo;
	}


}