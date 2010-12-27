<?php

/**
 * CarMoteur form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarMoteurForm extends BaseCarMoteurForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idmoteur'    => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormTextarea(),
      'description' => new sfWidgetFormTextarea(),
      'active'      => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),
    ));

    $this->setValidators(array(
      'idmoteur'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idmoteur', 'required' => false)),
      'title'       => new sfValidatorString(),
      'description' => new sfValidatorString(),
      'active'      => new sfValidatorBoolean(),      
    ));

    $this->widgetSchema->setNameFormat('car_moteur[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
