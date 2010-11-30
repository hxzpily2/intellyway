<?php

/**
 * CarCon filter form base class.
 *
 * @package    car
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarConFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'adresse'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tel1'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tel2'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fax'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'active'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'adresse'    => new sfValidatorPass(array('required' => false)),
      'tel1'       => new sfValidatorPass(array('required' => false)),
      'tel2'       => new sfValidatorPass(array('required' => false)),
      'fax'        => new sfValidatorPass(array('required' => false)),
      'active'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('car_con_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarCon';
  }

  public function getFields()
  {
    return array(
      'idmarque'   => 'Number',
      'idville'    => 'Number',
      'adresse'    => 'Text',
      'tel1'       => 'Text',
      'tel2'       => 'Text',
      'fax'        => 'Text',
      'active'     => 'Number',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
