<?php

/**
 * Ip2country form base class.
 *
 * @method Ip2country getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseIp2countryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ip_from'       => new sfWidgetFormInputHidden(),
      'ip_to'         => new sfWidgetFormInputText(),
      'country_code2' => new sfWidgetFormInputText(),
      'country_code3' => new sfWidgetFormInputText(),
      'country_name'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ip_from'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'ip_from', 'required' => false)),
      'ip_to'         => new sfValidatorInteger(array('required' => false)),
      'country_code2' => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'country_code3' => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'country_name'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ip2country[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ip2country';
  }

}
