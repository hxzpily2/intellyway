<?php

/**
 * CarGar filter form base class.
 *
 * @package    car
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarGarFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'information'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'logo'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'baniere'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'notevisiteur'   => new sfWidgetFormFilterInput(),
      'nbnotevisiteur' => new sfWidgetFormFilterInput(),
      'noteadmin'      => new sfWidgetFormFilterInput(),
      'nbnoteadmin'    => new sfWidgetFormFilterInput(),
      'active'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'title'          => new sfValidatorPass(array('required' => false)),
      'information'    => new sfValidatorPass(array('required' => false)),
      'description'    => new sfValidatorPass(array('required' => false)),
      'logo'           => new sfValidatorPass(array('required' => false)),
      'baniere'        => new sfValidatorPass(array('required' => false)),
      'notevisiteur'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nbnotevisiteur' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'noteadmin'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nbnoteadmin'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'active'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('car_gar_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarGar';
  }

  public function getFields()
  {
    return array(
      'idgar'          => 'Number',
      'title'          => 'Text',
      'information'    => 'Text',
      'description'    => 'Text',
      'logo'           => 'Text',
      'baniere'        => 'Text',
      'notevisiteur'   => 'Number',
      'nbnotevisiteur' => 'Number',
      'noteadmin'      => 'Number',
      'nbnoteadmin'    => 'Number',
      'active'         => 'Number',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}