<?php

require_once dirname(__FILE__).'/../../generic/GenericService.php';

class UserService extends GenericService{
	protected $context = null;

	public function createUser(CreateUserVO $user){
		return AmjiUser::createUser($user);
	}

	public function addContact(InviteContactVO $invite){

	}

	public function inviteContact(InviteContactVO $invite){
		$user = $this->getUser()->getAttribute(Sessions::USERCONNECTED);
		$this->getContext()->getLogger()->info("liste contacts : ".AmjiUser::getInvitation($user->getIdamji_user(),$invite->idcontact));
		return AmjiUser::inviteContact($user->getIdamji_user(),$invite->idcontact,$invite->message);
	}
	
	public function searchContacts($critere){
		$contacts = AmjiUser::searchContact($critere);
		$user = $this->getUser()->getAttribute(Sessions::USERCONNECTED);
		$listeContacts = array();
		foreach ($contacts as $amjiuser){
			if($amjiuser->getIdamji_user()!=$user->getIdamji_user()){
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
				if(AmjiUser::isContact($user->getIdamji_user(),$amjiuser->getIdamji_user())==true){
					$userVo->connstatut = AmjiStatut::getStatutById($amjiuser->getIdamji_statut());
				}else{
					$userVo->connstatut = Constantes::HORSLIGNE;	
				}
				$listeContacts[] = $userVo;
			}
		}
		return $listeContacts;
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
			$userVo->humeur = $amjiuser->getHumeur();
			$userVo->civilite = $amjiuser->getCivilite();
			$userVo->connstatut = $userVO->statut;
			$amjiuser->setIdamji_statut(AmjiStatut::getStatutId($userVO->statut));
			$amjiuser->save();
			$this->getUser ()->setAttribute ( Sessions::USERCONNECTED, $amjiuser );
			$this->getUser ()->setAttribute ( 'user_id', $user->getId (), 'sfGuardSecurityUser' );
			$this->getUser ()->setAuthenticated ( true );
			$this->getUser ()->clearCredentials ();
			$this->getUser ()->addCredentials ( $user->getAllPermissionNames () );
			$user->setLastLogin ( date ( 'Y-m-d h:i:s' ) );
			$user->save ();
			$loginVO = new LoginVO();
			$loginVO->userVO = $userVo;
			$loginVO->listTypes = AmjiType::getTypePerUser($userVo->idamji_user);
			$listeContacts = AmjiUser::getContacts($userVo->idamji_user);
			$listInvitations = AmjiUser::getInvitations($userVo->idamji_user);			
			$listUserInvitations = AmjiUser::getUsersInvitations($userVo->idamji_user);
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
				$c->humeur = $contact->getHumeur();
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
				$c->humeur = Constantes::NORMAL;
				$c->civilite = $contact->getCivilite();
				$c->connstatut = Constantes::HORSLIGNE;
				$loginVO->listeContacts[] = $c;
			}
			foreach ($listUserInvitations as $invite){
				$contact = AmjiUser::getUserById($invite->getIdamji_user());
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
				$c->humeur = Constantes::NORMAL;
				$c->civilite = $contact->getCivilite();
				$c->connstatut = Constantes::HORSLIGNE;
				$loginVO->listInvitations[] = $c;
			}
			$this->getContext()->getLogger()->info("liste contacts : ".sizeof($listUserInvitations));			
			return $loginVO;
		}else{						
			return NULL;
		}
	}
	
	public function statutChange($statut){
		$idstatut = AmjiStatut::getStatutId($statut);
		$user = $this->getUser()->getAttribute(Sessions::USERCONNECTED);
		$user->setIdamji_statut($idstatut);
		$user->save();
	}
	
	public function changePseudo($pseudo){
		$user = $this->getUser()->getAttribute(Sessions::USERCONNECTED);
		$user->setPseudo($pseudo);
		$user->save();
	}
	
	public function accepteInvitation($id){
		$user = $this->getUser()->getAttribute(Sessions::USERCONNECTED);
		AmjiUser::addContact($user->getIdamji_user(),$id);
		$contact=AmjiUser::getUserById($id);
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
		$c->humeur = $contact->getHumeur();
		$c->civilite = $contact->getCivilite();
		$c->connstatut = AmjiStatut::getStatutById($contact->getIdamji_statut());
		return $c;
	}
	
	public function ignoreInvitation($id){
		$user = $this->getUser()->getAttribute(Sessions::USERCONNECTED);
		AmjiUser::refuseInviteContact($user->getIdamji_user(),$id);
		$contact=AmjiUser::getUserById($id);
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
		$c->humeur = $contact->getHumeur();
		$c->civilite = $contact->getCivilite();
		$c->connstatut = AmjiStatut::getStatutById($contact->getIdamji_statut());
		return $c;
	}
	
	public function getInfoContact($email){
		return AmjiUser::getInfoContact($email);
	}
}

?>