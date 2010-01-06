<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Requestusers', 'doctrine');

/**
 * BaseRequestusers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $request
 * @property integer $user
 * @property integer $readed
 * 
 * @method integer      getRequest() Returns the current record's "request" value
 * @method integer      getUser()    Returns the current record's "user" value
 * @method integer      getReaded()  Returns the current record's "readed" value
 * @method Requestusers setRequest() Sets the current record's "request" value
 * @method Requestusers setUser()    Sets the current record's "user" value
 * @method Requestusers setReaded()  Sets the current record's "readed" value
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseRequestusers extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('requestusers');
        $this->hasColumn('request', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('user', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('readed', 'integer', 1, array(
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
        
    }
}