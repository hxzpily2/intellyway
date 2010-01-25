<?php

/**
 * AmjiRequestAttachment form base class.
 *
 * @method AmjiRequestAttachment getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiRequestAttachmentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_file'    => new sfWidgetFormInputHidden(),
      'idamji_request' => new sfWidgetFormInputHidden(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_file'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_file', 'required' => false)),
      'idamji_request' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_request', 'required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_request_attachment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiRequestAttachment';
  }

}
