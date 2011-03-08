<?php

/**
 * aCategoryGroup form base class.
 *
 * @method aCategoryGroup getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseaCategoryGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'category_id' => new sfWidgetFormInputHidden(),
      'group_id'    => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'category_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'category_id', 'required' => false)),
      'group_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'group_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('a_category_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'aCategoryGroup';
  }

}
