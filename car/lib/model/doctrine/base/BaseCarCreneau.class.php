<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CarCreneau', 'doctrine');

/**
 * BaseCarCreneau
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idcrenau
 * @property integer $idauto
 * @property integer $iduser
 * @property timestamp $dated
 * @property integer $heured
 * @property integer $mind
 * @property integer $heuref
 * @property integer $minf
 * @property integer $active
 * @property CarAuto $CarAuto
 * 
 * @method integer    getIdcrenau() Returns the current record's "idcrenau" value
 * @method integer    getIdauto()   Returns the current record's "idauto" value
 * @method integer    getIduser()   Returns the current record's "iduser" value
 * @method timestamp  getDated()    Returns the current record's "dated" value
 * @method integer    getHeured()   Returns the current record's "heured" value
 * @method integer    getMind()     Returns the current record's "mind" value
 * @method integer    getHeuref()   Returns the current record's "heuref" value
 * @method integer    getMinf()     Returns the current record's "minf" value
 * @method integer    getActive()   Returns the current record's "active" value
 * @method CarAuto    getCarAuto()  Returns the current record's "CarAuto" value
 * @method CarCreneau setIdcrenau() Sets the current record's "idcrenau" value
 * @method CarCreneau setIdauto()   Sets the current record's "idauto" value
 * @method CarCreneau setIduser()   Sets the current record's "iduser" value
 * @method CarCreneau setDated()    Sets the current record's "dated" value
 * @method CarCreneau setHeured()   Sets the current record's "heured" value
 * @method CarCreneau setMind()     Sets the current record's "mind" value
 * @method CarCreneau setHeuref()   Sets the current record's "heuref" value
 * @method CarCreneau setMinf()     Sets the current record's "minf" value
 * @method CarCreneau setActive()   Sets the current record's "active" value
 * @method CarCreneau setCarAuto()  Sets the current record's "CarAuto" value
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCarCreneau extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('car_creneau');
        $this->hasColumn('idcrenau', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '10',
             ));
        $this->hasColumn('idauto', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
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
        $this->hasColumn('dated', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '25',
             ));
        $this->hasColumn('heured', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('mind', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('heuref', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('minf', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
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

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}