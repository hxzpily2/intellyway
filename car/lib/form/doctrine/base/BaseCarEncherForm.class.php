<?php

/**
 * CarEncher form base class.
 *
 * @method CarEncher getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarEncherForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idencher'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarProposition'), 'add_empty' => true)),
      'idauto'     => new sfWidgetFormInputHidden(),
      'iduser'     => new sfWidgetFormInputText(),
      'prixstart'  => new sfWidgetFormInputText(),
      'datedebut'  => new sfWidgetFormDateTime(),
      'datefin'    => new sfWidgetFormDateTime(),
      'active'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idencher'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarProposition'), 'required' => false)),
      'idauto'     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idauto', 'required' => false)),
      'iduser'     => new sfValidatorInteger(array('required' => false)),
      'prixstart'  => new sfValidatorInteger(array('required' => false)),
      'datedebut'  => new sfValidatorDateTime(),
      'datefin'    => new sfValidatorDateTime(),
      'active'     => new sfValidatorInteger(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_encher[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarEncher';
  }

}
