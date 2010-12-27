<?php

/**
 * CarModele form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarModeleForm extends BaseCarModeleForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idmodele'       => new sfWidgetFormInputHidden(),
      'idmarque'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarMarque'), 'add_empty' => true)),
      'title'          => new sfWidgetFormTextarea(),
      'description'    => new sfWidgetFormTextarea(),      
      'active'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),      
    ));

    $this->setValidators(array(
      'idmodele'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idmodele', 'required' => false)),
      'idmarque'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarMarque'), 'required' => false)),
      'title'          => new sfValidatorString(),
      'description'    => new sfValidatorString(),      
      'active'         => new sfValidatorBoolean(),    
    ));

    $this->widgetSchema->setNameFormat('car_modele[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
