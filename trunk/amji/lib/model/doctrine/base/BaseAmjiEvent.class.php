<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AmjiEvent', 'doctrine');

/**
 * BaseAmjiEvent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idamji_event
 * @property string $content
 * @property string $title
 * @property integer $iduser
 * @property timestamp $date
 * @property integer $active
 * @property AmjiUser $AmjiUser
 * @property Doctrine_Collection $AmjiEventAttachment
 * @property Doctrine_Collection $AmjiEventUser
 * 
 * @method integer             getIdamjiEvent()         Returns the current record's "idamji_event" value
 * @method string              getContent()             Returns the current record's "content" value
 * @method string              getTitle()               Returns the current record's "title" value
 * @method integer             getIduser()              Returns the current record's "iduser" value
 * @method timestamp           getDate()                Returns the current record's "date" value
 * @method integer             getActive()              Returns the current record's "active" value
 * @method AmjiUser            getAmjiUser()            Returns the current record's "AmjiUser" value
 * @method Doctrine_Collection getAmjiEventAttachment() Returns the current record's "AmjiEventAttachment" collection
 * @method Doctrine_Collection getAmjiEventUser()       Returns the current record's "AmjiEventUser" collection
 * @method AmjiEvent           setIdamjiEvent()         Sets the current record's "idamji_event" value
 * @method AmjiEvent           setContent()             Sets the current record's "content" value
 * @method AmjiEvent           setTitle()               Sets the current record's "title" value
 * @method AmjiEvent           setIduser()              Sets the current record's "iduser" value
 * @method AmjiEvent           setDate()                Sets the current record's "date" value
 * @method AmjiEvent           setActive()              Sets the current record's "active" value
 * @method AmjiEvent           setAmjiUser()            Sets the current record's "AmjiUser" value
 * @method AmjiEvent           setAmjiEventAttachment() Sets the current record's "AmjiEventAttachment" collection
 * @method AmjiEvent           setAmjiEventUser()       Sets the current record's "AmjiEventUser" collection
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAmjiEvent extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('amji_event');
        $this->hasColumn('idamji_event', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
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
        $this->hasColumn('title', 'string', null, array(
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
        $this->hasColumn('date', 'timestamp', 25, array(
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
        $this->hasOne('AmjiUser', array(
             'local' => 'iduser',
             'foreign' => 'idamji_user'));

        $this->hasMany('AmjiEventAttachment', array(
             'local' => 'idamji_event',
             'foreign' => 'idamji_event'));

        $this->hasMany('AmjiEventUser', array(
             'local' => 'idamji_event',
             'foreign' => 'idamji_event'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}