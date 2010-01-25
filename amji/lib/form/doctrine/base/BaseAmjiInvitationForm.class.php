<?php

/**
 * AmjiInvitation form base class.
 *
 * @method AmjiInvitation getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiInvitationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_user'   => new sfWidgetFormInputHidden(),
      'idamji_invite' => new sfWidgetFormInputHidden(),
      'message'       => new sfWidgetFormTextarea(),
      'accepted'      => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_user'   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_user', 'required' => false)),
      'idamji_invite' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_invite', 'required' => false)),
      'message'       => new sfValidatorString(),
      'accepted'      => new sfValidatorInteger(),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_invitation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiInvitation';
  }

}
