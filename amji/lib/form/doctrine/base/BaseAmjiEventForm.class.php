<?php

/**
 * AmjiEvent form base class.
 *
 * @method AmjiEvent getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiEventForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_event' => new sfWidgetFormInputHidden(),
      'content'      => new sfWidgetFormTextarea(),
      'title'        => new sfWidgetFormTextarea(),
      'iduser'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'), 'add_empty' => false)),
      'datedebut'    => new sfWidgetFormDateTime(),
      'datefin'      => new sfWidgetFormDateTime(),
      'active'       => new sfWidgetFormInputText(),
      'idtype'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiTypeEvent'), 'add_empty' => false)),
      'idpriorite'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiPrioriteEvent'), 'add_empty' => false)),
      'idnotif'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiEventNotification'), 'add_empty' => true)),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_event' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_event', 'required' => false)),
      'content'      => new sfValidatorString(),
      'title'        => new sfValidatorString(),
      'iduser'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'))),
      'datedebut'    => new sfValidatorDateTime(),
      'datefin'      => new sfValidatorDateTime(),
      'active'       => new sfValidatorInteger(),
      'idtype'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiTypeEvent'))),
      'idpriorite'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiPrioriteEvent'))),
      'idnotif'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiEventNotification'), 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiEvent';
  }

}
