<?php

/**
 * CarAdresseLoc form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarAdresseLocForm extends BaseCarAdresseLocForm
{
  public function configure()
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
    ));

    $this->widgetSchema->setNameFormat('car_adresse_loc[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
