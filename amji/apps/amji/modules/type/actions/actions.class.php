<?php

/**
 * type actions.
 *
 * @package    amji
 * @subpackage type
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class typeActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->amji_types = Doctrine::getTable('AmjiType')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->amji_type = Doctrine::getTable('AmjiType')->find(array($request->getParameter('idamji_type')));
    $this->forward404Unless($this->amji_type);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new AmjiTypeForm();
    try{
    	$this->getMailer()->composeAndSend('reda.ze@gmail.com', 'reda.ze@gmail.com', 'Subject', 'Body');
    }catch (Exception $e){
    	echo "error";
    }
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new AmjiTypeForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($amji_type = Doctrine::getTable('AmjiType')->find(array($request->getParameter('idamji_type'))), sprintf('Object amji_type does not exist (%s).', $request->getParameter('idamji_type')));
    $this->form = new AmjiTypeForm($amji_type);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($amji_type = Doctrine::getTable('AmjiType')->find(array($request->getParameter('idamji_type'))), sprintf('Object amji_type does not exist (%s).', $request->getParameter('idamji_type')));
    $this->form = new AmjiTypeForm($amji_type);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($amji_type = Doctrine::getTable('AmjiType')->find(array($request->getParameter('idamji_type'))), sprintf('Object amji_type does not exist (%s).', $request->getParameter('idamji_type')));
    $amji_type->delete();

    $this->redirect('type/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $amji_type = $form->save();

      $this->redirect('type/edit?idamji_type='.$amji_type->getIdamjiType());
    }
  }
  
  public function executeSendmail(sfWebRequest $request){
  	/*$message = $this->getMailer()->compose();
    $message->setSubject("subject");
    $message->setTo("@to");
    $message->setFrom("@from");

    $html = $this->getPartial('mymodule/myTemplateHtml',$params);
    $message->setBody($html, 'text/html');
    $text = $this->getPartial('mymodule/myTemplateTxt',$params);
    $message->addPart(text, 'text/plain');    

    $this->getMailer()->send($message);*/

  	$this->getMailer()->composeAndSend('from@example.com', 'to@example.com', 'Subject', 'Body');
  }
}
