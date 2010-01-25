<?php

/**
 * AmjiResponseGroup form base class.
 *
 * @method AmjiResponseGroup getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiResponseGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_response' => new sfWidgetFormInputHidden(),
      'content'         => new sfWidgetFormTextarea(),
      'iduser'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'), 'add_empty' => false)),
      'idrequest'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiRequestGroup'), 'add_empty' => false)),
      'idresponse'      => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_response' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_response', 'required' => false)),
      'content'         => new sfValidatorString(),
      'iduser'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'))),
      'idrequest'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiRequestGroup'))),
      'idresponse'      => new sfValidatorInteger(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_response_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiResponseGroup';
  }

}
