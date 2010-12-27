<?php

/**
 * CarCon form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarConForm extends BaseCarConForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idcon'          => new sfWidgetFormInputHidden(),
      'idmarque'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarMarque'), 'add_empty' => true)),
      'idville'        => new sfWidgetFormInputHidden(),
      'adresse'        => new sfWidgetFormTextarea(),
      'tel1'           => new sfWidgetFormTextarea(),
      'tel2'           => new sfWidgetFormTextarea(),
      'fax'            => new sfWidgetFormTextarea(),      
      'active'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),
      
    ));

    $this->setValidators(array(
      'idcon'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idcon', 'required' => false)),
      'idmarque'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarMarque'), 'required' => false)),
      'idville'        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idville', 'required' => false)),
      'adresse'        => new sfValidatorString(),
      'tel1'           => new sfValidatorString(),
      'tel2'           => new sfValidatorString(),
      'fax'            => new sfValidatorString(),
      'active'         => new sfValidatorBoolean(),      
    ));

    $this->widgetSchema->setNameFormat('car_con[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
