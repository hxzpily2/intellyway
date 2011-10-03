<?php

/**
 * CarAccessoireExt form base class.
 *
 * @method CarAccessoireExt getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarAccessoireExtForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idacc'      => new sfWidgetFormInputHidden(),
      'idauto'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'add_empty' => true)),
      'title'      => new sfWidgetFormTextarea(),
      'active'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idacc'      => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idacc', 'required' => false)),
      'idauto'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'required' => false)),
      'title'      => new sfValidatorString(),
      'active'     => new sfValidatorInteger(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_accessoire_ext[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarAccessoireExt';
  }

}