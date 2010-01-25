<?php

/**
 * AmjiCastResponseGroup form base class.
 *
 * @method AmjiCastResponseGroup getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiCastResponseGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_response' => new sfWidgetFormInputHidden(),
      'iduser'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'), 'add_empty' => false)),
      'active'          => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_response' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_response', 'required' => false)),
      'iduser'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'))),
      'active'          => new sfValidatorInteger(),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_cast_response_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiCastResponseGroup';
  }

}
