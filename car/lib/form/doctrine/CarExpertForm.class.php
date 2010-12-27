<?php

/**
 * CarExpert form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarExpertForm extends BaseCarExpertForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idexpert'       => new sfWidgetFormInputHidden(),
      'nom'            => new sfWidgetFormTextarea(),
      'prenom'         => new sfWidgetFormTextarea(),
      'description'    => new sfWidgetFormTextarea(),
      'active'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),
    ));

    $this->setValidators(array(
      'idexpert'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idexpert', 'required' => false)),
      'nom'            => new sfValidatorString(),
      'prenom'         => new sfValidatorString(),
      'description'    => new sfValidatorString(),
      'active'         => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('car_expert[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
