<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CarLoc', 'doctrine');

/**
 * BaseCarLoc
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idloc
 * @property string $title
 * @property string $information
 * @property string $description
 * @property string $logo
 * @property string $baniere
 * @property integer $notevisiteur
 * @property integer $nbnotevisiteur
 * @property integer $noteadmin
 * @property integer $nbnoteadmin
 * @property integer $active
 * @property Doctrine_Collection $CarAdresseLoc
 * 
 * @method integer             getIdloc()          Returns the current record's "idloc" value
 * @method string              getTitle()          Returns the current record's "title" value
 * @method string              getInformation()    Returns the current record's "information" value
 * @method string              getDescription()    Returns the current record's "description" value
 * @method string              getLogo()           Returns the current record's "logo" value
 * @method string              getBaniere()        Returns the current record's "baniere" value
 * @method integer             getNotevisiteur()   Returns the current record's "notevisiteur" value
 * @method integer             getNbnotevisiteur() Returns the current record's "nbnotevisiteur" value
 * @method integer             getNoteadmin()      Returns the current record's "noteadmin" value
 * @method integer             getNbnoteadmin()    Returns the current record's "nbnoteadmin" value
 * @method integer             getActive()         Returns the current record's "active" value
 * @method Doctrine_Collection getCarAdresseLoc()  Returns the current record's "CarAdresseLoc" collection
 * @method CarLoc              setIdloc()          Sets the current record's "idloc" value
 * @method CarLoc              setTitle()          Sets the current record's "title" value
 * @method CarLoc              setInformation()    Sets the current record's "information" value
 * @method CarLoc              setDescription()    Sets the current record's "description" value
 * @method CarLoc              setLogo()           Sets the current record's "logo" value
 * @method CarLoc              setBaniere()        Sets the current record's "baniere" value
 * @method CarLoc              setNotevisiteur()   Sets the current record's "notevisiteur" value
 * @method CarLoc              setNbnotevisiteur() Sets the current record's "nbnotevisiteur" value
 * @method CarLoc              setNoteadmin()      Sets the current record's "noteadmin" value
 * @method CarLoc              setNbnoteadmin()    Sets the current record's "nbnoteadmin" value
 * @method CarLoc              setActive()         Sets the current record's "active" value
 * @method CarLoc              setCarAdresseLoc()  Sets the current record's "CarAdresseLoc" collection
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCarLoc extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('car_loc');
        $this->hasColumn('idloc', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '10',
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
        $this->hasColumn('information', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('logo', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('baniere', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('notevisiteur', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('nbnotevisiteur', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('noteadmin', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('nbnoteadmin', 'integer', 2, array(
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
        $this->hasMany('CarAdresseLoc', array(
             'local' => 'idloc',
             'foreign' => 'idloc'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}