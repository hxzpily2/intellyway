<?php

/**
 * CarImages form base class.
 *
 * @method CarImages getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarImagesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idimage'    => new sfWidgetFormInputHidden(),
      'idauto'     => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idimage'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idimage', 'required' => false)),
      'idauto'     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idauto', 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_images[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarImages';
  }

}
