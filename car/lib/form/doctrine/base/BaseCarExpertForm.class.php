<?php

/**
 * CarExpert form base class.
 *
 * @method CarExpert getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarExpertForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idexpert'    => new sfWidgetFormInputHidden(),
      'nom'         => new sfWidgetFormTextarea(),
      'prenom'      => new sfWidgetFormTextarea(),
      'description' => new sfWidgetFormTextarea(),
      'active'      => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idexpert'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idexpert', 'required' => false)),
      'nom'         => new sfValidatorString(),
      'prenom'      => new sfValidatorString(),
      'description' => new sfValidatorString(),
      'active'      => new sfValidatorInteger(),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_expert[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarExpert';
  }

}
