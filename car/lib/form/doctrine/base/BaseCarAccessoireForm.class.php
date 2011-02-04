<?php

/**
 * CarAccessoire form base class.
 *
 * @method CarAccessoire getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarAccessoireForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idacc'       => new sfWidgetFormInputHidden(),
      'idtypeacc'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarTypeAccessoire'), 'add_empty' => true)),
      'title'       => new sfWidgetFormTextarea(),
      'description' => new sfWidgetFormTextarea(),
      'active'      => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idacc'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idacc', 'required' => false)),
      'idtypeacc'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarTypeAccessoire'), 'required' => false)),
      'title'       => new sfValidatorString(),
      'description' => new sfValidatorString(),
      'active'      => new sfValidatorInteger(),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_accessoire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarAccessoire';
  }

}