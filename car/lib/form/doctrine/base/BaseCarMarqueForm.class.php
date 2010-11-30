<?php

/**
 * CarMarque form base class.
 *
 * @method CarMarque getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarMarqueForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idmarque'    => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormTextarea(),
      'information' => new sfWidgetFormTextarea(),
      'description' => new sfWidgetFormTextarea(),
      'active'      => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idmarque'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idmarque', 'required' => false)),
      'title'       => new sfValidatorString(),
      'information' => new sfValidatorString(),
      'description' => new sfValidatorString(),
      'active'      => new sfValidatorInteger(),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_marque[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarMarque';
  }

}