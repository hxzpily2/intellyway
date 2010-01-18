<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AmjiCastResponseGroup', 'doctrine');

/**
 * BaseAmjiCastResponseGroup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idamji_response
 * @property integer $iduser
 * @property integer $active
 * @property AmjiUser $AmjiUser
 * @property AmjiResponseGroup $AmjiResponseGroup
 * 
 * @method integer               getIdamjiResponse()    Returns the current record's "idamji_response" value
 * @method integer               getIduser()            Returns the current record's "iduser" value
 * @method integer               getActive()            Returns the current record's "active" value
 * @method AmjiUser              getAmjiUser()          Returns the current record's "AmjiUser" value
 * @method AmjiResponseGroup     getAmjiResponseGroup() Returns the current record's "AmjiResponseGroup" value
 * @method AmjiCastResponseGroup setIdamjiResponse()    Sets the current record's "idamji_response" value
 * @method AmjiCastResponseGroup setIduser()            Sets the current record's "iduser" value
 * @method AmjiCastResponseGroup setActive()            Sets the current record's "active" value
 * @method AmjiCastResponseGroup setAmjiUser()          Sets the current record's "AmjiUser" value
 * @method AmjiCastResponseGroup setAmjiResponseGroup() Sets the current record's "AmjiResponseGroup" value
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAmjiCastResponseGroup extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('amji_cast_request');
        $this->hasColumn('idamji_response', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('iduser', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
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
        $this->hasOne('AmjiUser', array(
             'local' => 'iduser',
             'foreign' => 'idamji_user'));

        $this->hasOne('AmjiResponseGroup', array(
             'local' => 'idamji_response',
             'foreign' => 'idamji_response'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}