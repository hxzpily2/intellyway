<?php

/**
 * CarVille form base class.
 *
 * @method CarVille getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarVilleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idville'    => new sfWidgetFormInputHidden(),
      'title'      => new sfWidgetFormTextarea(),
      'idpays'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarPays'), 'add_empty' => true)),
      'active'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idville'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idville', 'required' => false)),
      'title'      => new sfValidatorString(),
      'idpays'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarPays'), 'required' => false)),
      'active'     => new sfValidatorInteger(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_ville[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarVille';
  }

}
