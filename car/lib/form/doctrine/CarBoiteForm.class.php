<?php

/**
 * CarBoite form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarBoiteForm extends BaseCarBoiteForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idboite'     => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormTextarea(),
      'description' => new sfWidgetFormTextarea(),
      'active'      => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),
    ));

    $this->setValidators(array(
      'idboite'     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idboite', 'required' => false)),
      'title'       => new sfValidatorString(),
      'description' => new sfValidatorString(),
      'active'      => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('car_boite[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
