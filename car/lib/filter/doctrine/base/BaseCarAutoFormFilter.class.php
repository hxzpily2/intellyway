<?php

/**
 * CarAuto filter form base class.
 *
 * @package    car
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarAutoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idmarque'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarMarque'), 'add_empty' => true)),
      'idmodele'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarModele'), 'add_empty' => true)),
      'idmoteur'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarMoteur'), 'add_empty' => true)),
      'idtype'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarType'), 'add_empty' => true)),
      'idetat'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarEtat'), 'add_empty' => true)),
      'idcouleur'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarCouleur'), 'add_empty' => true)),
      'idcarosserie'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarCarosserie'), 'add_empty' => true)),
      'idboite'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarBoite'), 'add_empty' => true)),
      'anneecir'       => new sfWidgetFormFilterInput(),
      'moiscir'        => new sfWidgetFormFilterInput(),
      'anneeded'       => new sfWidgetFormFilterInput(),
      'moisded'        => new sfWidgetFormFilterInput(),
      'description'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'notevisiteur'   => new sfWidgetFormFilterInput(),
      'nbnotevisiteur' => new sfWidgetFormFilterInput(),
      'noteadmin'      => new sfWidgetFormFilterInput(),
      'nbnoteadmin'    => new sfWidgetFormFilterInput(),
      'nbportes'       => new sfWidgetFormFilterInput(),
      'pfiscale'       => new sfWidgetFormFilterInput(),
      'kilometrage'    => new sfWidgetFormFilterInput(),
      'cylindres'      => new sfWidgetFormFilterInput(),
      'prixstart'      => new sfWidgetFormFilterInput(),
      'reprise'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'active'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'idmarque'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarMarque'), 'column' => 'idmarque')),
      'idmodele'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarModele'), 'column' => 'idmodele')),
      'idmoteur'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarMoteur'), 'column' => 'idmoteur')),
      'idtype'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarType'), 'column' => 'idtype')),
      'idetat'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarEtat'), 'column' => 'idetat')),
      'idcouleur'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarCouleur'), 'column' => 'idcouleur')),
      'idcarosserie'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarCarosserie'), 'column' => 'idcarosserie')),
      'idboite'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarBoite'), 'column' => 'idboite')),
      'anneecir'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'moiscir'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'anneeded'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'moisded'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'description'    => new sfValidatorPass(array('required' => false)),
      'notevisiteur'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nbnotevisiteur' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'noteadmin'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nbnoteadmin'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nbportes'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pfiscale'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'kilometrage'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cylindres'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'prixstart'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'reprise'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'active'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('car_auto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarAuto';
  }

  public function getFields()
  {
    return array(
      'idauto'         => 'Number',
      'idmarque'       => 'ForeignKey',
      'idmodele'       => 'ForeignKey',
      'idmoteur'       => 'ForeignKey',
      'idtype'         => 'ForeignKey',
      'idetat'         => 'ForeignKey',
      'idcouleur'      => 'ForeignKey',
      'idcarosserie'   => 'ForeignKey',
      'idboite'        => 'ForeignKey',
      'anneecir'       => 'Number',
      'moiscir'        => 'Number',
      'anneeded'       => 'Number',
      'moisded'        => 'Number',
      'description'    => 'Text',
      'notevisiteur'   => 'Number',
      'nbnotevisiteur' => 'Number',
      'noteadmin'      => 'Number',
      'nbnoteadmin'    => 'Number',
      'nbportes'       => 'Number',
      'pfiscale'       => 'Number',
      'kilometrage'    => 'Number',
      'cylindres'      => 'Number',
      'prixstart'      => 'Number',
      'reprise'        => 'Number',
      'active'         => 'Number',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
