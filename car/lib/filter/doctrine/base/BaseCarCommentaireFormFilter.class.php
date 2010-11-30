<?php

/**
 * CarCommentaire filter form base class.
 *
 * @package    car
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCarCommentaireFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idauto'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarAuto'), 'add_empty' => true)),
      'idgroup'       => new sfWidgetFormFilterInput(),
      'iduser'        => new sfWidgetFormFilterInput(),
      'active'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'idauto'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CarAuto'), 'column' => 'idauto')),
      'idgroup'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'iduser'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'active'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('car_commentaire_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CarCommentaire';
  }

  public function getFields()
  {
    return array(
      'idcommentaire' => 'Number',
      'idauto'        => 'ForeignKey',
      'idgroup'       => 'Number',
      'iduser'        => 'Number',
      'active'        => 'Number',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
    );
  }
}
