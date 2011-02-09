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
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  public function executeSlideshow(sfWebRequest $request)
  {
    $this->files = $this->getUser ()->getAttribute ( Constantes::SESSION_ANNONCES );   
  }

  public function executeUploadannonce(sfWebRequest $request)
  {
      $fileName = $request->getFiles('Filedata');
             
      $fileFinalName = strtotime("now").$this->getFileExtension($fileName['name']);
      $uploadDir = sfConfig::get("sf_upload_dir");
      $annonces_uploads = $uploadDir.'/annonces';
      move_uploaded_file($fileName['tmp_name'], "$annonces_uploads/$fileFinalName");

      $this->files = $this->getUser ()->getAttribute ( Constantes::SESSION_ANNONCES );
      if($this->files==NULL)
          $files = array();
      $this->files[] = $fileFinalName;
      $this->getUser ()->setAttribute ( Constantes::SESSION_ANNONCES, $this->files);
      
      
      echo count($this->files);
      return sfView::NONE;
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
