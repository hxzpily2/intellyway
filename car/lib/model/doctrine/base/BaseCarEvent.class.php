<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CarEvent', 'doctrine');

/**
 * BaseCarEvent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idevent
 * @property string $content
 * @property string $title
 * @property timestamp $datedebut
 * @property timestamp $datefin
 * @property string $image
 * @property integer $active
 * 
 * @method integer   getIdevent()   Returns the current record's "idevent" value
 * @method string    getContent()   Returns the current record's "content" value
 * @method string    getTitle()     Returns the current record's "title" value
 * @method timestamp getDatedebut() Returns the current record's "datedebut" value
 * @method timestamp getDatefin()   Returns the current record's "datefin" value
 * @method string    getImage()     Returns the current record's "image" value
 * @method integer   getActive()    Returns the current record's "active" value
 * @method CarEvent  setIdevent()   Sets the current record's "idevent" value
 * @method CarEvent  setContent()   Sets the current record's "content" value
 * @method CarEvent  setTitle()     Sets the current record's "title" value
 * @method CarEvent  setDatedebut() Sets the current record's "datedebut" value
 * @method CarEvent  setDatefin()   Sets the current record's "datefin" value
 * @method CarEvent  setImage()     Sets the current record's "image" value
 * @method CarEvent  setActive()    Sets the current record's "active" value
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCarEvent extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('car_event');
        $this->hasColumn('idevent', 'integer', 4, array(
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
        $this->hasColumn('image', 'string', 200, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '200',
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
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}