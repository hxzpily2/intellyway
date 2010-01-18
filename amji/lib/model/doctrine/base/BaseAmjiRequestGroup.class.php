<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AmjiRequestGroup', 'doctrine');

/**
 * BaseAmjiRequestGroup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idamji_request
 * @property string $title
 * @property string $content
 * @property integer $iduser
 * @property integer $idpriorite
 * @property integer $idgroup
 * @property AmjiUser $AmjiUser
 * @property AmjiPriorite $AmjiPriorite
 * @property AmjiGroup $AmjiGroup
 * @property Doctrine_Collection $AmjiResponseGroup
 * @property Doctrine_Collection $AmjiCastRequestGroup
 * 
 * @method integer             getIdamjiRequest()        Returns the current record's "idamji_request" value
 * @method string              getTitle()                Returns the current record's "title" value
 * @method string              getContent()              Returns the current record's "content" value
 * @method integer             getIduser()               Returns the current record's "iduser" value
 * @method integer             getIdpriorite()           Returns the current record's "idpriorite" value
 * @method integer             getIdgroup()              Returns the current record's "idgroup" value
 * @method AmjiUser            getAmjiUser()             Returns the current record's "AmjiUser" value
 * @method AmjiPriorite        getAmjiPriorite()         Returns the current record's "AmjiPriorite" value
 * @method AmjiGroup           getAmjiGroup()            Returns the current record's "AmjiGroup" value
 * @method Doctrine_Collection getAmjiResponseGroup()    Returns the current record's "AmjiResponseGroup" collection
 * @method Doctrine_Collection getAmjiCastRequestGroup() Returns the current record's "AmjiCastRequestGroup" collection
 * @method AmjiRequestGroup    setIdamjiRequest()        Sets the current record's "idamji_request" value
 * @method AmjiRequestGroup    setTitle()                Sets the current record's "title" value
 * @method AmjiRequestGroup    setContent()              Sets the current record's "content" value
 * @method AmjiRequestGroup    setIduser()               Sets the current record's "iduser" value
 * @method AmjiRequestGroup    setIdpriorite()           Sets the current record's "idpriorite" value
 * @method AmjiRequestGroup    setIdgroup()              Sets the current record's "idgroup" value
 * @method AmjiRequestGroup    setAmjiUser()             Sets the current record's "AmjiUser" value
 * @method AmjiRequestGroup    setAmjiPriorite()         Sets the current record's "AmjiPriorite" value
 * @method AmjiRequestGroup    setAmjiGroup()            Sets the current record's "AmjiGroup" value
 * @method AmjiRequestGroup    setAmjiResponseGroup()    Sets the current record's "AmjiResponseGroup" collection
 * @method AmjiRequestGroup    setAmjiCastRequestGroup() Sets the current record's "AmjiCastRequestGroup" collection
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAmjiRequestGroup extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('amji_request_group');
        $this->hasColumn('idamji_request', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('title', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('content', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
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
        $this->hasColumn('idpriorite', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('idgroup', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('AmjiUser', array(
             'local' => 'iduser',
             'foreign' => 'idamji_user'));

        $this->hasOne('AmjiPriorite', array(
             'local' => 'idpriorite',
             'foreign' => 'idamji_priorite'));

        $this->hasOne('AmjiGroup', array(
             'local' => 'idgroup',
             'foreign' => 'idamji_group'));

        $this->hasMany('AmjiResponseGroup', array(
             'local' => 'idamji_request',
             'foreign' => 'idrequest'));

        $this->hasMany('AmjiCastRequestGroup', array(
             'local' => 'idamji_request',
             'foreign' => 'idamji_request'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}