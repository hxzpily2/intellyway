<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CarModele', 'doctrine');

/**
 * BaseCarModele
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idmodele
 * @property integer $idmarque
 * @property string $title
 * @property string $description
 * @property integer $notevisiteur
 * @property integer $nbnotevisiteur
 * @property integer $noteadmin
 * @property integer $nbnoteadmin
 * @property integer $sanspermis
 * @property integer $active
 * @property CarMarque $CarMarque
 * @property Doctrine_Collection $CarAuto
 * 
 * @method integer             getIdmodele()       Returns the current record's "idmodele" value
 * @method integer             getIdmarque()       Returns the current record's "idmarque" value
 * @method string              getTitle()          Returns the current record's "title" value
 * @method string              getDescription()    Returns the current record's "description" value
 * @method integer             getNotevisiteur()   Returns the current record's "notevisiteur" value
 * @method integer             getNbnotevisiteur() Returns the current record's "nbnotevisiteur" value
 * @method integer             getNoteadmin()      Returns the current record's "noteadmin" value
 * @method integer             getNbnoteadmin()    Returns the current record's "nbnoteadmin" value
 * @method integer             getSanspermis()     Returns the current record's "sanspermis" value
 * @method integer             getActive()         Returns the current record's "active" value
 * @method CarMarque           getCarMarque()      Returns the current record's "CarMarque" value
 * @method Doctrine_Collection getCarAuto()        Returns the current record's "CarAuto" collection
 * @method CarModele           setIdmodele()       Sets the current record's "idmodele" value
 * @method CarModele           setIdmarque()       Sets the current record's "idmarque" value
 * @method CarModele           setTitle()          Sets the current record's "title" value
 * @method CarModele           setDescription()    Sets the current record's "description" value
 * @method CarModele           setNotevisiteur()   Sets the current record's "notevisiteur" value
 * @method CarModele           setNbnotevisiteur() Sets the current record's "nbnotevisiteur" value
 * @method CarModele           setNoteadmin()      Sets the current record's "noteadmin" value
 * @method CarModele           setNbnoteadmin()    Sets the current record's "nbnoteadmin" value
 * @method CarModele           setSanspermis()     Sets the current record's "sanspermis" value
 * @method CarModele           setActive()         Sets the current record's "active" value
 * @method CarModele           setCarMarque()      Sets the current record's "CarMarque" value
 * @method CarModele           setCarAuto()        Sets the current record's "CarAuto" collection
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCarModele extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('car_modele');
        $this->hasColumn('idmodele', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '10',
             ));
        $this->hasColumn('idmarque', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
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
        $this->hasColumn('description', 'string', null, array(
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
        $this->hasColumn('sanspermis', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '1',
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
        $this->hasOne('CarMarque', array(
             'local' => 'idmarque',
             'foreign' => 'idmarque',
             'onDelete' => 'CASCADE'));

        $this->hasMany('CarAuto', array(
             'local' => 'idmodele',
             'foreign' => 'idmodele'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}