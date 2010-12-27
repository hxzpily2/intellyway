<?php

/**
 * CarCarosserie form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarCarosserieForm extends BaseCarCarosserieForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idcarosserie' => new sfWidgetFormInputHidden(),
      'title'        => new sfWidgetFormTextarea(),
      'image'        => new sfWidgetFormInputFile(),
      'description'  => new sfWidgetFormTextarea(),
      'active'       => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),      
    ));

    $this->setValidators(array(
      'idcarosserie' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idcarosserie', 'required' => false)),
      'title'        => new sfValidatorString(),
      'image'        => new sfValidatorFile(array(
                                        'required' => false,
                                        'path' => sfConfig::get('sf_upload_dir').'/carosserie/',
                                        'mime_types' => 'web_images',
									)),
      'description'  => new sfValidatorString(),
      'active'       => new sfValidatorBoolean(),	           
    ));

    $this->widgetSchema->setNameFormat('car_carosserie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
