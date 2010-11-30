<?php

/**
 * CarImage form base class.
 *
 * @method CarImage getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarImageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idimage'    => new sfWidgetFormInputHidden(),
      'image'      => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idimage'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idimage', 'required' => false)),
      'image'      => new sfValidatorString(array('max_length' => 200)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_image[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarImage';
  }

}
