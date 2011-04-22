<?php

/**
 * CarModele filter form base class.
 *
 * @package    car
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarModeleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idmarque'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarMarque'), 'add_empty' => true)),
      'title'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'notevisiteur'   => new sfWidgetFormFilterInput(),
      'nbnotevisiteur' => new sfWidgetFormFilterInput(),
      'noteadmin'      => new sfWidgetFormFilterInput(),
      'nbnoteadmin'    => new sfWidgetFormFilterInput(),
      'sanspermis'     => new sfWidgetFormFilterInput(),
      'active'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'idmarque'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarMarque'), 'column' => 'idmarque')),
      'title'          => new sfValidatorPass(array('required' => false)),
      'description'    => new sfValidatorPass(array('required' => false)),
      'notevisiteur'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nbnotevisiteur' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'noteadmin'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nbnoteadmin'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sanspermis'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'active'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('car_modele_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarModele';
  }

  public function getFields()
  {
    return array(
      'idmodele'       => 'Number',
      'idmarque'       => 'ForeignKey',
      'title'          => 'Text',
      'description'    => 'Text',
      'notevisiteur'   => 'Number',
      'nbnotevisiteur' => 'Number',
      'noteadmin'      => 'Number',
      'nbnoteadmin'    => 'Number',
      'sanspermis'     => 'Number',
      'active'         => 'Number',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
