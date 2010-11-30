<?php

/**
 * CarPays form base class.
 *
 * @method CarPays getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarPaysForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idpays'     => new sfWidgetFormInputHidden(),
      'title'      => new sfWidgetFormTextarea(),
      'active'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idpays'     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idpays', 'required' => false)),
      'title'      => new sfValidatorString(),
      'active'     => new sfValidatorInteger(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_pays[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarPays';
  }

}
