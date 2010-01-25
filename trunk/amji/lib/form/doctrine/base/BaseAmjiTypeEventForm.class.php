<?php

/**
 * AmjiTypeEvent form base class.
 *
 * @method AmjiTypeEvent getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiTypeEventForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_type' => new sfWidgetFormInputHidden(),
      'libelle'     => new sfWidgetFormInputText(),
      'owner'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'), 'add_empty' => true)),
      'description' => new sfWidgetFormTextarea(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_type' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_type', 'required' => false)),
      'libelle'     => new sfValidatorString(array('max_length' => 100)),
      'owner'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'), 'required' => false)),
      'description' => new sfValidatorString(),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_type_event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiTypeEvent';
  }

}
