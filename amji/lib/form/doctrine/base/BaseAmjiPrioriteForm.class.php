<?php

/**
 * AmjiPriorite form base class.
 *
 * @method AmjiPriorite getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiPrioriteForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_priorite' => new sfWidgetFormInputHidden(),
      'libelle'         => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_priorite' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_priorite', 'required' => false)),
      'libelle'         => new sfValidatorString(array('max_length' => 100)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_priorite[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiPriorite';
  }

}
