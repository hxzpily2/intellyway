<?php

/**
 * Country filter form base class.
 *
 * @package    car
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCountryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormFilterInput(),
      'printable_name' => new sfWidgetFormFilterInput(),
      'iso3'           => new sfWidgetFormFilterInput(),
      'numcode'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorPass(array('required' => false)),
      'printable_name' => new sfValidatorPass(array('required' => false)),
      'iso3'           => new sfValidatorPass(array('required' => false)),
      'numcode'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('country_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Country';
  }

  public function getFields()
  {
    return array(
      'iso'            => 'Text',
      'name'           => 'Text',
      'printable_name' => 'Text',
      'iso3'           => 'Text',
      'numcode'        => 'Number',
    );
  }
}
