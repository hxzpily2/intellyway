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
      'code'       => new sfWidgetFormInputText(),
      'bigcode'    => new sfWidgetFormInputText(),  	
      'active'     => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),      
    ));

    $this->setValidators(array(
      'idpays'     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idpays', 'required' => false)),
      'title'      => new sfValidatorString(),
      'code'       => new sfValidatorString(array('max_length' => 2)),
      'bigcode'    => new sfValidatorString(array('max_length' => 3)),    
      'active'     => new sfValidatorBoolean(),      
    ));

    $this->widgetSchema->setNameFormat('car_pays[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
