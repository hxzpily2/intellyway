<?php

/**
 * AmjiEventNotification form base class.
 *
 * @method AmjiEventNotification getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiEventNotificationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_notif' => new sfWidgetFormInputHidden(),
      'owner'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'), 'add_empty' => true)),
      'periode'      => new sfWidgetFormInputText(),
      'type'         => new sfWidgetFormInputText(),
      'notifmail'    => new sfWidgetFormInputText(),
      'notifsms'     => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_notif' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_notif', 'required' => false)),
      'owner'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'), 'required' => false)),
      'periode'      => new sfValidatorInteger(array('required' => false)),
      'type'         => new sfValidatorString(array('max_length' => 100)),
      'notifmail'    => new sfValidatorInteger(),
      'notifsms'     => new sfValidatorInteger(),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_event_notification[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiEventNotification';
  }

}
