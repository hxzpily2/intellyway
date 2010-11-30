<?php

/**
 * CarCarosserie form base class.
 *
 * @method CarCarosserie getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarCarosserieForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idcarosserie' => new sfWidgetFormInputHidden(),
      'title'        => new sfWidgetFormTextarea(),
      'description'  => new sfWidgetFormTextarea(),
      'active'       => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idcarosserie' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idcarosserie', 'required' => false)),
      'title'        => new sfValidatorString(),
      'description'  => new sfValidatorString(),
      'active'       => new sfValidatorInteger(),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_carosserie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarCarosserie';
  }

}
