<?php

/**
 * CarCreneau form base class.
 *
 * @method CarCreneau getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarCreneauForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idcrenau'   => new sfWidgetFormInputHidden(),
      'idauto'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'add_empty' => true)),
      'iduser'     => new sfWidgetFormInputText(),
      'dated'      => new sfWidgetFormDateTime(),
      'heured'     => new sfWidgetFormInputText(),
      'mind'       => new sfWidgetFormInputText(),
      'heuref'     => new sfWidgetFormInputText(),
      'minf'       => new sfWidgetFormInputText(),
      'active'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idcrenau'   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idcrenau', 'required' => false)),
      'idauto'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'required' => false)),
      'iduser'     => new sfValidatorInteger(array('required' => false)),
      'dated'      => new sfValidatorDateTime(),
      'heured'     => new sfValidatorInteger(array('required' => false)),
      'mind'       => new sfValidatorInteger(array('required' => false)),
      'heuref'     => new sfValidatorInteger(array('required' => false)),
      'minf'       => new sfValidatorInteger(array('required' => false)),
      'active'     => new sfValidatorInteger(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_creneau[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarCreneau';
  }

}
