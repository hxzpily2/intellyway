<?php

/**
 * CarGar form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarGarForm extends BaseCarGarForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idgar'          => new sfWidgetFormInputHidden(),
      'title'          => new sfWidgetFormTextarea(),
      'information'    => new sfWidgetFormTextarea(),
      'description'    => new sfWidgetFormTextarea(),      
      'active'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),      
    ));

    $this->setValidators(array(
      'idgar'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idgar', 'required' => false)),
      'title'          => new sfValidatorString(),
      'information'    => new sfValidatorString(),
      'description'    => new sfValidatorString(),      
      'active'         => new sfValidatorBoolean(),      
    ));

    $this->widgetSchema->setNameFormat('car_gar[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
