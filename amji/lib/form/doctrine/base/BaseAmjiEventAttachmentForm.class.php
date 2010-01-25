<?php

/**
 * AmjiEventAttachment form base class.
 *
 * @method AmjiEventAttachment getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiEventAttachmentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_event' => new sfWidgetFormInputHidden(),
      'idamji_file'  => new sfWidgetFormInputHidden(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_event' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_event', 'required' => false)),
      'idamji_file'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_file', 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_event_attachment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiEventAttachment';
  }

}
