<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AmjiPrioriteEvent', 'doctrine');

/**
 * BaseAmjiPrioriteEvent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idamji_priorite
 * @property string $libelle
 * @property Doctrine_Collection $AmjiEvent
 * 
 * @method integer             getIdamjiPriorite()  Returns the current record's "idamji_priorite" value
 * @method string              getLibelle()         Returns the current record's "libelle" value
 * @method Doctrine_Collection getAmjiEvent()       Returns the current record's "AmjiEvent" collection
 * @method AmjiPrioriteEvent   setIdamjiPriorite()  Sets the current record's "idamji_priorite" value
 * @method AmjiPrioriteEvent   setLibelle()         Sets the current record's "libelle" value
 * @method AmjiPrioriteEvent   setAmjiEvent()       Sets the current record's "AmjiEvent" collection
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAmjiPrioriteEvent extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('amji_priorite_event');
        $this->hasColumn('idamji_priorite', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('libelle', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '100',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('AmjiEvent', array(
             'local' => 'idamji_priorite',
             'foreign' => 'idpriorite'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}