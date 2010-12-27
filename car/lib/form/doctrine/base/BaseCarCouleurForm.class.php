<?php

/**
 * CarCouleur form base class.
 *
 * @method CarCouleur getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarCouleurForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idcouleur'  => new sfWidgetFormInputHidden(),
      'title'      => new sfWidgetFormTextarea(),
      'hexrep'     => new sfWidgetFormInputText(),
      'active'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idcouleur'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idcouleur', 'required' => false)),
      'title'      => new sfValidatorString(),
      'hexrep'     => new sfValidatorString(array('max_length' => 8)),
      'active'     => new sfValidatorInteger(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_couleur[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarCouleur';
  }

}
