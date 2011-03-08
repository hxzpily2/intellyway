<?php

/**
 * aEmbedMediaAccount form base class.
 *
 * @method aEmbedMediaAccount getObject() Returns the current form's model object
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseaEmbedMediaAccountForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'service'  => new sfWidgetFormInputText(),
      'username' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'service'  => new sfValidatorString(array('max_length' => 100)),
      'username' => new sfValidatorString(array('max_length' => 100)),
    ));

    $this->widgetSchema->setNameFormat('a_embed_media_account[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'aEmbedMediaAccount';
  }

}
