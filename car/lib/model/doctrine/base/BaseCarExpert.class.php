<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CarExpert', 'doctrine');

/**
 * BaseCarExpert
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idexpert
 * @property string $nom
 * @property string $prenom
 * @property string $description
 * @property integer $active
 * 
 * @method integer   getIdexpert()    Returns the current record's "idexpert" value
 * @method string    getNom()         Returns the current record's "nom" value
 * @method string    getPrenom()      Returns the current record's "prenom" value
 * @method string    getDescription() Returns the current record's "description" value
 * @method integer   getActive()      Returns the current record's "active" value
 * @method CarExpert setIdexpert()    Sets the current record's "idexpert" value
 * @method CarExpert setNom()         Sets the current record's "nom" value
 * @method CarExpert setPrenom()      Sets the current record's "prenom" value
 * @method CarExpert setDescription() Sets the current record's "description" value
 * @method CarExpert setActive()      Sets the current record's "active" value
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCarExpert extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('car_expert');
        $this->hasColumn('idexpert', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('nom', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('prenom', 'string', null, array(
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