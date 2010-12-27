<?php

/**
 * CarVille form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarVilleForm extends BaseCarVilleForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idville'    => new sfWidgetFormInputHidden(),
      'title'      => new sfWidgetFormTextarea(),
      'idpays'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarPays'), 'add_empty' => true)),
      'active'     => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),      
    ));

    $this->setValidators(array(
      'idville'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idville', 'required' => false)),
      'title'      => new sfValidatorString(),
      'idpays'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarPays'), 'required' => false)),
      'active'     => new sfValidatorBoolean(),      
    ));

    $this->widgetSchema->setNameFormat('car_ville[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
