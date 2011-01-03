<?php

/**
 * Country form base class.
 *
 * @method Country getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCountryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'iso'            => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'printable_name' => new sfWidgetFormInputText(),
      'iso3'           => new sfWidgetFormInputText(),
      'numcode'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'iso'            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'iso', 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'printable_name' => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'iso3'           => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'numcode'        => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('country[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Country';
  }

}
