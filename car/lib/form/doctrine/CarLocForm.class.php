<?php

/**
 * CarLoc form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarLocForm extends BaseCarLocForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idloc'          => new sfWidgetFormInputHidden(),
      'title'          => new sfWidgetFormTextarea(),
      'information'    => new sfWidgetFormTextarea(),
      'description'    => new sfWidgetFormTextarea(),
      'logo'           => new sfWidgetFormInputFile(),
      'baniere'        => new sfWidgetFormInputFile(),
      'active'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idloc'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idloc', 'required' => false)),
      'title'          => new sfValidatorString(),
      'information'    => new sfValidatorString(),
      'description'    => new sfValidatorString(),
      'logo'           => new sfValidatorFile(array(
                                        'required' => false,
                                        'path' => sfConfig::get('sf_upload_dir').'/location/',
                                        'mime_types' => 'web_images',
									)),
      'baniere'        => new sfValidatorFile(array(
                                        'required' => false,
                                        'path' => sfConfig::get('sf_upload_dir').'/location/',
                                        'mime_types' => 'web_images',
									)),
      'active'         => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('car_loc[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  	
  }
}
