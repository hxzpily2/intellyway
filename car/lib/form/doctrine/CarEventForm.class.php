<?php

/**
 * CarEvent form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarEventForm extends BaseCarEventForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idevent'    => new sfWidgetFormInputHidden(),
      'content'    => new sfWidgetFormTextarea(),
      'title'      => new sfWidgetFormTextarea(),
      'datedebut'  => new sfWidgetFormDateTime(),
      'datefin'    => new sfWidgetFormDateTime(),
      'image'      => new sfWidgetFormInputFile(),
      'active'     => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),      
    ));

    $this->setValidators(array(
      'idevent'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idevent', 'required' => false)),
      'content'    => new sfValidatorString(),
      'title'      => new sfValidatorString(),
      'datedebut'  => new sfValidatorDateTime(),
      'datefin'    => new sfValidatorDateTime(),
      'image'      => new sfValidatorFile(array(
                                        'required' => false,
                                        'path' => sfConfig::get('sf_upload_dir').'/events/',
                                        'mime_types' => 'web_images',
									)),
      'active'     => new sfValidatorBoolean(),      
    ));

    $this->widgetSchema->setNameFormat('car_event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
