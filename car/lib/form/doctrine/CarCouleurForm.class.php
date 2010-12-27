<?php

/**
 * CarCouleur form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarCouleurForm extends BaseCarCouleurForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idcouleur'  => new sfWidgetFormInputHidden(),
      'title'      => new sfWidgetFormTextarea(),
      'hexrep'     => new sfWidgetFormInputText(),
      'active'     => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),     
    ));

    $this->setValidators(array(
      'idcouleur'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idcouleur', 'required' => false)),
      'title'      => new sfValidatorString(),
      'hexrep'     => new sfValidatorString(array('max_length' => 8)),
      'active'     => new sfValidatorBoolean(),      
    ));

    $this->widgetSchema->setNameFormat('car_couleur[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
