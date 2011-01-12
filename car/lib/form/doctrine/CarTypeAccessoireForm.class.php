<?php

/**
 * CarTypeAccessoire form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarTypeAccessoireForm extends BaseCarTypeAccessoireForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idtypeacc'   => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormTextarea(),
      'description' => new sfWidgetFormTextarea(),
      'active'      => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),
    ));

    $this->setValidators(array(
      'idtypeacc'   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idtypeacc', 'required' => false)),
      'title'       => new sfValidatorString(),
      'description' => new sfValidatorString(),
      'active'      => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('car_type_accessoire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
