<?php

/**
 * CarType form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarTypeForm extends BaseCarTypeForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idtype'      => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormTextarea(),
      'description' => new sfWidgetFormTextarea(),
      'active'      => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),      
    ));

    $this->setValidators(array(
      'idtype'      => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idtype', 'required' => false)),
      'title'       => new sfValidatorString(),
      'description' => new sfValidatorString(),
      'active'      => new sfValidatorBoolean(),      
    ));

    $this->widgetSchema->setNameFormat('car_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
