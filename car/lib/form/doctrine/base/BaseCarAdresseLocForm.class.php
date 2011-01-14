<?php

/**
 * CarAdresseLoc form base class.
 *
 * @method CarAdresseLoc getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarAdresseLocForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idadresseloc' => new sfWidgetFormInputHidden(),
      'idloc'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarLoc'), 'add_empty' => true)),
      'idville'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarVille'), 'add_empty' => true)),
      'adresse'      => new sfWidgetFormTextarea(),
      'tel1'         => new sfWidgetFormTextarea(),
      'tel2'         => new sfWidgetFormTextarea(),
      'fax'          => new sfWidgetFormTextarea(),
      'active'       => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idadresseloc' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idadresseloc', 'required' => false)),
      'idloc'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarLoc'), 'required' => false)),
      'idville'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarVille'), 'required' => false)),
      'adresse'      => new sfValidatorString(),
      'tel1'         => new sfValidatorString(),
      'tel2'         => new sfValidatorString(),
      'fax'          => new sfValidatorString(),
      'active'       => new sfValidatorInteger(),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_adresse_loc[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarAdresseLoc';
  }

}
