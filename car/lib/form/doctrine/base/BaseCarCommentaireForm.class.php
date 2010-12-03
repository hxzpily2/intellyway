<?php

/**
 * CarCommentaire form base class.
 *
 * @method CarCommentaire getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarCommentaireForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idcommentaire' => new sfWidgetFormInputHidden(),
      'idauto'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'add_empty' => true)),
      'iduser'        => new sfWidgetFormInputText(),
      'commentaire'   => new sfWidgetFormTextarea(),
      'active'        => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idcommentaire' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idcommentaire', 'required' => false)),
      'idauto'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'required' => false)),
      'iduser'        => new sfValidatorInteger(array('required' => false)),
      'commentaire'   => new sfValidatorString(),
      'active'        => new sfValidatorInteger(),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('car_commentaire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarCommentaire';
  }

}
