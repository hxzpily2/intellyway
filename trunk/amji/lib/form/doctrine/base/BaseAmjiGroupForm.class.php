<?php

/**
 * AmjiGroup form base class.
 *
 * @method AmjiGroup getObject() Returns the current form's model object
 *
 * @package    amji
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAmjiGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idamji_group' => new sfWidgetFormInputHidden(),
      'title'        => new sfWidgetFormInputText(),
      'owner'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'), 'add_empty' => false)),
      'description'  => new sfWidgetFormTextarea(),
      'active'       => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idamji_group' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idamji_group', 'required' => false)),
      'title'        => new sfValidatorString(array('max_length' => 100)),
      'owner'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AmjiUser'))),
      'description'  => new sfValidatorString(),
      'active'       => new sfValidatorInteger(),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('amji_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AmjiGroup';
  }

}
