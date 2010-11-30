<?php

/**
 * CarEvent form base class.
 *
 * @method CarEvent getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarEventForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idevent'    => new sfWidgetFormInputHidden(),
      'content'    => new sfWidgetFormTextarea(),
      'title'      => new sfWidgetFormTextarea(),
      'datedebut'  => new sfWidgetFormDateTime(),
      'datefin'    => new sfWidgetFormDateTime(),
      'image'      => new sfWidgetFormInputText(),
      'active'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idevent'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idevent', 'required' => false)),
      'content'    => new sfValidatorString(),
      'title'      => new sfValidatorString(),
      'datedebut'  => new sfValidatorDateTime(),
      'datefin'    => new sfValidatorDateTime(),
      'image'      => new sfValidatorString(array('max_length' => 200)),
      'active'     => new sfValidatorInteger(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarEvent';
  }

}
