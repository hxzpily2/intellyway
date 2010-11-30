<?php

/**
 * CarPrestation form base class.
 *
 * @method CarPrestation getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarPrestationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idprestation' => new sfWidgetFormInputHidden(),
      'type'         => new sfWidgetFormTextarea(),
      'prix'         => new sfWidgetFormInputText(),
      'active'       => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idprestation' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idprestation', 'required' => false)),
      'type'         => new sfValidatorString(array('required' => false)),
      'prix'         => new sfValidatorInteger(array('required' => false)),
      'active'       => new sfValidatorInteger(),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_prestation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarPrestation';
  }

}
