<?php

/**
 * CarAutoPrestations form base class.
 *
 * @method CarAutoPrestations getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarAutoPrestationsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'idprestation' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarPrestation'), 'add_empty' => true)),
      'idauto'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'add_empty' => true)),
      'iduser'       => new sfWidgetFormInputText(),
      'prix'         => new sfWidgetFormInputText(),
      'active'       => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'idprestation' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarPrestation'), 'required' => false)),
      'idauto'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'required' => false)),
      'iduser'       => new sfValidatorInteger(array('required' => false)),
      'prix'         => new sfValidatorInteger(array('required' => false)),
      'active'       => new sfValidatorInteger(),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_auto_prestations[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarAutoPrestations';
  }

}
