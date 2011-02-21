<?php

require_once dirname(__FILE__).'/../lib/annonceGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/annonceGeneratorHelper.class.php';

/**
 * annonce actions.
 *
 * @package    car
 * @subpackage annonce
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class annonceActions extends sfActions
{
  public function preExecute()
  {
    /***
     * ADDED BY ZER TO SET COUNTRY FROM ADDR IP
     */    
    $this->pays = Country::getCoutryByIp();
    $this->getUser()->setAttribute(Constantes::SESSION_PAYS_ID, $this->pays);
    /***
     * END SET COUNTRY
     */
    $this->configuration = new annonceGeneratorConfiguration();

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($this->getActionName())))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.pre_execute', array('configuration' => $this->configuration)));

    $this->helper = new annonceGeneratorHelper();
  }

  public function executeIndex(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();
  }

  public function executeFilter(sfWebRequest $request)
  {
    $this->setPage(1);

    if ($request->hasParameter('_reset'))
    {
      $this->setFilters($this->configuration->getFilterDefaults());

      $this->redirect('@car_auto');
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());

    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());

      $this->redirect('@car_auto');
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    $this->setTemplate('index');
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->car_auto = $this->form->getObject();
    $this->typesaccessoire = CarTypeAccessoire::getAll();
    $this->carosserie = CarCarosserie::getAll();

    
    $this->getUser()->setAttribute(Constantes::SESSION_PREFIX_ANNONCE,strtotime("now")."_");

  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->car_auto = $this->form->getObject();

    //$this->processForm($request, $this->form);

    $annonce = new CarAuto();

    $annonce->setActive(1);
    $annonce->setIdetat($request->getParameter("idetat"));
    $annonce->setIdtype($request->getParameter("idtype"));
    $annonce->setIdmoteur($request->getParameter("idmoteur"));
    $annonce->setIdboite($request->getParameter("idboite"));
    $annonce->setKilometrage($request->getParameter("kilometrage"));
    $annonce->setAnneeded($request->getParameter("anneeded"));
    $annonce->setMoisded($request->getParameter("moisded"));
    $annonce->setAnneecir($request->getParameter("anneecir"));
    $annonce->setMoiscir($request->getParameter("moiscir"));
    $annonce->setPrixstart($request->getParameter("prixstart"));
    $annonce->setAnneegarantie($request->getParameter("anneegarantie"));
    $annonce->setIdmodele($request->getParameter("idmodele"));
    $annonce->setIdmarque($request->getParameter("idmarque"));
    $annonce->setCylindres($request->getParameter("cylindres"));
    $annonce->setPfiscale($request->getParameter("pfiscale"));
    $annonce->setNbportes($request->getParameter("nbportes"));
    $annonce->setIdcouleur($request->getParameter("idcouleur"));
    $annonce->setIdcarosserie($request->getParameter("idcarosserie"));
    $annonce->setEtranger($request->getParameter("etranger"));
    $annonce->setDedouane($request->getParameter("dedouane"));
    $annonce->setGarantie($request->getParameter("garantie"));
    $annonce->setReprise($request->getParameter("reprise"));
    $annonce->setHand($request->getParameter("hand"));
    $annonce->setGaraged($request->getParameter("garaged"));
    $annonce->setUrgent($request->getParameter("urgent"));
    $annonce->setIdville($request->getParameter("ville"));
    $annonce->setIduser($this->getUser ()->getAttribute('user_id','','sfGuardSecurityUser'));
    $conn = Doctrine_Manager::connection();
    $conn->beginTransaction();
    $annonce->save();
    $accs = $request->getParameter("acc");
    for($i=0;$i<(int)count($accs);$i++){
        $acc = new CarAccessoires();
        $acc->setIdacc($accs[$i]);
        $acc->setIdauto($annonce->getIdauto());
        $acc->setActive(1);
        $acc->save();        
    }

    $prefix = $this->getUser ()->getAttribute ( Constantes::SESSION_PREFIX_ANNONCE );    
    $uploadDir = sfConfig::get("sf_upload_dir");
    $annonces_uploads = $uploadDir.'/annonces/';
    $finder = sfFinder::type('file');
    $finder = $finder->name($prefix.'*');
    $files = $finder->in($annonces_uploads);
    
    for($i=0;$i<count($files);$i++){
        $image = new CarImage();
        $image->setImage(basename($files[$i]));
        $image->save();
        $annonce_image = new CarImages();
        $annonce_image->setIdauto($annonce->getIdauto());
        $annonce_image->setIdimage($image->getIdimage());
        $annonce_image->save();
    }
    $conn->commit();
    $this->setTemplate('annonce');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->car_auto = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->car_auto);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->car_auto = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->car_auto);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    if ($this->getRoute()->getObject()->delete())
    {
      $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
    }

    $this->redirect('@car_auto');
  }

  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@car_auto');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@car_auto');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CarAuto'));
    try
    {
      // validate ids
      $ids = $validator->clean($ids);

      // execute batch
      $this->$method($request);
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
    }

    $this->redirect('@car_auto');
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $records = Doctrine_Query::create()
      ->from('CarAuto')
      ->whereIn('idauto', $ids)
      ->execute();

    foreach ($records as $record)
    {
      $record->delete();
    }

    $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
    $this->redirect('@car_auto');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      try {
        $car_auto = $form->save();
      } catch (Doctrine_Validator_Exception $e) {

        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $car_auto)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@car_auto_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'car_auto_edit', 'sf_subject' => $car_auto));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }

  protected function getFilters()
  {
    return $this->getUser()->getAttribute('annonce.filters', $this->configuration->getFilterDefaults(), 'admin_module');
  }

  protected function setFilters(array $filters)
  {
    return $this->getUser()->setAttribute('annonce.filters', $filters, 'admin_module');
  }

  protected function getPager()
  {
    $pager = $this->configuration->getPager('CarAuto');
    $pager->setQuery($this->buildQuery());
    $pager->setPage($this->getPage());
    $pager->init();

    return $pager;
  }

  protected function setPage($page)
  {
    $this->getUser()->setAttribute('annonce.page', $page, 'admin_module');
  }

  protected function getPage()
  {
    return $this->getUser()->getAttribute('annonce.page', 1, 'admin_module');
  }

  protected function buildQuery()
  {
    $tableMethod = $this->configuration->getTableMethod();
    if (null === $this->filters)
    {
      $this->filters = $this->configuration->getFilterForm($this->getFilters());
    }

    $this->filters->setTableMethod($tableMethod);

    $query = $this->filters->buildQuery($this->getFilters());

    $this->addSortQuery($query);

    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_query'), $query);
    $query = $event->getReturnValue();

    return $query;
  }

  protected function addSortQuery($query)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function getSort()
  {
    if (null !== $sort = $this->getUser()->getAttribute('annonce.sort', null, 'admin_module'))
    {
      return $sort;
    }

    $this->setSort($this->configuration->getDefaultSort());

    return $this->getUser()->getAttribute('annonce.sort', null, 'admin_module');
  }

  protected function setSort(array $sort)
  {
    if (null !== $sort[0] && null === $sort[1])
    {
      $sort[1] = 'asc';
    }

    $this->getUser()->setAttribute('annonce.sort', $sort, 'admin_module');
  }

  protected function isValidSortColumn($column)
  {
    return Doctrine::getTable('CarAuto')->hasColumn($column);
  }

  public function executeMarquesjson(sfWebRequest $request)
  {
    $this->setTemplate('marquesjson');
  }

  public function executeShow(sfWebRequest $request)
  {
    
  }

  public function executeSave(sfWebRequest $request)
  {

  }
}
