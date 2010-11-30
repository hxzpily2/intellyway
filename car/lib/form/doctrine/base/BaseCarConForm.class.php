<?php

/**
 * CarCon form base class.
 *
 * @method CarCon getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarConForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idmarque'   => new sfWidgetFormInputHidden(),
      'idville'    => new sfWidgetFormInputHidden(),
      'adresse'    => new sfWidgetFormTextarea(),
      'tel1'       => new sfWidgetFormTextarea(),
      'tel2'       => new sfWidgetFormTextarea(),
      'fax'        => new sfWidgetFormTextarea(),
      'active'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idmarque'   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idmarque', 'required' => false)),
      'idville'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idville', 'required' => false)),
      'adresse'    => new sfValidatorString(),
      'tel1'       => new sfValidatorString(),
      'tel2'       => new sfValidatorString(),
      'fax'        => new sfValidatorString(),
      'active'     => new sfValidatorInteger(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_con[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarCon';
  }

}
