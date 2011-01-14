<?php

/**
 * CarAdresseLoc filter form base class.
 *
 * @package    car
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarAdresseLocFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idloc'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarLoc'), 'add_empty' => true)),
      'idville'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarVille'), 'add_empty' => true)),
      'adresse'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tel1'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tel2'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fax'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'active'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'idloc'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarLoc'), 'column' => 'idloc')),
      'idville'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarVille'), 'column' => 'idville')),
      'adresse'      => new sfValidatorPass(array('required' => false)),
      'tel1'         => new sfValidatorPass(array('required' => false)),
      'tel2'         => new sfValidatorPass(array('required' => false)),
      'fax'          => new sfValidatorPass(array('required' => false)),
      'active'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('car_adresse_loc_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarAdresseLoc';
  }

  public function getFields()
  {
    return array(
      'idadresseloc' => 'Number',
      'idloc'        => 'ForeignKey',
      'idville'      => 'ForeignKey',
      'adresse'      => 'Text',
      'tel1'         => 'Text',
      'tel2'         => 'Text',
      'fax'          => 'Text',
      'active'       => 'Number',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
    );
  }
}
