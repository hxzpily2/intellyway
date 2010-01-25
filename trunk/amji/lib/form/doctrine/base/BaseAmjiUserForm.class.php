<?php

/**
 * AmjiUser form base class.
 *
 * @method AmjiUser getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_user'   => new sfWidgetFormInputHidden(),
      'pseudo'        => new sfWidgetFormInputText(),
      'email'         => new sfWidgetFormInputText(),
      'nom'           => new sfWidgetFormInputText(),
      'prenom'        => new sfWidgetFormInputText(),
      'adr'           => new sfWidgetFormInputText(),
      'tel'           => new sfWidgetFormInputText(),
      'etudiant'      => new sfWidgetFormInputText(),
      'ecole'         => new sfWidgetFormInputText(),
      'niveau'        => new sfWidgetFormInputText(),
      'salarie'       => new sfWidgetFormInputText(),
      'statut'        => new sfWidgetFormInputText(),
      'societe'       => new sfWidgetFormInputText(),
      'image'         => new sfWidgetFormInputText(),
      'idamji_statut' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiStatut'), 'add_empty' => true)),
      'thanks'        => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_user'   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_user', 'required' => false)),
      'pseudo'        => new sfValidatorString(array('max_length' => 100)),
      'email'         => new sfValidatorString(array('max_length' => 100)),
      'nom'           => new sfValidatorString(array('max_length' => 100)),
      'prenom'        => new sfValidatorString(array('max_length' => 100)),
      'adr'           => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'tel'           => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'etudiant'      => new sfValidatorInteger(array('required' => false)),
      'ecole'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'niveau'        => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'salarie'       => new sfValidatorInteger(array('required' => false)),
      'statut'        => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'societe'       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'image'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'idamji_statut' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiStatut'), 'required' => false)),
      'thanks'        => new sfValidatorInteger(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiUser';
  }

}
