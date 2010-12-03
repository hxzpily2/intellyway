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
      'idcon'          => new sfWidgetFormInputHidden(),
      'idmarque'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarMarque'), 'add_empty' => true)),
      'idville'        => new sfWidgetFormInputHidden(),
      'adresse'        => new sfWidgetFormTextarea(),
      'tel1'           => new sfWidgetFormTextarea(),
      'tel2'           => new sfWidgetFormTextarea(),
      'fax'            => new sfWidgetFormTextarea(),
      'notevisiteur'   => new sfWidgetFormInputText(),
      'nbnotevisiteur' => new sfWidgetFormInputText(),
      'noteadmin'      => new sfWidgetFormInputText(),
      'nbnoteadmin'    => new sfWidgetFormInputText(),
      'active'         => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idcon'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idcon', 'required' => false)),
      'idmarque'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarMarque'), 'required' => false)),
      'idville'        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idville', 'required' => false)),
      'adresse'        => new sfValidatorString(),
      'tel1'           => new sfValidatorString(),
      'tel2'           => new sfValidatorString(),
      'fax'            => new sfValidatorString(),
      'notevisiteur'   => new sfValidatorInteger(array('required' => false)),
      'nbnotevisiteur' => new sfValidatorInteger(array('required' => false)),
      'noteadmin'      => new sfValidatorInteger(array('required' => false)),
      'nbnoteadmin'    => new sfValidatorInteger(array('required' => false)),
      'active'         => new sfValidatorInteger(),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
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
