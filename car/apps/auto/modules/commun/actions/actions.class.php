<?php

/**
 * commun actions.
 *
 * @package    car
 * @subpackage commun
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class communActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->car_autos = Doctrine::getTable('CarAuto')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CarAutoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CarAutoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($car_auto = Doctrine::getTable('CarAuto')->find(array($request->getParameter('idauto'))), sprintf('Object car_auto does not exist (%s).', $request->getParameter('idauto')));
    $this->form = new CarAutoForm($car_auto);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($car_auto = Doctrine::getTable('CarAuto')->find(array($request->getParameter('idauto'))), sprintf('Object car_auto does not exist (%s).', $request->getParameter('idauto')));
    $this->form = new CarAutoForm($car_auto);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($car_auto = Doctrine::getTable('CarAuto')->find(array($request->getParameter('idauto'))), sprintf('Object car_auto does not exist (%s).', $request->getParameter('idauto')));
    $car_auto->delete();

    $this->redirect('commun/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $car_auto = $form->save();

      $this->redirect('commun/edit?idauto='.$car_auto->getIdauto());
    }
  }

  public function executeUploadannonce(sfWebRequest $request)
  {
      $fileName = $request->getFiles('Filedata');

      $fileFinalName = strtotime("now").$this->getFileExtension($fileName['name']);
      $uploadDir = sfConfig::get("sf_upload_dir");
      $annonces_uploads = $uploadDir.'/annonces';
      move_uploaded_file($fileName['tmp_name'], "$annonces_uploads/$fileFinalName");
      
      $this->files = $this->getUser ()->getAttribute ( Constantes::SESSION_ANNONCES,array());
      
      $this->files[] = $fileFinalName;
      $this->getUser ()->setAttribute ( Constantes::SESSION_ANNONCES, $this->files);
      
      $this->setLayout(false);
      $this->setTemplate('slideshow');
  }

  public function executeDeluploadannonce(sfWebRequest $request)
  {
      $fileName = $request->getFiles('Filedata');

      $fileFinalName = strtotime("now").$this->getFileExtension($fileName['name']);
      $uploadDir = sfConfig::get("sf_upload_dir");
      $annonces_uploads = $uploadDir.'/annonces';
      move_uploaded_file($fileName['tmp_name'], "$annonces_uploads/$fileFinalName");

      $files = $this->getUser ()->getAttribute ( Constantes::SESSION_ANNONCES );
      if($files==NULL)
          $files = array();
      $files[] = $fileFinalName;
      
      $this->getUser ()->setAttribute ( Constantes::SESSION_ANNONCES, $files);

      return sfView::NONE;
  }
  

  public function getFileExtension($filename){
    return substr($filename, strrpos($filename, '.'));
  }
}
