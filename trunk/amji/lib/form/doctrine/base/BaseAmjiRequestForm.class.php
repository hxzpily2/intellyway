<?php

/**
 * AmjiRequest form base class.
 *
 * @method AmjiRequest getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiRequestForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_request' => new sfWidgetFormInputHidden(),
      'title'          => new sfWidgetFormTextarea(),
      'content'        => new sfWidgetFormTextarea(),
      'iduser'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'), 'add_empty' => false)),
      'idpriorite'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiPriorite'), 'add_empty' => false)),
      'idtype'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiType'), 'add_empty' => false)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_request' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_request', 'required' => false)),
      'title'          => new sfValidatorString(),
      'content'        => new sfValidatorString(),
      'iduser'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'))),
      'idpriorite'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiPriorite'))),
      'idtype'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiType'))),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_request[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiRequest';
  }

}
