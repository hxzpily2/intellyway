<?php

/**
 * AmjiEventUser form base class.
 *
 * @method AmjiEventUser getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiEventUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_user'  => new sfWidgetFormInputHidden(),
      'idamji_event' => new sfWidgetFormInputHidden(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_user'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_user', 'required' => false)),
      'idamji_event' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_event', 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_event_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiEventUser';
  }

}
