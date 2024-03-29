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
 * @property timestamp $datedebut
 * @property timestamp $datefin
 * @property integer $active
 * @property integer $idtype
 * @property integer $idpriorite
 * @property integer $idnotif
 * @property AmjiUser $AmjiUser
 * @property AmjiTypeEvent $AmjiTypeEvent
 * @property AmjiPrioriteEvent $AmjiPrioriteEvent
 * @property AmjiEventNotification $AmjiEventNotification
 * @property Doctrine_Collection $AmjiEventAttachment
 * @property Doctrine_Collection $AmjiEventUser
 * 
 * @method integer               getIdamjiEvent()           Returns the current record's "idamji_event" value
 * @method string                getContent()               Returns the current record's "content" value
 * @method string                getTitle()                 Returns the current record's "title" value
 * @method integer               getIduser()                Returns the current record's "iduser" value
 * @method timestamp             getDatedebut()             Returns the current record's "datedebut" value
 * @method timestamp             getDatefin()               Returns the current record's "datefin" value
 * @method integer               getActive()                Returns the current record's "active" value
 * @method integer               getIdtype()                Returns the current record's "idtype" value
 * @method integer               getIdpriorite()            Returns the current record's "idpriorite" value
 * @method integer               getIdnotif()               Returns the current record's "idnotif" value
 * @method AmjiUser              getAmjiUser()              Returns the current record's "AmjiUser" value
 * @method AmjiTypeEvent         getAmjiTypeEvent()         Returns the current record's "AmjiTypeEvent" value
 * @method AmjiPrioriteEvent     getAmjiPrioriteEvent()     Returns the current record's "AmjiPrioriteEvent" value
 * @method AmjiEventNotification getAmjiEventNotification() Returns the current record's "AmjiEventNotification" value
 * @method Doctrine_Collection   getAmjiEventAttachment()   Returns the current record's "AmjiEventAttachment" collection
 * @method Doctrine_Collection   getAmjiEventUser()         Returns the current record's "AmjiEventUser" collection
 * @method AmjiEvent             setIdamjiEvent()           Sets the current record's "idamji_event" value
 * @method AmjiEvent             setContent()               Sets the current record's "content" value
 * @method AmjiEvent             setTitle()                 Sets the current record's "title" value
 * @method AmjiEvent             setIduser()                Sets the current record's "iduser" value
 * @method AmjiEvent             setDatedebut()             Sets the current record's "datedebut" value
 * @method AmjiEvent             setDatefin()               Sets the current record's "datefin" value
 * @method AmjiEvent             setActive()                Sets the current record's "active" value
 * @method AmjiEvent             setIdtype()                Sets the current record's "idtype" value
 * @method AmjiEvent             setIdpriorite()            Sets the current record's "idpriorite" value
 * @method AmjiEvent             setIdnotif()               Sets the current record's "idnotif" value
 * @method AmjiEvent             setAmjiUser()              Sets the current record's "AmjiUser" value
 * @method AmjiEvent             setAmjiTypeEvent()         Sets the current record's "AmjiTypeEvent" value
 * @method AmjiEvent             setAmjiPrioriteEvent()     Sets the current record's "AmjiPrioriteEvent" value
 * @method AmjiEvent             setAmjiEventNotification() Sets the current record's "AmjiEventNotification" value
 * @method AmjiEvent             setAmjiEventAttachment()   Sets the current record's "AmjiEventAttachment" collection
 * @method AmjiEvent             setAmjiEventUser()         Sets the current record's "AmjiEventUser" collection
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
        $this->hasColumn('idtype', 'integer', 4, array(
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
        $this->hasColumn('idnotif', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
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

        $this->hasOne('AmjiTypeEvent', array(
             'local' => 'idtype',
             'foreign' => 'idamji_type'));

        $this->hasOne('AmjiPrioriteEvent', array(
             'local' => 'idpriorite',
             'foreign' => 'idamji_priorite'));

        $this->hasOne('AmjiEventNotification', array(
             'local' => 'idnotif',
             'foreign' => 'idamji_notif'));

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