<?php

/**
 * CarMessage filter form base class.
 *
 * @package    car
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarMessageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idmessage'   => new sfWidgetFormFilterInput(),
      'iduserfrom'  => new sfWidgetFormFilterInput(),
      'iduserto'    => new sfWidgetFormFilterInput(),
      'commentaire' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'active'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'idmessage'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'iduserfrom'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'iduserto'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'commentaire' => new sfValidatorPass(array('required' => false)),
      'active'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('car_message_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarMessage';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'idmessage'   => 'Number',
      'iduserfrom'  => 'Number',
      'iduserto'    => 'Number',
      'commentaire' => 'Text',
      'active'      => 'Number',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}
