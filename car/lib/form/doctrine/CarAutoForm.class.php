<?php

/**
 * CarAuto form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarAutoForm extends BaseCarAutoForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idauto'         => new sfWidgetFormInputHidden(),
      'idpays'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarPays'), 'add_empty' => true)),  	
      'idmarque'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarMarque'), 'add_empty' => true)),
      'idmodele'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarModele'), 'add_empty' => true)),
      'idmoteur'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarMoteur'), 'add_empty' => true)),
      'idtype'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarType'), 'add_empty' => true)),
      'idetat'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarEtat'), 'add_empty' => true)),
      'idcouleur'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarCouleur'), 'add_empty' => true)),
      'idcarosserie'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarCarosserie'), 'add_empty' => true)),
      'idboite'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarBoite'), 'add_empty' => true)),
      'anneecir'       => new sfWidgetFormInputText(),
      'moiscir'        => new sfWidgetFormInputText(),
      'anneeded'       => new sfWidgetFormInputText(),
      'moisded'        => new sfWidgetFormInputText(),
      'description'    => new sfWidgetFormTextarea(),
      'nbportes'       => new sfWidgetFormInputText(),
      'pfiscale'       => new sfWidgetFormInputText(),
      'kilometrage'    => new sfWidgetFormInputText(),
      'cylindres'      => new sfWidgetFormInputText(),
      'prixstart'      => new sfWidgetFormInputText(),
      'reprise'        => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),
      'active'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),      
    ));

    $this->setValidators(array(
      'idauto'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idauto', 'required' => false)),
      'idpays'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarPays'), 'required' => false)),    
      'idmarque'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarMarque'), 'required' => false)),
      'idmodele'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarModele'), 'required' => false)),
      'idmoteur'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarMoteur'), 'required' => false)),
      'idtype'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarType'), 'required' => false)),
      'idetat'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarEtat'), 'required' => false)),
      'idcouleur'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarCouleur'), 'required' => false)),
      'idcarosserie'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarCarosserie'), 'required' => false)),
      'idboite'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarBoite'), 'required' => false)),
      'anneecir'       => new sfValidatorInteger(array('required' => false)),
      'moiscir'        => new sfValidatorInteger(array('required' => false)),
      'anneeded'       => new sfValidatorInteger(array('required' => false)),
      'moisded'        => new sfValidatorInteger(array('required' => false)),
      'description'    => new sfValidatorString(),
      'nbportes'       => new sfValidatorInteger(array('required' => false)),
      'pfiscale'       => new sfValidatorInteger(array('required' => false)),
      'kilometrage'    => new sfValidatorInteger(array('required' => false)),
      'cylindres'      => new sfValidatorInteger(array('required' => false)),
      'prixstart'      => new sfValidatorInteger(array('required' => false)),
      'reprise'        => new sfValidatorBoolean(),	
      'active'         => new sfValidatorBoolean(),	      
    ));

    $this->widgetSchema->setNameFormat('car_auto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
