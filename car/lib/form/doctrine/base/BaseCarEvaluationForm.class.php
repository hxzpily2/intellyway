<?php

/**
 * CarEvaluation form base class.
 *
 * @method CarEvaluation getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarEvaluationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'idevaluation' => new sfWidgetFormInputText(),
      'iduser'       => new sfWidgetFormInputText(),
      'idauto'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'add_empty' => true)),
      'noteprix'     => new sfWidgetFormInputText(),
      'notemoteur'   => new sfWidgetFormInputText(),
      'notekm'       => new sfWidgetFormInputText(),
      'noteconso'    => new sfWidgetFormInputText(),
      'noteetat'     => new sfWidgetFormInputText(),
      'noteoption'   => new sfWidgetFormInputText(),
      'noteglobal'   => new sfWidgetFormInputText(),
      'active'       => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'idevaluation' => new sfValidatorInteger(array('required' => false)),
      'iduser'       => new sfValidatorInteger(array('required' => false)),
      'idauto'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'required' => false)),
      'noteprix'     => new sfValidatorInteger(array('required' => false)),
      'notemoteur'   => new sfValidatorInteger(array('required' => false)),
      'notekm'       => new sfValidatorInteger(array('required' => false)),
      'noteconso'    => new sfValidatorInteger(array('required' => false)),
      'noteetat'     => new sfValidatorInteger(array('required' => false)),
      'noteoption'   => new sfValidatorInteger(array('required' => false)),
      'noteglobal'   => new sfValidatorInteger(array('required' => false)),
      'active'       => new sfValidatorInteger(),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_evaluation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarEvaluation';
  }

}
