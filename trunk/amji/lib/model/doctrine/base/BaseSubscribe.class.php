<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Subscribe', 'doctrine');

/**
 * BaseSubscribe
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user
 * @property integer $type
 * @property timestamp $dateinscr
 * 
 * @method integer   getUser()      Returns the current record's "user" value
 * @method integer   getType()      Returns the current record's "type" value
 * @method timestamp getDateinscr() Returns the current record's "dateinscr" value
 * @method Subscribe setUser()      Sets the current record's "user" value
 * @method Subscribe setType()      Sets the current record's "type" value
 * @method Subscribe setDateinscr() Sets the current record's "dateinscr" value
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseSubscribe extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('subscribe');
        $this->hasColumn('user', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('type', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('dateinscr', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '25',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}