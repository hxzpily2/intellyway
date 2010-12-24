<?php

/**
 * CarMarque form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarMarqueForm extends BaseCarMarqueForm
{
	public function configure()
	{
		
		$this->setWidgets(array(
	      'idmarque'       => new sfWidgetFormInputHidden(),
	      'title'          => new sfWidgetFormTextarea(),
	      'image'          => new sfWidgetFormInputFile(),
	      'imagelittle'    => new sfWidgetFormInputFile(),
	      'information'    => new sfWidgetFormTextarea(),
	      'description'    => new sfWidgetFormTextarea(),     
	      'active'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),      
	    ));
	    
	    $this->setValidators(array(
	      'idmarque'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idmarque', 'required' => false)),
	      'title'          => new sfValidatorString(),
	      'image'          => new sfValidatorFile(array(
                                        'required' => true,
                                        'path' => sfConfig::get('sf_upload_dir').'/emblem/',
                                        'mime_types' => 'web_images',
									)),
	      'imagelittle'    => new sfValidatorFile(array(
                                        'required' => false,
                                        'path' => sfConfig::get('sf_upload_dir').'/emblem/',
                                        'mime_types' => 'web_images',
									)),
	      'information'    => new sfValidatorString(),
	      'description'    => new sfValidatorString(),      
	      'active'         => new sfValidatorBoolean(),	      
	    ));
	
		$this->widgetSchema->setNameFormat('car_marque[%s]');

    	$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);


	}
}
