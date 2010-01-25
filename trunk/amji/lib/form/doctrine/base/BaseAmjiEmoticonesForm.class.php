<?php

/**
 * AmjiEmoticones form base class.
 *
 * @method AmjiEmoticones getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiEmoticonesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_emoticones' => new sfWidgetFormInputHidden(),
      'racourci'          => new sfWidgetFormInputText(),
      'image'             => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_emoticones' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_emoticones', 'required' => false)),
      'racourci'          => new sfValidatorString(array('max_length' => 100)),
      'image'             => new sfValidatorString(array('max_length' => 200)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_emoticones[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiEmoticones';
  }

}
