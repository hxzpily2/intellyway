<?php

/**
 * userform actions.
 *
 * @package    car
 * @subpackage userform
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userformActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
  
  public function executeCreate(sfWebRequest $request)
  {
   	
  }
  
  public function executeSave(sfWebRequest $request)
  {
   	    /*$candidat = new JobeetCandidat ( );
		$candidat->setNom ( $request->getParameter ( 'nom' ) );
		$candidat->setPrenom ( $request->getParameter ( 'prenom' ) );
		$candidat->setMail ( $request->getParameter ( 'email' ) );
		$candidat->setAdresse ( $request->getParameter ( 'adresse' ) );
		$candidat->setTelephone ( $request->getParameter ( 'tel' ) );
		$candidat->setPays ( $request->getParameter ( 'pays' ) );
		$candidat->setVille ( $request->getParameter ( 'ville' ) );
		$candidat->setZip ( $request->getParameter ( 'zip' ) );
		$candidat->setDatenais( $request->getParameter ( 'datenais' ) );
		$candidat->setImageprofil ( $request->getParameter ( 'defaultimage' ) );*/
  	    //AccountService::createUser();
  	    if($request->getParameter ( 'profil' ) == Constantes::PROFIL_USER){
  	    	$nom = $request->getParameter ( 'nom' );
  	    	$prenom = $request->getParameter ( 'prenom' );
  	    	$login = $request->getParameter ( 'login' );
  	    	$password = $request->getParameter ( 'password' );
  	    	$email = $request->getParameter ( 'email' );
  	    	$tel = $request->getParameter ( 'tel' );
  	    	
  	    	AccountService::createUser($nom,$prenom,$login,$password,$email,$tel,Constantes::PROFIL_USER);
  	    }
  	   
  }
}
