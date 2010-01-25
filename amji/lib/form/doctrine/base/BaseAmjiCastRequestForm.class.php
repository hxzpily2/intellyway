<?php

/**
 * AmjiCastRequest form base class.
 *
 * @method AmjiCastRequest getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiCastRequestForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_request' => new sfWidgetFormInputHidden(),
      'iduser'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'), 'add_empty' => false)),
      'active'         => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_request' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_request', 'required' => false)),
      'iduser'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'))),
      'active'         => new sfValidatorInteger(),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_cast_request[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiCastRequest';
  }

}
