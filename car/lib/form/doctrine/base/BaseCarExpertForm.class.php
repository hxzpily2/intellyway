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
      'idexpert'       => new sfWidgetFormInputHidden(),
      'nom'            => new sfWidgetFormTextarea(),
      'prenom'         => new sfWidgetFormTextarea(),
      'description'    => new sfWidgetFormTextarea(),
      'notevisiteur'   => new sfWidgetFormInputText(),
      'nbnotevisiteur' => new sfWidgetFormInputText(),
      'noteadmin'      => new sfWidgetFormInputText(),
      'nbnoteadmin'    => new sfWidgetFormInputText(),
      'active'         => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idexpert'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idexpert', 'required' => false)),
      'nom'            => new sfValidatorString(),
      'prenom'         => new sfValidatorString(),
      'description'    => new sfValidatorString(),
      'notevisiteur'   => new sfValidatorInteger(array('required' => false)),
      'nbnotevisiteur' => new sfValidatorInteger(array('required' => false)),
      'noteadmin'      => new sfValidatorInteger(array('required' => false)),
      'nbnoteadmin'    => new sfValidatorInteger(array('required' => false)),
      'active'         => new sfValidatorInteger(),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
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