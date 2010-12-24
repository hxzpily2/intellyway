<?php

/**
 * CarPays form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarPaysForm extends BaseCarPaysForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idpays'     => new sfWidgetFormInputHidden(),
      'title'      => new sfWidgetFormTextarea(),
      'active'     => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),      
    ));

    $this->setValidators(array(
      'idpays'     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idpays', 'required' => false)),
      'title'      => new sfValidatorString(),
      'active'     => new sfValidatorBoolean(),      
    ));

    $this->widgetSchema->setNameFormat('car_pays[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
