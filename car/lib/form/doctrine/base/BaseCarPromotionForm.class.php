<?php

/**
 * CarPromotion form base class.
 *
 * @method CarPromotion getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarPromotionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'idpromotion' => new sfWidgetFormInputText(),
      'idcon'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarCon'), 'add_empty' => true)),
      'idauto'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'add_empty' => true)),
      'prix'        => new sfWidgetFormInputText(),
      'datedebut'   => new sfWidgetFormDateTime(),
      'datefin'     => new sfWidgetFormDateTime(),
      'active'      => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'idpromotion' => new sfValidatorInteger(array('required' => false)),
      'idcon'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarCon'), 'required' => false)),
      'idauto'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'required' => false)),
      'prix'        => new sfValidatorInteger(array('required' => false)),
      'datedebut'   => new sfValidatorDateTime(),
      'datefin'     => new sfValidatorDateTime(),
      'active'      => new sfValidatorInteger(),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_promotion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarPromotion';
  }

}
