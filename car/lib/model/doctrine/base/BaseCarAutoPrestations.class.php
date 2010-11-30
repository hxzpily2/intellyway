<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CarAutoPrestations', 'doctrine');

/**
 * BaseCarAutoPrestations
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idprestation
 * @property integer $idauto
 * @property integer $idgroup
 * @property integer $iduser
 * @property integer $prix
 * @property integer $active
 * @property CarAuto $CarAuto
 * @property CarPrestation $CarPrestation
 * 
 * @method integer            getIdprestation()  Returns the current record's "idprestation" value
 * @method integer            getIdauto()        Returns the current record's "idauto" value
 * @method integer            getIdgroup()       Returns the current record's "idgroup" value
 * @method integer            getIduser()        Returns the current record's "iduser" value
 * @method integer            getPrix()          Returns the current record's "prix" value
 * @method integer            getActive()        Returns the current record's "active" value
 * @method CarAuto            getCarAuto()       Returns the current record's "CarAuto" value
 * @method CarPrestation      getCarPrestation() Returns the current record's "CarPrestation" value
 * @method CarAutoPrestations setIdprestation()  Sets the current record's "idprestation" value
 * @method CarAutoPrestations setIdauto()        Sets the current record's "idauto" value
 * @method CarAutoPrestations setIdgroup()       Sets the current record's "idgroup" value
 * @method CarAutoPrestations setIduser()        Sets the current record's "iduser" value
 * @method CarAutoPrestations setPrix()          Sets the current record's "prix" value
 * @method CarAutoPrestations setActive()        Sets the current record's "active" value
 * @method CarAutoPrestations setCarAuto()       Sets the current record's "CarAuto" value
 * @method CarAutoPrestations setCarPrestation() Sets the current record's "CarPrestation" value
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCarAutoPrestations extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('car_autoprestations');
        $this->hasColumn('idprestation', 'integer', 10, array(
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
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('idgroup', 'integer', 10, array(
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
        $this->hasColumn('prix', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
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

        $this->hasOne('CarPrestation', array(
             'local' => 'idprestation',
             'foreign' => 'idprestation',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}