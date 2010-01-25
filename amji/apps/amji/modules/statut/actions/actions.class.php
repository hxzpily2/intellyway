<?php

/**
 * statut actions.
 *
 * @package    amji
 * @subpackage statut
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class statutActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->amji_statuts = Doctrine::getTable('AmjiStatut')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->amji_statut = Doctrine::getTable('AmjiStatut')->find(array($request->getParameter('idamji_statut')));
    $this->forward404Unless($this->amji_statut);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new AmjiStatutForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new AmjiStatutForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($amji_statut = Doctrine::getTable('AmjiStatut')->find(array($request->getParameter('idamji_statut'))), sprintf('Object amji_statut does not exist (%s).', $request->getParameter('idamji_statut')));
    $this->form = new AmjiStatutForm($amji_statut);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($amji_statut = Doctrine::getTable('AmjiStatut')->find(array($request->getParameter('idamji_statut'))), sprintf('Object amji_statut does not exist (%s).', $request->getParameter('idamji_statut')));
    $this->form = new AmjiStatutForm($amji_statut);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($amji_statut = Doctrine::getTable('AmjiStatut')->find(array($request->getParameter('idamji_statut'))), sprintf('Object amji_statut does not exist (%s).', $request->getParameter('idamji_statut')));
    $amji_statut->delete();

    $this->redirect('statut/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $amji_statut = $form->save();

      $this->redirect('statut/edit?idamji_statut='.$amji_statut->getIdamjiStatut());
    }
  }
}
