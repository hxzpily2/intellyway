<?php

/**
 * Ip2country filter form base class.
 *
 * @package    car
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseIp2countryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ip_to'         => new sfWidgetFormFilterInput(),
      'country_code2' => new sfWidgetFormFilterInput(),
      'country_code3' => new sfWidgetFormFilterInput(),
      'country_name'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'ip_to'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'country_code2' => new sfValidatorPass(array('required' => false)),
      'country_code3' => new sfValidatorPass(array('required' => false)),
      'country_name'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ip2country_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ip2country';
  }

  public function getFields()
  {
    return array(
      'ip_from'       => 'Number',
      'ip_to'         => 'Number',
      'country_code2' => 'Text',
      'country_code3' => 'Text',
      'country_name'  => 'Text',
    );
  }
}
