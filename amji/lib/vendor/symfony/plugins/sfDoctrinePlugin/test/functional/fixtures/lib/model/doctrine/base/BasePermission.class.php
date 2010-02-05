<?php

/**
 * BasePermission
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property Doctrine_Collection $Users
 * @property Doctrine_Collection $Groups
 * 
 * @method string              getName()   Returns the current record's "name" value
 * @method Doctrine_Collection getUsers()  Returns the current record's "Users" collection
 * @method Doctrine_Collection getGroups() Returns the current record's "Groups" collection
 * @method Permission          setName()   Sets the current record's "name" value
 * @method Permission          setUsers()  Sets the current record's "Users" collection
 * @method Permission          setGroups() Sets the current record's "Groups" collection
 * 
 * @package    symfony12
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BasePermission extends myDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('permission');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('User as Users', array(
             'refClass' => 'UserPermission',
             'local' => 'permission_id',
             'foreign' => 'user_id'));

        $this->hasMany('Group as Groups', array(
             'refClass' => 'GroupPermission',
             'local' => 'permission_id',
             'foreign' => 'group_id'));
    }
}