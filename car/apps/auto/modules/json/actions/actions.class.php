<?php

/**
 * json actions.
 *
 * @package    car
 * @subpackage json
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class jsonActions extends sfActions
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

  public function executeMarquesjson(sfWebRequest $request)
  {
    $data = CarMarque::getAllMarques();
    
    $i=0;
    $output = "";
    foreach ($data as $marque){
        $output .= "{'id':'".$marque->getIdmarque()."','name':'".$marque->getTitle()."'}";
        $i++;
        if($i!=count($data))
            $output .= ",";
    }
    
    $this->getResponse()->setHttpHeader('Content-type', 'application/json');
    
    $this->getResponse()->setContent("{'marques':[".$output."]}");
    
    return sfView::NONE;
  }

  public function executeEtatsjson(sfWebRequest $request)
  {
    $data = CarEtat::getAllEtats();

    $i=0;
    $output = "";
    foreach ($data as $marque){
        $output .= "{'id':'".$marque->getIdetat()."','name':'".$marque->getTitle()."'}";
        $i++;
        if($i!=count($data))
            $output .= ",";
    }

    $this->getResponse()->setHttpHeader('Content-type', 'application/json');

    $this->getResponse()->setContent("{'etats':[".$output."]}");

    return sfView::NONE;
  }

  public function executeTypesjson(sfWebRequest $request)
  {
    $data = CarType::getAllTypes();

    $i=0;
    $output = "";
    foreach ($data as $marque){
        $output .= "{'id':'".$marque->getIdtype()."','name':'".$marque->getDescription()."'}";
        $i++;
        if($i!=count($data))
            $output .= ",";
    }

    $this->getResponse()->setHttpHeader('Content-type', 'application/json');

    $this->getResponse()->setContent("{'types':[".$output."]}");

    return sfView::NONE;
  }

  public function executeCarosseriesjson(sfWebRequest $request)
  {
    $data = CarCarosserie::getAll();

    $i=0;
    $output = "";
    foreach ($data as $marque){
        $output .= "{'id':'".$marque->getIdcarosserie()."','name':'".$marque->getTitle()."'}";
        $i++;
        if($i!=count($data))
            $output .= ",";
    }

    $this->getResponse()->setHttpHeader('Content-type', 'application/json');

    $this->getResponse()->setContent("{'carosseries':[".$output."]}");

    return sfView::NONE;
  }

  public function executeMoteursjson(sfWebRequest $request)
  {
    $data = CarMoteur::getAll();

    $i=0;
    $output = "";
    foreach ($data as $marque){
        $output .= "{'id':'".$marque->getIdmoteur()."','name':'".$marque->getTitle()."'}";
        $i++;
        if($i!=count($data))
            $output .= ",";
    }

    $this->getResponse()->setHttpHeader('Content-type', 'application/json');

    $this->getResponse()->setContent("{'moteurs':[".$output."]}");

    return sfView::NONE;
  }

  public function executeBoitesjson(sfWebRequest $request)
  {
    $data = CarBoite::getAll();

    $i=0;
    $output = "";
    foreach ($data as $marque){
        $output .= "{'id':'".$marque->getIdboite()."','name':'".$marque->getTitle()."'}";
        $i++;
        if($i!=count($data))
            $output .= ",";
    }

    $this->getResponse()->setHttpHeader('Content-type', 'application/json');

    $this->getResponse()->setContent("{'boites':[".$output."]}");

    return sfView::NONE;
  }

  public function executeDedjson(sfWebRequest $request)
  {
    $i=0;
    $output = "";
    for($j=date("Y")-30;$j <= date("Y");$j++){           
           $output .= "{'id':'".$j."','name':'".$j."'}";
           if($j!=date("Y"))
               $output .= ",";
    }
    /*foreach ($data as $marque){
        $output .= "{'id':'".$marque->getIdboite()."','name':'".$marque->getTitle()."'}";
        $i++;
        if($i!=count($data))
            $output .= ",";
    }*/

    $this->getResponse()->setHttpHeader('Content-type', 'application/json');

    $this->getResponse()->setContent("{'annees':[".$output."]}");

    return sfView::NONE;
  }

  public function executeModelejson(sfWebRequest $request)
  {   

    $i=0;
    $output = "";
    if($request->getParameter("id")!=""){
        $data = CarModele::getAllByMarque($request->getParameter("id"));
        foreach ($data as $marque){
            $output .= "{'id':'".$marque->getIdmodele()."','name':'".$marque->getTitle()."'}";
            $i++;
            if($i!=count($data))
                $output .= ",";
        }
    }

    $this->getResponse()->setHttpHeader('Content-type', 'application/json');

    $this->getResponse()->setContent("{'modeles':[".$output."]}");

    return sfView::NONE;
  }

  public function executeColorjson(sfWebRequest $request)
  {

    $data = CarCouleur::getAll();

    $i=0;
    $output = "";
    foreach ($data as $marque){
        $output .= "{'id':'".$marque->getIdcouleur()."','name':'".$marque->getTitle()."'}";
        $i++;
        if($i!=count($data))
            $output .= ",";
    }

    $this->getResponse()->setHttpHeader('Content-type', 'application/json');

    $this->getResponse()->setContent("{'couleurs':[".$output."]}");

    return sfView::NONE;
  }
}
