<?php

/**
 * CarProposition form base class.
 *
 * @method CarProposition getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarPropositionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idproposition' => new sfWidgetFormInputHidden(),
      'idencher'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarEncher'), 'add_empty' => true)),
      'idgroup'       => new sfWidgetFormInputText(),
      'iduser'        => new sfWidgetFormInputText(),
      'prix'          => new sfWidgetFormInputText(),
      'accepted'      => new sfWidgetFormInputText(),
      'active'        => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idproposition' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idproposition', 'required' => false)),
      'idencher'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarEncher'), 'required' => false)),
      'idgroup'       => new sfValidatorInteger(array('required' => false)),
      'iduser'        => new sfValidatorInteger(array('required' => false)),
      'prix'          => new sfValidatorInteger(array('required' => false)),
      'accepted'      => new sfValidatorInteger(),
      'active'        => new sfValidatorInteger(),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_proposition[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarProposition';
  }

}
