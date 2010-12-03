<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CarEncher', 'doctrine');

/**
 * BaseCarEncher
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idencher
 * @property integer $idauto
 * @property integer $iduser
 * @property integer $prixstart
 * @property timestamp $datedebut
 * @property timestamp $datefin
 * @property integer $active
 * @property CarAuto $CarAuto
 * @property Doctrine_Collection $CarProposition
 * 
 * @method integer             getIdencher()       Returns the current record's "idencher" value
 * @method integer             getIdauto()         Returns the current record's "idauto" value
 * @method integer             getIduser()         Returns the current record's "iduser" value
 * @method integer             getPrixstart()      Returns the current record's "prixstart" value
 * @method timestamp           getDatedebut()      Returns the current record's "datedebut" value
 * @method timestamp           getDatefin()        Returns the current record's "datefin" value
 * @method integer             getActive()         Returns the current record's "active" value
 * @method CarAuto             getCarAuto()        Returns the current record's "CarAuto" value
 * @method Doctrine_Collection getCarProposition() Returns the current record's "CarProposition" collection
 * @method CarEncher           setIdencher()       Sets the current record's "idencher" value
 * @method CarEncher           setIdauto()         Sets the current record's "idauto" value
 * @method CarEncher           setIduser()         Sets the current record's "iduser" value
 * @method CarEncher           setPrixstart()      Sets the current record's "prixstart" value
 * @method CarEncher           setDatedebut()      Sets the current record's "datedebut" value
 * @method CarEncher           setDatefin()        Sets the current record's "datefin" value
 * @method CarEncher           setActive()         Sets the current record's "active" value
 * @method CarEncher           setCarAuto()        Sets the current record's "CarAuto" value
 * @method CarEncher           setCarProposition() Sets the current record's "CarProposition" collection
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCarEncher extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('car_encher');
        $this->hasColumn('idencher', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('idauto', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('iduser', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('prixstart', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('datedebut', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '25',
             ));
        $this->hasColumn('datefin', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '25',
             ));
        $this->hasColumn('active', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '1',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CarAuto', array(
             'local' => 'idauto',
             'foreign' => 'idauto',
             'onDelete' => 'CASCADE'));

        $this->hasMany('CarProposition', array(
             'local' => 'idencher',
             'foreign' => 'idencher'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}