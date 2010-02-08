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

	public function login(UserVO $userVO){
		$user = AmjiUser::getUser ( $userVO->login, $userVO->pass );
		if($user!=NULL){
			$amjiuser = AmjiUser::getUserByEmail($userVO->login);
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
			$amjiuser->setIdamji_statut(AmjiStatut::getStatutId($userVO->statut));
			$amjiuser->save();
			$this->getUser ()->setAttribute ( Sessions::USERCONNECTED, $user );
			$this->getUser ()->setAttribute ( 'user_id', $user->getId (), 'sfGuardSecurityUser' );
			$this->getUser ()->setAuthenticated ( true );
			$this->getUser ()->clearCredentials ();
			$this->getUser ()->addCredentials ( $user->getAllPermissionNames () );
			$user->setLastLogin ( date ( 'Y-m-d h:i:s' ) );
			$user->save ();
			$loginVO = new LoginVO();
			$loginVO->userVO = $userVo;
			$listeContacts = AmjiUser::getContacts($userVo->idamji_user);
			$listInvitations = AmjiUser::getInvitations($userVo->idamji_user);
			$loginVO->listeContacts = array();
			$loginVO->listInvitations = array();
			foreach ($listeContacts as $contact){
				$c = new CreateUserVO();
				$c->idamji_user = $contact->getIdamji_user();
				$c->adr = $contact->getAdr();
				$c->ecole = $contact->getEcole();
				$c->email = $contact->getEmail();
				$c->etudiant = $contact->getEtudiant();
				$c->niveau = $contact->getNiveau();
				$c->nom = $contact->getNom();
				$c->prenom = $contact->getPrenom();
				$c->pseudo = $contact->getPseudo();
				$c->salarie = $contact->getSalarie();
				$c->societe = $contact->getSociete();
				$c->statut = $contact->getStatut();
				$c->tel = $contact->getTel();
				$c->civilite = $contact->getCivilite();
				$c->connstatut = AmjiStatut::getStatutById($contact->getIdamji_statut());
				$loginVO->listeContacts[] = $c;				
			} 
			foreach ($listInvitations as $contact){
				$c = new CreateUserVO();
				$c->idamji_user = $contact->getIdamji_user();
				$c->adr = $contact->getAdr();
				$c->ecole = $contact->getEcole();
				$c->email = $contact->getEmail();
				$c->etudiant = $contact->getEtudiant();
				$c->niveau = $contact->getNiveau();
				$c->nom = $contact->getNom();
				$c->prenom = $contact->getPrenom();
				$c->pseudo = $contact->getPseudo();
				$c->salarie = $contact->getSalarie();
				$c->societe = $contact->getSociete();
				$c->statut = $contact->getStatut();
				$c->tel = $contact->getTel();
				$c->civilite = $contact->getCivilite();
				$c->connstatut = Constantes::HORSLIGNE;
				$loginVO->listInvitations[] = $c;
			}
			//$this->getContext()->getLogger()->info("liste contacts : ".sizeof($loginVO->listeContacts));			
			return $loginVO;
		}else{						
			return NULL;
		}
	}
}

?>